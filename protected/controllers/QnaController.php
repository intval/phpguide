<?php

class QnaController extends Controller
{
    const POSTS_ON_QNA = 15;
    
    public function actionIndex()
    {
    	$this->pageTitle = 'שאלות ותשובות PHP | עזרה עם PHP | לימוד PHP';
    	$this->keywords = 'לימוד, עזרה, שאלה, PHP, MySQL, Apache, תשובה';
    	$this->description = 'שאלות ותשובות לימוד PHP. יש לך שאלה? תשאל!';
    	
        $this->addscripts('ui', 'qna', 'paginator3000');
        
        $page = 0;
        
        if(isset($_GET['page']))
        {
            $page = intval($_GET['page']) - 1;
            if($page < 0) $page = 0;
        }
        
        $qnas=QnaQuestion::model()->findAll();
        
        $this->render('index' ,array
            (
            'qnas' => QnaQuestion::model()->byPage($page, self::POSTS_ON_QNA)->findAll(),
            'pagination' => array('total_pages' => ceil(sizeof($qnas)/self::POSTS_ON_QNA) , 'current_page' => $page+1)
            )
        );
    }
    
    public function actionNew()
    {
        if(isset($_POST['QnaQuestion']))
        {
            $model = new QnaQuestion();
            $model->attributes = $_POST['QnaQuestion'];

            $model->authorid = Yii::app()->user->id;
            $model->html_text = bbcodes::bbcode($model->bb_text, $model->subject);

            if( $model->validate() )
            {
                $model->save();
                echo $model->qid;
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
        	
	    	$this->addscripts('qna','bbcode'); 
            
            if (!Helpers::checkSessionCounter('qnaidss', $qna->qid))
            {
                $qna->views++;
                $qna->save();
            }

            $this->render('//qna/viewQna', array('qna' => &$qna));            
        }
        else
        {
            throw new CHttpException(404, "aww");
        }
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
    	    	if( null === $answer->time ) $answer->time = new DateTime();
    	    	
    	    	

                if( !$answer->validate())
                {
                    throw new InvalidArgumentException("Some submitted data for QnaANswer didnt pass validation");
                }

                if(!$answer->save() )
                {
                    throw new ErrorException("Failed to save QnaComment, or increment answers counter though all data has passed validation. bug?!");
                }

                $transaction->commit();   

                
                if('string' === gettype($answer->time)) $answer->time = new DateTime($answer->time); 
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
    
    
}