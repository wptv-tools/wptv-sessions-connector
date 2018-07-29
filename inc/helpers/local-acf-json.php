<?php

/**
 *
 * Change the Locacion of the acf-json folder
 *
 */
add_filter('acf/settings/save_json', 'wptvsc_acf_json_save_point');

function wptvsc_acf_json_save_point( $path ) {

    // update path
    $path = WPTV_SESSION_CONNECTOR_PLUGIN_PATH . 'acf-json';

    // return
    return $path;
}


add_filter('acf/settings/load_json', 'wptvsc_acf_json_load_point');

function wptvsc_acf_json_load_point( $paths ) {
    // remove original path (optional)
    unset($paths[0]);

    // append path
    $paths[] = WPTV_SESSION_CONNECTOR_PLUGIN_PATH . 'acf-json';

    // return
    return $paths;
}

add_filter('acf/settings/remove_wp_meta_box', '__return_true');