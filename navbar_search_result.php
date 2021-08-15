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

	//pagination part-1 start

	$show_per_page= 5;
	$page= 1;
	$username= $_GET["data"];
	echo $username;

	if(isset($_GET["page"]) && isset($_GET["data"]))
	{
		$page= $_GET['page'];
		Session::set("page", $page);

		$username= $_GET['data'];
		Session::set("data", $username);
	}
	else
	{
		Session::set("page", NULL);
		Session::set("data", NULL);
	}

	if(Session::get("page") && Session::get("data"))
	{
		$page= Session::get("page");
		$username= Session::get("data");
	}
	
	$track_start_page= ($page-1)*$show_per_page;

	//pagination part-1 end
	
	$search_details= $user->navbarSearchDetails($logged_in_id, $track_start_page, $show_per_page);

	//to show search user followers list	
	
	$search_result_user_id= $user->getSearchingResultUserId($username);

	$search_result_user_followers= $user->getSearchingResultUserFollowers($search_result_user_id, $logged_in_id);
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
					//pagination part-2 start
			
					$pagination_result= $user->paginationForShowingSearchUserPosts($username);
					echo $pagination_result;
					$total_pages= ceil($pagination_result/$show_per_page);

					echo "<span class='pagination'> 
							<a href='?logged_in_id=$logged_in_id&data='".$username."'&page=1'>Start</a>";

							for ($i=1; $i <=$total_pages ; $i++) { 
								
								echo "<a href='?logged_in_id=$logged_in_id&data='".$username."'&page=$i'>$i</a>";
							}

							echo "<a href='?logged_in_id=$logged_in_id&data='".$username."'&page=$total_pages'>End</a> 
						</span>";

					//pagination part-2 end

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
			</div>
		</div>
	<?php } ?>
</div>
<br>

<?php include 'inc/footer.php';	?>