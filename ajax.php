<?php

//======================================================================
//data receive functions:

/**
* give release list for combobox in json format
*/
add_action('wp_ajax_get_releases', 'afmng_ajax_get_releases');
function afmng_ajax_get_releases() 
{
	$project_id = $_POST['project_id'];
	
	$data = afmng_db_project_releases($project_id);
	
	ob_clean();
	echo json_encode($data);
	die(); // this is required to return a proper result
}


/**
* deliver a step list
*/ 
add_action('wp_ajax_get_steps', 'afmng_ajax_get_steps');
function afmng_ajax_get_steps()
{
	ob_clean();
	echo json_encode(afmng_db_steps());
	die();
}

//======================================================================
//special functions:

/**
* Assign a task to user
*/
add_action('wp_ajax_task_accept', 'wp_ajax_task_accept');
function wp_ajax_task_accept()
{
	//accept task for current user
	$task_id = $_POST['task_id'];
	
	try 
	{
		$user = wp_get_current_user()->user_login;
		afmng_db_task_accept($task_id, $user);
		ob_clean();
		echo json_encode(true);
		die();
	} 
	catch (Exception $e) 
	{
		$res = array("error"=>true, msg=>$e->getMessage() );
		ob_clean();
		echo json_encode($res);
		die();
	}
}

/**
* Assign a task to user
*/
add_action('wp_ajax_task_create_assign', 'wp_ajax_task_create_assign');
function wp_ajax_task_create_assign()
{
	//accept task for current user
	$release_id = $_POST['release_id'];
	$step_id = $_POST['step_id'];
	
	try 
	{
		$user = wp_get_current_user()->user_login;
		afmng_db_task_add($release_id, $step_id, $user);
		ob_clean();
		echo json_encode(true);
		die();
	} 
	catch (Exception $e) 
	{
		$res = array("error"=>true, msg=>$e->getMessage() );
		ob_clean();
		echo json_encode($res);
		die();
	}
}

/**
* Release a task from an user
*/
add_action('wp_ajax_task_free', 'wp_ajax_task_free');
function wp_ajax_task_free()
{
	//accept task for current user
	$task_id = $_POST['task_id'];
	
	try 
	{
		afmng_db_task_free($task_id);
		ob_clean();
		echo json_encode(true);
		die();
	} 
	catch (Exception $e) 
	{
		$res = array("error"=>true, msg=>$e->getMessage() );
		ob_clean();
		echo json_encode($res);
		die();
	}
}


/**
* Release a task from an user
*/
add_action('wp_ajax_project_clear_status', 'wp_ajax_project_clear_status');
function wp_ajax_project_clear_status()
{
	//accept task for current user
	$project_id = $_POST['project_id'];
	
	try 
	{
		afmng_project_update($project_id, null, false, false);
		ob_clean();
		echo json_encode(true);
		die();
	} 
	catch (Exception $e) 
	{
		$res = array("error"=>true, msg=>$e->getMessage() );
		ob_clean();
		echo json_encode($res);
		die();
	}
}



//======================================================================
//update functions:

//update task(tid, state, desc)
add_action('wp_ajax_task_update', 'wp_ajax_task_update');
function wp_ajax_task_update()
{
	$task_id = $_POST['task_id'];
	$state_no =  $_POST['state_no'];
	$description = $_POST['description'];
	
	try 
	{
		afmng_db_task_update($task_id, $state_no, $description);
		ob_clean();
		echo json_encode(true);
		die();
	} 
	catch (Exception $e) 
	{
		$res = array("error"=>true, msg=>$e->getMessage() );
		ob_clean();
		echo json_encode($res);
		die();
	}
}



//======================================================================
//delete functions:

//delete project(pid)
add_action('wp_ajax_project_delete', 'wp_ajax_project_delete');
function wp_ajax_project_delete()
{
	//TODO security handling
	$project_id = $_POST['project_id'];
	
	try 
	{
		afmng_project_delete($project_id);
		ob_clean();
		echo json_encode(true);
		die();
	} 
	catch (Exception $e) 
	{
		//errors:
		//- has episodes
		//- does not exist
	
		$res = array("error"=>true, msg=>$e->getMessage());
		ob_clean();
		echo json_encode($res);
		die();
	}
}

//delete episode(eid)
add_action('wp_ajax_episode_delete', 'wp_ajax_episode_delete');
function wp_ajax_episode_delete()
{
	//TODO security handling
	
	$release_id = $_POST['release_id'];
	$delete_tasks = filter_var($_POST['delete_tasks'], FILTER_VALIDATE_BOOLEAN);
	
	try 
	{
		if($delete_tasks)
		{
			//delete all tasks from episode
			afmng_db_release_delete_tasks($release_id);
		}
		
		afmng_db_release_delete($release_id);
		ob_clean();
		echo json_encode(true);
		die();
	} 
	catch (Exception $e) 
	{
		//errors:
		//- has tasks
		//- does not exist
	
		$res = array( "error"=>true, msg=>$e->getMessage() );
		ob_clean();
		echo json_encode($res);
		die();
	}
}

//delete task(tid)
add_action('wp_ajax_task_delete', 'wp_ajax_task_delete');
function wp_ajax_task_delete()
{
	//TODO security handling
	
	$task_id = $_POST['task_id'];
	
	try 
	{
		afmng_db_task_delete($task_id);
		ob_clean();
		echo json_encode(true);
		die();
	} 
	catch (Exception $e) 
	{
		//errors:
		//- has episodes
		//- does not exist
	
		$res = array( "error"=>true, msg=>$e->getMessage() );
		ob_clean();
		echo json_encode($res);
		die();
	}
}

//delete tasks(eid) all tasks of an episode


?>
