<?php

add_action( 'wpcf7_init', 'wptvsc_select_room_form_tag' );

function wptvsc_select_room_form_tag() {
    wpcf7_add_form_tag( 'room_selector', 'wptv_room_selector_form_tag_handler' );
    wpcf7_add_form_tag( 'date_selector', 'wptv_date_selector_form_tag_handler' );
    wpcf7_add_form_tag( 'session_type', 'wptv_session_type_selector_form_tag_handler' );
}

function wptv_room_selector_form_tag_handler( $tag ) {
    // return 'room';
    $html = '<span class="wpcf7-form-control-wrap room">';
    $html .= '<select name="room" class="wpcf7-form-control wpcf7-select" aria-invalid="false">';

    // Loop the Rooms for the event
    // Get the parameter for the Query
        $args = array(
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'post_type'         => 'raum',
            'order_by'          => 'date',
            'order'             => 'ASC',
            'page'              => 'paged',
            'meta_query'    => array(
                array(
                    'key'       => 'event',
                    'value'     => '"' . get_the_ID() . '"',
                    'compare'   => 'LIKE',
                )
            )
        );

    $get_rooms = get_posts($args);

    foreach ($get_rooms as $room) {
        $html .= '<option value="'. $room->post_title .'">'. $room->post_title .'</option>';
    }

    $html .= '</select>';
    $html .= '</span>';

    return $html;
}

function wptv_date_selector_form_tag_handler( $tag ) {

    $start_date = date('Y-m-d', strtotime( get_field('datum_veranstaltung_start')));
    $end_date   = date('Y-m-d', strtotime( get_field('datum_veranstaltung_ende')));

    return '<span class="wpcf7-form-control-wrap datum"><input name="datum" value="" class="wpcf7-form-control wpcf7-date wpcf7-validates-as-required wpcf7-validates-as-date" min="'. $start_date .'" max="'. $end_date .'" aria-required="true" aria-invalid="false" type="date"></span>';
}

function wptv_session_type_selector_form_tag_handler( $tag ){
    $html = '<span class="wpcf7-form-control-wrap type">';
    $html .= '<select name="type" class="wpcf7-form-control wpcf7-select" aria-required="true" aria-invalid="false">';

    $terms = get_terms( array(
        'taxonomy' => 'session_type',
        'hide_empty' => false,
    ) );

    // print_r($terms);
    // die();

    foreach ($terms as $term) {
        $html .= '<option value="'. $term->name .'">'. $term->name .'</option>';
    }

    $html .= '</select>';
    $html .= '</span>';

    return $html;
}
