<?php

register_activation_hook(AFMNG_PLUGINFILE, 'afmng_install_db' );
register_activation_hook(AFMNG_PLUGINFILE, 'afmng_install_dbdata' );

//register_deactivation_hook($file, $function);
//register_uninstall_hook();

function afmng_install_db()
{
	if(AFMNG_DEBUG)
	{
		//debug: call dbDelta each activation time
		update_option( "afmng_db_version", '0.0');
	}
	
	global $wpdb;
	$afmng_db_ver_current = '0.1';
	$afmng_db_ver_installed = get_option( "afmng_db_version" );

	if( $afmng_db_ver_installed != $afmng_db_ver_current ) 
	{
		
		//get table names
		$tbl_anime =  afmngdb::$tbl_anime;
		$tbl_episode =  afmngdb::$tbl_episode;
		$tbl_steps = afmngdb::$tbl_steps;
		$tbl_tasks = afmngdb::$tbl_tasks;
		
		//sql script
		$sql = "CREATE TABLE ".$tbl_anime." (
				project_id mediumint(9) NOT NULL AUTO_INCREMENT,
				anime_name tinytext NOT NULL,
				completed BOOLEAN default 0 NOT NULL,
				licensed BOOLEAN default 0 NOT NULL,
				PRIMARY KEY  (project_id)
				);
				CREATE TABLE ".$tbl_episode." (
				release_id mediumint(9) NOT NULL AUTO_INCREMENT,
				project_id mediumint(9) NOT NULL,
				episode_no tinytext NOT NULL,
				episode_title text NULL,
				PRIMARY KEY  (release_id),
				FOREIGN KEY (project_id) REFERENCES $tbl_anime (project_id)
				);
				CREATE TABLE ".$tbl_steps." (
				step_id mediumint(9) NOT NULL AUTO_INCREMENT,
				prev_step_id mediumint(9) NULL,
				name tinytext NOT NULL,
				description mediumtext NULL,
				capability tinytext NULL,
				multiple BOOLEAN default 0 NOT NULL,
				PRIMARY KEY  (step_id)
				);
				CREATE TABLE ".$tbl_tasks." (
				task_id mediumint(9) NOT NULL AUTO_INCREMENT,
				release_id mediumint(9) NOT NULL,
				step_id mediumint(9) NOT NULL,
				user tinytext NULL,
				state_no tinyint(1) DEFAULT 0 NOT NULL,
				description mediumtext NULL,
				PRIMARY KEY  (task_id),
				FOREIGN KEY (release_id) REFERENCES $tbl_episode (release_id),
				FOREIGN KEY (step_id) REFERENCES $tbl_steps (step_id)
				);
				";
				
	  file_put_contents(AFMNG_PLUGINDIR.'/sql/afmngdb.sql', $sql);
	  
	  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	  $result = dbDelta( $sql );
	  
	  update_option( "afmng_db_version", $afmng_db_ver_current );
	}
	
	//add capibilities
}


function afmng_db_add_step($step_id, $prev_step, $name, $desc, $cap)
{
	global $wpdb;
	
	//check for null
	
	$wpdb->insert( afmngdb::$tbl_steps,  array( 
			'step_id' => $step_id,
			'prev_step_id' => $prev_step, 
			'name' => $name,
			'description' => $desc,
			'capability' => $cap
		), 
		array( '%d', '%d', '%s', '%s', '%s') 
	);
}


function afmng_install_dbdata() 
{
	//Raw
	afmng_db_add_step(0, null, 'Raw', 'Raw verfügbar', 'afmng_rawprovider');
	//Translation
	afmng_db_add_step(1, 0, 'Translation', 'Übersetzung', 'afmng_translator');
	//Edit
	afmng_db_add_step(2, 1, 'Edit', 'Edit', 'afmng_edit');
	//Typeset
	afmng_db_add_step(3, 2, 'Typeset', 'Typeset', 'afmng_typeset');
	//Karaoke
	afmng_db_add_step(4, 3, 'Karaoke', 'Karaoke', 'afmng_karaoke');
	//QC
	afmng_db_add_step(5, 4, 'QC', 'Quality Check', 'afmng_qc');
	//Mux
	afmng_db_add_step(6, 5, 'Mux', 'Mux & UL', 'afmng_mux');
	//Hardsub
	afmng_db_add_step(7, 6, 'Hardsub', 'Hardsub', 'afmng_hardsub');
	
	//V2 & Co
	afmng_db_add_step(8, null, 'Rerelease', 'Rerelease', 'afmng_rerelease');
}




?>
