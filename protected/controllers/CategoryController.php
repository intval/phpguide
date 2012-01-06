<?php

/**
 * Controller to display articles in a concrete category by name
 * from url such as: http://phpguide.co.il/cat/<some_category_name>.htm
 * 
 * @author Alex Raskin (Alex@phpguide.co.il)
 */
class CategoryController extends Controller
{
    public function actionIndex($cat_url)
    {
        $category = Category::model()->with('articles')->byTimeDesc()-> findByAttributes(array('name' => $cat_url));

        if( $category === null)
        {
            throw new CHttpException(404);
        }

        $this->vars['title']        =  $cat_url . ' — מדריכי PHP';
        $this->vars['keywords']     =  $cat_url . ' מדריכים וכתבתות PHP';
        $this->vars['description']  =  $cat_url . ' מדריכי PHP ותכנות אתרים' ;

        $this->addscripts('ui');
        $this->render('//article/articlesInCategory', array('category' => $category));
    }

}
