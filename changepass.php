<?php
  include 'inc/header.php';
  Session::checkSession();
?>
<?php 
	if(isset($_GET['id']))
	{
		$userid= (int) $_GET['id']; 
		$sesid= Session::get("id");

		if($userid!=$sesid)
		{
			echo "<script> window.location= 'index.php'; </script>";
		}				
	}	
	$user= new User();

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['updatepass']))
	{
		$updatepass= $user-> updatePassword($userid, $_POST);
	}
?>

<div class="card">
    <div class="card-header">
	    <h2 class="text-center"> ...Change Password... <span class="pull-right">
		<a class="btn btn-primary" href="profile.php?id=<?php echo $userid; ?>"> Profile </a>
		</span> 
		</h2>
	</div>
	
	<div class="card-body">
		<div class="mycard">
			<?php
			    if(isset($updatepass))
				{
					echo $updatepass;
				}
			?>
			
			<form action="" method="POST" class="form_label">
                <div class="form-group">
				    <label for="old_pass">Old_password</label>
					<input type="password" id="old_pass" name="old_pass" class="form-control"/ >
				</div>
				<div class="form-group">
				    <label for="password">New_password</label>
					<input type="password" id="password" name="password" class="form-control" / >
				</div>
				
				<div class="buttons">
                    <div class="one">
                        <button type="submit" name="updatepass" class="btn btn-success">Updated</button>
                        <span><button type="reset" name="clear" class="btn btn-warning">Clear</button></span>
                        
                    </div>
                </div>									
            </form>				
        </div>		    
	</div>
</div>
<br>
<script>
	$(document).ready(function(){
		$(".author").addClass("active");
		$(".home").removeClass("active");
	});
</script>
<?php include 'inc/footer.php';	?>