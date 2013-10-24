<?php
/* Main Menu Hook*/
add_action( 'admin_menu', 'afmng_menu_setup' );

/* Setup AFMNG Menus*/
function afmng_menu_setup() 
{
	//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	add_menu_page('Anime Fansub Manager', 'Anfam', 'publish_posts', 'afmng_main_menu', 'afmng_menu_main', null, 3);
	
	//todo list
	add_submenu_page('afmng_main_menu', 'TODO Liste', 'TODO Liste', 'publish_posts', 'afmng_menu_todo', 'afmng_menu_todo');
	
	//only if caps are ok?:
	if(is_admin())
	{
		//User Manager
		add_submenu_page('afmng_main_menu', 'User Manager', 'User Manager', 'publish_posts', 'afmng_menu_usermng', 'afmng_menu_usermng');

		//Project Manager
		add_submenu_page('afmng_main_menu', 'Projekt Manager', 'Projekt Manager', 'publish_posts', 'afmng_menu_projectmng', 'afmng_menu_projectmng');
	
		//Completed Projects
	}
}

/**
* Renders the AFMNG main menu
*/
function afmng_menu_main()
{
	$current_user = wp_get_current_user();
	
	//check for required stuff?
	// * a parent "Projekte" page
	
	if(afmng_check_post())
		afmng_menu_main_postback();
	
	
	$ltpl = new LTemplate();
	$ltpl->tasks = afmng_db_gettasks($current_user->user_login);
	
	//own tasks
	
	if (is_admin())
	{
		$ltpl->is_admin = true;
		//add admin info
	}
	
	//render template
	$ltpl->render(afmng_get_tplfile('tpl.MainMenu.php'));
}

/**
* Postback Handler for MainMenu
*/
function afmng_menu_main_postback()
{
	//check if user has the rights
	//if( !current_user_can( 'manage_options' )
	
	switch($_POST["action"])
	{
		case 'create_anime':
			afmng_projects_add($_POST["anime_name"], $_POST["anime_description"]);
			break;
	}
}




/** 
* Render the AFMNG todo list 
*/
function afmng_menu_todo() 
{
	/*if ( !current_user_can( 'manage_options' ) )  
	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}*/
	
	//different views? 
	
	//get cap for current user?
		//trans, qc, karoake, fx, raw 
	
	if(afmng_check_post())
	{
		//handle form postback
	}
	
	
	$ltpl = new LTemplate();
	
	//set the right data
	//$ltpl->lastreleases = afmng_projects_lastreleases();
	
	//render page
	$ltpl->render(afmng_get_tplfile('tpl.TodoList.php'));
}


/**
* Render the Project Manager Page
*/
function afmng_menu_projectmng()
{
	$ltpl = new LTemplate();
	
	
	$data = afmng_db_project_list();
	
	
	$d = afmng_group_dbresult($data, array(array('project_id', 'anime_name'), 
	                                       array('release_id', 'episode_no', 'episode_title'),
	                                        array('step_name', 'user', 'state_no', 'description')));
	
	//var_dump($d);
	
	$ltpl->project_list = $d;
	
	//render page
	$ltpl->render(afmng_get_tplfile('tpl.ProjectMng.php'));
}

/**
* Render the User Manager Page
*/
function afmng_menu_usermng()
{
	$ltpl = new LTemplate();
	//render page
	$ltpl->render(afmng_get_tplfile('tpl.UserMng.php'));
}



?>
