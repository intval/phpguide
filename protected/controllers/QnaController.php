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
            $this->render('//qna/viewQna', array('qna' => &$qna));
            $qna->save();
        }
        else
        {
            throw new CHttpException(404, "aww");
        }
    }
    
    
    public function actionNewAnswer()
    {
    	if(isset($_POST['QnaComment']))
    	{
    	    $transaction = YII::app()->db->beginTransaction();
    	    sleep(5);
    	    try
    	    {
        		$comment = new QnaComment();
        		$comment->attributes = $_POST['QnaComment'];
        
        		$comment->authorid = Yii::app()->user->id;
        		$comment->html_text = bbcodes::bbcode($comment->bb_text, '');
        
        		if( !$comment->validate())
        		{
        		    throw new InvalidArgumentException("Some submitted data for QnaANswer didnt pass validation");
        		}
        		
        		$question = QnaQuestion::model()->findByPk($comment->qid);
        		
        		if($question === null)
        		{
        		    throw new OutOfRangeException("QnaAnswer claims to belong to inexisting Question");
        		}
        		
        		
        		$question->answers++;
        		
        		if(!$comment->save() || !$question->save())
        		{
        		    throw new ErrorException("Failed to save QnaComment, or increment answers counter though all data has passed validation. bug?!");
        		}
        
        		$transaction->commit();
        		$this->renderPartial('//qna/comment', array('answer' => &$comment));
    	    }
    	    catch(Exception $e)
    	    {
        		echo ':err:';
        		$transaction->rollback();
    	    }
    	    
    	    
    	}
    }

}