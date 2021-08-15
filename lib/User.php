<?php
  require "phpMailer/vendor/autoload.php";
      
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
?>

<?php 
	include_once 'Session.php';
	include 'Database.php';
class User
{
	private $db;
	private $table= "users";

	public function __construct()
	{
		$this->db= new dbConnection();
	}

	public function usernameCheck($username)
	{
		$sql= "select username from $this->table where username= :u";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':u', $username);
		$query->execute();
		if($query->rowCount()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function emailCheck($email)
	{
		$sql= "select email from $this->table where email= :email";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':email', $email);
		$query->execute();
		if($query->rowCount()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function userRegistration($data)
	{
		$name= $data['name'];
		$username= $data['username'];
		$email= $data['email'];
		$password= $data['password'];
		$confirm_password= $data['confirm_password'];

		if($name=="" || $username=="" || $email=="" || $password=="" || $confirm_password==""){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Field must not empty.</div>";
			return $msg;
		}

		if(preg_match('/[^A-Za-z0-9 ._-]+/i', $name)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Name must only contain alphanumerical, dashes and underscore.</div>";
			return $msg;
		}

		if(preg_match('/[^A-Za-z0-9 ._-]+/i', $username)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Username must only contain alphanumerical, dot, dashes and underscore.</div>";
			return $msg;
		}elseif (strlen($username)<3) {
				
			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Username is too short </div>";
			return $msg;
		}

		$username_chk= $this->usernameCheck($username);

		if($username_chk==true){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> The username already exist </div>";
			return $msg;
		}

		if(filter_var($email, FILTER_VALIDATE_EMAIL)==false){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong>The email address is not valid. Please put like name@gmail.com </div>";
			return $msg;
		}
		$email_chk= $this->emailCheck($email);

		if($email_chk==true){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> The email address already exist </div>";
			return $msg;
		}

		if(strlen($password)<6){
			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Password is too short. It must be greater than 5 values </div>";
			return $msg;
		}

		if($password != $confirm_password){
			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Password dosen't match. </div>";
			return $msg;
		}

		$password= md5($data['password']);
		
		$sql= "insert into $this->table(name, username, email, password) values(:name, :username, :email, :password)";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':name', $name);
		$query->bindValue(':username', $username);
		$query->bindValue(':email', $email);
		$query->bindValue(':password', $password);
		
		if($query->execute())
		{
			$msg= "<div class='alert alert-success'> <strong> Successfull! </strong>
			Thank You, you have been registered... </div>";
			return $msg;
		}
		else
		{
			$msg= "<div class='alert alert-danger'> <strong> Error! </strong>
			Sorry, there has been problem to insert your details. </div>";
			return $msg;
		}
	}

	public function getLoginUser($username, $password)
	{
		$sql= "select * from $this->table where username= :username and password= :password limit 1";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':username', $username);
		$query->bindValue(':password', $password);
		$query->execute();
		
		return $query->fetch(PDO::FETCH_OBJ);
		
	}
	public function userLogin($data)
	{
		$username= $data['username'];
		$password= ($data['password']);
		$confirm_password= $data['confirm_password'];
				
		if($username== "" OR $password== "" OR $confirm_password== "")
		{
			$msg= "<div class='alert alert-danger'> <strong> Error! </strong>
			Field must not be empty </div>";
			return $msg;
		}

		if(preg_match('/[^A-Za-z0-9 ._-]+/i', $username)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Username must only contain alphanumerical, dot, dashes and underscore.</div>";
			return $msg;
		}elseif (strlen($username)<3) {
				
			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Username is too short.</div>";
			return $msg;
		}

		$username_chk= $this->usernameCheck($username);

		if($username_chk==false){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> The username doesn't match. </div>";
			return $msg;
		}

		if(strlen($password)<6)
		{
			$msg= "<div class='alert alert-danger'> <strong> Error! </strong>
			Password is too short. It must be greater than 5 values </div>";
			return $msg;
		}

		if($password != $confirm_password){
			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Password dosen't match. </div>";
			return $msg;
		}

		$password= md5($data['password']);

		$result= $this->getLoginUser($username, $password);

		if($result)
		{
			Session::init();
			Session::set("login", true);
			Session::set("id", $result->id);
			Session::set("name", $result->name);
			Session::set("username", $result->username);
			Session::set("email", $result->email);
			Session::set("loginmsg", "<div class='alert alert-success'> <strong>Successfull! </strong>
			You are logged in... </div>");
			echo "<script> window.location= 'index.php'; </script>";
		}
		else
		{
			$msg= "<div class='alert alert-danger'> <strong> Error! </strong>
			Incorrect password ! </div>";
			return $msg;
		}
	}
	public function getUserData()
	{
		$sql= "select * from $this->table order by id desc";
		$query= dbConnection::myPrepareMethod($sql);		
		$query->execute();
		
		$result= $query->fetchAll();
		return $result;
	}
	public function getUserById($id)
	{
		$sql= "select * from $this->table where id= :id limit 1";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':id', $id);
		$query->execute();
		
		$result= $query->fetch(PDO::FETCH_OBJ);
		return $result;
	}

