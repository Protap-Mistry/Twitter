<?php
  include 'inc/header.php';
  //Session::checkSession();
 
?>

<?php
	if(!isset($_SESSION['id']))
	{
		echo "<script> window.location= 'login.php'; </script>";
	}
?>

<?php
	$loginmsg= Session::get("loginmsg");
	if(isset($loginmsg))
	{
		echo $loginmsg;
	}
	Session::set("loginmsg", NULL);
?>

<?php 
	$user= new User();
	$id= Session::get("id");

	//start for pagination
	
	if(isset($_GET["page"])){

		$page= $_GET['page'];
		Session::set("page", $page);
	}
	else
	{
		Session::set("page", NULL);
	}
	//end for pagination

	if(isset($_POST['action']) && $_POST['action'] == 'insert')
	{

		$post= $user-> userPost($id, $_POST);
		
	}
	
?>

<div class="row">
	<div class="col-md-8">
		<div class="card">
		    <div class="card-header">
		    	<div class="row">
		    		<div class="col-md-8">
		    			<h3 class="card-title">Start from right here ...</h3>
		    		</div>
		    		<div class="col-md-4">
						<div class="image_upload">
							<form action="upload.php" method="POST" id="uploadImage">

								<input type="file" class="novisible" name="uploadFile" id="uploadFile" accept=".jpg, .png, .mp3, .mp4"/>
								<label for="uploadFile" class="btn btn-md btn-teak pull-right">
									<i class="fa fa-cloud-upload fa-2x" aria-hidden="true"> </i> <span>Upload</span>
								</label>

							</form>
						</div>
					</div>
				</div>	  
			</div>
			
			<div class="card-body">
				<form method="POST" id="post_form">
					<div class="form-group" id="dynamic_field">
						<textarea name="post_content" rows="4" id="post_content" maxlength="200" class="form-control" placeholder="Write your short story (upto 200 characters)...You can also upload image, video, audio and website link"></textarea>
					</div>
					<div id="link_content">
						
					</div>
					<div class="form-group">
						
						<input type="hidden" name="action" value="insert">
						<input type="hidden" name="post_type" id="post_type" value="text">
						<input type="submit" name="share_post" id="share_post" class="btn btn-success pull-right" value="Tweet">
						
					</div>
				</form>			    
			</div>
		</div>
		<br>
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Trending Now !!!</h3>
			</div>
			<div class="card-body">
				<div class="row postcard">
					<div id="post_list">
						
					</div>
				</div>
			</div>			
		</div>		
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Users list</h3>
			</div>
			<br>
			<div class="row search">
				<div class="col-lg-12">
				    <div class="input-group">
				      	<span class="input-group-btn">
				        	<button class="btn btn-default" type="button">@</button>
				      	</span>
				      	<input type="text" name="search_text" id="search_text" class="form-control" placeholder="Search user using (user)name to (un)follow...">
				    </div><!-- /input-group -->
				</div><!-- /.col-lg-12 -->
			</div><!-- /.row -->

			<br/>
			<div id="result"></div>
			<div style="clear:both"></div>

			<div class="card-body">
				<div id="users_list">
					
				</div>
			</div>
			
		</div>
	</div>
</div>
<br>
<?php include 'inc/footer.php';	?>