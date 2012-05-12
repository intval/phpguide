<?php

/**
 * Widget to display most helping users on the qna this week
 * @author Alex Raskin (Alex@phpguide.co.il)
 */

class RatingWidget extends CWidget
{
    public function run()
    {
    	$criteria = new CDbCriteria(array(
    			'limit' => 5,
    			'order' => 'points DESC',
    			'select' => 'login, points'		
    	));
    	$topUsers = User::model()->findAll($criteria);
        $this->render('RatingWidget', array('users' => $topUsers));
    }
}