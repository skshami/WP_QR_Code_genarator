
<?php
/**
 * Plugin Name:       Posts QR Code
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Display QR Code under evry posts.
 * Version:           1.0.0
 * Author:            Shamim khan
 * Author URI:        https://github.com/skshami/
 * Text Domain:       pqrc
 * Domain Path:       /languages
 */

function pqrc_load_textdomain() {
    load_plugin_textdomain( 'pqrc', false, dirname( __FILE__ ) . "/language" );
}

//Post to QR code Add
function pqrc_dispaly_qrcode( $content ) {
    $current_post_id = get_the_ID();
    $current_post_title = get_the_title();
    $current_post_url = urlencode( get_the_permalink( $current_post_id ) );
    $current_post_types= get_post_type($current_post_id);

    // Post Type check hook
    $excluded_post_types = apply_filters('pqrc_excluded_post_types', array());
    if(in_array($current_post_types,$excluded_post_types)){
        return $content;
    }

    //Post QR Code Image dimension hook
    $dimension= apply_filters('pqrc_image_dimension','220x220');

    //Post QR Code Image Attributes
    $image_attributes=apply_filters('pqrc_image_attributes',null);

    $image_src = sprintf( 'https://api.qrserver.com/v1/create-qr-code/?size=%s&margin=0&data=%s',$dimension,$current_post_url );
    $content .= sprintf( '<div class="qpcode"><img %s src="%s" alt="%s"></div>',$image_attributes,$image_src,$current_post_title);
    return $content;
}
add_filter( 'the_content', 'pqrc_dispaly_qrcode');
