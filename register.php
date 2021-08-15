<?php
  include 'inc/header.php'; 
?>

<?php 

	if(isset($_SESSION['id']))
	{
		echo "<script> window.location= 'index.php'; </script>";
	}
?>
<?php
	$user= new User();
	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['register']))
	{
		$userRegi= $user-> userRegistration($_POST);
	}
?>
		<div class="card">
		    <div class="card-header">
			    <h2 class="text-center"> ...User Registration...</h2>
			</div>
			<div class="card-body">
				<div class="mycard">
					<?php
					    if(isset($userRegi))
						{
							echo $userRegi;
						}
					?>
					<form action=" " method="POST" class="form_label">
		                <div class="form-group">
						    <label for="name">Your name</label>
							<input type="text" id="name" name="name" class="form-control"/ >
						</div>
						<div class="form-group">
						    <label for="username">Username</label>
							<input type="text" id="username" name="username" class="form-control"/ >
						</div>
						<div class="form-group">
						    <label for="email">Email address</label>
							<input type="text" id="email" name="email" class="form-control"/ >
						</div>
						<div class="form-group">
						    <label for="password">Password</label>
							<input type="password" id="password" name="password" class="form-control"/ >
						</div>
						<div class="form-group">
						    <label for="confirm_password">Confirm Password</label>
							<input type="password" id="confirm_password" name="confirm_password" class="form-control"/ >
						</div>

						<div class="buttons">
	                        <div class="one">
	                            <button type="submit" name="register" class="btn btn-success">Registered</button>
	                            <span><button type="reset" name="clear" class="btn btn-warning">Clear</button></span>
	                            
	                        </div>
	                    </div>
		            </form>
            	</div>		    
			</div>
		</div>
		<br>
<?php include 'inc/footer.php';	?>