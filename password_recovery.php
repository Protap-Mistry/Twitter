<?php 
	include 'inc/header.php';
	// Session::init();
	// Session::checkLogin();
?>

<?php 
	
	$user= new User();

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['pass_recover']))
	{
		$pass_recover= $user->userPasswordRecover($_POST);		
	}
				
?>
<div class="card">
    <div class="card-header">
	    <h2 class="text-center"> ...Recover Your Password... </h2>
	</div>
	<div class="card-body">
		<div class="mycard">
			<?php
			    if(isset($pass_recover))
				{
					echo $pass_recover;
				}
			?>
			<form action=" " method="POST" class="form_label">
                <div class="form-group">
				    <label for="email">Give Your Email Address</label>
					<input type="text" id="email" name="email" class="form-control"/ >
				</div>
				
				<div class="buttons">
                    <div class="one">
                        <button type="submit" name="pass_recover" class="btn btn-success">Recovered</button>	                            
                    </div>
                </div>	
            </form>
        </div>		    
	</div>
</div>

<?php include 'inc/footer.php'; ?>