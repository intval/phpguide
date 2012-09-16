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
    
	public function actionMarkascorrect($ans){
		$ans = (int) $ans;
		
		$answer = QnaComment::model()->findByPk($ans);
		//correct answers for this qna
		$is_qna_answered = QnaComment::model()->countByAttributes(array('qid'=>$answer->qid,'is_correct'=>1));

		if($answer->authorid != YII::app()->user->id && $is_qna_answered == 0){
			$answer->is_correct = 1;
			$answer->save();
			
			$the_helpers_user = User::model()->findByPk($answer->authorid);
			$the_helpers_user->points += 2;
			$the_helpers_user->save();
		}
	}
	
    public function actionIndex()
    {
    	$this->pageTitle = 'שאלות ותשובות PHP | עזרה עם PHP | לימוד PHP';
    	$this->keywords = 'שאלות ותשובות, PHP, פיתוח אינטרנט';
    	$this->description = 'שאלות ותשובות לימוד PHP. יש לך שאלה? תשאל!';
    	
        $this->addscripts( 'qna');
        
        $page = 0;
        
        if(isset($_GET['page']))
        {
            $page = intval($_GET['page']) - 1;
            if($page < 0) $page = 0;
            if($page > 100000) $page = 0;
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
        	
	    	$this->addscripts( 'qna','bbcode'); 
	    	
	    	if(!static::isQnaViewedEarlier($qna))
	    	{
	            $qna->views++;
	            $qna->save();
	            static::addQnaToViewedList($qna);
	    	}
	    
	    	$is_qna_answered = QnaComment::model()->countByAttributes(array('qid'=>$qna->qid,'is_correct'=>1));

            $this->render('//qna/viewQna', array('qna' => &$qna, 'is_qna_answered'=>$is_qna_answered));      
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
    	$d = Yii::app()->session[static::viewed_qnas_session_key]; 
    	return is_array($d) && in_array($qna->qid, $d);
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
    		
    		if(Yii::app()->user->isguest)
    		{
    			echo 'רק משתמשים רשומים יכולים לענות לשאלות';
    			return;
    		}
    		
    	    $transaction = YII::app()->db->beginTransaction();
    	    
    	    try
    	    {

    	    	$answer = null;
    	    	
    	    	if(isset($_POST['QnaComment']['aid']))
    	    	{
    	    		$answer = QnaComment::model()->findByPk($_POST['QnaComment']['aid']);
    	    		if(!Yii::app()->user->is_admin && Yii::app()->user->id !== $answer->authorid)
    	    			throw new Exception("Not enough permissions to edit this post");
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
                if(YII_DEBUG || (!Yii::app()->user->isguest &&  Yii::app()->user->is_admin)) echo $e->getMessage();
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
     * @param array prev_visit  */
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
    
    
    
}