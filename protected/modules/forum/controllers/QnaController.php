<?php

class QnaController extends PHPGController
{
	
	/**
	 * the session key of the viewed qnas array
	 * @var string
	 */
	const viewed_qnas_session_key = 'viewed_qna_ids';

	/**
	 * Number of questions on each page
	 * @var int
	 */
	const QNAS_ON_PAGE = 30;
    
	
	/**
	 * Amount of points given for a correct answer
	 * @var int
	 */
	const POINTS_FOR_CORRECT_ANSWER = 10;
	

    protected function beforeAction($action)
    {
        $this->mainNavSelectedItem = MainNavBarWidget::FORUM;
        return parent::beforeAction($action);
    }

	/**
	 * Used to mark an answer as the correct answer to a question
	 * @param int $ans answer's id
	 */
	public function actionMarkascorrect($ans){
		
		if(Yii::app()->user->isGuest) 
			return;
		
		$answerId = intval($ans);
		if($answerId < 1) return;
		
		/** @var QnaComment $answer */
		$answer = QnaComment::model()->findByPk($answerId);
		
		if($answer === null)
			return;
		
		$canUserMarkQuestion = Yii::app()->user->is_admin || $answer->question->authorid === Yii::app()->user->id;
		
		if(!$canUserMarkQuestion) 
			return;

        /** @var QnaComment $previousCorrectAnswer */
		$previousCorrectAnswer = QnaComment::model()->findByAttributes  (
				array('qid'=>$answer->qid , 'is_correct'=>true)
		);
		

		if(null !== $previousCorrectAnswer)
			$this->unmarkCorrectAnswer($previousCorrectAnswer);
		
		QnaComment::model()->updateByPk($answer->aid, array('is_correct' => true));
		$answer->author->updatePointsBy(+ self::POINTS_FOR_CORRECT_ANSWER);

		
	}
	
	

	private function unmarkCorrectAnswer(QnaComment $answer)
	{
		
		QnaComment::model()->updateByPk($answer->aid, array('is_correct' => false));
        $answer->author->updatePointsBy(- self::POINTS_FOR_CORRECT_ANSWER);
	}

    public function actionIndex()
    {
        $this->subNavSelectedItem = \SubNavBarWidget::FORUM_LIST;
        $this->render('index');
    }

    public function actionListNew()
    {
        $this->subNavSelectedItem = \SubNavBarWidget::FORUM_NEW;
        $this->addscripts('qna');

        $page = 0;

        if(isset($_GET['page']))
        {
            $page = intval($_GET['page']) - 1;
            if($page < 0) $page = 0;
            if($page > 100000) $page = 0;
        }

        $qnas=QnaQuestion::model()->count();
        //QnaController::storeQnasWithNewAnswersSinceLastVisitInSession($qnas);

        $this->render('listOfTopicsWithPagination' ,[
            'qnas' => QnaQuestion::model()->byPage($page, static::QNAS_ON_PAGE)->findAll(),
            'allCategories' => QnaCategory::model()->findAll(),
            'paginationTotalPages' => ceil($qnas/self::QNAS_ON_PAGE),
            'paginationCurrentPage' => $page+1,
            'showCategory' => true
        ]);
    }

    public function actionCreateNewTopic()
    {
        $this->render('newQuestionForm', ['selectedCategory' => null, 'allCategories' => QnaCategory::model()->findAll()]);
    }
	
    public function actionCategory($categoryId)
    {
        /** @var $category QnaCategory */
        $category = QnaCategory::model()->findByPk($categoryId);

        if(null === $category)
            throw new \CHttpException(404);

    	$this->pageTitle = 'פורום ושאלות ' . $category->cat_name;
    	$this->description = 'דיונים ושאלות בנושאים' . $category->cat_name . ' ' . $category->cat_description;
    	
        $this->addscripts('qna');

        $page = 0;
        
        if(isset($_GET['page']))
        {
            $page = intval($_GET['page']) - 1;
            if($page < 0) $page = 0;
            if($page > 100000) $page = 0;
        }
        
        $qnas=QnaQuestion::model()->inCategory($categoryId)->count();
        //QnaController::storeQnasWithNewAnswersSinceLastVisitInSession($qnas);

        $this->render('topicsInCategory' ,[
            'qnas' => QnaQuestion::model()->inCategory($categoryId)->byPage($page, static::QNAS_ON_PAGE)->findAll(),
            'allCategories' => QnaCategory::model()->findAll(),
            'paginationTotalPages' => ceil($qnas/self::QNAS_ON_PAGE),
            'paginationCurrentPage' => $page+1,
            'category' => $category
        ]);
    }
    
