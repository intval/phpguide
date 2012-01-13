<?php

class QnaController extends Controller
{
    
    public function actionIndex()
    {
        $this->addscripts('ui', 'qna'); 
        $this->render('index' ,array
            (
            'qnas' => QnaQuestion::model()->with('author')->findAll()
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
	    	$this->addscripts('qna','bbcode'); 
            $qna->views++;
            $qna->save();

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