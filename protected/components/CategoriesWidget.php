<?php

/*
 * Sidebar widget to display list of categories the posts belongs to
 *
 * @author Alex Raskin (Alex@phpguide.co.il)
 */


Class CategoriesWidget Extends CWidget
{
    public function run()
    {
        $this->render('categories',array( 'categories' => Category::model()->findAll()  ));
    }
}


?>