    public function actionNew()
    {
        if(isset($_POST['QnaQuestion']))
        {
        	if(Yii::app()->user->isguest)
        	{
        		echo 'רק משתמשים רשומים יכולים לקבל תשובות לשאלותיהם';
        		return;
        	}
        	
            $model = null;
            
            if(isset($_POST['QnaQuestion']['qid']))
            {
            	$condition = '';
            	if(!Yii::app()->user->is_admin) $condition = ' authorid="'.Yii::app()->user->id.'" ';
            	$model = QnaQuestion::model()->findByPk($_POST['QnaQuestion']['qid'], $condition);
            }
            else
            {
            	$model = new QnaQuestion();
            }
            
            if($model === null)
            {
            	echo 'aww';
            	return;
            }
            
            $model->attributes = $_POST['QnaQuestion'];
            
            if(gettype($model->last_activity) !== 'object')
				$model->last_activity = new SDateTime();
            
            $model->authorid = $model->authorid ? $model->authorid : Yii::app()->user->id;
            
            $contentBBencoder = new BBencoder($model->bb_text, $model->subject, !Yii::app()->user->isguest &&  Yii::app()->user->is_admin);
            $model->html_text = $contentBBencoder->GetParsedHtml();

            if( $model->validate() )
            {
                $model->save();
                echo $model->getUrl();
            }
            else
            {
                echo 'err::Invalid attributes?' ; var_dump($model->getErrors());
            }
        }
    }

    public function actionView($id)
    {
        /** @var QnaQuestion $qna */
        $qna = QnaQuestion::model()->with('category')->findByPk($id);
	
        if($qna)
        {
        	
        	$this->pageTitle = $qna->subject . ' | שאלת לימוד PHP';
        	$this->description = 'שאלה ' . $qna->subject;
        	$this->keywords = 'שאלה, עזרה' ;
        	$this->pageAuthor = $qna->author->login;
        	
	    	$this->addscripts( 'qna','bbcode', '//cdnjs.cloudflare.com/ajax/libs/ouibounce/0.0.8/ouibounce.js', 'ouibounce');
	    	
	    	if(!static::isQnaViewedEarlier($qna))
	    	{
	            $qna->views++;
	            $qna->save();
	            static::addQnaToViewedList($qna);
	    	}
	    
			$canUserMarkAnswer = !Yii::app()->user->isGuest && 
				( Yii::app()->user->is_admin || Yii::app()->user->id === $qna->author->id );


            $isSubscribed = !Yii::app()->user->isGuest &&
                QnaSubscription::isSubscribed(Yii::app()->user->id, $qna->qid);

            $allCategories = [];

            if(!Yii::app()->user->isGuest && Yii::app()->user->is_admin)
                $allCategories = QnaCategory::model()->findAll();

            $this->render('viewQna',
                array('qna' => &$qna,
                    'canUserMarkAnswer' => &$canUserMarkAnswer,
                    'isSubscribed' => $isSubscribed,
                    'allCategories' => $allCategories
                ));

            //QnaController::removeQnaFromListOfNewAnswers($qna);
        }
        else
        {
            throw new CHttpException(404, "aww");
        }
    }

    public function actionMoveQuestionToCategory()
    {
        if(Yii::app()->user->isGuest || !Yii::app()->user->is_admin)
            return;

        $questionId = Yii::app()->request->getPost('questionId');
        $destinationCatId = Yii::app()->request->getPost('destinationCatId');

        /** @var $question QnaQuestion */
        $question = QnaQuestion::model()->findByPk($questionId);

        if(null === $question)
            return;

        /** @var QnaCategory $category */
        $category = QnaCategory::model()->findByPk($destinationCatId);

        if(null === $category)
            return;

        $question->categoryid = $destinationCatId;
        $question->save();

        $this->redirect($question->getUrl());
    }
    
    /**
     * Returns whether the currently logged in user had already viewed this qna page earlier today
     * @param QnaQuestion $qna instance of the question.
     * @return bool
     */
    protected static function isQnaViewedEarlier($qna)
    {
    	$d = Yii::app()->session[static::viewed_qnas_session_key]; 
    	return is_array($d) && in_array($qna->qid, $d);
    }
    
