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
            $currentUserFirstName = Yii::app()->user->isGuest ? '' : Yii::app()->user->getUserInstance()->real_name ?: '';

            /** @var $firstCategory Category */
            $firstCategory = isset($article->categories, $article->categories[0]) ? $article->categories[0] : null;
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
}