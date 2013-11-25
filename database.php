<?php

class afmngdb
{
	public static $tbl_anime;
	public static $tbl_episode;
	public static $tbl_steps;
	public static $tbl_tasks;
	
	
	public static $step_state = array(0 => 'Offen', 1 => 'In Bearbeitung', 2 => 'Erledigt');
	//TODO: Rückesprache erforderlich?
	
	public static $caps = array('afmng_user',
								'afmng_admin',
								'afmng_rawprovider',
								'afmng_translator',
								'afmng_edit',
								'afmng_typeset',
								'afmng_karaoke',
								'afmng_qc',
								'afmng_qcd',
								'afmng_mux',
								'afmng_hardsub');

    public static function setup() 
    {
		global $wpdb;
		self::$tbl_anime = $wpdb->prefix . "afmng_anime";
		self::$tbl_episode = $wpdb->prefix . "afmng_episode";
		self::$tbl_steps  = $wpdb->prefix . "afmng_steps";
		self::$tbl_tasks = $wpdb->prefix . "afmng_tasks";
    }

}

afmngdb::setup();
$afmngdb = 'afmngdb';


//======================================================================
//project functions:

/**
* Return a project list
*/
function afmng_db_project_list()
{
	global $wpdb;
	
	return $wpdb->get_results( 
		"
		SELECT p.project_id, 
			   p.anime_name,
			   p.completed,
			   p.licensed
		FROM ".afmngdb::$tbl_anime." as p
		WHERE p.completed = false
		AND p.licensed = false
		"
	);
}

/**
* Return a project list
*/
function afmng_db_projects_closed()
{
	global $wpdb;
	
	return $wpdb->get_results( 
		"
		SELECT p.project_id, 
			   p.anime_name,
			   p.completed,
			   p.licensed
		FROM ".afmngdb::$tbl_anime." as p
		WHERE p.completed = true
		OR p.licensed = true
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
		FROM ".afmngdb::$tbl_episode." as r
		WHERE r.project_id=%d
		ORDER BY r.episode_no ASC
		",
		$projectid
        );
        
	return $wpdb->get_results($sql);
}


/**
* Add a new anime project
*/
function afmng_project_add($name)
{
	global $wpdb;

	$wpdb->insert( 
		afmngdb::$tbl_anime, 
		array( 
			'anime_name' => $name, 
		), 
		array( 
			'%s'
		) 
	);
	
}

/**
* Update a project
*/
function afmng_project_update($project_id, $name, $completed, $licensed)
{
	global $wpdb;
	
	$columns = array();
	$format = array();
	
	if(isset($name))
	{
		$columns['anime_name'] = $name;
		array_push($format, '%s');
	}
	if(isset($completed))
	{
		$columns['completed'] = $completed;
		array_push($format, '%d');
	}
	if(isset($licensed))
	{
		$columns['licensed'] = $licensed;
		array_push($format, '%d');
	}
	
	$wpdb->update( 
	afmngdb::$tbl_anime, 
	$columns, 
	array( 'project_id' => $project_id ), 
	$format, 
	array( '%d' ) 
    );
}


/**
* Update a project
*/
function afmng_project_delete($project_id)
{
	global $wpdb;
	
	$res = $wpdb->delete(afmngdb::$tbl_anime, array( 'project_id' => $project_id ), array( '%d' ) );
	
	if(!$res)
	{
		throw new Exception($wpdb->last_error);
	}
	
}



//======================================================================
//release/episode functions:

function afmng_db_release_get($release_id)
{
	global $wpdb;
	
	$results = $wpdb->get_results(
		$wpdb->prepare(
			"
			SELECT 
				r.release_id,
				r.episode_no,
				r.episode_title,
				p.anime_name
			FROM ".afmngdb::$tbl_episode." as r
			INNER JOIN ".afmngdb::$tbl_anime." as p
				ON p.project_id = r.project_id
			WHERE release_id = %d
			",
			$release_id
		)
	);
	
	return $results;
}