    /**
     * Add's the qna's id to the list of qna's already viewed by the user
     * @param QnaQuestion $qna instance of the question
     */
    protected static function addQnaToViewedList(QnaQuestion $qna)
    {
    	$tempSession=Yii::app()->session[static::viewed_qnas_session_key] ?: array();
    	array_push($tempSession, $qna->qid);
    	Yii::app()->session[static::viewed_qnas_session_key]=$tempSession;
    }
    
    
    public function actionAnswer()
    {
    	if(isset($_POST['QnaComment']))
    	{
    		
    		if(Yii::app()->user->isguest)
    		{
    			echo 'רק משתמשים רשומים יכולים לענות לשאלות';
    			return;
    		}
    		
    	    $transaction = YII::app()->db->beginTransaction();
    	    
    	    try
    	    {

    	    	$answer = null;
                $isNew = true;
    	    	
    	    	if(isset($_POST['QnaComment']['aid']))
    	    	{
    	    		$answer = QnaComment::model()->findByPk($_POST['QnaComment']['aid']);
    	    		if(!Yii::app()->user->is_admin && Yii::app()->user->id !== $answer->authorid)
    	    			throw new Exception("Not enough permissions to edit this post");

                    $isNew = false;
    	    	}
    	    	
    	    	if(null === $answer)
    	    	{
    	    		$answer = new QnaComment();
    	    	}
    	    	
    	    	
    	    	
    	    	$answer->attributes = $_POST['QnaComment'];
    	    	$answer->author = $answer->author ?:  Yii::app()->user;
    	    	$answer->authorid = $answer->authorid ?: Yii::app()->user->id;
    	    	
    	    	$contentBBencoder = new BBencoder($answer->bb_text, '', $answer->author->is_admin);
    	    	$answer->html_text = $contentBBencoder->GetParsedHtml();
    	    	if( null === $answer->time ) $answer->time = new SDateTime();
    	    	
    	    	

                if( !$answer->validate())
                {
                    $errList = [];

                    foreach($answer->getErrors() as $allErrorsForInput)
                        foreach($allErrorsForInput as $error)
                        $errList[] = $error;

                    throw new InvalidArgumentException(implode(PHP_EOL, $errList));
                }

                if(!$answer->save() )
                {
                    throw new ErrorException("Failed to save QnaComment, or increment answers counter though all data has passed validation. bug?!");
                }

                $transaction->commit();   
                
                if('string' === gettype($answer->time)) $answer->time = new SDateTime($answer->time); 
                $this->renderPartial('comment', array('answer' => &$answer, 'canUserMarkAnswer' => false ));



                if($isNew)
                {
                    QnaSubscription::notifySubscribers($answer->question, [Yii::app()->user->id]);

                    if(false !== Yii::app()->request->getPost('qnasubscribe', false))
                        QnaSubscription::subscribe(Yii::app()->user->id, $answer->question->qid);
                    else
                        QnaSubscription::unsubscribe(Yii::app()->user->id, $answer->question->qid);
                }

                
    	    }
    	    catch(Exception $e)
    	    {
                echo ':err:', $e->getMessage();
                if(YII_DEBUG || (!Yii::app()->user->isguest &&  Yii::app()->user->is_admin))
                {
                    var_dump($e);
                }

                if($transaction->active)
                    $transaction->rollback();

                Yii::log("Couldn't save qnaAnswer \r\n" . $e->getMessage() , CLogger::LEVEL_ERROR);
    	    }
    	    
    	    
    	}
    }





    /**
     * Renders CActiveForm for QNaComment by specified GET[id] in ajax requests only
     */
    public function actionGetEditForm()
    {
    	if(Yii::app()->request->getIsAjaxRequest())
    	{
    		$commentid = Yii::app()->request->getQuery('id');
    		$model = null;
    		
    		if( null !== $commentid ) $model = QnaComment::model()->findByPk($commentid,  (!Yii::app()->user->isguest &&  Yii::app()->user->is_admin) ? '' : 'authorid = ' . Yii::app()->user->id);
    		if( null === $model ) $model = new QnaComment();
    		$this->renderPartial('commentsForm', array('model' => $model));
    	}
    }
    
    
    /**
     * Renders CActiveForm for QNaQuestion by specified GET[id] in ajax requests only
     */
    public function actionGetQuestionEditForm()
    {
    	if(Yii::app()->request->getIsAjaxRequest())
    	{
    		$questionid = Yii::app()->request->getQuery('id');
    		$model = null;
    
    		if( null !== $questionid ) $model = QnaQuestion::model()->findByPk($questionid,  (!Yii::app()->user->isguest &&  Yii::app()->user->is_admin) ? '' : 'authorid = ' . Yii::app()->user->id);
    		if( null === $model )
    		{
    			echo 'aw';
    			return;
    		}
    		$this->renderPartial('lightQuestionForm', array('model' => $model));
    	}
    }
    
    
    
