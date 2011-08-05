<?php

class CommentsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/';


	/**
	 * Creates a new comment.
	 * 
	 */
	public function actionAdd()
	{
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Comment']))
		{
                        $model=new Comment;
			$model->attributes=$_POST['Comment'];
                        
                        $model->approved    = 1;
                        $model->author      = 'test';
                        $model->date        = new CDbExpression('NOW()');
        
                        try
                        {
                            $model->save();
                            echo 'תודה, תגובתכם נוספה';  
                        }
                        catch( Exception $e)
                        {
                            // empty response indicates an error
                        }
                        

		}

        }


}
