<?php

class ArticleController extends PHPGController
{
    public function actionIndex($article_url)
    {
        $article = Article::model()->findByAttributes( array('url' => $article_url) );

        if($article === null)
        {
            throw new CHttpException(404, $article_url);
        }
        
        if( Article::APPROVED_NONE === $article->approved && !Yii::app()->user->isGuest && $article->author_id == Yii::app()->user->id)
        {
            Yii::app()->user->setFlash('yourpost', "מדריך זה עדיין לא אושר וניתן לצפיה רק לך");
        }
        
        $this->pageTitle = $article->title;
        
        $this->keywords     =  $article->keywords;
        $this->description  =  $article->description;
        $this->pageAuthor  =  $article->author->login;
        $this->metaType    = 'Article';
		if($this->facebook) $this->facebook['image'] = $article->image;

        if(Yii::app()->user->isGuest || !Yii::app()->user->getUserInstance()->hasMailSubscription)
        {
            $this->addscripts
            (
                'http://code.angularjs.org/1.2.0-rc.2/angular.min.js',
                'http://code.angularjs.org/1.2.0-rc.2/angular-resource.min.js',
                'http://code.angularjs.org/1.2.0-rc.2/angular-cookies.min.js',
                'MailSubscriptionCtrl'
            );

            $currentLoggedInUserEmail = Yii::app()->user->isGuest ? '' : Yii::app()->user->email ?: '';
            $currentUserFirstName = Yii::app()->user->isGuest ? '' : Yii::app()->user->real_name ?: '';

            /** @var $firstCategory Category */
            $firstCategory = $article->categories[0] ?: null;
            $articleCategory = $firstCategory ? $firstCategory->name: '';
        }
        else
        {
            $currentLoggedInUserEmail = null;
            $currentUserFirstName = null;
            $articleCategory = null;
        }

        $this->render('index',
            [
                'article' => &$article,
                'currentLoggedInUserEmail' => $currentLoggedInUserEmail,
                'currentUserFirstName' => $currentUserFirstName,
                'articleCategory' => $articleCategory
            ]
        );
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

        $totalPages = ceil( Article::model()->count() / $posts_per_page );

    	$this->render('allArticles' ,
            [
                'articles'     => Article::model()->byPage($page, $posts_per_page)->findAll(),
                'pagination'   => ['total_pages' => & $totalPages , 'current_page' => $page+1]
            ]
    	);
    	
    }


}