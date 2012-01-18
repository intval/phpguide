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
    
    /**
     * Generates sitemap. available only via webcron from localhost
     */
    public function actionSitemap()
    {
    	// available only in debug mode for localhost
    	if(!YII_DEBUG) return;
    	
    	$items = Yii::app()->db->createCommand("
    			
	    			SELECT 
	    				'article' as 'type', 
	    				id, 
	    				url as 'loc', 
	    				DATE_FORMAT(`pub_date`,'%Y-%m-%d') as 'lastmod', 
	    				0.9 as 'priority', 
	    				'monthly' as 'freq' 
	    			FROM `blog` WHERE `approved`=1
    			
    			UNION
    			
    				SELECT 
    					'qna' as 'type', 	
    					qid as 'id', 
    					subject as 'loc', 
    					DATE_FORMAT(`time`,'%Y-%m-%d') as 'lastmod', 
    					0.4 as 'priority', 
    					'daily' as 'freq' 
    				FROM qna_questions WHERE time >= DATE_SUB(NOW(), INTERVAL 7 DAY)
    			
    			UNION
    			
    				SELECT 
    					'qna' as 'type', 
    					qid as 'id', 
    					subject as 'loc', 
    					DATE_FORMAT(`time`,'%Y-%m-%d') as 'lastmod', 
    					0.4 as 'priority', 
    					'monthly' as 'freq' 
    				FROM qna_questions WHERE time < DATE_SUB(NOW(), INTERVAL 7 DAY)
    			
    			")->queryAll();
    	
    	
    	$sitemap = $this->renderPartial('sitemap', array('items' => $items), true);
    	file_put_contents(Yii::app()->getBasePath().'/../static/sitemap.xml' , $sitemap);
    	echo $sitemap; 
    }
    
}