/**
* get steps of a release
*/
function afmng_db_release_steps($releaseid)
{
	global $wpdb;
	
	$sql = $wpdb->prepare( 
		"
		SELECT sm.task_id,
			   sm.step_id,
			   s.name as step_name,
			   s.description as step_description,
			   sm.user,
			   sm.state_no,
			   sm.description
		FROM ".afmngdb::$tbl_tasks." as sm
		INNER JOIN ".afmngdb::$tbl_steps." as s
			ON s.step_id = sm.step_id	
		WHERE sm.release_id=%d
		ORDER BY sm.step_id ASC
		",
		$releaseid
        );
        
	return $wpdb->get_results($sql);
}

/**
* Add a new anime release (episode)
*/
function afmng_db_release_add($project_id, $episode_no, $episode_title)
{
	global $wpdb;

	$wpdb->insert( 
		afmngdb::$tbl_episode, 
		array( 
			'project_id' => $project_id,
			'episode_no' => $episode_no,
			'episode_title' => $episode_title
		), 
		array( 
			'%d',
			'%s',
			'%s'
		) 
	);
}

/**
* Update anime release (episode)
*/
function afmng_db_release_update($release_id, $episode_no, $episode_title)
{
	global $wpdb;

	$wpdb->update( 
		afmngdb::$tbl_episode, 
		array( 
			'episode_no' => $episode_no,
			'episode_title' => $episode_title
		), 
		array ('release_id' => $release_id),
		array( 
			'%s',
			'%s'
		),
		array('%d')
	);
}

/**
* Delete a release/episode
*/
function afmng_db_release_delete($release_id)
{
	global $wpdb;
	
	$res = $wpdb->delete(afmngdb::$tbl_episode, array( 'release_id' => $release_id ), array( '%d' ) );

	if(!$res)
	{
		throw new Exception($wpdb->last_error);
	}

	return true;
}

/**
* Delete a release/episode
*/
function afmng_db_release_delete_tasks($release_id)
{
	global $wpdb;
	
	$res = $wpdb->delete(afmngdb::$tbl_tasks, array( 'release_id' => $release_id ), array( '%d' ) );

	if(!$res)
	{
		throw new Exception($wpdb->last_error);
	}

	return true;
}



//======================================================================
//step functions:

/**
* Return all available steps
*/
function afmng_db_steps()
{
	global $wpdb;	
	
	return $wpdb->get_results( 
		"
		SELECT
			s.step_id,
			s.name
		FROM ".afmngdb::$tbl_steps." as s
		"
	);
}

//======================================================================
//tasks functions:

function afmng_db_task_add($release_id, $step_id, $user)
{
	global $wpdb;

	if(!empty($user))
	{
		$wpdb->insert( 
			afmngdb::$tbl_tasks, 
			array( 
				'release_id' => $release_id,
				'step_id' => $step_id,
				'user' => $user
			), 
			array( 
				'%d',
				'%d',
				'%s'
			) 
		);
	}
	else
	{
		$wpdb->insert( 
			afmngdb::$tbl_tasks, 
			array( 
				'release_id' => $release_id,
				'step_id' => $step_id
			), 
			array( 
				'%d',
				'%d'
			) 
		);
	}
}

//delete task
function afmng_db_task_delete($task_id)
{
	global $wpdb;
	
	$res = $wpdb->delete(afmngdb::$tbl_tasks, array( 'task_id' => $task_id ), array( '%d' ) );
	
	if(!$res)
	{
		throw new Exception($wpdb->last_error);
	}

	return true;
}


//update task
function afmng_db_task_update($task_id, $state_no, $description)
{
	global $wpdb;
	
	$res = $wpdb->update( 
		afmngdb::$tbl_tasks, 
		array( 
			'state_no' => $state_no,
			'description' => $description
		), 
		array( 'task_id' => $task_id ), 
		array( 
			'%d',	// value1
			'%s'	// value2
		), 
		array( '%d' ) 
	);
	
	if(!$res)
	{
		throw new Exception($wpdb->last_error);
	}
}

//assign task to user
function afmng_db_task_accept($task_id, $user)
{
	global $wpdb;
	
	$res = $wpdb->update( 
		afmngdb::$tbl_tasks, 
		array( 
			'user' => $user
		), 
		array( 'task_id' => $task_id ), 
		array('%s'), 
		array('%d') 
	);
	
	if($res === 0)
	{
		throw new Exception("No tasks updated");
	}
	
	if(!$res)
	{
		throw new Exception($wpdb->last_error);
	}
}

