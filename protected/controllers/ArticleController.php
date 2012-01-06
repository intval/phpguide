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
        
        $this->vars['title']        =  $article->title;
        $this->vars['keywords']     =  $article->keywords;
        $this->vars['description']  =  $article->description;
        $this->vars['page_author']  =  $article->author->login;



        $this->addscripts('ui');
        $this->render('index', array('article' => &$article));
    }


}