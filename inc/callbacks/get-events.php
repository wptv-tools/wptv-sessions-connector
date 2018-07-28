<?php

function wptvsc_get_event_posts( WP_REST_Request $request ){

    $per_page         = $request->get_param('per_page');
    $post_type        = 'event';


    // Get the parameter for the Query
    $args = array(
        'posts_per_page'    => $per_page,
        'post_status'       => 'publish',
        'post_type'         => $post_type,
        'order_by'          => 'date',
        'order'             => 'DESC',
        'page'              => 'paged'
    );

    // Add the custom taxonomies to $args
    $taxonomies = wp_list_filter( get_object_taxonomies( $post_type, 'objects' ), array( 'show_in_rest' => true ) );

    if ( is_array($taxonomies) ) {
        foreach ( $taxonomies as $taxonomy ) {
            $base = ! empty( $taxonomy->rest_base ) ? $taxonomy->rest_base : $taxonomy->name;

            if ( ! empty( $request[ $base ] ) ) {
                $args['tax_query'][] = array(
                    'taxonomy'         => $taxonomy->name,
                    'field'            => 'term_id',
                    'terms'            => $request[ $base ],
                    'include_children' => false,
                );
            }
        }
    }


    // Get Events
    $posts = get_posts( $args );

    // Get Total of Posts
    $total_posts = wp_count_posts( $post_type )->publish;
    $max_pages = ceil( $total_posts / (int) $per_page );

    // Filter the posts information for the json response
    $set_parameters = array();

    $i = 0;

    foreach ($posts as $key => $value) {


        $set_parameters[] = array(
                'ID'                => $value->ID,
                'post_modified_gmt' => $value->post_modified_gmt,
                'post_title'        => get_the_title( $value->ID ),
                'thumbnail'         => get_the_post_thumbnail_url( $value->ID, 'full', '' ),
                'event_date'        => '',
                'event_year'        => '',
                'event_city'        => get_field('stadt', $value->ID),
                'producer_name'     => get_field('video_producer_name', $value->ID),
                'producer_username' => get_field('video_producer_username', $value->ID)
            );
    }

    $response = new WP_REST_Response( $set_parameters );
    $response->header( 'X-WP-Total', (int) $total_posts );
    $response->header( 'X-WP-TotalPages', (int) $max_pages );

    return $response;
}

function wptvsc_get_event( WP_REST_Request $request ){

    $post_id          = $request->get_param('id');
    $post_type        = 'event';


    // Get the parameter for the Query
    $args = array(
        'posts_per_page'    => -1,
        'post_status'       => 'publish',
        'post_type'         => $post_type,
        'order_by'          => 'date',
        'order'             => 'DESC',
        'page'              => 'paged'
    );

    // Get Events
    $posts = get_posts( $args );

    // Filter the posts information for the json response
    $set_parameters = array();

    foreach ($posts as $key => $value) {

        // Get the Sessions post relationship
        // Get the parameter for the Query
        $sessions_args = array(
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'post_type'         => 'session',
            'order_by'          => 'date',
            'order'             => 'DESC',
            'page'              => 'paged',
            'meta_query'    => array(
                array(
                    'key'       => 'event',
                    'value'     => '"' . $value->ID . '"',
                    'compare'   => 'LIKE',
                )
            )
        );

        $get_sessions = get_posts($sessions_args);
        $sessions = array();

        foreach ($get_sessions as $session) {
           $sessions[] = array(
                'ID'                    => $session->ID,
                'speaker_name'          => get_field('speaker_name', $session->ID),
                'sesion_description'    => get_field('session_beschreibung', $session->ID),
                'twitterhandle'         => get_field('twitterhandle', $session->ID),
                'room'                  => get_field('raum', $session->ID),
                'date'                  => get_field('datum', $session->ID),
                'time'                  => get_field('uhrzeit', $session->ID),
                'sprache'               => get_field('sprache', $session->ID),
           );
        }

        $set_parameters[] = array(
                'ID'                => $value->ID,
                'post_modified_gmt' => $value->post_modified_gmt,
                'post_title'        => get_the_title( $value->ID ),
                'thumbnail'         => get_the_post_thumbnail_url( $value->ID, 'full', '' ),
                'event_date'        => '',
                'event_year'        => '',
                'event_city'        => get_field('stadt', $value->ID),
                'producer_name'     => get_field('video_producer_name', $value->ID),
                'producer_username' => get_field('video_producer_username', $value->ID),
                'sessions'          => $sessions
            );

    }

    $response = new WP_REST_Response( $set_parameters );
    return $response;
}