    /**
     * Deletes the answer
     */
    public function actionDelete($id)
    {
    	$id = intval($id);
    	
    	if(Yii::app()->request->getIsAjaxRequest() && $id > 0)
    	{
			$condition = '';
			if(!Yii::app()->user->is_admin) $condition = ' authorid="'.Yii::app()->user->id.'" ';
			QnaComment::model()->deleteByPk($id, $condition);
    	}
    }
    
    public function actionDeleteQuestion($id)
    {
    	$id = intval($id);
    	 
    	if(Yii::app()->request->getIsAjaxRequest() && $id > 0)
    	{
    		$condition = '';
    		if(!Yii::app()->user->is_admin) $condition = ' authorid="'.Yii::app()->user->id.'" ';
    		QnaQuestion::model()->deleteByPk($id, $condition);
    	}
    }
    
    
    /**
     * Stores id's of qna's that have answers published after user's previous visit
     * @param array $qnas  */
    public static function storeQnasWithNewAnswersSinceLastVisitInSession(array $qnas)
    {
    	
    	if(Yii::app()->user->isguest) return;
    	$prev_visit = Yii::app()->user->prev_visit;
			
		$new = array();
		
    	foreach($qnas as $qna)
    		if( $qna->last_activity > $prev_visit)
    			$new[] = $qna->qid;
    	
    	$already_known_to_have_new_answers = Yii::app()->user->getState('qnas_with_new_answers', array());
    	if(!is_array($already_known_to_have_new_answers)) $already_known_to_have_new_answers = array();
    	$list_of_qnas_with_new_answers = array_unique(array_merge($already_known_to_have_new_answers , $new));
    	Yii::app()->user->setState('qnas_with_new_answers', $list_of_qnas_with_new_answers);
    }
    
    
    /**
     * Returns whether this question has answers posted after users prev. visit
     * @param QnaQuestion $qna
     */
    public static function doesQnaHaveNewAnswersSinceLastVisit(QnaQuestion $qna)
    {
    	$questions_with_new_answers = Yii::app()->user->getState('qnas_with_new_answers', array());
    	return in_array($qna->qid, $questions_with_new_answers);
    }
    
    
    /**
     * Removes question from the list of qid that have new answers since prev. user's visit
     * @param QnaQuestion $qna
     */
    public static function removeQnaFromListOfNewAnswers(QnaQuestion $qna)
    {
    	$questions_with_new_answers = Yii::app()->user->getState('qnas_with_new_answers', array());
    	if(false !== ($key = array_search($qna->qid, $questions_with_new_answers, true)))
    	{
    		unset($questions_with_new_answers[$key]);
    		Yii::app()->user->setState('qnas_with_new_answers', $questions_with_new_answers);
    	}
    }
    










    public function actionSubscribe()
    {
        $shouldSubscribe = Yii::app()->request->getQuery('subscribe', false);
        $qid = intval(Yii::app()->request->getQuery('subscribeQid'));

        if(0 === $qid || Yii::app()->user->isGuest)
            return;

        $user = Yii::app()->user->id;

        if($shouldSubscribe === 'true')
            QnaSubscription::subscribe($user, $qid);
        else
        {
            QnaSubscription::unsubscribe($user, $qid);
           echo 'ההרשמה לאשכול בוטלה';
        }
    }

    public function actionUnsubscribeAll()
    {
        $userid = Yii::app()->request->getQuery('user', null);
        $hash = Yii::app()->request->getQuery('hash', null);

        if(QnaSubscription::unsubscribeAll($userid, $hash))
            echo 'ההרשמה לכל האשכולות בוטלה';
        else
            echo 'invalid url';
    }











    
}