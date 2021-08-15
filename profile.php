<?php
  include 'inc/header.php';
  Session::checkSession();
?>
<?php 
	if(isset($_GET['id']))
	{
		$userid= (int) $_GET['id']; 
	}	
	$user= new User();
	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['update']))
	{
		$updateuser= $user-> updateUserData($userid, $_POST);
	}
?>
		<div class="card">
		    <div class="card-header">
			    <h2 class="text-center"> ...User profile... <span class="pull-right">
				<a class="btn btn-primary" href="index.php"> Back </a>
				</span> 
				</h2>
			</div>
			
			<div class="card-body">
				<div class="mycard">
					<?php
					    if(isset($updateuser))
						{
							echo $updateuser;
						}
					?>
					<?php
						$userdata= $user->getUserById($userid);
						if($userdata)
						{

					?>
					<form action=" " method="POST" enctype="multipart/form-data" class="form_label">
		                <div class="form-group">
						    <label for="name">Your name</label>
							<input type="text" id="name" name="name" class="form-control" value="<?php echo $userdata->name; ?>"/ >
						</div>
						<div class="form-group">
						    <label for="username">Username</label>
							<input type="text" id="username" name="username" class="form-control"  value="<?php echo $userdata->username; ?>"/ >
						</div>
						<div class="form-group">
						    <label for="email">Email address</label>
							<input type="text" id="email" name="email" class="form-control" value="<?php echo $userdata->email; ?>"/ >
						</div>
						<div class="form-group">
						    <label for="image">Image</label>
							<input type="file" id="image" name="image" class="form-control" accept="image/*"/ >

							<img src="<?php echo $userdata->image; ?>" class="img-thumbnail" width="150px" alt="avatar">

						</div>
						<div class="form-group">
						    <label for="bio">Biodata</label>
						    <textarea id="bio" name="bio" class="form-control">
						    	<?php echo $userdata->bio; ?>
						    </textarea>
							
						</div>
						<?php
							$sesid= Session::get("id");
							if($userid==$sesid)
							{
						?>
						<div class="buttons">
	                        <div class="one">
	                            <button type="submit" name="update" class="btn btn-success">Updated</button>
	                            <span><a class="btn btn-info" href="changepass.php?id=<?php echo $userid;?>">Password Change</a></span>
	                            
	                        </div>
	                    </div>
						
						<?php } ?>

		            </form>
					<?php } ?>
	            </div>		    
			</div>
		</div>
		<br>
<?php include 'inc/footer.php';	?>