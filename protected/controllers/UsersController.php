<?php

class UsersController extends Controller
{
	public function actionUser($username)
	{
		$user = $this->loadUser($username);
		$this->renderPage($user);
	}
	
	public function actionUpdate($username)
	{
		if(!isset($_POST['User']) || Yii::app()->user->isGuest) return;
		$user = $this->loadUser($username);
		
		if($user->id !== Yii::app()->user->id) return; 
		
		$user->attributes = $_POST['User'];
		
		if($user->validate()) $user->save();
		
		$this->actionUser($username);
		
	}
	
	private function loadUser($username)
	{
		return User::model()->
		with(array( 'blogposts' => array('select' => array('title', 'url', 'html_desc_paragraph'))))->
		findByAttributes(array('login' => $username));
	}
	
	private function renderPage($user)
	{
		if($user === null)
			throw new CHttpException(404);
		
		$this->pageTitle = $user->login;
		$this->description = 'phpguide user '.$user->login;
		$this->keywords = 'phpguide user, '.$user->login;
		
		$this->render('userinfo', array('user' => $user));
	}
}