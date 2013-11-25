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
			option.attr('value', data[i]['release_id']).text(data[i]['episode_no']+' / '+data[i]['episode_title']);
			jQuery('#cmb_episode').append(option);
		}
	});
}


jQuery(document).ready(function($) 
{
	//register anime select 
	$("#cmb_anime").change(afmng_tasks_animeselect);
	$('#cmb_anime option:first').removeAttr('selected');
	$("#cmb_anime").trigger("change");
});


/**
* Update a task for a user
*/
function afmng_tasks_update(task_id)
{
	//extract state_no
	//extract description
	var state_no = jQuery("#state_no\\:"+task_id).val();
	var description = jQuery("#description\\:"+task_id).val();
	
	//ajax request
	var data = {
		action: 'task_update',
		task_id: task_id,
		state_no: state_no,
		description: description
	};
	
	//alert(JSON.stringify(data));
	
	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
	jQuery.post(ajaxurl, data, function(response) 
	{
		try
		{
			var data = JSON.parse(response);
			
			//check for errors
			if(data.error)
			{
				alert(data.msg);
			}
			
			//dummy submit
			jQuery("#dummyForm").submit();
		}
		catch(e)
		{
			alert(e + '\n' + response);
		}
	});
}

/**
* Remove own user from a task
*/
function afmng_tasks_free(task_id)
{
	alert("Not yet implemented");
}


/**
* assign the current task to user
*/
function afmng_tasks_accept(task_id)
{
	//ajax request
	var data = {
		action: 'task_accept',
		task_id: task_id
	};
	
	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
	jQuery.post(ajaxurl, data, function(response) 
	{
		try
		{
			var data = JSON.parse(response);
			
			//check for errors
			if(data.error)
			{
				alert(data.msg);
			}
			
			//dummy submit
			jQuery("#dummyForm").submit();
		}
		catch(e)
		{
			alert(e + '\n' + response);
		}
	});
}


/**
* Create a task and assign it to user
*/
function afmng_tasks_create_assign()
{
	alert("Not yet implemented");
}


/**
* Delete a task
*/ 
function afmng_tasks_delete(task_id)
{
	//ajax request
	var data = {
		action: 'task_delete',
		task_id: task_id
	};
	
	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
	jQuery.post(ajaxurl, data, function(response) 
	{
		try
		{
			var data = JSON.parse(response);
			
			//check for errors
			if(data.error)
			{
				alert(data.msg);
			}
			
			//dummy submit
			jQuery("#dummyForm").submit();
		}
		catch(e)
		{
			alert(e + '\n' + response);
		}
	});
}
