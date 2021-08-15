<?php
	$filepath= realpath(dirname(__FILE__));
	include_once $filepath.'./lib/Session.php';

	include 'lib/User.php';
	Session::init();
	Session::checkSession();
?>
<?php 

	$user= new User();
	$logged_in_id= Session::get("id");

	if(isset($_POST['post_id']) && !isset($_POST["action"]))
	{
		$fetch_to_update= $user->fetchThePost($logged_in_id);
		echo $fetch_to_update;		
	}
	if(isset($_POST["action"]))
	{
	 	$error = '';
		$success = '';
		$post = '';

		if(empty($_POST["post_content2"]))
		{
		  	$error .= '<p>Field must not empty !!!</p>';
		}
		else
		{
		  	$post = $_POST["post_content2"];
		}

		if($error == '')
		{
			$update_post= $user->updateThePost($post, $logged_in_id);
			//echo $update_post;
			return true;
		}
	}

	if(isset($_POST['remove']) && $_POST['remove'] == 'remove_the_post')
	{
		$remove= $user->removePost($logged_in_id);
		//echo $remove;		
	}
	
?>
