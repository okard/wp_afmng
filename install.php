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
		
		$tbl_projects =  afmngdb::$tbl_projects;
		$tbl_releases =  afmngdb::$tbl_releases;

		//sql from file replaces tables
		
		$sql = "CREATE TABLE ".$tbl_projects." (
				project_id mediumint(9) NOT NULL AUTO_INCREMENT,
				creation_date datetime NULL,
				anime_name tinytext NOT NULL,
				anime_description text NULL,
				url VARCHAR(100) DEFAULT '' NULL,
				visible BOOLEAN default 1 NOT NULL,
				PRIMARY KEY  (project_id)
				);
				CREATE TABLE ".$tbl_releases." (
				release_id mediumint(9) NOT NULL AUTO_INCREMENT,
				project_id mediumint(9) NOT NULL,
				episode tinytext NOT NULL,
				creation_date datetime NULL,
				translation_status TINYINT UNSIGNED DEFAULT 0 NOT NULL,
				PRIMARY KEY  (release_id),
				FOREIGN KEY (project_id) REFERENCES $tbl_projects (project_id)
				);
			
				";

	  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	  $result = dbDelta( $sql );
	  
	  update_option( "afmng_db_version", $afmng_db_ver_current );
	}
	
	//add capibilities
}


function afmng_install_dbdata() 
{
   global $wpdb;
   
}




?>
