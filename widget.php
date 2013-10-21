<?php

function afmng_widget_status($args) 
{
    extract($args);
    echo $before_widget;
    echo $before_title. 'Status'. $after_title;
    
    $ltpl = new LTemplate();
    $ltpl->render(afmng_get_tplfile('tpl.StatusWidget.php'));

	echo $after_widget;
}

wp_register_sidebar_widget(
    'afmng_status_widget',	//unique widget id
    'AFMNG Status Widget',  // widget name
    'afmng_widget_status',  // callback function
    array(                  // options
        'description' => 'Shows Current Sub Status'
    )
);

?>
