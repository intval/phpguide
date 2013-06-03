<?php

/**
 * Controller to display articles in a concrete category by name
 * from url such as: http://phpguide.co.il/cat/<some_category_name>.htm
 * 
 * @author Alex Raskin (Alex@phpguide.co.il)
 */
class CategoryController extends PHPGController
{
    public function actionIndex($cat_url)
    {
        $category = Category::model()->with('articles')->byTimeDesc()-> findByAttributes(array('name' => $cat_url));

        if( $category === null)
        {
            throw new CHttpException(404);
        }

        $this->pageTitle        =  $cat_url . ' | לימוד PHP | מדריכי PHP';
        $this->keywords     =  $cat_url . ' מדריכים, לימוד וכתבתות PHP';
        $this->description  =  $cat_url . ' לימוד PHP ותכנות אתרים' ;


        $this->render('//article/articlesInCategory', array('category' => $category));
    }

}
