<?php
/* Main Menu Hook*/
add_action( 'admin_menu', 'afmng_menu_setup' );

/* Setup AFMNG Menus*/
function afmng_menu_setup() 
{
	//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	add_menu_page('Aufgaben', 'Aufgaben', 'publish_posts', 'afmng_main_menu', 'afmng_menu_main', null, 3);
	
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
	$ltpl->user = $current_user->user_login;
	
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
* Render the Project Manager Page
*/
function afmng_menu_projectmng()
{
	//right check
	
	$ltpl = new LTemplate();
	
	$ltpl->project_list = afmng_db_project_list();
	
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
