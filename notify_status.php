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

	if(isset($_POST['notify_clear']) && $_POST['notify_clear'] == 'update_notification_status')
	{

		$notification= $user->updateNotifationStatus($id);
		//echo $follow_action;
		
	}
	
?>