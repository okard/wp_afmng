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
		$tbl_projects =  afmngdb::$tbl_projects;
		$tbl_releases =  afmngdb::$tbl_releases;
		$tbl_release_steps = afmngdb::$tbl_release_steps;
		$tbl_release_steps_map = afmngdb::$tbl_release_steps_map;
		
		//sql script
		$sql = "CREATE TABLE ".$tbl_projects." (
				project_id mediumint(9) NOT NULL AUTO_INCREMENT,
				anime_name tinytext NOT NULL,
				completed BOOLEAN default 0 NOT NULL,
				licensed BOOLEAN default 0 NOT NULL,
				PRIMARY KEY  (project_id)
				);
				CREATE TABLE ".$tbl_releases." (
				release_id mediumint(9) NOT NULL AUTO_INCREMENT,
				project_id mediumint(9) NOT NULL,
				episode_no tinytext NOT NULL,
				episode_title text NULL,
				PRIMARY KEY  (release_id),
				FOREIGN KEY (project_id) REFERENCES $tbl_projects (project_id)
				);
				CREATE TABLE ".$tbl_release_steps." (
				step_id mediumint(9) NOT NULL AUTO_INCREMENT,
				prev_step_id mediumint(9) NULL,
				name tinytext NOT NULL,
				description mediumtext NULL,
				PRIMARY KEY  (step_id)
				);
				CREATE TABLE ".$tbl_release_steps_map." (
				release_id mediumint(9) NOT NULL,
				step_id mediumint(9) NOT NULL,
				user tinytext NULL,
				state_no tinyint(1) DEFAULT 0 NOT NULL,
				description mediumtext NULL,
				FOREIGN KEY (release_id) REFERENCES $tbl_releases (release_id),
				FOREIGN KEY (step_id) REFERENCES $tbl_release_steps (step_id)
				);
				";
				
	  //file_put_contents(AFMNG_PLUGINDIR.'/sql/afmngdb.sql', $sql);
	  
	  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	  $result = dbDelta( $sql );
	  
	  update_option( "afmng_db_version", $afmng_db_ver_current );
	}
	
	//add capibilities
}


function afmng_install_dbdata() 
{
   global $wpdb;
   
   //add steps
   
}




?>