	public function updateTimeUsernameCheck($username, $id)
	{
		$sql= "select username from $this->table where username= :u and id != $id";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':u', $username);
		$query->execute();
		if($query->rowCount()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function updateUserData($id, $data)
	{
		$name= $data['name'];
		$username= $data['username'];
		$email= $data['email'];
		$bio= $data['bio'];

		/*Image work start*/
	    $permitted= array('jpg', 'jpeg', 'png', 'gif');
	    $image_file_name= $_FILES['image']['name'];
	    $file_size= $_FILES['image']['size'];
	    $file_temp_name= $_FILES['image']['tmp_name'];

	    $divided= explode('.', $image_file_name);
	    $file_extension= strtolower(end($divided));
	    $unique_image= substr(md5(time()), 0, 10).'.'.$file_extension;
	    $uploaded_image= "images/".$unique_image;
	    /*Image work start*/
			
		if($name=="" || $username=="" || $email==""){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Field must not empty ( Image and bio aren't mandatory).</div>";
			return $msg;
		}
		if(preg_match('/[^A-Za-z0-9 ._-]+/i', $name)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Name must only contain alphanumerical, dashes and underscore.</div>";
			return $msg;
		}

		if(preg_match('/[^A-Za-z0-9 ._-]+/i', $username)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Username must only contain alphanumerical, dot, dashes and underscore.</div>";
			return $msg;
		}elseif (strlen($username)<3) {
				
			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Username is too short </div>";
			return $msg;
		}

		$update_time_username_chk= $this->updateTimeUsernameCheck($username, $id);

		if($update_time_username_chk==true){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> The username already exist </div>";
			return $msg;
		}

		if(filter_var($email, FILTER_VALIDATE_EMAIL)==false){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong>The email address is not valid. Please put like name@gmail.com </div>";
			return $msg;
		}

		if(!empty($image_file_name))
        {

			if($file_size>1048567)
			{
		        $msg= "<div class='alert alert-danger'> <strong> Error!!! </strong>Image size should be less than 1 MB. </div>";
		        return $msg;
		    }
		    elseif (in_array($file_extension, $permitted) === false) 
		    {
		        $msg= "<div class='alert alert-danger'> <strong> Error!!! </strong>You can upload only: ".implode(', ', $permitted)."</div>";
		        return $msg;
		    }
		    else
		    {
		        move_uploaded_file($file_temp_name, $uploaded_image);
		    }

			$sql= "update $this->table set name= :name, username= :username, email= :email, image=:i, bio= :b where id= :id";
			$query= dbConnection::myPrepareMethod($sql);
			$query->bindValue(':name', $name);
			$query->bindValue(':username', $username);
			$query->bindValue(':email', $email);
			$query->bindValue(':i', $uploaded_image);
			$query->bindValue(':b', $bio);
			$query->bindValue(':id', $id);
			
			if($query->execute())
			{
				$msg= "<div class='alert alert-success'> <strong> Successfull! </strong>
				Your data updated successfully ...</div>";
				return $msg;
			}
			else
			{
				$msg= "<div class='alert alert-danger'> <strong> Error! </strong>
				Sorry, User data not updated !!!  </div>";
				return $msg;
			}
		}
		else
        {
	        $sql= "update $this->table set name= :name, username= :username, email= :email, bio= :b where id= :id";
			$query= dbConnection::myPrepareMethod($sql);
			$query->bindValue(':name', $name);
			$query->bindValue(':username', $username);
			$query->bindValue(':email', $email);
			$query->bindValue(':b', $bio);
			$query->bindValue(':id', $id);
	          
	        if($query->execute())
			{
				$msg= "<div class='alert alert-success'> <strong> Successfull! </strong>
				Your data updated successfully ...</div>";
				return $msg;
			}
			else
			{
				$msg= "<div class='alert alert-danger'> <strong> Error! </strong>
				Sorry, User data not updated !!!  </div>";
				return $msg;
			}
        }
	}
	public function checkPassword($id, $old_pass)
	{
		$password= md5($old_pass);
		$sql= "select password from $this->table where id= :id  and  password= :password";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':id', $id);
		$query->bindValue(':password', $password);
		$query->execute();
		if($query->rowCount()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function updatePassword($id, $data)
	{
		$old_pass= $data['old_pass'];
		$new_pass= $data['password'];

		if($old_pass== "" OR $new_pass== "")
		{
			$msg= "<div class='alert alert-danger'> <strong> Error! </strong>Field must not be empty!!! </div>";
			return $msg;
		}
		$chk_pass= $this->checkPassword($id, $old_pass);
		
		if($chk_pass== false)
		{
			$msg= "<div class='alert alert-danger'> <strong> Error! </strong>Old password not exist!!! </div>";
			return $msg;
		}
		if(strlen($new_pass)<=5)
		{
			$msg= "<div class='alert alert-danger'> <strong> Error! </strong>Password length is too short. You have put at least 6 values </div>";
			return $msg;
		}

		$password=md5($new_pass);

		$sql= "update $this->table set password= :password where id= :id";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':password', $password);		
		$query->bindValue(':id', $id);
		
		if($query->execute())
		{
			$msg= "<div class='alert alert-success'> <strong> Successfull! </strong>Password updated successfully </div>";
			return $msg;
		}
		else
		{
			$msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, Password not updated !!!  </div>";
			return $msg;
		}
	}

	//recovery customer password by sending email
    public function userPasswordRecover($data){
      $email= $data['email'];

      if($email == ""){
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Field must not be empty !!!</div> </br>";
        return $msg;
      }
      if(filter_var($email, FILTER_VALIDATE_EMAIL)==false){

        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>The email address is not valid. Please put like name@gmail.com </div> </br>";
        return $msg;    
      }

      $email_chk= $this->emailCheck($email);

      if($email_chk==true)
      {
        
        $new_generate= substr($email, 0, 3);
        $random= rand(10000, 99999);
        $combine= "$new_generate$random";
        $new_pass= md5($combine);

        $sql= "update users set password= :p where email= :email";
        $query= dbConnection::myPrepareMethod($sql);

        $query->bindValue(':p', $new_pass);
        $query->bindValue(':email', $email);
        $query->execute();

        //new work start

        $sender = 'sender_email@gmail.com';

        $developmentMode = true;
        $mailer = new PHPMailer($developmentMode);
        $mailer->Mailer = "smtp";

        try 
        {
            $mailer->SMTPDebug = 0;
            $mailer->isSMTP();

            if ($developmentMode) 
            {
                $mailer->SMTPOptions = [
                    'ssl'=> [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    ]
                ];
            }

            $mailer->Host = 'smtp.gmail.com';
            $mailer->SMTPAuth = true;
            $mailer->Username = $sender;
            $mailer->Password = 'sender_email_password';
            $mailer->SMTPSecure = 'tls';
            $mailer->Port = 587;

            $mailer->setFrom($sender, 'Author');
            $mailer->addAddress($email);

            $mailer->isHTML(true);
            $mailer->Subject = 'Your New Password';
            $mailer->Body = "Your new password is ".$combine.". Please visit our website to login";
       
            //$mailer->ClearAllRecipients();
            //echo "E-mail has been sent successfully !!!";
            if($mailer->send())
            {
              $msg= "<div class='alert alert-success'>E-mail has been sent successfully !!! Please check your email for getting new password.</div> </br>";
              return $msg;
            }
        } 
        catch (Exception $e) 
        {
            echo "E-mail sending failed. INFO: " . $mailer->ErrorInfo;
        }
        //new work end           
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong> The email address doesn't exist. </div> </br>";
        return $msg;
      }
    }

	public function userPost($id, $data)
	{
		$user_id= $id;
		$post= $data['post_content'];

		// if($post== "")
		// {
		// 	$msg= "<div class='alert alert-danger'> <strong> Error! </strong>Field must not be empty!!! </div>";
		// 	return $msg;
		// }

		$sql= "insert into posts(user_id, post) values(:u_id, :p)";
		$query= dbConnection::myPrepareMethod($sql);

		$query->bindValue(':u_id', $user_id);
		$query->bindValue(':p', $post);

		if($query->execute())
		{
			//to get notification
			$notify_query= "select receiver_id from followers where sender_id='".$user_id."'";
			$stmt= dbConnection::myPrepareMethod($notify_query);
			$stmt->execute();
			$result= $stmt->fetchAll();

			foreach ($result as $value) 
			{
				$notify_text= '<b>'.$this->getUsernameForNotify($user_id).'</b> has share new post(s)';

				$insert= "insert into notifications(notify_receiver_id, notify_text, read_notify) values('".$value['receiver_id']."','".$notify_text."', 'no')"; 
				$insert_stmt= dbConnection::myPrepareMethod($insert);
				$insert_stmt->execute();
			}
		}
		else
		{
			$msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, there has been problem to create your post.  </div>";
			return $msg;
		}

		
	}
	//to get username from whom logged_in_user get notification
	public function getUsernameForNotify($user_id)
	{
		$sql= "select username from users where id='".$user_id."'";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$result= $stmt->fetchAll();

		foreach ($result as $value) 
		{
			return $value["username"]; 
		}
	}
	public function countNotification($receiver_id)
	{
		$sql= "select count(notify_id) as total from notifications where notify_receiver_id='".$receiver_id."' and read_notify= 'no'";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$result= $stmt->fetchAll();

		foreach ($result as $value) 
		{
			return $value["total"]; 
		}
	}
	public function loadNotification($receiver_id)
	{
		$sql= "select * from notifications where notify_receiver_id='".$receiver_id."' order by notify_id desc";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$result= $stmt->fetchAll();

		$total_rows= $stmt->rowCount();

		$output= '';

		if($total_rows>0)
		{
			foreach ($result as $value) 
			{
				$output .= '<li> <a href="#">@'.$value["notify_text"].'</a></li>';
			}
		}
		return $output;
	}

	public function showPost($logged_in_id, $track_start_page, $show_per_page)
	{
		$output= '';

		// $sql="select posts.*, users.username, users.image from posts 
		// 	inner join users on posts.user_id= users.id where posts.user_id=$logged_in_id
		// 	group by posts.id 
		// 	order by posts.id desc";
		$sql="select * from posts 
			inner join users 
			on posts.user_id= users.id 
			left join followers 
			on posts.user_id= followers.sender_id 
			where followers.receiver_id=$logged_in_id 
			or posts.user_id=$logged_in_id
			group by posts.post_id 
			order by posts.post_id desc 
			limit $track_start_page, $show_per_page";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$result= $stmt->fetchAll();
		// var_dump($sql);
		$row_count= $stmt->rowCount();
		//echo "string ". $row_count;
		if($row_count>0)
		{
			foreach ($result as $value) 
			{
				$profile_image= '';

				if($value['image'] != '')
				{
					$profile_image= '<img src="'.$value["image"].'" class="img-thumbnail img-responsive" />';
				}
				else
				{
					$profile_image= '<img src="images/user.png" class="img-thumbnail img-responsive" />';
				}

				$repost= 'disabled';
				$remove= '';
				$update= '';

				if($value["user_id"] != $logged_in_id)
				{
					$repost= '';					
					$remove= 'disabled';
					$update= 'disabled';
				}

				$output = $output.'
				<div class="jumbotron">
					<div class="row">
						<div class="col-md-2">
						'.$profile_image.'
						</div>
						<div class="col-md-8">
							<h3> <b>@'.$value["username"].'</b></h3>

							<p>'.$value["post"].'<hr>
								<button type="button" class="btn btn-link like_button" data-post_id="'.$value["post_id"].'">
									<i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true"></i> ('.$this->countLike($value["post_id"]).')
								</button>
								<button type="button" class="btn btn-link dislikes" data-toggle="tooltip" data-post_id="'.$value["post_id"].'">
									<i class="fa fa-thumbs-o-down fa-lg" aria-hidden="true"></i> ('.$this->countDislikes($value["post_id"]).') 
								</button>
								<button type="button" class="btn btn-primary post_comment" id="'.$value["post_id"].'" data-user_id="'.$value["user_id"].'">
									<i class="fa fa-comments fa" aria-hidden="true" title="Comments"></i> ('.$this->countComment($value["post_id"]).') 
								</button>

								<button type="button" class="btn btn-primary post_update" data-post_id="'.$value["post_id"].'"'.$update.'>
									<i class="fa fa-pencil-square-o" aria-hidden="true" title="Update"></i> 
								</button>

								<button type="button" class="btn btn-danger post_delete" data-post_id="'.$value["post_id"].'"'.$remove.'>
									<i class="fa fa-trash-o" aria-hidden="true" title="Remove"></i> 
								</button>

								<button type="button" class="btn btn-primary repost" data-post_id="'.$value["post_id"].'"'.$repost.'>
									<i class="fa fa-files-o" aria-hidden="true" title="Repost"></i> ('.$this->countRepost($value["post_id"]).') 
								</button>
							</p>
							<div id="comment_form'.$value["post_id"].'" style="display:none;">
								<span id="old_comment'.$value["post_id"].'"> </span>
								<div class="form-group">
									<textarea name="comment" class="form-control" id="comment'.$value["post_id"].'"></textarea>
								</div>
								<div class="form-group" align="right">
									<button type="button" name="submit_comment" class="btn btn-primary btn-xs submit_comment">Comment</button>
								</div>
							</div>
						</div>
					</div>
				</div>';

			}
		}
		else
		{
			$output= '<h5 class="no_result">Whoops!!! No Post Found...</h5>';
		}
		return $output;
	}

	public function paginationForShowingPosts($logged_in_id)
	{
		$sql= "select count(posts.post_id) from posts 
			inner join users 
			on posts.user_id= users.id 
			left join followers 
			on posts.user_id= followers.sender_id 
			where followers.receiver_id= '".$logged_in_id."' 
			or posts.user_id= '".$logged_in_id."'
			group by posts.post_id 
			order by posts.post_id desc";
	    $result= dbConnection::myPrepareMethod($sql);
	    $result->execute();

	    $result->fetchAll();
		//print_r($result);
		$row_count= $result->rowCount();
	    return $row_count;
	}

	public function showUsers($logged_in_id, $track_start_page, $show_per_page)
	{
		$output= '';

		$sql="select * from users where id != $logged_in_id order by id desc limit $track_start_page, $show_per_page";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$result= $stmt->fetchAll();
		//print_r($result);
		$row_count= $stmt->rowCount();
		//echo "string ". $row_count;
		if($row_count>0)
		{
			foreach ($result as $value) 
			{
				$profile_image= '';

				if($value['image'] != '')
				{
					$profile_image= '<img src="'.$value["image"].'" class="img-thumbnail img-responsive" />';
				}
				else
				{
					$profile_image= '<img src="images/user.png" class="img-thumbnail img-responsive" />';
				}

				$output = $output.'
					<div class="row users">
						<div class="col-md-4">
						'.$profile_image.'
						</div>
						<div class="col-md-8">
							<h4> <b>@'.$value["username"].'</b></h4><p>'.$value["bio"].'</p>'.$this->makeFollower($value["id"], $logged_in_id).'
							<span class="follower_number">('.$value["follower_number"].') Followers</span>
						</div>
					</div><div class="under_users"></div>';

			}			
		}
		else
		{
			$output= '<h5 class="no_result">Whoops!!! No User Found...</h5>';
		}
		return $output;
	}

	public function paginationForShowingUsers($logged_in_id)
	{

		$sql= "select * from users where id != $logged_in_id order by id desc";
	    $result= dbConnection::myPrepareMethod($sql);
	    $result->execute();

	    //$result->fetchAll();
		//print_r($result);
		$row_count= $result->fetchColumn();
		//echo $row_count;
	    return $row_count;
	    
	}

	public function search($logged_in_id)
	{

		$query="select * from users where name like '%".$_POST['query']."%'
				or username like '%".$_POST['query']."%'";
		$stmt= dbConnection::myPrepareMethod($query);
		$stmt->execute();
		$result= $stmt->fetchAll();
		//print_r($result);
		$row_count= $stmt->rowCount();

		$output= '';

		if($row_count>0)
		{
			foreach ($result as $value) 
			{
				$profile_image= '';

				if($value['image'] != '')
				{
					$profile_image= '<img src="'.$value["image"].'" class="img-thumbnail img-responsive" />';
				}
				else
				{
					$profile_image= '<img src="images/user.png" class="img-thumbnail img-responsive" />';
				}

				$output = $output.'
					<div class="row">
						<div class="col-md-4">
						'.$profile_image.'
						</div>
						<div class="col-md-8">
							<h4> <b>@'.$value["username"].'</b></h4><p>'.$value["bio"].'</p>'.$this->makeFollower($value["id"], $logged_in_id).'
							<span class="search_span">('.$value["follower_number"].') Followers</span>
						</div>
					</div>';
			}
			return $output.'<div class="under_search"></div>';
		}
		else
		{ ?>
			<h5 class="no_result"> Whoops !!! no related data found ...</h5>
		<?php }		
	}

	public function makeFollower($sender_id, $receiver_id)
	{
		$sql="select * from followers where sender_id= :s_id and receiver_id= :r_id";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->bindValue(':s_id', $sender_id);
		$stmt->bindValue(':r_id', $receiver_id);
		$stmt->execute();
		$result= $stmt->fetchAll();

		//print_r($result);
		$row_count= $stmt->rowCount();

		$output= '';

		if($row_count>0)
		{
			$output= '<button type="button" name="follow_button" class="btn btn-warning action_button" data-action="unfollow" data-sender_id="'.$sender_id.'">Following</button>';
		}
		else
		{
			$output= '<button type="button" name="follow_button" class="btn btn-info action_button" data-action="follow" data-sender_id="'.$sender_id.'"><i class="fa fa-eye" aria-hidden="true"></i> Follow</button>';
		}
		return $output;
	}

	public function activateFollower($logged_in_id)
	{
		$sql="insert into followers(sender_id, receiver_id) values(:s_id, :r_id)";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->bindValue(':s_id', $_POST["sender_id"]);
		$stmt->bindValue(':r_id', $logged_in_id);
		if($stmt->execute())
		{
			$follow= "update users set follower_number=follower_number+1 where id='". $_POST["sender_id"]."'";
			$update_follow= dbConnection::myPrepareMethod($follow);
			if($update_follow->execute())
			{
				//to get notification				
				$notify_text= '<b>'.$this->getUsernameForNotify($logged_in_id).'</b> has follow you.';

				$insert= "insert into notifications(notify_receiver_id, notify_text, read_notify) values('".$_POST["sender_id"]."','".$notify_text."', 'no')"; 
				$insert_stmt= dbConnection::myPrepareMethod($insert);
				$insert_stmt->execute();
			}
		}
	}
	public function activateUnfollower($logged_in_id)
	{
		$sql="delete from followers where sender_id= :s_id and receiver_id= :r_id";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->bindValue(':s_id', $_POST["sender_id"]);
		$stmt->bindValue(':r_id', $logged_in_id);
		if($stmt->execute())
		{
			$unfollow= "update users set follower_number=follower_number-1 where id='". $_POST["sender_id"]."'";
			$unfollow_stmt= dbConnection::myPrepareMethod($unfollow);
			if($unfollow_stmt->execute())
			{
				//to get notification				
				$notify_text= '<b>'.$this->getUsernameForNotify($logged_in_id).'</b> has unfollow you.';

				$insert= "insert into notifications(notify_receiver_id, notify_text, read_notify) values('".$_POST["sender_id"]."','".$notify_text."', 'no')"; 
				$insert_stmt= dbConnection::myPrepareMethod($insert);
				$insert_stmt->execute();
			}
		}
	}

	public function submitComment($logged_in_id)
	{
		$sql= "insert into comments(post_id, user_id, comment) values(:p_id, :u_id, :c)";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->bindValue(':p_id', $_POST["post_id"]);
		$stmt->bindValue(':u_id', $logged_in_id);
		$stmt->bindValue(':c', $_POST["comment"]);
		if($stmt->execute())
		{
			//to get notification
			$notify_query= "select user_id,post from posts where post_id='".$_POST["post_id"]."'";
			$stmt= dbConnection::myPrepareMethod($notify_query);
			$stmt->execute();
			$result= $stmt->fetchAll();

			foreach ($result as $value) 
			{
				$notify_text= '<b>'.$this->getUsernameForNotify($logged_in_id).'</b> has comment on your post- "'.strip_tags(substr($value["post"], 0, 30)).'..."';

				$insert= "insert into notifications(notify_receiver_id, notify_text, read_notify) values('".$value['user_id']."','".$notify_text."', 'no')"; 
				$insert_stmt= dbConnection::myPrepareMethod($insert);
				$insert_stmt->execute();
			}
		}
		else
		{
			$msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, there has been problem to send your comment.  </div>";
			return $msg;
		}
	}

	public function countComment($post_id)
	{
		$sql= "select * from comments where post_id='".$post_id."'";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$rows= $stmt->rowCount();
		return $rows;

	}

	public function showComments()
	{
		$output= '';

		$sql= "select * from comments
				inner join users
				on comments.user_id=users.id
				where post_id='".$_POST["post_id"]."'
				order by comments.id asc";
		$stmt= dbConnection::myPrepareMethod($sql);

		if($stmt->execute())
		{
			$result= $stmt->fetchAll();
			foreach ($result as $value) 
			{
				$profile_image= '';

				if($value['image'] != '')
				{
					$profile_image= '<img src="'.$value["image"].'" class="img-thumbnail img-responsive img-circle" />';
				}
				else
				{
					$profile_image= '<img src="images/user.png" class="img-thumbnail img-responsive img-circle" />';
				}

				$output = $output.'
					<div class="row">
						<div class="col-md-2">
						'.$profile_image.'
						</div>
						<div class="col-md-10">
							<small> <b>@'.$value["username"].'</b><br/><p class="comment_section">'.$value["comment"].'</p>
							</small>
						</div>
					</div>';
			} 
		}
		return $output;
	}

	public function fetchThePost($logged_in_id)
	{
		$sql= "select * from posts where post_id= '".$_POST['post_id']."' and user_id=$logged_in_id";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$result= $stmt->fetchAll();

		foreach ($result as $value) {
	
			$data[]= $value;
		}
		return json_encode($data);
	}
	public function updateThePost($post, $logged_in_id)
	{
		$error = '';
 		$success = '';

		$data = array(
		   	':user_id' => $logged_in_id,
		   	':post' => $post,
		   	':post_id' => $_POST["post_id"]
	  	);

	  	$sql= "update posts set user_id=:user_id, post=:post where post_id=:post_id";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute($data);
		
		$success = 'The Post Updated';

		$output = array(
		  'success'  => $success,
		  'error'   => $error
		);
		echo json_encode($output);
	}

	public function removePost($logged_in_id)
	{
		$sql= "delete from posts where post_id='".$_POST["post_id"]."' and user_id=$logged_in_id";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
	}

	public function repost($logged_in_id)
	{
		$sql= "select * from repost where post_id='".$_POST["post_id"]."' and user_id=$logged_in_id";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$row_count= $stmt->rowCount();

		if($row_count>0)
		{
			echo "You have already repost this post";
		}
		else
		{
			$sql2= "insert into repost(post_id,user_id) values('".$_POST["post_id"]."', $logged_in_id)";
			$stmt2= dbConnection::myPrepareMethod($sql2);
			if($stmt2->execute())
			{
				$sql3= "select * from posts where post_id='".$_POST["post_id"]."'";
				$stmt3= dbConnection::myPrepareMethod($sql3);
				if($stmt3->execute())
				{
					$result= $stmt3->fetch();					

					$post_content= '';

					$post_content= $result['post'];
				
					// foreach ($result as $value) 
					// {
					// 	//var_dump($value);
					// 	$post_content= $value['post'];
					// }

					$sql4= "insert into posts(user_id,post) values($logged_in_id, '".$post_content."')";
					$stmt4= dbConnection::myPrepareMethod($sql4);
					if($stmt4->execute())
					{	
						//to get notification
						$notify_query= "select user_id,post from posts where post_id='".$_POST["post_id"]."'";
						$stmt= dbConnection::myPrepareMethod($notify_query);
						$stmt->execute();
						$result= $stmt->fetchAll();

						foreach ($result as $value) 
						{
							$notify_text= '<b>'.$this->getUsernameForNotify($logged_in_id).'</b> has repost your post- "'.strip_tags(substr($value["post"], 0, 30)).'..."';

							$insert= "insert into notifications(notify_receiver_id, notify_text, read_notify) values('".$value['user_id']."','".$notify_text."', 'no')"; 
							$insert_stmt= dbConnection::myPrepareMethod($insert);
							$insert_stmt->execute();
						}

						echo "Repost done successfully !!!";
					}
					else
					{
						echo "Whoops!!! There has been a problem to repost this post";
					}
				}
				else
				{
					echo "Execution problem";
				}
			}
			else
			{
				echo "Execution problem";
			}
		}
	}	

	public function countRepost($post_id)
	{
		$sql= "select * from repost where post_id='".$post_id."'";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$rows= $stmt->rowCount();
		return $rows;

	}

	public function like($logged_in_id)
	{
		$sql= "select * from likes where post_id='".$_POST["post_id"]."' and user_id=$logged_in_id";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$row_count= $stmt->rowCount();

		if($row_count>0)
		{
			echo "You have already like this post";
		}
		else
		{
			$sql2= "insert into likes(post_id,user_id) values('".$_POST["post_id"]."', $logged_in_id)";
			$stmt2= dbConnection::myPrepareMethod($sql2);
			if($stmt2->execute())
			{
				//to get notification
				$notify_query= "select user_id,post from posts where post_id='".$_POST["post_id"]."'";
				$stmt= dbConnection::myPrepareMethod($notify_query);
				$stmt->execute();
				$result= $stmt->fetchAll();

				foreach ($result as $value) 
				{
					$notify_text= '<b>'.$this->getUsernameForNotify($logged_in_id).'</b> has like your post- "'.strip_tags(substr($value["post"], 0, 30)).'..."';

					$insert= "insert into notifications(notify_receiver_id, notify_text, read_notify) values('".$value['user_id']."','".$notify_text."', 'no')"; 
					$insert_stmt= dbConnection::myPrepareMethod($insert);
					$insert_stmt->execute();
				}
			}
			
			echo "Like a post";
		}
	}
	public function countLike($post_id)
	{
		$sql= "select * from likes where post_id='".$post_id."'";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$rows= $stmt->rowCount();
		return $rows;

	}

	public function showLiker()
	{
		$output= '';

		$sql= "select * from likes
			inner join users
			on likes.user_id=users.id
			where likes.post_id='".$_POST["post_id"]."'";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$result= $stmt->fetchAll();
		
		foreach ($result as $value) 
		{
			$output=$output.'<p>@'.$value["username"].'</p>';
		}
		echo $output;
	}

	public function dislike($logged_in_id)
	{
		$sql= "select * from dislikes where post_id='".$_POST["post_id"]."' and user_id=$logged_in_id";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$row_count= $stmt->rowCount();

		if($row_count>0)
		{
			echo "You have already given dislike to this post";
		}
		else
		{
			$sql2= "insert into dislikes(post_id,user_id) values('".$_POST["post_id"]."', $logged_in_id)";
			$stmt2= dbConnection::myPrepareMethod($sql2);
			if($stmt2->execute())
			{
				//to get notification
				$notify_query= "select user_id,post from posts where post_id='".$_POST["post_id"]."'";
				$stmt= dbConnection::myPrepareMethod($notify_query);
				$stmt->execute();
				$result= $stmt->fetchAll();

				foreach ($result as $value) 
				{
					$notify_text= '<b>'.$this->getUsernameForNotify($logged_in_id).'</b> has dislike your post- "'.strip_tags(substr($value["post"], 0, 30)).'..."';

					$insert= "insert into notifications(notify_receiver_id, notify_text, read_notify) values('".$value['user_id']."','".$notify_text."', 'no')"; 
					$insert_stmt= dbConnection::myPrepareMethod($insert);
					$insert_stmt->execute();
				}
			}
			
			echo "Put dislike to a post";
		}
	}
	public function countDislikes($post_id)
	{
		$sql= "select * from dislikes where post_id='".$post_id."'";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$rows= $stmt->rowCount();
		return $rows;

	}
	public function showDisliker()
	{
		$output= '';

		$sql= "select * from dislikes
			inner join users
			on dislikes.user_id=users.id
			where dislikes.post_id='".$_POST["post_id"]."'";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$result= $stmt->fetchAll();
		
		foreach ($result as $value) 
		{
			$output=$output.'<p>@'.$value["username"].'</p>';
		}
		echo $output;
	}

	//notification number remove after seeing 
	public function updateNotifationStatus($logged_in_id)
	{
		$sql= "update notifications set read_notify='yes' where notify_receiver_id='".$logged_in_id."'";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
	}

	//navbar search to get whole details of users
	public function navbarSearchToGetWholeDetailsOfAnUser($logged_in_id)
	{
		$sql= "select username, image from users where username like '%".$_POST['query_type']."%' and id != $logged_in_id";

		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$result= $stmt->fetchAll();

		foreach ($result as $value) 
		{
			$data[]= $value["username"]; //it stores all username data under this $data variable in a re-format
		}
		return json_encode($data); //it will convert data in json format and send to ajax request

	}

	public function navbarSearchDetails($logged_in_id, $track_start_page, $show_per_page)
	{
		$output= '';

		$sql= "select * from posts
				inner join users on
				posts.user_id= users.id
				where users.username='".$_GET["data"]."'
				group by posts.post_id
				order by posts.post_id desc limit $track_start_page, $show_per_page";
		//"data" get from scripts_using_ajax_jquery file
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$result= $stmt->fetchAll();
		$row_count= $stmt->rowCount();
		//echo "string ". $row_count;
		if($row_count>0)
		{
			foreach ($result as $value) 
			{
				$profile_image= '';

				if($value['image'] != '')
				{
					$profile_image= '<img src="'.$value["image"].'" class="img-thumbnail img-responsive" />';
				}
				else
				{
					$profile_image= '<img src="images/user.png" class="img-thumbnail img-responsive" />';
				}

				$repost= 'disabled';
				$remove= '';
				$update= '';

				if($value["user_id"] != $logged_in_id)
				{
					$repost= '';
					$remove= 'disabled';
					$update= 'disabled';
				}

				$output = $output.'
				<div class="jumbotron">
					<div class="row">
						<div class="col-md-2">
						'.$profile_image.'
						</div>
						<div class="col-md-8">
							<h3> <b>@'.$value["username"].'</b></h3>

							<p>'.$value["post"].'<hr>
								<button type="button" class="btn btn-link like_button" data-post_id="'.$value["post_id"].'">
									<i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true"></i> ('.$this->countLike($value["post_id"]).')
								</button>
								<button type="button" class="btn btn-link dislikes" data-toggle="tooltip" data-post_id="'.$value["post_id"].'">
									<i class="fa fa-thumbs-o-down fa-lg" aria-hidden="true"></i> ('.$this->countDislikes($value["post_id"]).') 
								</button>
								<button type="button" class="btn btn-primary post_comment" id="'.$value["post_id"].'" data-user_id="'.$value["user_id"].'">
									<i class="fa fa-comments fa" aria-hidden="true" title="Comments"></i> ('.$this->countComment($value["post_id"]).') 
								</button>
								<button type="button" class="btn btn-primary post_update" data-post_id="'.$value["post_id"].'"'.$update.'>
									<i class="fa fa-pencil-square-o" aria-hidden="true" title="Update"></i> 
								</button>
								<button type="button" class="btn btn-danger post_delete" data-post_id="'.$value["post_id"].'"'.$remove.'>
									<i class="fa fa-trash-o" aria-hidden="true" title="Remove"></i> 
								</button>
								<button type="button" class="btn btn-primary repost" data-post_id="'.$value["post_id"].'"'.$repost.'>
									<i class="fa fa-files-o" aria-hidden="true" title="Repost"></i> ('.$this->countRepost($value["post_id"]).') 
								</button>
							</p>
							<div id="comment_form'.$value["post_id"].'" style="display:none;">
								<span id="old_comment'.$value["post_id"].'"> </span>
								<div class="form-group">
									<textarea name="comment" class="form-control" id="comment'.$value["post_id"].'"></textarea>
								</div>
								<div class="form-group" align="right">
									<button type="button" name="submit_comment" class="btn btn-primary btn-xs submit_comment">Comment</button>
								</div>
							</div>
						</div>
					</div>
				</div>';

			}
		}
		else
		{
			$output= '<h5 class="no_result">Whoops!!! No Post Found...</h5>';
		}
		return $output;
	}

	public function paginationForShowingSearchUserPosts($username)
	{
		$sql= "select count(posts.post_id) from posts
				inner join users on
				posts.user_id= users.id
				where users.username='".$username."'
				group by posts.post_id
				order by posts.post_id desc";
	    $result= dbConnection::myPrepareMethod($sql);
	    $result->execute();

	    $result->fetchAll();
		print_r($result);
		$row_count= $result->rowCount();
	    return $row_count;
	}

	public function getSearchingResultUserId($username)
	{
		$sql= "select id from users where username= '".$username."'";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$result= $stmt->fetchAll();
		
		foreach ($result as $value)
		{
			return $value["id"];
		}
	}
	public function getSearchingResultUserFollowers($search_result_user_id, $logged_in_id)
	{
		$output= '';

		$sql= "select * from users
				inner join followers
				on followers.receiver_id=users.id
				where followers.sender_id= '".$search_result_user_id."'";

		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$result= $stmt->fetchAll();
		
		$row_count= $stmt->rowCount();
		//echo "string ". $row_count;
		if($row_count>0)
		{
			foreach ($result as $value) 
			{
				$profile_image= '';

				if($value['image'] != '')
				{
					$profile_image= '<img src="'.$value["image"].'" class="img-thumbnail img-responsive" />';
				}
				else
				{
					$profile_image= '<img src="images/user.png" class="img-thumbnail img-responsive" />';
				}

				$output = $output.'
					<div class="row users">
						<div class="col-md-4">
						'.$profile_image.'
						</div>
						<div class="col-md-8">
							<h4><b><a href="navbar_search_result.php?data='.$value["username"].'">'.'@'.$value["username"].'</a></b></h4><p>'.$value["bio"].'</p>'.$this->makeFollower($value["id"], $logged_in_id).'
							<span class="follower_number">('.$value["follower_number"].') Followers</span>
						</div>
					</div><div class="under_users"></div>';

			}
		}
		else
		{
			$output= '<h5 class="no_result">Whoops!!! No Followers Found...</h5>';
		}
		return $output;
	}
}
?>