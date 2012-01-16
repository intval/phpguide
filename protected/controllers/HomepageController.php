<?php

class HomepageController extends Controller
{
    const POSTS_ON_HOMEPAGE = 8;
   
    public function actionIndex()
    {
        
        $page = 0;
        $qnas = array();
        
        if(isset($_GET['page']))
        {
            $page = intval($_GET['page']) - 1;
            if($page < 0) $page = 0;
        }
        
        if($page == 0)
        {
            $qnas = QnaQuestion::model()->findAll(array('limit' => 7, 'order' => 'time DESC'));
        }
        

        $this->addscripts('ui', 'paginator3000'); 
        $this->render('index' ,
            array 
            (
                'articles'     => Article::model()->byPage($page, self::POSTS_ON_HOMEPAGE)->findAll(), 
                'qnas'         => &$qnas, 
                'pagination'   => array('total_pages' => ceil(Article::model()->countByAttributes(array('approved' => 1))/self::POSTS_ON_HOMEPAGE) , 'current_page' => $page+1)
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
                    $alternatives = Article::model()->findAll(array('limit' => 8, 'order' => 'pub_date DESC'));
                }
		
                $this->render('error_404', array('alternatives' => $alternatives));
            }
            else
            {
                $this->render('error_500');
                Yii::log($error['message'], CLogger::LEVEL_ERROR, '500');
                if(YII_DEBUG || Yii::app()->user->is_admin ) echo $error['message'];
            }

        }
        else
        {
            $this->redirect(Yii::app()->homeUrl);
        }

    }

    /**
     * Displays site posts as RSS feed 
     */
    public function actionRss()
    {
        $this->layout = '/';
        $this->render('rss' ,array('articles'   => Article::model()->byPage(0, 10)->findAll()));
    }
}