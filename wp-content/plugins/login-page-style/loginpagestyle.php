<?php
/*
Plugin Name: Login Page Style
Plugin URI: 
Description: You get freedom change login ( wp-login.php) default style And you also change logo and logo background.
Version: 0.01
Author URI:http://www.projapotibd.com/author/osmansorkar
*/
// We Add Jquery For Upload
function lps_jquery() {
?><script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('.hlogobbutton').click(function() {
            tb_show('', 'media-upload.php?TB_iframe=true');
            window.send_to_editor = function(html) {
                url = jQuery(html).attr('href');
                jQuery('#headerlogo').val(url);
                tb_remove();
            };
        return false;
        });
    });
    </script>
        <script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('.backgbutton').click(function() {
            tb_show('', 'media-upload.php?TB_iframe=true');
            window.send_to_editor = function(html) {
                url = jQuery(html).attr('href');
                jQuery('#backg-photo').val(url);
                tb_remove();
            };
        return false;
        });
    });
    </script>
<?php 
}
add_action('admin_head', 'lps_jquery');

function lps_Scripts() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
}
add_action('admin_print_scripts', 'lps_Scripts');
 
function lps_styles() {
    wp_enqueue_style('thickbox');
}
add_action('admin_print_styles', 'lps_styles');

add_filter('login_headerurl','lps_login_headerurl');
function lps_login_headerurl($url){
	$url=get_site_url();
	return $url;
	}
add_filter('login_headertitle','lps_login_headertitle');
function lps_login_headertitle($ptitle){
	$ptitle= 'Powar by '.get_bloginfo('name');
	return $ptitle; 
}
?>
<?php
if ( is_admin() ) : // Load only if we are viewing an admin page
function lps_option_initt() {
	// Register settings and call sanitation functions
	register_setting( 'lps', 'lpsop' );
}
add_action( 'admin_init', 'lps_option_initt' );
function lps_add_plugin_page() {
	// Add theme options page to the addmin menu
	add_options_page( 'Login page style', 'Login page Plugin', 'edit_plugins', 'login_page_style', 'login_page_style' );
}

add_action( 'admin_menu', 'lps_add_plugin_page' );

// Function to generate options page
function login_page_style() {?>
<div class="wrap" style="margin-left:50px;">
<?php screen_icon(); ?>
<h2>Login Plugin Page Management page</h2>

<div style="width:600px">

<form method="post" action="options.php"> 
<?php settings_fields( 'lps' ); ?>
<?php 	$defaults = array(
  'cocss' => '.login form {
background: none repeat scroll 0 0 yellowgreen;
color:white;
}
.message,#login_error {
    background-color: #FFFFE0;
    border-color: #E6DB55;
    margin: 0 0 0 10px;
}
.login .message {
    margin: 0 0 0 10px;
}
#nav, #backtoblog {
    background: none repeat scroll 0 0 yellowgreen;
    margin-left: 10px !important;
	padding: 10px;
}
.login #nav a, .login #backtoblog a {
    color: black !important;
}',
  'bphoto' => '',
  'hlogo' => '',
  'bgc' => '',
  'lbg' => ''
);
	 $lpsop =wp_parse_args(get_option('lpsop'), $defaults); ?>
<table style="text-align:left">

<tr><th><label for="Header-Logo">Header Logo</label></th><th>&nbsp;</th>
<td><input id="headerlogo" type="text" name="lpsop[hlogo]" value="<?php echo $lpsop['hlogo']; ?>" /><input type="button" value="Browse" id="hlogobbutton" class="hlogobbutton"  /></td></tr>

<tr><th><label for="Background Photo">Background Photo</label></th><th>&nbsp;</th>
<td><input id="backg-photo" type="text" name="lpsop[bphoto]" value="<?php echo $lpsop['bphoto']; ?>" /><input type="button" value="Browse" id="backgbutton" class="backgbutton"  /></td></tr>

<tr><th><label for="Logo Background">Logo Background Color</label></th><th>&nbsp;</th>
<td><input id="lbg-color" type="text" name="lpsop[lbg]" value="<?php echo $lpsop['lbg']; ?>" /></td></tr>

<tr><th><label for="Background Color">Background Color</label></th><th>&nbsp;</th>
<td><input id="bgc" type="text" name="lpsop[bgc]" value="<?php echo $lpsop['bgc']; ?>" /></td></tr>

<tr><th><label for="Costom ">Custom Css</label></th><th>&nbsp;</th>
<td><textarea name="lpsop[cocss]" cols="40" rows="7" id="cocss"><?php echo $lpsop['cocss']; ?></textarea></td></tr>
</table>
</div>
<?php submit_button(); ?>
</form>
</div>
<?php
}
endif;  // EndIf is_admin()
function change_my_wp_login_image() {
	$defaults = array(
  'cocss' => '.login form {
background: none repeat scroll 0 0 yellowgreen;
color:white;
}
.message,#login_error {
    background-color: #FFFFE0;
    border-color: #E6DB55;
    margin: 0 0 0 10px;
}
.login .message {
    margin: 0 0 0 10px;
}
#nav, #backtoblog {
    background: none repeat scroll 0 0 yellowgreen;
    margin-left: 10px !important;
	padding: 10px;
}
.login #nav a, .login #backtoblog a {
    color: black !important;
}',
  'bphoto' => '',
  'hlogo' => '',
  'bgc' => '',
  'lbg' => ''
);
	 $lpsop =wp_parse_args(get_option('lpsop'), $defaults);
	  if(!$lpsop['bphoto']==''){
		 $lpsop['bphoto']="background: url('".$lpsop['bphoto']."') repeat scroll 0 0 transparent !important";
	 }
echo'<style type="text/css">'.$lpsop['cocss']
.'

</style>
';
echo "
<style>
body {
    ".$lpsop['bphoto']."
}
#login h1 a {
background: url('".$lpsop['hlogo']."') center no-repeat ;
background-size: 274px 63px;
 }
body.login{
	background: url('".$lpsop['bphoto']."') center repeat ;
	background: none repeat scroll 0 0 ".$lpsop['bgc'].";
}
h1 {
    background: none repeat scroll 0 0 ".$lpsop['lbg'].";
    font-size: 2em;
    margin-bottom: 0.67em;
    margin-left: 10px !important;
    margin-top: 0.67em !important;
}
</style>
";
}
add_action("login_head", "change_my_wp_login_image");
?>