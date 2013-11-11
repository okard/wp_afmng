<?php

add_action('wp_ajax_get_releases', 'afmng_ajax_get_releases');

//======================================================================
//data receive functions:

/**
* give release list for combobox in json format
*/
function afmng_ajax_get_releases() 
{
	$project_id = $_POST['project_id'];
	
	$data = afmng_db_project_releases($project_id);
	
	ob_clean();
	echo json_encode($data);
	die(); // this is required to return a proper result
}


add_action('wp_ajax_get_steps', 'afmng_ajax_get_steps');

/**
* deliver a step list
*/ 
function afmng_ajax_get_steps()
{
	ob_clean();
	echo json_encode(afmng_db_steps());
	die();
}

//======================================================================
//update functions:

//update task(tid, state, desc)
add_action('wp_ajax_task_update', 'wp_ajax_task_update');
function wp_ajax_task_update()
{
	ob_clean();
	echo json_encode(false);
	die();
}



//======================================================================
//delete functions:

//delete project(pid)
add_action('wp_ajax_project_delete', 'wp_ajax_project_delete');
function wp_ajax_project_delete()
{
	//TODO security handling
	$project_id = $_POST['project_id'];
	
	//errors:
	//- has episodes
	//- does not exist
	
	ob_clean();
	echo json_encode(false);
	die();
}

//delete episode(eid)
add_action('wp_ajax_episode_delete', 'wp_ajax_episode_delete');
function wp_ajax_episode_delete()
{
	//TODO security handling
	
	$release_id = $_POST['release_id'];
	
	//errors:
	//- has episodes
	//- does not exist
	
	ob_clean();
	echo json_encode(false);
	die();
}

//delete task(tid)

//delete tasks(eid)


?>
