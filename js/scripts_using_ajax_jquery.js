$(document).ready(function()
{	

	//share post
	$('#post_form').on('submit', function(event)
	{
		event.preventDefault();
		// let post_content = $('#post_content').val();
		// console.log(post_content);

		//for posting image or video with text
		if($('#post_type').val() == 'upload')
		{
			$('#post_content').val($('#sub_division').html());
		}
		//for posting link
		if($('#post_type').val() == 'link')
		{
			$('#post_content').val($('#link_content').html());
			
			$('#link_content').css('padding', '0');
			$('#link_content').css('background-color', '');
			$('#link_content').css('margin-bottom', '0');
		}
		//for posting simple text
		if($('#post_content').val() == '')
		{

			alert('Enter Story Content');
		}
		else
		{
			var form_data= $(this).serialize();

			$.ajax({
				url: "index.php",
				method: "POST",
				data: form_data,

				success:function(data)
				{
					alert('Post has been shared');
					$('#post_form')[0].reset();

					$('#uploadFile').val="";
					document.getElementById('post_content').value= "";
					var area = "<textarea name='post_content' rows='4' id='post_content' maxlength='200' class='form-control' placeholder='Write your short story (upto 200 characters)...You can also upload image, video, audio and website link'></textarea>";
					$('#dynamic_field').html(area);

					$('#link_content').html(''); 

					fetch_post();
				}

			});
		}
	});

	//start to image/video upload with text
	$('#uploadFile').on('change', function(event){

		var html= '<div class="main_division" id="main_division">';
		html += '<div id="sub_division" contenteditable class="form-control"</div><h4>Fetching...</h4></div>';
		html += '<input type="hidden" name="post_content" id="post_content" />';

		$('#post_type').val('upload');

		$('#dynamic_field').html(html); 

		$('#uploadImage').ajaxSubmit({
			target: '#sub_division',
			resetForm: true,

		});	
	});

	//end to image/video upload with text

	//start to link with video upload 

	$(document).on('keyup', '#post_content', function(){
		var check_content= $('#post_content').val();
		var check_url= /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;

		var if_url= check_content.match(check_url);

		if(if_url)
		{
			$('#link_content').css('padding', '16px');
			$('#link_content').css('background-color', '#f9f9f9');
			$('#link_content').css('margin-bottom', '16px');

			$('#link_content').html('<h4>Fetching...</h4>');

			$('#post_type').val('link');

			var action= 'fetch_link_content';

			$.ajax({
				url: "upload.php",
				method: "POST",
				data: {action:action, url:if_url},
				//action and url are variables, action and if_url are values
				success:function(data)
				{
					var title= $(data).filter("meta[property='og:title']").attr('content');//it fetch the value of content attribute of og:title meta tag property
					var description= $(data).filter("meta[property='og:description']").attr('content');
					var image= $(data).filter("meta[property='og:image']").attr('content'); 

					if(title == undefined)
					{
						title= $(data).filter("meta[name='twitter:title']").attr('content');
					}
					if(description == undefined)
					{
						description= $(data).filter("meta[name='twitter:description']").attr('content');
					}
					if(image == undefined)
					{
						image= $(data).filter("meta[name='twitter:image']").attr('content');
					}

					var output= '<p><a href="'+if_url[0]+'" target="_blank">'+if_url[0]+'</a></p>';//it will make clickable link which we have shared

					output += '<img src="'+image+'" class="img-responsive img-thumbnail" />'; //it will display image from link property

					output += '<h3><b>'+title+'</b></h3>'; //it will displays link meta title
					output += '<p>'+description+'</p>';

					$('#link_content').html(output);

				}
			})
		}
		else
		{
			$('#link_content').html('');
			$('#link_content').css('padding', '0');
			$('#link_content').css('background-color', '');
			$('#link_content').css('margin-bottom', '');

			return false;
		}
	});

	//end to link with video upload

	fetch_post();

	function fetch_post()
	{

		var action= 'fetch_post';
		
		//$('#post_list').html('');
		$.ajax({
				url: "fetch_posts.php",
				method: "POST",
				data: {action: action},

				success:function(data)
				{
					//console.log(data);
					
					$('#post_list').html(data);
				}

			});
	}

	fetch_users();

	function fetch_users()
	{
		var action= 'fetch_users';

		$.ajax({
			url: "users_list.php",
			method: "POST",
			data: {action: action},

			success:function(data)
			{
				$('#users_list').html(data);
			}
		});
	}

	$(document).on('click', '.action_button', function(){
		var sender_id= $(this).data('sender_id');
		var action= $(this).data('action');
		$.ajax({
			url: "follow_unfollow_button_actions.php",
			method: "POST",
			data:{sender_id:sender_id, action:action},
			success:function(data)
			{
				fetch_users();
				fetch_post();
			}
		});
	});

	var post_id;
	var user_id;

	$(document).on('click', '.post_comment', function(){
		
		post_id= $(this).attr('id');
		user_id= $(this).data('user_id');

		var show_comment= 'fetch_comment';

		$.ajax({
			url: 'comments_reply.php',
			method: 'POST',
			data: {post_id:post_id, user_id:user_id,show_comment:show_comment},

			success:function(data)
			{
				$('#old_comment'+post_id).html(data);

				$('#comment_form'+post_id).slideToggle('slow');
			}

		});
		
	});
	
	$(document).on('click', '.submit_comment', function(){
		
		var comment= $('#comment'+post_id).val();

		var action= 'submit_comment';
		var receiver_id= user_id;

		if(action != '')
		{
			$.ajax({
				url: "comments_reply.php",
				method: "POST",
				data:{post_id:post_id, receiver_id:receiver_id, comment:comment, action:action},
				success:function(data)
				{
					$('#comment_form'+post_id).slideUp('slow');
					fetch_post();
				}
			});
		}

	});

	$(document).on('click','.repost', function(){

		var post_id= $(this).data('post_id');
		//console.log(post_id);
		var copy_the_post= 'repost';

		$.ajax({
			url: "comments_reply.php",
			method: "POST",
			data: {post_id:post_id, copy_the_post:copy_the_post},

			success:function(data)
			{

				alert(data);
				//console.log(fetch_post());
				fetch_post();

			}
		});
	});

	$(document).on('click', '.like_button', function(){

		var post_id= $(this).data('post_id');
		var like_the_post= 'like';

		$.ajax({
			url: "reacts.php",
			method: "POST",
			data: {post_id:post_id, like_the_post:like_the_post},

			success:function(data)
			{

				alert(data);
				//console.log(fetch_post());
				fetch_post();

			}
		});
	});

	//start to show the users who like(s) the post
	//$('[data-toggle="tooltip"]').tooltip();
	$('body').tooltip({
		selector: '.like_button',
		title: fetch_users_who_like_the_post,
		html: true,
		placement: 'right'
	});

	function fetch_users_who_like_the_post()
	{

		let fetch_data= '';
		var element= $(this); //it well get the like_button property
		var post_id= element.data('post_id');
		//console.log(post_id);
		var liker= 'users_list_who_throw_like';
		
		fetch_data = $.ajax({
			url: "reacts.php",
			method: "POST",
			data: {post_id:post_id, liker:liker},

			async: false,
	
		}).responseText;
		// console.log(fetch_data);
		return fetch_data;
	}

	//end to show the users who like(s) the post

	$(document).on('click', '.dislikes', function(){

		var post_id= $(this).data('post_id');
		var dislikes= 'dislike';

		$.ajax({
			url: "reacts.php",
			method: "POST",
			data: {post_id:post_id, dislikes:dislikes},

			success:function(data)
			{
				alert(data);
				fetch_post();
			}
		});
	});

	//start to show the users who dislike the post
	$(document).tooltip({
		selector: '.dislikes',
		title: fetch_users_who_dislike_the_post,
		html: true,
		placement: 'right'
	});

	function fetch_users_who_dislike_the_post()
	{	
		let fetch_data2= '';
		var element2= $(this); //it well get the dislikes property
		var post_id2= element2.data('post_id');

		var dislike= 'fetch_disliker';
		
		fetch_data2 = $.ajax({
			url: "reacts.php",
			method: "POST",
			data: {post_id:post_id2, disliker:dislike},

			async: false,
	
		}).responseText;
		//console.log(fetch_data2);
		return fetch_data2;
	}
	//end to show the users who dislike the post

	//to remove notification number after seeing
	$('#view_notification').click(function()
	{
		var notify_clear= 'update_notification_status';

		$.ajax({
			url: "notify_status.php",
			method: "POST",
			data: {notify_clear:notify_clear},

			success:function(data)
			{
				$('#total_notification').remove();
			}

		});
	});

	//navbar search to get whole details of users

	$('#navbar_search').typeahead({
		source:function(query_type, result)
		{
			$('.typeahead').css('position', 'absolute');

			var nav_search= 'search_users_to_get_details';

			$.ajax({
				url: "search.php",
				method: "POST",
				data: {query_type:query_type, nav_search:nav_search},
				dataType:"json",

				success:function(data)
				{
					result($.map(data, function(item){
						return item;
					}));
				}
			});
		}
	});

	//to show search result into a page of searching usesr details
	$(document).on('click', '.typeahead li', function(){

		var search_query= $(this).text(); //return text on which one we click
		window.location.href="navbar_search_result.php?data="+search_query;
	});

	//update a post
	$(document).on('click', '.post_update', function()
	{
		var post_id= $(this).data('post_id');

		$.ajax({
			url: "update_remove.php",
			method: "POST",
			data: {post_id:post_id},
			dataType: 'json',

			success:function(data)
			{
				localStorage.setItem('post', data[0].post);

				//dialogify portion start
				var options = {				
				    ajaxPrefix:'',
				};

				new Dialogify('update.php', options)
			    .title('Update the Post') // dialog title
			    .buttons([ // custom buttons
			        {
			          text: 'Cancel',
			          type: Dialogify.BUTTON_DANGER,
			          click: function(e){
			              this.close();
			          }
			        },
			        {
			          text: 'Update',
			          type: Dialogify.BUTTON_PRIMARY,
			          click: function(e)
			          {
			          	var form = document.querySelector('#update_form2');
			            var form_data= new FormData(form);
			            //console.log(form_data);

			            form_data.append('post', $('#post_content2').val());
			            form_data.append('post', $('#link_content2').val());
			            form_data.append('post_id', data[0].post_id);

			            $.ajax({
							url: "update_remove.php",
							method: "POST",
							data: form_data,
							dataType: 'json',
							contentType:false,
							cache:false,
							processData:false,
							
							success:function(data)
							{
								if(data.error != '')
						        {
						           $('#form_response').html('<div class="alert alert-danger">'+data.error+'</div>');
					          	}
					          	else
					          	{
						           $('#form_response').html('<div class="alert alert-success">'+data.success+'</div>');
						           fetch_post();
								}
							} 
						});

			          }
			        }
			    ]).showModal(); // shows the modal

				//dialogify portion end
			}
		});
	});

	//delete a post
	$(document).on('click','.post_delete', function(){

		var post_id= $(this).data('post_id');
		//console.log(post_id);
		var remove= 'remove_the_post';

		swal({
		  	title: "Are you sure to delete this post?",
		  	text: "Once deleted, you will not be able to recover this Data !!!",
		  	icon: "warning",
		  	buttons: true,
		  	dangerMode: true,
		})
		.then((willDelete) => 
		{
		  	if (willDelete) 
		  	{
			    $.ajax({
			    	type: "POST",
			    	url: "update_remove.php",
			    	data: {post_id:post_id, remove:remove},
			    	success: function(response)
			    	{
			    		swal({
			    			title: "Post deleted successfully !!!",
			    			text: "You clicked the button!",
			    			icon: "success",
			    		})
			    		.then((result) => 
			    		{
			    			fetch_post();
			    		});			    		
		    		}
		    	});
		  	}
		});
	});
	

});