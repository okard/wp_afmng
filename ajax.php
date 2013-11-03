<?php

add_action('wp_ajax_get_releases', 'afmng_ajax_get_releases');

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




?>
