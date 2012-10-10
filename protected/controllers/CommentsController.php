<?php

class CommentsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/';


	/** Num of seconds required to pass between two comment posts*/
	const ANTISPAM_DELAY = 15;


     /**
	 * Creates a new comment.
	 * @todo A proper solution would be to serve an error message regarding time limit
	 */
	public function actionAdd()
	{
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['Comment']))
            {
                if (!$this->antispam_check_passed())
                {
                    echo 'spam';
                    return;
                }
                
                if(Yii::app()->user->isguest)
                {
                	echo 'only registered users can submit comments';
                	return;
                }

                $model=new Comment;
                $model->attributes=$_POST['Comment'];

                $model->approved    = 1;
                $model->authorid    = Yii::app()->user->id;
                $model->date        = new CDbExpression('NOW()');
                $model->postingip   = Yii::app()->request->userHostAddress;

                try
                {
                    $model->save();
		    		$model->date = 'now';
                    $this->renderPartial('//article/singleComment', array('comment' => &$model));
                }
                catch( Exception $e)
                {
                    echo 'error';
                }
            }

        }

        /** Checks whether the ANTISPAM delay has passed since the last comment */
        private function antispam_check_passed()
        {
            $is_comment_ok = true;

            try
            {
                $is_comment_ok = Yii::app()->db->createCommand
                (
                 "SELECT COUNT(*)
                  FROM " . Comment::model()->tableName() . "
                  WHERE postingip = :ip AND
                  date > DATE_SUB(NOW(), INTERVAL :delay SECOND)"
                ) ->queryScalar
                (
                    array
                    (
                        'ip' => Yii::app()->request->userHostAddress,
                        'delay' => self::ANTISPAM_DELAY
                    )
                ) < 1;
            }
            catch(Exception $e)
            {
                $is_comment_ok = false;
            }

            return $is_comment_ok;
        }


}
