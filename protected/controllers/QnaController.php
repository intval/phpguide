<?php

class QnaController extends Controller
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
    
    public function actionIndex()
    {
    	$this->pageTitle = 'שאלות ותשובות PHP | עזרה עם PHP | לימוד PHP';
    	$this->keywords = 'שאלות ותשובות, PHP, פיתוח אינטרנט';
    	$this->description = 'שאלות ותשובות לימוד PHP. יש לך שאלה? תשאל!';
    	
        $this->addscripts('ui', 'qna', 'paginator3000');
        
        $page = 0;
        
        if(isset($_GET['page']))
        {
            $page = intval($_GET['page']) - 1;
            if($page < 0) $page = 0;
        }
        
        $qnas=QnaQuestion::model()->findAll();
        QnaController::storeQnasWithNewAnswersSinceLastVisitInSession($qnas);
        
        $this->render('index' ,array
            (
            'qnas' => QnaQuestion::model()->byPage($page, static::QNAS_ON_PAGE)->findAll(),
            'pagination' => array('total_pages' => ceil(sizeof($qnas)/self::QNAS_ON_PAGE) , 'current_page' => $page+1)
            )
        );
    }
    
    public function actionNew()
    {
        if(isset($_POST['QnaQuestion']))
        {
            $model = new QnaQuestion();
            $model->attributes = $_POST['QnaQuestion'];
			$model->last_activity = new SDateTime();
            $model->authorid = Yii::app()->user->id;
            $model->html_text = bbcodes::bbcode($model->bb_text, $model->subject);

            if( $model->validate() )
            {
                $model->save();
                echo $model->getUrl();
            }
            else
            {
                echo 'err::Invalid attributes?' , var_dump($model->getErrors());
            }
        }
    }


    public function actionView($id)
    {
        $qna = QnaQuestion::model()->findByPk($id);
	
        if($qna)
        {
        	
        	$this->pageTitle = $qna->subject . ' | שאלת לימוד PHP';
        	$this->description = 'שאלה ' . $qna->subject;
        	$this->keywords = 'שאלה, עזרה' ;
        	$this->pageAuthor = $qna->author->login;
        	
	    	$this->addscripts('ui', 'qna','bbcode'); 
	    	
	    	if(!static::isQnaViewedEarlier($qna))
	    	{
	            $qna->views++;
	            $qna->save();
	            static::addQnaToViewedList($qna);
	    	}

            $this->render('//qna/viewQna', array('qna' => &$qna));      
            QnaController::removeQnaFromListOfNewAnswers($qna);
        }
        else
        {
            throw new CHttpException(404, "aww");
        }
    }
    
    
    /**
     * Returns whether the currently logged in user had already viewed this qna page earlier today
     * @param QnaQuestion $qna instance of the question.
     */
    protected static function isQnaViewedEarlier($qna)
    {
    	return 
    		is_array(Yii::app()->session[static::viewed_qnas_session_key]) && 
    		in_array($qna->qid, Yii::app()->session[static::viewed_qnas_session_key]);
    }
    
    /**
     * Add's the qna's id to the list of qna's already viewed by the user
     * @param QnaQuestion $qid instance of the question
     */
    protected static function addQnaToViewedList($qna)
    {
    	$tempSession=Yii::app()->session[static::viewed_qnas_session_key] ?: array();
    	array_push($tempSession, $qna->qid);
    	Yii::app()->session[static::viewed_qnas_session_key]=$tempSession;
    }
    
    
    public function actionAnswer()
    {
    	if(isset($_POST['QnaComment']))
    	{
    	    $transaction = YII::app()->db->beginTransaction();
    	    
    	    try
    	    {

    	    	$answer = null;
    	    	
    	    	if(isset($_POST['QnaComment']['aid']))
    	    	{
    	    		$answer = QnaComment::model()->findByPk($_POST['QnaComment']['aid']);
    	    	}
    	    	
    	    	if(null === $answer)
    	    	{
    	    		$answer = new QnaComment();
    	    	}
    	    	
    	    	
    	    	$answer->attributes = $_POST['QnaComment'];
    	    	$answer->author = Yii::app()->user;
    	    	$answer->authorid = Yii::app()->user->id;
    	    	$answer->html_text = bbcodes::bbcode($answer->bb_text, '');
    	    	if( null === $answer->time ) $answer->time = new SDateTime();
    	    	
    	    	

                if( !$answer->validate())
                {
                    throw new InvalidArgumentException("Some submitted data for QnaANswer didnt pass validation");
                }

                if(!$answer->save() )
                {
                    throw new ErrorException("Failed to save QnaComment, or increment answers counter though all data has passed validation. bug?!");
                }

                $transaction->commit();   

                
                if('string' === gettype($answer->time)) $answer->time = new SDateTime($answer->time); 
                $this->renderPartial('//qna/comment', array('answer' => &$answer ));
                
    	    }
    	    catch(Exception $e)
    	    {
                echo ':err:'; 
                if(YII_DEBUG || Yii::app()->user->is_admin) echo $e->getMessage();
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
    		
    		if( null !== $commentid ) $model = QnaComment::model()->findByPk($commentid, 'authorid = ' . Yii::app()->user->id);
    		if( null === $model ) $model = new QnaComment();
    		$this->renderPartial('commentsForm', array('model' => $model));
    	}
    }
    
    
    
    /**
     * Deletes the answer
     */
    public function actionDelete()
    {
    	if(Yii::app()->request->getIsAjaxRequest() && Yii::app()->user->is_admin)
    	{
    		$id = Yii::app()->request->getQuery('id');
    		if(null !== $id) QnaComment::model()->deleteByPk($id);
    	}
    }
    
    
    
    
    /**
     * Stores id's of qna's that have answers published after user's previous visit
     * @param array prev_visit  */
    public static function storeQnasWithNewAnswersSinceLastVisitInSession(array $qnas)
    {
    	
    	$prev_visit = Yii::app()->user->prev_visit;
		
		$new = array();
    	foreach($qnas as $qna)
    	{
    		if( $qna->last_activity > $prev_visit)
    		{
    			$new[$qna->qid] = $qna->qid;
    		}
    	}
    	
    	$already_known_to_have_new_answers = Yii::app()->user->getState('qnas_with_new_answers', array());
    	$list_of_qnas_with_new_answers = $already_known_to_have_new_answers + $new;
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
    	unset($questions_with_new_answers[$qna->qid]);
    	Yii::app()->user->setState('qnas_with_new_answers', $questions_with_new_answers);
    }
    
    
    
}