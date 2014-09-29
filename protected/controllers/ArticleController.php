<?php

class ArticleController extends PHPGController
{
    public function actionIndex($article_url)
    {
        $this->mainNavSelectedItem = MainNavBarWidget::POSTS;

        /** @var Article $article */
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

        $hasUserVoted = !Yii::app()->user->isGuest && $article->HasUserVoted(Yii::app()->user->id);

        $article->IncrementViewsCount();
        $this->MergeJsState([
            'post' => [
                'id' => $article->id,
                'rating' => $article->GetRating(),
                'hasCurrentUserVoted' => $hasUserVoted
            ]
        ]);

        $this->addscripts('//cdnjs.cloudflare.com/ajax/libs/ouibounce/0.0.8/ouibounce.min.js', 'ouibounce');

        $url = bu('posts/'.$article->id, true);
        $tweetText = mb_substr($article->title, 0, 139-mb_strlen($url)) . ' '. $url;

        $this->render('index',
            [
                'article' => &$article,
                'currentLoggedInUserEmail' => $currentLoggedInUserEmail,
                'currentUserFirstName' => $currentUserFirstName,
                'articleCategory' => $articleCategory,
                'tweetText' => $tweetText
            ]
        );
    }
}