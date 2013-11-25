/* projectmng.js */

/**
* Do form post
*/
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

/**
* Do ajax post
*/
function afmng_do_ajax_post(data)
{
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
* Delete project
*/
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
			afmng_do_ajax_post(data);
		}
	);
}

/**
* Delete a release/episode
*/
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
			afmng_do_ajax_post(data);
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

/**
* Clear project status
*/
function afmng_project_clear_status(project_id)
{
	jQuery.jconfirm(
		{
			title: 'Projekt zurücksetzen',
			message: 'Status des Projekts ('+project_id+') wirklich zurücksetzen?',
			confirm: 'Ja',
			cancel: 'Nein'
		}, 
		function() 
		{
			//ajax request
			var data = {
				action: 'project_clear_status',
				project_id: project_id
			};
			afmng_do_ajax_post(data);
		}
	);
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
	afmng_do_ajax_post(data);
}

/**
* Remove own user from a task
*/
function afmng_tasks_free(task_id)
{
	//ajax request
	var data = {
		action: 'task_free',
		task_id: task_id
	};
	afmng_do_ajax_post(data);
}


/**
* Remove own user from a task
*/
function afmng_episode_delete_tasks(release_id)
{
	jQuery.jconfirm(
	    {
			title: 'Aufgaben löschen',
			message: 'Alle Aufgaben der Episode('+release_id+') wirklich löschen?',
			confirm: 'Ja',
			cancel: 'Nein'
		}, 
		function() 
		{
			//ajax request
			var data = {
				action: 'episode_delete_tasks',
				release_id: release_id
			};
			afmng_do_ajax_post(data);
		}
	);
}


