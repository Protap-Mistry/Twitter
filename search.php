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

	//navbar searching to get whole details of an user
	if(isset($_POST['nav_search']) && $_POST['nav_search'] == "search_users_to_get_details")
	{

		$navbar_search= $user->navbarSearchToGetWholeDetailsOfAnUser($logged_in_id);
		echo $navbar_search;		
	}

	//users list searching to get users for (un)following
	if(isset($_POST['query']))
	{

		$search= $user->search($logged_in_id);
		echo $search;		
	}
	
?>