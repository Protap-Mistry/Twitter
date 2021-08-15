<div class="card-header">
	<div class="row">
		<div class="col-md-8">
			<h2 class="card-title"></h2>
		</div>
		<div class="col-md-4">
			<div class="image_upload">
				<form action="update.php" method="POST" id="uploadImage">

					<input type="file" class="novisible" name="uploadFile" id="uploadFile2" accept=".jpg, .png, .mp3, .mp4"/>
					<label for="uploadFile" class="btn btn-md btn-teak pull-right">
						<i class="fa fa-cloud-upload fa-2x" aria-hidden="true"> </i> <span>Upload</span>
					</label>

				</form>
			</div>
		</div>
	</div>	  
</div>
<span id="form_response"></span>
<div class="card">
	<div class="card-body">
		<form method="POST" id="update_form2">
			<div class="form-group" id="dynamic_field">
				<textarea name="post_content2" rows="4" id="post_content2" maxlength="200" class="form-control" placeholder="Write your short story (upto 200 characters)...You can also upload image, video, audio and website link"></textarea>
			</div>
			<div id="link_content2">
				
			</div>
			<div class="form-group">
				
				<input type="hidden" name="action" value="update">
				<input type="hidden" name="post_type" id="post_type" value="text">
				<!-- <input type="submit" name="share_post" id="post_update" class="btn btn-success pull-right" value="Tweet"> -->
				
			</div>
		</form>			    
	</div>	
</div>
<script>
	$(document).ready(function(){
		var post= localStorage.getItem('post');

		$('#post_content2').val(post);
		//$('#uploadFile2').val(post);
		$('#link_content2').val(post);
	});
</script>