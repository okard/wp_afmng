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


function afmng_group_dbresult($data, $grouping)
{
	if(count($grouping) == 0)
		return null;

	$current_group = array_shift($grouping);
	$object = array();
	
	foreach($data as $entry)
	{
		$row = array();
		foreach($current_group as $grp_field)
		{
			$row[$grp_field] = $entry->$grp_field;
		}
		$row['__data'] = afmng_group_dbresult($data, $grouping);
		
		array_push($object, $row);
	}
	
	return $object;
}



?>
