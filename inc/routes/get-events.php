<?php

 /*
 *
 * Register Routes
 *
 */

add_action( 'rest_api_init', 'wptvsc_add_event_posts_route' );

function wptvsc_add_event_posts_route(){
    register_rest_route( 'wptvsc-app-routes/v2', 'get-event-posts', array(
        'methods'  => WP_REST_Server::READABLE,
        'callback' => 'wptvsc_get_event_posts',
        'show_in_index'       => false,
        'args'                => array(
            'per_page'      => array(
                'default'               => 20,
                'sanitize_callback'     => 'absint',
            )
        )
    ));
}