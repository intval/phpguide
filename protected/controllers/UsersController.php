<?php

class UsersController extends Controller
{
	public function actionUser($username)
	{
		
		$user = User::model()->with(array( 'blogposts' => array('select' => array('title', 'url', 'html_desc_paragraph'))))->findByAttributes(array('login' => $username));
		
		$model = new UserinfoForm($user);
		
		if(isset($_POST['UserinfoForm']))
		{
			$model->attributes=$_POST['UserinfoForm'];
		
			if($model->validate()){
				$user->about = $_POST['UserinfoForm']['about'];
				$user->city = $_POST['UserinfoForm']['city'];
				$user->site = $_POST['UserinfoForm']['site'];
				$user->save();
			}
		}
		
		
		if($user === null)
			throw new CHttpException(404);
		
		
		$this->pageTitle = $username;
		$this->description = 'phpguide user '.$username;
		$this->keywords = 'phpguide user, '.$username;
		
		//$model=new UserinfoForm;
		$this->render('userinfo', array('user' => $user, 'model'=>$model));
	}
}