<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-dark mynav">
  	<a class="navbar-brand" href="index.php"> <img src="images/twitter.svg" class="img-thumbnail img-circle logo" alt="Logo"></a>
  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    	<span class="navbar-toggler-icon"></span>
  	</button>

  	<div class="collapse navbar-collapse" id="navbarSupportedContent">
    	<ul class="navbar-nav mr-auto">
      		<li class="nav-item active home">
        		<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      		</li>
      		<li class="nav-item">
        		<a class="nav-link" href="#">Author</a>
      		</li>
		     <!--  <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          Dropdown
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item" href="#">Action</a>
		          <a class="dropdown-item" href="#">Another action</a>
		          <div class="dropdown-divider"></div>
		          <a class="dropdown-item" href="#">Something else here</a>
		        </div>
		      </li> -->
      
    	</ul>

    	<ul class="navbar-nav my-2 my-lg-0">

		  	<?php
		  		$user= new User();

			    $id= Session::get("id");
			    $userlogin= Session::get("login");
			    $username= Session::get("username");

			    if($userlogin==true)
			    {

				   $total_notification= $user->countNotification($id);
				   //$notify= $user->loadNotification($id);

		   ?>

		   	<li>
		   		 
                <div class="row align-items-center">
                    <span class="input-group-btn">
				        <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
				    </span>
    				<input type="text" name="navbar_search" id="navbar_search" class="form-control input-sm navbar_search" placeholder="Search user(s) using username to get whole details ..." autocomplete="off" />
    			</div>
    	
    		</li>

		   	<li class="nav-item dropdown">
		   		<a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="view_notification">
		   			Notification
		   			<?php 
		   				
		   				if($total_notification>0)
		   				{
		   					echo '<span id="total_notification"> ('.$total_notification.')</span>';
		   				}
		   			?>
		   			<span class="caret"></span>
		   		</a>
		   		<ul class="dropdown-menu for_notify_menu">
		   			<?php
		   				
		   				echo $user->loadNotification($id);
		   			?>
		   		</ul>
		   	</li>

		  	<li class="dropdown">
		   		<a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		   			<?php echo $username;?>
		   			<span class="caret"></span>
		   		</a>
		   		<ul class="dropdown-menu usermenu">
		   			
				   	<li> <a href="profile.php?id=<?php echo $id; ?>" > Profile </a>  </li>
				   	<li> <a href="?action=logout"> Logout </a> </li>
		   		</ul>
		   </li>
			   
		   <?php }else{ ?>

	            <li class="nav-item login_active">
	              <a class="nav-link" href="login.php">Login</a>
	            </li>
	            <li class="nav-item register_active">
	                <a class="nav-link" href="register.php">Register</a>
	            </li>

           <?php } ?>
		</ul>
  </div>
</nav>
<br>