<?php

class afmngdb
{
	public static $tbl_projects;
	public static $tbl_releases;

    public static function setup() 
    {
		global $wpdb;
		self::$tbl_projects = $wpdb->prefix . "afmng_projects";
		self::$tbl_releases = $wpdb->prefix . "afmng_releases";
    }

}

afmngdb::setup();
$afmngdb = 'afmngdb';

/**
* Return a project list
*/
function afmng_project_list()
{
	global $wpdb;
	
	return $wpdb->get_results( 
		"
		SELECT project_id, anime_name, anime_description, creation_date
		FROM ".afmngdb::$tbl_projects."
		ORDER BY creation_date DESC
		"
	);
}


function afmng_projects_lastreleases()
{
	global $wpdb;
	
	return $wpdb->get_results( 
		"
		SELECT p.project_id, p.anime_name, r.release_id, MAX(r.creation_date) as creation_date, r.translation_status
		FROM ".afmngdb::$tbl_projects." as p
		LEFT JOIN ".afmngdb::$tbl_releases." as r 
			ON p.project_id = r.project_id
		ORDER BY p.creation_date DESC
		"
	);
}


function afmng_projects_add($name, $description)
{
	global $wpdb;

	$wpdb->insert( 
		afmngdb::$tbl_projects, 
		array( 
			'anime_name' => $name, 
			'anime_description' => $description,
			'creation_date' => current_time( 'mysql', 1 )
		), 
		array( 
			'%s', 
			'%s',
			'%s'
		) 
	);
	
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



?>
