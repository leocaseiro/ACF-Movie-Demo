<?php

/** Remove Admin Menus */

add_action( 'admin_menu', 'remove_menus' );
function remove_menus() {
  remove_menu_page( 'index.php' );                  //Dashboard
  remove_menu_page( 'edit.php' );                   //Posts
  remove_menu_page( 'edit-comments.php' );          //Comments
  remove_menu_page( 'users.php' );                  //Users
}


/* Reorder Menu Admin */
add_filter('menu_order', 'custom_menu_order');
function custom_menu_order( $menu_ord ) {
    if ( ! $menu_ord ) {
    	return true;
    }

    return array(
        'index.php', // Dashboard
        'separator1', // First separator
        'edit.php?post_type=movie', // Movies
        'edit.php?post_type=actor', // Actors
        'edit.php?post_type=page', // Pages
        'upload.php', // Media
        'separator2', // Second separator
        'themes.php', // Appearance
        'plugins.php', // Plugins
        'users.php', // Users
        'tools.php', // Tools
        'options-general.php', // Settings
        'separator-last', // Last separator
    );
}
add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order


/** Widget Recent Posts with Movie Post Type */
add_filter('widget_posts_args', 'widget_posts_args_add_custom_type');
function widget_posts_args_add_custom_type($params) {
	$params['post_type'] = array('movie');
	return $params;
}


/** Homepage / Category filter shows Movie Custom Post Type */
add_action("pre_get_posts", "custom_front_page");
function custom_front_page($wp_query){
    //Ensure this filter isn't applied to the admin area
    if(is_admin()) {
        return;
    }

    if( is_home() || is_archive() ):

        $wp_query->set('post_type', 'movie');
        $wp_query->set('page_id', ''); //Empty

        //Set properties that describe the page to reflect that
        //we aren't really displaying a static page
        $wp_query->is_page = 0;
        $wp_query->is_singular = 0;
        $wp_query->is_post_type_archive = 1;
        $wp_query->is_archive = 1;

    endif;

}

add_action( 'init', 'leocaseiro_register_ctp' );
function leocaseiro_register_ctp() {
	$labels = array(
		"name" => "Movies",
		"singular_name" => "Movie",
	);

	$args = array(
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"show_ui" => true,
		"has_archive" => true,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "movie", "with_front" => true ),
		"query_var" => true,
		"menu_icon" => "dashicons-format-video",
		"supports" => array( "title", "editor", "thumbnail", "custom-fields" ),
		"taxonomies" => array( "category" )
	);
	register_post_type( "movie", $args );

	$labels = array(
		"name" => "Actors",
		"singular_name" => "Actor",
	);

	$args = array(
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"show_ui" => true,
		"has_archive" => true,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "page",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "actor", "with_front" => true ),
		"query_var" => true,
		"menu_icon" => "dashicons-admin-users",
		"supports" => array( "title", "editor", "thumbnail" )
	);
	register_post_type( "actor", $args );

}
