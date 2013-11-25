<?php

/**
* Check if current request is a post
*/
function afmng_check_post()
{
	return $_SERVER['REQUEST_METHOD'] === 'POST';
}

/**
* Return a path to a plugin template
*/
function afmng_get_tplfile($filename)
{
	$tpl = get_template_directory().'/afmng/'.$filename;
	if(file_exists($tpl))
		return $tpl;
	else
		return AFMNG_PLUGINDIR.'/tpl/'.$filename;
}


/**
* Edit link to a page find by title
*/
function afmng_editlink_bypagetitle($title)
{
	$page = get_page_by_title($title);
	
	if($page != null)
	{
		return '<a href="'.get_edit_post_link($page->ID).'">Edit</a>';
	}
	else
		return "<p>Keine Seite verfügbar</p>";
}


/**
* User has cap
* Admin has all
*/
function afmng_user_cap($cap, $user_id)
{
	if($user_id != null)
	{
		return user_can($user_id, $cap);
	}
	return current_user_can($cap);
}


?>
