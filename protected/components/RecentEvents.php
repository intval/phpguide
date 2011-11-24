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
        $command = Yii::app()->db->createCommand("

            SELECT `cid` as 'eventid', `url` as 'location', LEFT(`text`, 70) as 'text', `author`,
            `date` as 'time', 1 as 'is_blog',  DATE_FORMAT( date ,'%H:%i') as 'hour'
            FROM `blog_comments`
            LEFT JOIN `blog` ON `blog`.`id` = `blog_comments`.`blogid`
            WHERE `blog_comments`.`approved` = 1
            ORDER BY time DESC LIMIT 7
        ");
        
        
        $this->render('recentEvents',array('events'=> $command->query() ));
    }
}


?>
