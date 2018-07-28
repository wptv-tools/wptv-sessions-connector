<?php

function wptvsc_get_session_posts( WP_REST_Request $request ){
    $id = $request->get_param('id');

    $set_parameters = array();

    $set_parameters[] = array(
        'ID'                    => $id,
        'post_modified_gmt'     => get_post_modified_time('Y-m-d H:i:s',false, $id),
        'post_title'            => get_the_title($id),
        'event_relationship'    => get_field( 'event', $id, false, false )[0],
    );

    $response = new WP_REST_Response( $set_parameters );
    return $response;
}