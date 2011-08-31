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
            
             /* eventid, location, text, author, time, is_blog, hour */
             
             SELECT *, DATE_FORMAT( time ,'%H:%i') as 'hour' FROM
                (
                    SELECT `cid` as 'eventid', `url` as 'location', LEFT(`text`, 70) as 'text', `author`, 
                    `date` as 'time', 1 as 'is_blog' FROM `blog_comments`
                    LEFT JOIN `blog` ON `blog`.`id` = `blog_comments`.`blogid`
                    WHERE `blog_comments`.`approved` = 1 

                    UNION

                    SELECT `zzsmf_messages`.`id_msg` as 'eventid', `zzsmf_topics`.`id_topic` as 'location',  
                    `subject` as 'text' , `poster_name` as 'author', FROM_UNIXTIME(`poster_time`) as 'time', 0 as 'is_blog'
                    FROM `zzsmf_topics` , `zzsmf_messages`
                    WHERE `zzsmf_messages`.`id_msg` = `zzsmf_topics`.`id_first_msg` && `zzsmf_messages`.`id_board` != 18

                ) r
                ORDER BY r.time DESC LIMIT 7

        ");
        
        
        $this->render('recentEvents',array('events'=> $command->query() ));
    }
}


?>
