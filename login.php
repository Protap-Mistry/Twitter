<?php
  include 'inc/header.php';
  Session::init();
  //Session::checkLogin();
?>

<?php
	if(isset($_SESSION['id']))
	{
		 echo "<script> window.location= 'index.php'; </script>";
	}
?>

<?php
	$user= new User();
	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['login']))
	{
		$userLogin= $user-> userLogin($_POST);
	}
?>
		<div class="card">
		    <div class="card-header">
			    <h2 class="text-center"> ...User Login... </h2>
			</div>
			<div class="card-body">
				<div class="mycard">
					<?php
					    if(isset($userLogin))
						{
							echo $userLogin;
						}
					?>
					<form action=" " method="POST" class="form_label">
		                <div class="form-group">
						    <label for="username">Username</label>
							<input type="text" id="username" name="username" class="form-control"/ >
						</div>
						<div class="form-group">
						    <label for="password"> Password</label>
							<input type="password" id="password" name="password" class="form-control"/ >
						</div>
						<div class="form-group">
						    <label for="confirm_password">Confirm Password</label>
							<input type="password" id="confirm_password" name="confirm_password" class="form-control"/ >
						</div>
						
						<div class="buttons">
	                        <div class="one">
	                            <button type="submit" name="login" class="btn btn-success">Logged_in</button>
	                            <span><button type="reset" name="clear" class="btn btn-warning">Clear</button></span>
	                            
	                        </div>
	                        <div class="two">
	                            <a href="password_recovery.php" class="btn btn-primary stretched-link pull-right">Recovery Password?</a>
	                        </div>
	                    </div>						
		            </form>
	            </div>		    
			</div>
		</div>
		<br>
<?php include 'inc/footer.php';	?>