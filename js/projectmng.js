/* projectmng.js */


//delete project

function afmng_project_delete(project_id)
{
	 jQuery.jconfirm(
	    {
			title: 'Projekt löschen',
			message: 'Dieses Projekt wirklich löschen?',
			confirm: 'Ja',
			cancel: 'Nein'
		}, 
		function() 
		{
			alert('Löschen');
				//make an ajax delete request
			
			//raise a postback for now
			jQuery("#dummyForm").submit();
	
			return false;
		}
	);
}

//delete episode

//delete task?
