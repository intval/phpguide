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
	 * @todo A proper solution would be to serve an error message regarding time limit
	 */
	public function actionAdd()
	{
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Comment']) && User::get_current_user()->last_post_time < time()-15)
		{
                        $model=new Comment;
			$model->attributes=$_POST['Comment'];
                        
                        $model->approved    = 1;
                        $model->author      = User::get_current_user()->member_name;
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
