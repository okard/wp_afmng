/* tasks.js */


function afmng_tasks_animeselect()
{
	var v_project_id = jQuery("#cmb_anime").val();
	
	var data = {
		action: 'get_releases',
		project_id: v_project_id
	};
	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
	jQuery.post(ajaxurl, data, function(response) 
	{
		//alert(response);
		jQuery('#cmb_episode').empty();
		try
		{
			var data = JSON.parse(response);
		}
		catch(e)
		{
			alert(e + '\n' + response);
		}
	
		for (var i=0; i<data.length; i++) 
		{
			var option = jQuery('<option />');
			option.attr('value', data[i]['release_id']).text(data[i]['episode_title']);
			jQuery('#cmb_episode').append(option);
		}
	});
}


jQuery(document).ready(function($) 
{
	$("#cmb_anime").change(afmng_tasks_animeselect);
	$('#cmb_anime option:first').removeAttr('selected');
	$("#cmb_anime").trigger("change");
	
});


