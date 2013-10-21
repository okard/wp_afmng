<?php
/* Main Menu Hook*/
add_action( 'admin_menu', 'afmng_menu_setup' );

/* Setup AFMNG Menus*/
function afmng_menu_setup() 
{
	//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	add_menu_page('Anime Fansub Manager', 'AFMNG', 'publish_posts', 'afmng_main_menu', 'afmng_menu_main', null, 3);
	
	//todo list
	add_submenu_page('afmng_main_menu', 'TODO Liste', 'TODO Liste', 'publish_posts', 'afmng_menu_todo', 'afmng_menu_todo');
	
	//user management page
	//project administration
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
	$ltpl->lastreleases = afmng_projects_lastreleases();
	
	//render page
	$ltpl->render(afmng_get_tplfile('tpl.TodoList.php'));
}


?>
