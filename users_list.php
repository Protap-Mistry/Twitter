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

	//pagination part-1 start
	$show_per_page= 3;
	$users_pagination= 1;
	
	if(Session::get("users_pagination")){

		$users_pagination= Session::get("users_pagination");
	}

	$track_start_page= ($users_pagination-1)*$show_per_page;
	//pagination part-1 end

	if(isset($_POST['action']) && $_POST['action'] == 'fetch_users')
	{

		$users_fetch= $user->showUsers($id, $track_start_page, $show_per_page);
		echo $users_fetch;
		
	}

	//pagination part-2 start
			
	$pagination_result= $user->paginationForShowingUsers($id);
	//echo $pagination_result;

	$total_pages= ceil($pagination_result/$show_per_page);

	echo "<span class='pagination'>
		<a href='index.php?&users_pagination=1'>Start</a>";

		for ($i=1; $i <=$total_pages ; $i++) { 
			
			echo "<a href='index.php?&users_pagination=$i'>$i</a>";
		}

		echo "<a href='index.php?&users_pagination=$total_pages'>End</a> 
	</span>";

	//pagination part-2 end
	
?>
