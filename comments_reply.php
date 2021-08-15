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

	if(isset($_POST['action']) && $_POST['action'] == 'submit_comment')
	{

		$submit_comment= $user->submitComment($id);
	}
	if(isset($_POST['show_comment']) && $_POST['show_comment'] == 'fetch_comment')
	{
		$show_comment= $user->showComments();
		echo $show_comment;		
	}
	if(isset($_POST['copy_the_post']) && $_POST['copy_the_post'] == 'repost')
	{
		$repost= $user->repost($id);
		echo $repost;		
	}
	
?>
