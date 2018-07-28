<?php

add_action( 'wpcf7_before_send_mail', 'wptvsc_cf7_save_to_session_cpt', 10, 1);

function wptvsc_cf7_save_to_session_cpt( $data ){

    $submission = WPCF7_Submission::get_instance();

    if ( $submission ){
        $formdata = $submission->get_posted_data();

        // stop if spam fill this field
        if ( ! empty($formdata['wptv-session-interesse']) ) return;
    }


    // check contactform 7 id
    if( $data->id() !== 20) return;

    $new_post = array(
        'post_title'    => sanitize_title( $formdata['title'] ),
        'post_status'   => 'draft',
        'post_type'     => 'session'
    );

    $new_post_id = wp_insert_post($new_post);

    // Add Custom Field
    add_post_meta($new_post_id, 'event', abs( $formdata['event']) );
    add_post_meta($new_post_id, 'speaker_name', sanitize_text_field( $formdata['speaker_name']) );
    add_post_meta($new_post_id, 'session_beschreibung', sanitize_textarea_field( $formdata['session_beschreibung']) );

    // Check if string contain @
    $twitterhandle = $formdata['twitterhandle'];
    $twitter_user = strpos($twitterhandle, '@') ? $twitterhandle : '@' . $twitterhandle;

    add_post_meta($new_post_id, 'twitterhandle', sanitize_text_field( $twitter_user ));
    add_post_meta($new_post_id, 'raum', sanitize_text_field($formdata['raum']));
    add_post_meta($new_post_id, 'datum', sanitize_text_field($formdata['datum']));
    add_post_meta($new_post_id, 'uhrzeit', sanitize_text_field($formdata['uhrzeit']));
    add_post_meta($new_post_id, 'sprache', sanitize_text_field($formdata['sprache']));

    return;
}