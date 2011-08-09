<?php

class HomepageController extends Controller
{
    
   
	public function actionIndex()
	{
                
                $this->addscript('ui');
		$this->render('index' , 
                        array
                        (
                            'categories' => Category::model()->findAll() ,
                            'articles'   => Article::model()->newest()->findAll()
                        )   
                 );
	}
        
        public function actionError()
        {
            // empty layout without header, footer, sidebar
            $this->layout = '/';
            
            if( false !== ($error =  Yii::app()->errorHandler->error ))
            {   
                if($error['type'] === 'CHttpException' and $error['code'] === 404)
                {
                    if( !empty($error['message']) )
                    {
                        $alternatives = Article::model()->similarTo($error['message'])->findAll();
                    }
                    else
                    {
                        $alternatives = Article::model()->newest(8)->findAll();
                    }
                    $this->render('error_404', array('alternatives' => $alternatives));
                }
                else
                {
                    $this->render('error_500');
                }
                
            }
            else
            {
                $this->redirect(Yii::app()->homeUrl);
            }
           
        }

}