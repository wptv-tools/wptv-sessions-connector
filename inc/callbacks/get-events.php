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