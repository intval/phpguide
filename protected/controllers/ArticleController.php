<?php

class ArticleController extends Controller
{
    
    
    public $vars;


    public function actionIndex($article_url)
    {

        $article = Article::model()->with('author.about')->findByAttributes( array('url' => $article_url) );

        if($article === null)
        {
            throw new CHttpException(404, $article_url);
        }

        $article->pub_date = new DateTime($article->pub_date);

        $this->vars['title']        =  $article->title;
        $this->vars['keywords']     =  $article->keywords;
        $this->vars['description']  =  $article->description;
        $this->vars['page_author']  =  $article->author->full_name;



        $this->addscripts('ui');
        $this->render('index', array('article' => &$article));
    }


}