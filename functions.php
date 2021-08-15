<?php
/*This file is part of abril-child, abril child theme.

All functions of this file will be loaded before of parent theme functions.
Learn more at https://codex.wordpress.org/Child_Themes.

Note: this function loads the parent stylesheet before, then child theme stylesheet
(leave it in place unless you know what you are doing.)
*/


if ( ! function_exists( 'suffice_child_enqueue_child_styles' ) ) {

	function abril_child_enqueue_child_styles() {

	    // loading parent style

	    wp_register_style(

	      'parente2-style',

	      get_template_directory_uri() . '/style.css'

	    );



	    wp_enqueue_style( 'parente2-style' );

	    // loading child style

	    wp_register_style(

	      'childe2-style',

	      get_stylesheet_directory_uri() . '/style.css'

	    );

	    wp_enqueue_style( 'childe2-style');

	 }

}
add_action( 'wp_enqueue_scripts', 'abril_child_enqueue_child_styles' );

/*Write here your own functions */



add_action('wp_footer', 'Nccmms_scripts');
function Nccmms_scripts()
{
    ?>
        <script>
            jQuery(document).ready(function(){ 
                
            }
// contact form for single time display error message 
                jQuery( '.wpcf7-form' ).submit(function() { // form class name
                    jQuery( '.wpcf7-submit' ).attr( 'disabled', true );
                });

                document.addEventListener( 'wpcf7invalid', function() {
                    jQuery( '.wpcf7-submit' ).attr( 'disabled', false );
                }, false );

                document.addEventListener( 'wpcf7mailsent', function( event ) {
                    jQuery( '.wpcf7-submit' ).attr( 'disabled', false );
                }, false );

                jQuery("form .form-control").focus(function(){
                    jQuery(this).parent().parent().addClass('active');
                  }).blur(function(){
                    var cval = jQuery(this).val();
                //        console.log(cval);
                    if(cval.length < 1) {jQuery(this).parent().parent().removeClass('active');}
                  });

                document.addEventListener( 'wpcf7invalid', function( event ) {

                    jQuery('.form-label').removeClass('active');
                }, false );
                document.addEventListener( 'wpcf7spam', function( event ) {
                   jQuery('.form-label').removeClass('active');
                }, false );
                document.addEventListener( 'wpcf7mailfailed', function( event ) {
                    jQuery('.form-label').removeClass('active');
                }, false );

                document.addEventListener( 'wpcf7mailsent', function( event ) {
                    jQuery('.form-label').removeClass('active');
                }, false );
                
                
                
                 //   this script for the phone masking move cursor at first position
                    jQuery('.your-phone input').on('focus click',function(){
                      jQuery(this)[0].setSelectionRange(0, 0);
                   });
                   
                });
        </script>
        <?php
}

/* remove template redirection */
function saf_remove_template_redirect(){
  ob_start( function( $buffer ){
    $buffer = str_replace( array( 
        '<script type="text/javascript">',
        "<script type='text/javascript'>", 
        "<script type='text/javascript' src=",
        '<script type="text/javascript" src=',
        '<style type="text/css">', 
        "' type='text/css' media=", 
        '<style type="text/css" media',
        "' type='text/css'>",
'<style></style>',
'type="text/css" id="wp-custom-css"',
'frameborder="0" scrolling="no"',
'frameborder="0" allowfullscreen="allowfullscreen"',
    ), 
    array(
        '<script>', 
        "<script>", 
        "<script src=",
        '<script src=',
        '<style>', 
        "' media=", 
        '<style media',
        "' >",
'',
'id="wp-custom-css"',
'',
' allowfullscreen="allowfullscreen"',
    ), $buffer );

    return $buffer;
  });
};
add_action( 'template_redirect', 'saf_remove_template_redirect', 10, 2);


/* For Recaptcha 
find posts and shortcode , and if shortcode is found then display captcha
*/

add_action('wp_print_scripts', function () {
	global $post;
	if ( is_a( $post, 'WP_Post' ) && !has_shortcode( $post->post_content, 'contact-form-7') ) {
		wp_dequeue_script( 'google-recaptcha' );
		wp_dequeue_script( 'wpcf7-recaptcha' );
	}
});