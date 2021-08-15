<?php
	$filepath= realpath(dirname(__FILE__));
	include_once $filepath.'./lib/Session.php';

	include 'lib/User.php';
	Session::init();
	Session::checkSession();
?>
<?php 

	if(!empty($_FILES))
	{
		$file_extension= strtolower(pathinfo($_FILES["uploadFile"]["name"], PATHINFO_EXTENSION));
		$new_file_name= rand().'.'.$file_extension;

		$source_path= $_FILES["uploadFile"]["tmp_name"];
		$target_path= 'images/'.$_FILES["uploadFile"]["name"];

		if(move_uploaded_file($source_path, $target_path))
		{
			if($file_extension == 'jpg' || $file_extension == 'png')
			{
				echo '<p><img src="'.$target_path.'" class="img-responsive img-thumbnail" width="500px" height="300px"/></p><br/>';
			}
			if($file_extension == 'mp3' || $file_extension == 'mp4')
			{
				echo '<div class="embed-responsive embed-responsive-16by9">
				<video class="embed-responsive-item" controls="controls" src="'.$target_path.'"> </video> </div>';
			}
		}
	}

	if(isset($_POST['action']) && $_POST["action"] =="fetch_link_content")
	{
		echo file_get_contents($_POST["url"][0]);//it returns file in string format
	}
?>