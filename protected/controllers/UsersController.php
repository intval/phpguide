<?php

class UsersController extends Controller
{
	public function actionUser($username)
	{
		
		
		$user = User::model()->with(array( 'blogposts' => array('select' => array('title', 'url', 'html_desc_paragraph'))))->findByAttributes(array('login' => $username));
		
		if($user === null)
			throw new CHttpException(404);
		
		
		$this->pageTitle = $username;
		$this->description = 'phpguide user '.$username;
		$this->keywords = 'phpguide user, '.$username;
		
		$this->render('userinfo', array('user' => $user));
	}
}