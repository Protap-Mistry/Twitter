$(document).ready(function(){

	load_data();
	function load_data(query)
	{
		$.ajax({
			url:"search.php",
			method:"POST",
			data:{query:query},
			success:function(data)
			{
				$('#result').html(data);
			}
		});
	}
	
	$('#search_text').keyup(function(){
		var search = $(this).val();
		if(search != '')
		{
			load_data(search);
		}
		else
		{
			load_data();			
		}
	});

	// 	$('#search_text').keyup(function()
	// {
	// 	var search= $(this).val();

	// 	if(search != '')
	// 	{
	// 		$.ajax({
	// 			url: "helper.php",
	// 			method: "POST",
	// 			data: {query: search},
	// 			dataType: "text",

	// 			success:function(data)
	// 			{
	// 				$('#result').html(data);
	// 			}
	// 		});
	// 	}
	// 	else
	// 	{
	// 		$('#result').html('');
	// 	}
	// });
});