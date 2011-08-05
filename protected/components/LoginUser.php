<?php

/**
 * Widget to display user box on the sidebar with users avatar
 * and number of unvisited forum posts
 * Shows login form to unregistered users
 * 
 * @author Alex Raskin (Alex@phpguide.co.il)
 */

class LoginUser extends CWidget
{
    public function run()
    {
        $user = User::get_current_user();
        $this->render('loginBox', array('user' => $user));
    }
}