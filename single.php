<?php 

// get a value of the button label
$button_label =  get_post_meta( get_the_ID(), '_button_label', true );

// set the proper ID to find on index page
$go_link = ( empty( $button_label )  ) ? sanitize_title( get_the_title( get_the_ID() ) ) : sanitize_title( $button_label );

// weeee, go there!
wp_redirect ( get_site_url() . '/#' . $go_link );
exit;
?>