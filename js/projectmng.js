/* projectmng.js */

function afmng_do_form_post(data)
{
	//add key/value from data
	var form = jQuery("#dummyForm");
	
	jQuery.each(data, function(key, value) 
	{
		jQuery("<input type='hidden' />")
		.attr("name", key)
		.attr("value", value)
		.appendTo(form);
	});
	
	form.submit();
}

//delete project

function afmng_project_delete(project_id)
{
	 jQuery.jconfirm(
	    {
			title: 'Projekt löschen',
			message: 'Dieses Projekt ('+project_id+') wirklich löschen?',
			confirm: 'Ja',
			cancel: 'Nein'
		}, 
		function() 
		{
			//make an ajax delete request
				
			//ajax request
			var data = {
				action: 'project_delete',
				project_id: project_id
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
	);
}

//delete episode/release
function afmng_release_delete(release_id, delete_tasks)
{
	jQuery.jconfirm(
	    {
			title: 'Release löschen',
			message: 'Diesen Release ('+release_id+') wirklich löschen?',
			confirm: 'Ja',
			cancel: 'Nein'
		}, 
		function() 
		{
			//make an ajax delete request
				
			//ajax request
			var data = {
				action: 'episode_delete',
				release_id: release_id,
				delete_tasks: delete_tasks
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
	);
}


//delete task?

//delete all tasks

/**
* Show episode
*/
function afmng_episode_show(release_id)
{
	//ajax request
	var data = {
		view: 'episode',
		release_id: release_id
	};
			
	afmng_do_form_post(data);	
}
