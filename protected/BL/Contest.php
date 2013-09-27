<?php
namespace phpg\bl;

use phpg\bl\Interfaces\Contest\SubmissionResult;

class Contest
{
    const SANDBOX_SOLUTION_SUBMIT_URI = 'http://localsandbox/contestSolutionSubmit.php?problemId=%d';
    const SANDBOX_SOLUTION_RESULT_URI = 'http://localsandbox/contestSolutionResults/%s.json';

    public function newSubmission($problemId, $code, \User $user)
    {
        try
        {
            /** @var $problem \ContestProblem */
            $problem = \ContestProblem::model()->findByPk($problemId);

            return $this->tryAddNewSubmission($problem, $user, $code);
        }
        catch(\Exception $ex)
        {
            \Yii::log("failed to submit: ".$ex->getMessage(), \CLogger::LEVEL_TRACE, 'contest');
            $submission = new \ContestSubmit();
            $result = new SubmissionResult();
            $result->error = $ex->getMessage();
            $submission->date = new \SDateTime();
            $submission->result = $result;
            return $submission;
        }
    }

    private function tryAddNewSubmission(\ContestProblem $problem, \User $user, $code)
    {
        $this->checkInputParams($problem, $user, $code);
        $submission = $this->createNewSubmissionObject($problem, $user, $code);
        $result = $this->sendSubmissionForExecution($submission);
        \Yii::log("Got submission result: ".var_export($result, true), \CLogger::LEVEL_TRACE, 'contest');
        $this->saveSolutionToDb($submission, $result);
        return $submission;
    }

    /**
     * @param \ContestProblem $problem
     * @param \User $user
     * @param $code
     * @throws \InvalidArgumentException
     */
    private function checkInputParams(\ContestProblem $problem, \User $user, $code)
    {
        if (null === $problem)
            throw new \InvalidArgumentException("No problem with this id");

        if (null === $user)
            throw new \InvalidArgumentException("User submitting solution cannot be null");

        if (empty($code))
            throw new \InvalidArgumentException("Empty solution code");
    }


    private function createNewSubmissionObject(\ContestProblem $problem, \User $user, $code)
    {
        $submission = new \ContestSubmit();
        $submission->content = $code;
        $submission->problemid = $problem->problemid;
        $submission->userid = $user->id;
        $submission->date = new \SDateTime();

        if(!$submission->validate(['content', 'problemid', 'userid']) )
            throw new \Exception("Couldn't validate solution, some errors occured: \n" . var_export($submission->getErrors(), true) );

        return $submission;
    }

    private function saveSolutionToDb(\ContestSubmit $submission, $result)
    {
        $submission->result = $result;

        if(!$submission->validate() || !$submission->save())
            throw new \Exception("Couldn't save to database, some errors occured: \n" . var_export($submission->getErrors(), true) );
    }

    private function sendSubmissionForExecution(\ContestSubmit $solution)
    {
        $jsonContent = null;
        $resultId = $this->sendSubmission($solution);
        $attemptsCounter = 0;

        $result = new SubmissionResult();
        $result->id = $resultId;

        do
        {
            sleep(3);
            $attemptsCounter++;
            $jsonContent = $this->checkSolutionExecutionResult($resultId);
        }
        while( !$jsonContent && $attemptsCounter < 3 );

        if(!$jsonContent)
        {
            $result->error = "Execution of solution has timedout";
        }
        else
        {
            $json = json_decode($jsonContent);
            if(!is_object($json) || !property_exists($json,'passedTests'))
            {
                $result->error = "Invalid response from remote server";
            }
            else
            {
                $result->passedTests = $json->passedTests;
            }
        }

        return $result;
    }

    private function sendSubmission(\ContestSubmit $solution)
    {
        $url = sprintf(static::SANDBOX_SOLUTION_SUBMIT_URI, $solution->problemid);
        $err = null;

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, ['code' => $solution->content]);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 400);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if(false === $result)
            $err = "Failed to contact remote server for execution: ". curl_error($ch);

        curl_close($ch);

        if(null !== $err)
            throw new \Exception($err);

        if(400 === $httpCode)
            throw new \Exception("Remote server denied package: $result");

        return $result;
    }

    private function checkSolutionExecutionResult($resultAddress)
    {
        $url = sprintf(static::SANDBOX_SOLUTION_RESULT_URI, $resultAddress);
        $err = null;

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 400);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if(false === $result)
            $err = "Failed to contact remote server for result retreiving: ". curl_error($ch);

        curl_close($ch);

        if(null !== $err)
            throw new \Exception($err);

        if($httpCode === 404)
            $result = null;

        return $result;
    }
} 