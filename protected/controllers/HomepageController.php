<?php

class HomepageController extends Controller
{
    
   
    public function actionIndex()
    {
        $this->addscripts('ui'); 
        $this->render('index' ,array (
	    'articles' => Article::model()->newest()->findAll(), 
	    'qnas' => QnaQuestion::model()->findAll(array('limit' => 7, 'order' => 'time DESC'))) );
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
		Yii::log($error, CLogger::LEVEL_ERROR);
            }

        }
        else
        {
            $this->redirect(Yii::app()->homeUrl);
        }

    }

    public function actionRss()
    {
        $this->layout = '/';
        $this->render('rss' ,
            array
            (
                'articles'   => Article::model()->newest(10)->findAll()
            )
         );
    }
}