<?php
	$filepath= realpath(dirname(__FILE__));
	include_once $filepath.'./lib/Session.php';

	include 'lib/User.php';
	Session::init();
	Session::checkSession();
?>
<?php 

	$user= new User();
	$id= Session::get("id");

	if(isset($_POST['action']) && $_POST['action'] == 'follow')
	{

		$follow_action= $user->activateFollower($id);
		//echo $follow_action;
		
	}
	if(isset($_POST['action']) && $_POST['action'] == 'unfollow')
	{

		$unfollow_action= $user->activateUnfollower($id);
		//echo $unfollow_action;
		
	}
	
?>
