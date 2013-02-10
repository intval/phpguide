<?php

/*
 * Sidebar widget to display recent site events including new forum posts
 * and article comments around the site
 * 
 * @author Alex Raskin (Alex@phpguide.co.il)
 */


Class RecentEvents Extends CWidget
{
    public function run()
    {
        $comments = Comment::model()->RecentComments()->findAll();
        
        if(sizeof($comments) > 0)
            $this->render('RecentEvents',array('comments'=> $comments ));
    }

    public static function getCacheDependencySql()
    {
        return 'SELECT date FROM '.Comment::model()->tableName().
               ' ORDER BY date DESC LIMIT 1';
    }
}


?>
