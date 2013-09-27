<?php

class ContestController extends PHPGController
{
    public function actionShowContestProblems($contestId)
    {
        if(!filter_var($contestId, FILTER_VALIDATE_INT))
            throw new \CHttpException(404, "Contest id must be a number");

        $problems = ContestProblem::model()->findAllByAttributes(['contestid' => $contestId]);

        if(null === $problems || empty($problems))
            throw new CHttpException(404, "Oops, contest not found");

        $this->addscripts('contest');
        $this->render('listOfProblems', ['problems' => $problems]);
    }

    public function actionShowSingleProblem($problemId)
    {
        if(!filter_var($problemId, FILTER_VALIDATE_INT))
            throw new \CHttpException(404, "Problem wasn't found \\o/");

        $problem = ContestProblem::model()->findByPk($problemId);

        if(null === $problem)
            throw new \CHttpException(404, "Oops, problem wasn't found \\o/");

        $this->addscripts(
            '//ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.min.js',
            '//d1n0x3qji82z53.cloudfront.net/src-min-noconflict/ace.js',
            'contest');
        $this->render('singleProblemView', ['problem' => & $problem]);
    }

    public function actionSubmitSolution($problemId)
    {
        if(Yii::app()->user->isGuest)
            throw new \CHttpException(401, 'Guests not allowed');

        if(!filter_var($problemId, FILTER_VALIDATE_INT))
            throw new \CHttpException(400, "Huston, we don't have a ");

        $code = trim(Yii::app()->request->getPost('code', ''));

        if(empty($code))
            throw new CHttpException(400, "No code provided as solution?!");

        $contest = new \phpg\bl\Contest();
        $submission = $contest->newSubmission($problemId, $code, Yii::app()->user->getUserInstance());

        header("Content-type: application/json");
        echo json_encode($submission);
    }
}