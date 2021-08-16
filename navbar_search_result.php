<?php include 'inc/header.php'; ?>

<?php

	if(!isset($_SESSION['id']))
	{
		echo "<script> window.location= 'login.php'; </script>";
	}
?>
<?php 
	$user= new User();
	$logged_in_id= Session::get("id");

	//pagination part-1 for navbar search user posts start

	$show_per_page= 5;
	$navbar_search_user_posts= 1;
	$username= $_GET["data"];
	//echo $username;

	if(isset($_GET["navbar_search_user_posts"]) && isset($_GET["data"]))
	{
		$navbar_search_user_posts= $_GET['navbar_search_user_posts'];
		Session::set("navbar_search_user_posts", $navbar_search_user_posts);

		$username= $_GET['data'];
		Session::set("data", $username);
	}
	else
	{
		Session::set("navbar_search_user_posts", NULL);
		Session::set("data", NULL);
	}

	if(Session::get("navbar_search_user_posts") && Session::get("data"))
	{
		$navbar_search_user_posts= Session::get("navbar_search_user_posts");
		$username= Session::get("data");
	}
	
	$track_start_page= ($navbar_search_user_posts-1)*$show_per_page;

	//pagination part-1 for navbar search user posts end
	
	$search_details= $user->navbarSearchDetails($logged_in_id, $track_start_page, $show_per_page);

	//to show search user followers list	
	
	$search_result_user_id= $user->getSearchingResultUserId($username);

	//pagination part-1 for navbar search user followers start

	$show_follower_per_page= 3;
	$navbar_search_user_followers= 1;

	if(isset($_GET["navbar_search_user_followers"]) && isset($_GET["data"]))
	{
		$navbar_search_user_followers= $_GET['navbar_search_user_followers'];
		Session::set("navbar_search_user_followers", $navbar_search_user_followers);

		$username= $_GET['data'];
		Session::set("data", $username);
	}
	else
	{
		Session::set("navbar_search_user_followers", NULL);
		Session::set("data", NULL);
	}

	if(Session::get("navbar_search_user_followers") && Session::get("data"))
	{
		$navbar_search_user_followers= Session::get("navbar_search_user_followers");
		$username= Session::get("data");
	}
	
	$track_followers_start_page= ($navbar_search_user_followers-1)*$show_follower_per_page;

	//pagination part-1 for navbar search user followers end

	$search_result_user_followers= $user->getSearchingResultUserFollowers($search_result_user_id, $logged_in_id, $track_followers_start_page, $show_follower_per_page);
?>

<div class="row">
	<?php 
		if($search_details)
		{

	?>
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">
					<div class="row">
			    		<div class="col-md-8">
			    			<h3 class="card-title">
								<?php
									
									echo '@<b>'.$_GET["data"].'</b> Post Details';					  
							 	?>					 
							</h3>
			    		</div>
			    		<div class="col-md-4" align="right">
							<?php 
								if($search_result_user_id != $logged_in_id)
								{
									echo $user->makeFollower($search_result_user_id, $logged_in_id);
								}
							?>
						</div>
					</div>						
				</div>
				<div class="card-body">
					<div class="row postcard">
						
						<?php echo $search_details; ?>
						
					</div>
				</div>

				<?php 
					//pagination part-2 for showing navbar search user posts start
			
					$pagination_result= $user->paginationForShowingSearchUserPosts($username);
					//echo $pagination_result;
					$total_pages= ceil($pagination_result/$show_per_page);

					echo "<span class='pagination'> 
							<a href='?&data=".$username."&navbar_search_user_posts=1'>Start</a>";

							for ($i=1; $i <=$total_pages ; $i++) { 
								
								echo "<a href='?&data=".$username."&navbar_search_user_posts=$i'>$i</a>";
							}

							echo "<a href='?&data=".$username."&navbar_search_user_posts=$total_pages'>End</a> 
						</span>";

					//pagination part-2 for showing navbar search user posts end

				?>

			</div>		
		</div>

	<?php } ?>

	<?php 
		if($search_result_user_followers)
		{

	?>

		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">
	    				<?php
						
							echo '@<b>'.$_GET["data"].'</b> Followers';					  
						?>
	    			</h3>					
				</div>

				<div class="card-body">
					
					<?php echo $search_result_user_followers; ?>	
					
				</div>

				<?php 
					//pagination part-2 for showing navbar search user followers start
			
					$pagination_result_for_followers= $user->paginationForShowingSearchUserFollowers($search_result_user_id, $username);
					//echo $pagination_result_for_followers;
					$total_pages_for_followers= ceil($pagination_result_for_followers/$show_follower_per_page);

					echo "<span class='pagination'> 
							<a href='?&data=".$username."&navbar_search_user_followers=1'>Start</a>";

							for ($i=1; $i <=$total_pages_for_followers ; $i++) { 
								
								echo "<a href='?&data=".$username."&navbar_search_user_followers=$i'>$i</a>";
							}

							echo "<a href='?&data=".$username."&navbar_search_user_followers=$total_pages_for_followers'>End</a> 
						</span>";

					//pagination part-2 for showing navbar search user followers end

				?>

			</div>
		</div>
	<?php } ?>
</div>
<br>

<?php include 'inc/footer.php';	?>