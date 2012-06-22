<?php

class ArticleController extends Controller
{
    
    
    public $vars;


    public function actionIndex($article_url)
    {

        $article = Article::model()->findByAttributes( array('url' => $article_url) );

        if($article === null)
        {
            throw new CHttpException(404, $article_url);
        }
        
        if( '0' === $article->approved && !Yii::app()->user->isGuest && $article->author_id == Yii::app()->user->id)
        {
            Yii::app()->user->setFlash('yourpost', "מדריך זה עדיין לא אושר וניתן לצפיה רק לך");
        }
        
        $this->pageTitle = $article->title;
        
        $this->keywords     =  $article->keywords;
        $this->description  =  $article->description;
        $this->pageAuthor  =  $article->author->login;
		if($this->facebook) $this->facebook['image'] = $article->image;


        $this->render('index', array('article' => &$article));
    }
    
    
    public function actionAll()
    {
    	$posts_per_page = 10;
    	$page = 0;
   	
    	if(isset($_GET['page']))
    	{
    		$page = intval($_GET['page']) - 1;
    		if($page < 0) $page = 0;
    		if($page > 100000) $page = 0;
    	}


    	$this->render('allArticles' ,
    			array
    			(
    					'articles'     => Article::model()->byPage($page, $posts_per_page)->findAll(),
    					'pagination'   => array('total_pages' => ceil(Article::model()->countByAttributes(array('approved' => 1))/$posts_per_page) , 'current_page' => $page+1)
    			)
    	);
    	
    }


}