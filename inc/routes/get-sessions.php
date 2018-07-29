<?php

 /*
 *
 * Register Routes
 *
 */

add_action( 'rest_api_init', 'wptvsc_add_session_posts_route' );

function wptvsc_add_session_posts_route(){
    register_rest_route( 'wptvsc-app-routes/v2', 'get-session/(?P<id>\d+)', array(
        'methods'  => WP_REST_Server::READABLE,
        'callback' => 'wptvsc_get_session_posts',
        'show_in_index'       => false,
        'args'                => array(
            'id'      => array(
                'validate_callback' => 'is_numeric'
            )
        )
    ));
}