//release task from user
function afmng_db_task_free($task_id)
{
	global $wpdb;
	
	$res = $wpdb->query( 
		   $wpdb->prepare( 
				"
				UPDATE ".afmngdb::$tbl_tasks."
				SET user = NULL
				WHERE task_id = %d
				",
				$task_id 
				)
			);
	
	if($res === 0)
	{
		throw new Exception("No tasks updated");
	}
	
	if(!$res)
	{
		throw new Exception($wpdb->last_error);
	}
}


//======================================================================
//special functions:

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
			sm.task_id,
			sm.state_no,
			sm.description
		FROM ".afmngdb::$tbl_tasks." as sm
		INNER JOIN ".afmngdb::$tbl_steps." as s
			ON s.step_id = sm.step_id
		INNER JOIN ".afmngdb::$tbl_episode." as r 
			ON sm.release_id = r.release_id
		INNER JOIN ".afmngdb::$tbl_anime." as p
			ON p.project_id = r.project_id
		WHERE
			sm.user = '$user'
		AND NOT (p.completed = true OR p.licensed = true)
		AND NOT sm.state_no = 2
		"
	);
}

/**
* Return tasks which can a user assign
*/
function afmng_db_tasks_available($user_id)
{
	$caps = afmng_db_user_getcaps($user_id);
	
	global $wpdb;
	
	$sql =
		"
		SELECT
			sm.task_id,
			p.anime_name,
			r.release_id,
			r.episode_no,
			r.episode_title,
			s.name,
			s.step_id
		FROM ".afmngdb::$tbl_tasks." as sm
		INNER JOIN ".afmngdb::$tbl_steps." as s
			ON s.step_id = sm.step_id
		INNER JOIN ".afmngdb::$tbl_episode." as r 
			ON sm.release_id = r.release_id
		INNER JOIN ".afmngdb::$tbl_anime." as p
			ON p.project_id = r.project_id
		WHERE (sm.user IS NULL OR sm.user = '')
		AND s.capability IN ('".implode("','",$caps)."')
		AND NOT (p.completed = true OR p.licensed = true)
		"
		;
	
	$results = $wpdb->get_results($sql);
	
	
	//get tasks which user can create
	$sql =
		"
		SELECT
		 NULL as task_id, 
		 p.anime_name,
		 r.release_id,
		 r.episode_no,
		 r.episode_title, 
		 s.name,
		 s.step_id
		FROM
		(SELECT 
			sm.release_id,
			MAX(s.step_id) as step_id
		FROM ".afmngdb::$tbl_tasks." as sm
		INNER JOIN ".afmngdb::$tbl_steps." as s
			ON s.prev_step_id = sm.step_id
		INNER JOIN ".afmngdb::$tbl_episode." as r 
			ON sm.release_id = r.release_id
		INNER JOIN ".afmngdb::$tbl_anime." as p
			ON p.project_id = r.project_id 
			AND p.licensed = false AND p.completed = false
		GROUP BY 
			sm.release_id
		) as sm
		INNER JOIN ".afmngdb::$tbl_steps." as s
			ON s.step_id = sm.step_id
		INNER JOIN ".afmngdb::$tbl_episode." as r 
			ON sm.release_id = r.release_id
		INNER JOIN ".afmngdb::$tbl_anime." as p
			ON p.project_id = r.project_id 
		WHERE s.capability IN ('".implode("','",$caps)."')
		"
		;
	
	//tasks with prev_step_id == null
	
	//var_dump($sql);
	
	$task_createable = $wpdb->get_results($sql);
	
	return array_merge($results, $task_createable);
}

/**
* Get strings for state
*/
function afmng_db_steps_state($state_no)
{
	return afmngdb::$step_state[$state_no];
}

/**
* Check caps for current user
*/
function afmng_db_user_getcaps($user_id)
{
	if(user_can($user_id, 'afmng_admin'))
		return afmngdb::$caps;
	
	$has = array();
	
	foreach(afmngdb::$caps as $cap)
		if(user_can($user_id, $cap))
			array_push($has, $cap);
			
	return $has;
}

/**
* get all wp users
*/ 
function afmng_db_get_users()
{
	global $wpdb;
	return $wpdb->get_results("SELECT ID, user_login, display_name FROM $wpdb->users ORDER BY ID");
}


?>
