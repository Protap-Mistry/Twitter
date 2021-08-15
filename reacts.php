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

	if(isset($_POST['like_the_post']) && $_POST['like_the_post'] == 'like')
	{
		$like= $user->like($id);
		echo $like;		
	}
	if(isset($_POST['liker']) && $_POST['liker'] == 'users_list_who_throw_like')
	{
		$show_liker= $user->showLiker();
		//echo $show_liker;		
	}

	if(isset($_POST['dislikes']) && $_POST['dislikes'] == 'dislike')
	{
		$dislike= $user->dislike($id);
		echo $dislike;		
	}
	if(isset($_POST['disliker']) && $_POST['disliker'] == 'fetch_disliker')
	{
		$show_disliker= $user->showDisliker();
		//echo $show_disliker;		
	}
	
?>
