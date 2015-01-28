<?php
/*
Plugin Name: Hide Login+
Description: This plugin allows you to create custom URLs for user's login, logout and admin's login page.
Author: mohammad hossein aghanabi
Version: 3.1
Author URI: http://developr.ir
*/
/*
This is a new version of Stealth Login plguin by skullbit
*/
/* CHANGELOG 
03-09-2013
	* Changed some default options at activation to avoid 500 Servre internal error
	* Restrictions on using default slugs like `wp-admin` for admin slug that made confliction
	* Optimized code readablity and stability
	* Solved fatal error caused by `check_admin_referer()`
	* Tested over wordpress 3.6
03-02-2013 - v3.0
	* Completely rewrote.
	* All rewrite rules will apply with wordpress buil-in functions 
	* Remove plugin rewrite rules automatically on deactivation to wordpres default rules
	* Works with all permalink structures
	* Droped some useless options and codes and improved functionality 
	* Now Setting page menue is at root
	* Tested Over the latest Wordpress (v3.5.1)
28-07-2012 - v2.1
	* Fix an issue with hide mode capability
29-01-2012 - v2.0
	* Fix .htaccess query commands
	* Automatic removing and adding htaccess output to .htaccess file
	* Strong security key function
	* Added compatibility fix with WordPress installations in a directory like www.blog.com/wordpress/
	* Added ability to disable plugin from its setting page
	* Added ability to attempt to change .htaccess permissions to make writeable
	* Added wp-admin slug option (can't login with it yet though)
	* htaccess Output rules will always show even if htaccess is not writeable
	* added ability to create custom htaccess rules
	* Added Register slug option so you can still allow registrations with the hide-login. (If registration is not allowed, this option will not be available.)
	* Security Key now seperate for each slug so that those registering cannot reuse the key for use on login or logout
	* Added better rewrite rules for a hidden login system.
	* Removed wp-login.php refresh redirect in favor of using rewrite rules for prevention of direct access to the file.
*/
	/**
	 * [hide_options adds plugin default options at activation]
	 * @return [void]
	 */
	function hide_options()
	{
		add_option("hide_login_slug","login");
		add_option("hide_logout_slug", "?logout=me");
		add_option("hide_admin_slug","admin");
		add_option("hide_register_slug","register");
		add_option("hide_forgot_slug","forgot");
		add_option("hide_login_redirect", get_option('siteurl')."/".get_option("hide_admin_slug"));
		add_option("hide_mode", 0);
		add_option("hide_wp_admin", 0);
		add_option("htaccess_rules", "");
	}
	register_activation_hook( __FILE__ , 'hide_options' );
	add_action('init', '_setup');
	/**
	 * [_setup handle access to URLs]
	 * @return [void]
	 */
	function _setup() {
		if(get_option("hide_mode") == 1 && (strpos(strtolower($_SERVER['REQUEST_URI']),'wp-login.php') !== false) && $_SERVER['REQUEST_METHOD'] != "POST")
		{
			wp_redirect(get_option('siteurl'),302);
	        exit;
	    }
		else if(get_option("hide_logout_slug") != "" && (strpos(strtolower($_SERVER['REQUEST_URI']),get_option("hide_logout_slug")) !== false))
		{
			wp_logout();
			wp_redirect(get_option('siteurl'));
			exit;
		}
		else if(get_option("hide_wp_admin") == 1 && (strpos(strtolower($_SERVER['REQUEST_URI']),'wp-admin') !== false) && !is_user_logged_in())
		{
			wp_redirect(get_option('siteurl'));
			exit;
		}
	}
	add_action('admin_menu','AddPanel');
	/**
	 * [AddPanel add hide login menu]
	 */
	function AddPanel()
	{
		add_menu_page('Hide Login', 'Hide Login', 'manage_options', 'HideSettings', 'HideSettings');
	}
	add_action("admin_init", "UpdateSettings");
	/**
	 * [UpdateSettings update all settings after submitting form]
	 */
	function UpdateSettings()
	{
		if( $_POST['action'] == 'hide_login_update' ) 
		{
			$redirect = $_POST['hide_login_redirect'];
			$custom = $_POST['login_custom'];
			unset($_POST['hide_login_redirect'],$_POST['login_custom']);
			$_POST = str_replace(array("/","\\"," "),array("","",""),$_POST);
			$_POST['hide_login_redirect'] = $redirect;
			$_POST['login_custom'] = $custom;
			$_POST['type'] = "success";
			$_POST['notice'] = __('Settings Updated','hidelogin');
			if($_POST['hide_login_redirect'] == "Custom")
			{
				update_option("hide_login_redirect", $_POST['login_custom']);
			}
			else
			{
				update_option("hide_login_redirect", $_POST['hide_login_redirect']);
			}
			update_option("hide_login_slug", $_POST['hide_login_slug']);
			
			update_option("hide_logout_slug", $_POST['hide_logout_slug']);
			if($_POST['hide_admin_slug'] == "wp-admin")
			{
				$_POST['notice'] = __('You can\'t use wp-admin as admin slug. but you can put the field empty','hidelogin');
				$_POST['type'] = "error";
			}
			else
			{
				update_option("hide_admin_slug", $_POST['hide_admin_slug']);
			}
			update_option("hide_register_slug", $_POST['hide_register_slug']);
			update_option("hide_forgot_slug", $_POST['hide_forgot_slug']);
			if(get_option("hide_login_slug") != "")
			{
				update_option("hide_mode", $_POST['hide_mode']);
			}
			else
			{
				update_option("hide_mode", 0);
			}
			if(get_option("hide_admin_slug") != "")
			{
				update_option("hide_wp_admin", $_POST['hide_wp_admin']);
			}
			else
			{
				update_option("hide_wp_admin", 0);
			}
			hide_login();
		}
	}
	if(get_option("hide_login_redirect") != "")
	{
		add_action('login_form', 'redirect_after_login');
		function redirect_after_login() {
			global $redirect_to;
			if (!isset($_GET['redirect_to'])) {
				$redirect_to = get_option('hide_login_redirect');
			}
		}
	}
	if(get_option("hide_logout_slug") != "")
	{
		add_filter('logout_url', 'new_logout_url', 10, 2);
		function new_logout_url($logout_url, $redirect)
		{
			return "/".get_option("hide_logout_slug");
		}
	}
	if(get_option("hide_login_slug") != "")
	{
		add_filter( 'login_url', 'new_login_url', 10, 2 );
		function new_login_url( $login_url, $redirect ) {
				return "/".get_option("hide_login_slug");
		}
	}
	if(get_option("hide_register_slug") != "")
	{
		add_filter('register','new_signup_url');
		function new_signup_url($url){
			return str_replace(site_url('wp-login.php?action=register', 'login'),site_url(get_option("hide_register_slug"), 'login'),$url);
		}
	}
	if(get_option("hide_forgot_slug") != "")
	{
		add_filter('lostpassword_url','new_forgetpass_url');
		function new_forgetpass_url($url){
		   return str_replace('?action=lostpassword','',str_replace(network_site_url('wp-login.php', 'login'),site_url(get_option("hide_forgot_slug"), 'login'),$url));
		}
	}
	/**
	 * [hide_login write rewrite rules in .htaccess file]
	 */
	function hide_login()
	{
	    global $wp_rewrite;
		$other_rules = array();
		if(get_option("hide_admin_slug") != "")
		{
			add_rewrite_rule( get_option("hide_admin_slug").'/(.*?)$', 'wp-admin/$1?%{QUERY_STRING}', 'top' );
			$other_rules[get_option("hide_admin_slug").'$'] = 'WITH_SLASH';
		}
		if(get_option("hide_login_slug") != "")
		{
			add_rewrite_rule( get_option("hide_login_slug").'/?$', 'wp-login.php', 'top' );
		}
		if(get_option("hide_register_slug") != "")
		{
			add_rewrite_rule( get_option("hide_register_slug").'/?$', 'wp-login.php?action=register', 'top' );
		}
		if(get_option("hide_forgot_slug") != "")
		{
			add_rewrite_rule( get_option("hide_forgot_slug").'/?$', 'wp-login.php?action=lostpassword', 'top' );
		}
		$wp_rewrite->non_wp_rules = $other_rules + $wp_rewrite->non_wp_rules;
		function ht_rules($rules)
		{
			$rules = str_replace("/WITH_SLASH [QSA,L]", "%{REQUEST_URI}/ [R=301,L]", $rules);
			update_option("htaccess_rules", $rules);
			return $rules;
			
		}
		add_filter('mod_rewrite_rules', 'ht_rules');
		$wp_rewrite->flush_rules(true);
	}
	/**
	 * [dis_msg description]
	 * @param  [type] $msg  [shown message]
	 * @param  string $type [if "success"ful or an "error"]
	 * @return [string]       [html and message]
	 */
	function dis_msg($msg, $type = "success")
	{
		if($type == "success")
		{
			$display = '<div id="message" class="updated fade"><p><strong>' . $msg . '</strong></p></div>';
		}
		else if($type == "error")
		{
			$display = '<div id="message" class="error fade"><p><strong>' . $msg . '</strong></p></div>';
		}
		return $display;
	}
	/**
	 * [hideSettings form on the settings page]
	 */
	function hideSettings()
	{
		echo dis_msg($_POST['notice'], $_POST['type']);
			?>
	            <div class="wrap" style="font-family: tahoma !important;">
	            	<h2><?php _e('Hide Login Settings', 'hidelogin')?></h2>
	                <form method="post" action="">
	                    <table class="form-table">
	                        <tbody>
	                            <tr valign="top">
	                       			 <th scope="row"><label for="login_slug"><?php _e('Login Slug', 'hidelogin');?></label></th>
	                        		<td><input name="hide_login_slug" id="login_slug" value="<?php echo get_option('hide_login_slug');?>" type="text"><br />
	                                <strong style="color:#777;font-size:12px;">Login URL:</strong> <span style="font-size:0.9em;color:#999999;"><?php echo trailingslashit( get_option('siteurl') ); ?><span style="background-color: #fffbcc;"><?php echo get_option('hide_login_slug');?></span></span></td>
	                        	</tr>
	                            <tr valign="top">
	                            	<th scope="row"><label for="login_redirect"><?php _e('Login Redirect', 'hidelogin');?></label></th> 
	                                <td><select name="hide_login_redirect" id="login_redirect">
											<?php $cus = true; ?>
	                                		<option value="<?php echo get_option('siteurl')."/".get_option("hide_admin_slug");?>" <?php if(get_option('hide_login_redirect') == get_option('siteurl')."/".get_option("hide_admin_slug")){$cus = false;  echo 'selected="selected"';} ?>>WordPress Admin</option>
	                                		<option value="<?php echo get_option('siteurl');?>" <?php if(get_option('hide_login_redirect') == get_option('siteurl')){$cus = false; echo 'selected="selected"';} ?>>WordPress Address</option>
											<option value="Custom" <?php if($cus){echo 'selected="selected"';} ?>>Custom URL (Enter Below)</option>
	                                	</select><br />
									<input type="text" name="login_custom" size="40" value="<?php if($cus){ echo get_option('hide_login_redirect'); }?>" /><br />
									<strong style="color:#777;font-size:12px;">Redirect URL:</strong> <span style="font-size:0.9em;color:#999999;"><?php if( get_option('hide_login_redirect') != 'Custom' ) { echo get_option('hide_login_redirect'); } else { echo get_option('hide_login_custom'); } ?></span></td>
	                            </tr>
	                            <tr valign="top">
	                            	<th scope="row"><label for="logout_slug"><?php _e('Logout Slug', 'hidelogin');?></label></th>
	                                <td><input type="text" name="hide_logout_slug" id="logout_slug" value="<?php echo get_option('hide_logout_slug');?>" /><br />
	                                <strong style="color:#777;font-size:12px;">Logout URL:</strong> <span style="font-size:0.9em;color:#999999;"><?php echo trailingslashit( get_option('siteurl') ); ?><span style="background-color: #fffbcc;"><?php echo get_option('hide_logout_slug');?></span></span></td>
	                            </tr>
	                         <?php if( get_option('users_can_register') ){ ?>
	                            <tr valign="top">
	                            	<th scope="row"><label for="register_slug"><?php _e('Register Slug', 'hidelogin');?></label></th>
	                                <td><input type="text" name="hide_register_slug" id="register_slug" value="<?php echo get_option('hide_register_slug');?>" /><br />
	                                <strong style="color:#777;font-size:12px;">Register URL:</strong> <span style="font-size:0.9em;color:#999999;"><?php echo trailingslashit( get_option('siteurl') ); ?><span style="background-color: #fffbcc;"><?php echo get_option('hide_register_slug');?></span></span></td>
	                            </tr>
	                          <?php } ?>
	                          <tr valign="top">
	                       			 <th scope="row"><label for="admin_slug"><?php _e('Admin Slug', 'hidelogin');?></label></th>
	                        		<td><input name="hide_admin_slug" id="admin_slug" value="<?php echo get_option('hide_admin_slug');?>" type="text"><br />
	                                <strong style="color:#777;font-size:12px;">Admin URL:</strong> <span style="font-size:0.9em;color:#999999;"><?php echo trailingslashit( get_option('siteurl') ); ?><span style="background-color: #fffbcc;"><?php echo get_option('hide_admin_slug');?></span></span></td>
	                        	</tr>
								<tr valign="top">
	                       			 <th scope="row"><label for="forgot_slug"><?php _e('Forgot Password Slug', 'hidelogin');?></label></th>
	                        		<td><input name="hide_forgot_slug" id="forgot_slug" value="<?php echo get_option('hide_forgot_slug');?>" type="text"><br />
	                                <strong style="color:#777;font-size:12px;">Forgot Password URL:</strong> <span style="font-size:0.9em;color:#999999;"><?php echo trailingslashit( get_option('siteurl') ); ?><span style="background-color: #fffbcc;"><?php echo get_option('hide_forgot_slug');?></span></span></td>
	                        	</tr>
	                            <tr valign="top">
	                            	<th scope="row"><?php _e('hide Mode', 'hidelogin'); ?></th>
	                                <td><label><input type="radio" name="hide_mode" value="1" <?php if(get_option('hide_mode') ) echo 'checked="checked" ';?> /> Enable</label><br />
	                                	<label><input type="radio" name="hide_mode" value="0" <?php if(!get_option('hide_mode') ) echo 'checked="checked" ';?>/> Disable</label><br />
	                                    <small><?php _e('Prevent users from being able to access wp-login.php directly ( enable this when you use custom login slug )','hidelogin');?></small></td>
	                            </tr>
								<tr valign="top">
	                            	<th scope="row"><?php _e('hide wp-admin', 'hidelogin'); ?></th>
	                                <td><label><input type="radio" name="hide_wp_admin" value="1" <?php if(get_option('hide_wp_admin') ) echo 'checked="checked" ';?> /> Enable</label><br />
	                                	<label><input type="radio" name="hide_wp_admin" value="0" <?php if(!get_option('hide_wp_admin') ) echo 'checked="checked" ';?>/> Disable</label><br />
	                                    <small><?php _e('Prevent users from being able to access wp-admin directly ( enable this when you use custom admin slug )','hidelogin');?></small></td>
	                            </tr>
	                            <tr valign="top">
	                            <th scope="row"><?php _e('.htaccess Output', 'hidelogin');?></th>
	                            <td style="color: navy;"><pre><?php echo ((get_option('htaccess_rules') != "")?get_option('htaccess_rules'):"<span style=\"color: red !important;\">No Output.</span>");?></pre></td>
	                            </tr>
								<tr valign="top">
								<th scope="row"><?php _e('Did the Tricks ?', 'hidelogin');?></th>
								<td>
								        <input name="Submit" style="font-family: tahoma !important; font-weight: bold;" value="<?php _e('Save Changes','hidelogin');?>" type="submit" />
										<input name="action" value="hide_login_update" type="hidden" />
								</td>
								</tr>
	                    	</tbody>
	                 	</table>
	                </form>
	              
	            </div>
	<?php
	}
	/**
	 * [_deactivate remove all changes and leave wordpres rules as default on deactivation]
	 */
	function _deactivate()
	{
	    remove_action( 'generate_rewrite_rules', 'hide_login' );
	    $GLOBALS['wp_rewrite']->flush_rules(true);
	}
	register_deactivation_hook( __FILE__ , '_deactivate' );
?>