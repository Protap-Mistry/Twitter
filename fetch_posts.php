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
	$show_per_page= 5;
	$posts_pagination= 1;

	if(Session::get("posts_pagination"))
	{
		$posts_pagination= Session::get("posts_pagination");
	}
	
	$track_start_page= ($posts_pagination-1)*$show_per_page;
	//pagination part-1 end
		    

	if(isset($_POST['action']) && $_POST['action'] == 'fetch_post')
	{

		$post_fetch= $user->showPost($id, $track_start_page, $show_per_page);
		echo $post_fetch;
		
	}

	//pagination part-2 start
			
	$pagination_result= $user->paginationForShowingPosts($id);
	//echo $pagination_result;
	$total_pages= ceil($pagination_result/$show_per_page);

	echo "<span class='pagination'> 
			<a href='index.php?&posts_pagination=1'>Start</a>";

			for ($i=1; $i <=$total_pages ; $i++) { 
				
				echo "<a href='index.php?&posts_pagination=$i'>$i</a>";
			}

			echo "<a href='index.php?&posts_pagination=$total_pages'>End</a> 
		</span>";

	//pagination part-2 end
	
?>
