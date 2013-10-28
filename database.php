<?php

class afmngdb
{
	public static $tbl_projects;
	public static $tbl_releases;
	public static $tbl_release_steps;
	public static $tbl_release_steps_map;
	

    public static function setup() 
    {
		global $wpdb;
		self::$tbl_projects = $wpdb->prefix . "afmng_projects";
		self::$tbl_releases = $wpdb->prefix . "afmng_releases";
		self::$tbl_release_steps  = $wpdb->prefix . "afmng_release_steps";
		self::$tbl_release_steps_map = $wpdb->prefix . "afmng_release_steps_map";
    }

}

afmngdb::setup();
$afmngdb = 'afmngdb';

/**
* Return a project list
*/
function afmng_db_project_list()
{
	global $wpdb;
	
	
	return $wpdb->get_results( 
		"
		SELECT p.project_id, 
			   p.anime_name
		FROM ".afmngdb::$tbl_projects." as p
		WHERE p.completed = false
		"
	);
}

/**
* Get releases for a project
*/
function afmng_db_project_releases($projectid)
{
	global $wpdb;
	
	$sql = $wpdb->prepare( 
		"
		SELECT r.release_id,
			   r.episode_no,
			   r.episode_title
		FROM ".afmngdb::$tbl_releases." as r
		WHERE r.project_id=%d
		",
		$projectid
        );
        
	return $wpdb->get_results($sql);
}

/**
* get steps of a release
*/
function afmng_db_release_steps($releaseid)
{
	global $wpdb;
	
	$sql = $wpdb->prepare( 
		"
		SELECT sm.step_id,
			   s.name as step_name,
			   sm.user,
			   sm.state_no,
			   sm.description
		FROM ".afmngdb::$tbl_release_steps_map." as sm
		INNER JOIN ".afmngdb::$tbl_release_steps." as s
			ON s.step_id = sm.step_id	
		WHERE sm.release_id=%d
		",
		$releaseid
        );
        
	return $wpdb->get_results($sql);
}

function afmng_db_steps_state($state_no)
{
	switch($state_no)
	{
		case 1:
			return 'Offen';
		case 2:
			return 'In Bearbeitung';
		case 3:
			return 'Erledigt';
	}
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
* Get active tasks/steps for username
*/
function afmng_db_gettasks($user)
{
	global $wpdb;	
	
	return $wpdb->get_results( 
		"
		SELECT
			p.anime_name,
			r.episode_no,
			r.episode_title,
			s.name,
			sm.state_no
		FROM ".afmngdb::$tbl_release_steps_map." as sm
		INNER JOIN ".afmngdb::$tbl_release_steps." as s
			ON s.step_id = sm.step_id
		INNER JOIN ".afmngdb::$tbl_releases." as r 
			ON sm.release_id = r.release_id
		INNER JOIN ".afmngdb::$tbl_projects." as p
			ON p.project_id = r.project_id
		WHERE
			sm.user = '$user'
		"
	);
}

?>
