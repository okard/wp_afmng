<?php
/* Main Menu Hook*/
add_action( 'admin_menu', 'afmng_menu_setup' );

/* Setup AFMNG Menus*/
function afmng_menu_setup() 
{
	//only if caps are ok?:
	if(afmng_user_cap('afmng_user', null))
	{
		//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
		add_menu_page('Aufgaben', 'Aufgaben', 'afmng_user', 'afmng_menu_tasks', 'afmng_menu_tasks', null, 3);
	
		//Project Manager
		add_submenu_page('afmng_menu_tasks', 'Projekt Manager', 'Projekt Manager', 'afmng_user', 'afmng_menu_projectmng', 'afmng_menu_projectmng');
	
		//Completed Projects?
		
		if(afmng_user_cap('afmng_admin', null))
		{
			//User Manager
			add_submenu_page('afmng_menu_tasks', 'User Manager', 'User Manager', 'afmng_admin', 'afmng_menu_usermng', 'afmng_menu_usermng');
			//Manage Steps? Show Steps?
		}
	}
	
	
}

/**
* Stylesheets and scripts
*/
add_action( 'admin_enqueue_scripts', 'afmng_menu_script_styles');
function afmng_menu_script_styles($hook) 
{
	wp_register_style( 'afmng_plugin_css', AFMNG_PLUGINURL.'tpl/style.css', false, '1.0.0' );
    wp_enqueue_style( 'afmng_plugin_css' );
    
    //for confirmation boxes
    wp_enqueue_script('afmng_plugin_jconfirm', AFMNG_PLUGINURL.'js/jquery.jconfirm-1.0.min.js');
    
	switch($_GET["page"])
	{
		case 'afmng_menu_tasks':
			wp_enqueue_script('afmng_menu_tasks_scripts', AFMNG_PLUGINURL.'js/tasks.js');
			break;
				
		case 'afmng_menu_projectmng':
			wp_enqueue_script('afmng_menu_projectmng_scripts', AFMNG_PLUGINURL.'js/projectmng.js');
			break;
	}
}




/**
* Renders the AFMNG main menu
*/
function afmng_menu_tasks()
{
	//get_current_user_id();
	$current_user = wp_get_current_user();
	
	//check for required stuff?
	// * a parent "Projekte" page
	
	if(afmng_check_post())
		afmng_menu_tasks_postback();
	
	$ltpl = new LTemplate();
	$ltpl->tasks = afmng_db_gettasks($current_user->user_login);
	$ltpl->user = $current_user->user_login;
	
	$ltpl->tasks_available =  afmng_db_tasks_available($current_user->ID);
	
	//own tasks
	
	$ltpl->is_admin = afmng_user_cap('afmng_admin', null);
	
	//render template
	$ltpl->render(afmng_get_tplfile('tpl.Tasks.php'));
}

/**
* Postback Handler for MainMenu
*/
function afmng_menu_tasks_postback()
{
	//check if user has the rights
	//if( !current_user_can( 'manage_options' )
	
	//admin_task_add
	
	switch($_POST["action"])
	{
		case 'admin_task_add':
			afmng_db_task_add($_POST['episode'], $_POST['step'], $_POST['user']);
			break;
	}
}

/**
* Render the Project Manager Page
*/
function afmng_menu_projectmng()
{
	//right check
	
	//create subpages?
	//-project (single project + episodes)
	//-episode (single episode + tasks)
	
	//extract view
	$view = 'overview';
	
	if(afmng_check_post())
	{
		//handle actions:
		afmng_menu_projectmng_postback();
		//extract view
		if($_POST["view"])
			$view = $_POST["view"];
	}
		
	//show right view and prepare data
	switch($view)
	{
		case 'overview':
			$ltpl = new LTemplate();
			$ltpl->project_list = afmng_db_project_list();
			$ltpl->projects_closed = afmng_db_projects_closed();
			$ltpl->is_admin = afmng_user_cap('afmng_admin', null);
			$ltpl->view = 'overview';
			$ltpl->render(afmng_get_tplfile('tpl.ProjectMng.php'));
			break;
		case 'episode':
			$ltpl = new LTemplate();
			if($_POST["release_id"])
			{
				$ltpl->episode = afmng_db_release_get($_POST["release_id"])[0];
				$ltpl->tasks = afmng_db_release_steps($_POST["release_id"]);
			}
			$ltpl->is_admin = afmng_user_cap('afmng_admin', null);
			$ltpl->view = 'episode';
			$ltpl->render(afmng_get_tplfile('tpl.ProjectMng.Episode.php'));
			break;
	}
}

/**
* Postback handling for ProjectManager
*/
function afmng_menu_projectmng_postback()
{
	switch($_POST["action"])
	{
		case 'add_project':
			afmng_project_add($_POST["anime_name"]);
			break;
			
		case 'update_project':
			afmng_project_update($_POST["project_id"], $_POST["anime_name"], isset($_POST['completed']), isset($_POST['licensed']) );
			break;

		case 'add_release':
			afmng_db_release_add($_POST["project_id"], $_POST["episode_no"], $_POST["episode_title"]);
			break;
			
		case 'episode_update':
			 afmng_db_release_update($_POST["release_id"], $_POST["episode_no"], $_POST["episode_title"]);
			break;
	}
}

/**
* Render the User Manager Page
*/
function afmng_menu_usermng()
{
	if(afmng_check_post())
	{
		afmng_menu_usermng_postback();
	}
		
		
	$ltpl = new LTemplate();
	$ltpl->users = afmng_db_get_users();
	$ltpl->caps = afmngdb::$caps;
	//render page
	$ltpl->render(afmng_get_tplfile('tpl.UserMng.php'));
}

/**
* Handle postback from user manager
*/
function afmng_menu_usermng_postback()
{
	switch($_POST["action"])
	{
		case 'update_user':
			foreach(afmng_db_get_users() as $user)
			{
				foreach(afmngdb::$caps as $cap)
				{
					if($_POST[$cap.':'.$user->ID])
					{
						$user = new WP_User($user->ID);
						$user->add_cap($cap);
					}
					else
					{
						$user = new WP_User($user->ID);
						$user->remove_cap($cap);
					}
				}
			}
			break;
	}
}


?>
