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
	$tpl = get_template_directory().'/'.$filename;
	if(file_exists($tpl))
		return $tpl;
	else
		return AFMNG_PLUGINDIR.'/tpl/'.$filename;
}


?>
