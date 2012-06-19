<?php

class UsersController extends Controller
{
	public function actionUser($username)
	{
		
		
		$user = User::model()->with(array('info', 'blogposts' => array('select' => array('title', 'url', 'html_desc_paragraph'))))->findByAttributes(array('login' => $username));
		
		if($user === null)
			throw new CHttpException(404);
		
		
		$this->pageTitle = $username;
		$this->description = 'phpguide user '.$username;
		$this->keywords = 'phpguide user, '.$username;
		
		$this->addscripts('tabs');
		$this->render('userinfo', array('user' => $user));
	}
}