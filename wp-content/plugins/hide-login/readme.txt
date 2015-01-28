=== Hide Login+ ===
Contributors: mohammad hossein aghanabi
Tags: login, logout, htaccess, custom, url, wp-admin, admin, change, hide, stealth, security
Requires at least: 2.3
Tested up to: 3.6
Stable tag: 3.1

Have a secure login and admin page. Allows you to create custom URLs for user's login, logout and admin's login page as simple as possible.

== Description ==
= A must have plugin for wordpress blogs =

With it you can **simply** change most important URLs that are for daily use and then you may ask why **Hide Login+** plugin?

*So is this plugin for you? let's know*

`$requires = array(
	"you need secured and hidden login page that no one except you can access them?" => true,
	"you want custom and nice URLs for login and admin pages?" => true,
	"you need to have control over URLs that you never had an easy access before?" => true,
	"wanna prevent your website from being under attack & session hijacking?" => true
)
`

Then...

`if(in_array($what_you_want, $requires))
{
	echo "Then this plugin is for you";
}`

Features:

*	Define custom slugs for wordpess login, logout, registration, forgot password & admin URLs
*	Able to prevent access to `wp-login.php` and `wp-admin` directly
*	Custom redirection after login with pre-defined options
*	See your `.htaccess` content after changes successfuly has been done
*	Simple back-to-defaults ability on plugin deactivation


 *This won't secure your website perfectly, but if someone does manage to crack your password, it can make it difficult for them to find where to actually login.  This also prevents any bots that are used for malicious intents from accessing your `wp-login.php` file and attempting to break in.*

== Installation ==

1. Upload the `hide-login` directory to the `/wp-content/plugins/` directory

2. Add these two lines in wp-config.php file after `/* That's all, stop editing! Happy blogging. */`
`define('WP_ADMIN_DIR', 'YOUR_ADMIN_SLUG');`
`define('ADMIN_COOKIE_PATH', SITECOOKIEPATH . WP_ADMIN_DIR);`
Where `YOUR_ADMIN_SLUG` is the slug you use in plugin setting page for Admin.

3. Activate the plugin through the 'Plugins' menu in WordPress

4. Set the options in the Settings Panel

== Changelog ==
= 3.1 =
	* Changed some default options at activation to avoid 500 Server internal error
	* Restrictions on using default slugs like `wp-admin` for admin slug that made confliction
	* Optimized code readablity and stability
	* Solved fatal error caused by `check_admin_referer()`
	* Tested over wordpress 3.6
= 3.0 =
	* Completely rewrote.
	* All rewrite rules will apply with wordpress buil-in functions 
	* Remove plugin rewrite rules automatically on deactivation to wordpres default rules
	* Works with all permalink structures
	* Droped some useless options and codes and improved functionality 
	* Now Setting page menu is at root
	* Tested Over the latest Wordpress version(3.5.1)
= 2.1 =
	* Fix an issue with hide mode capability
= 2.0 =
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

== Frequently Asked Questions ==

= Something gone horribly wrong and my site is down =

Just deactivate it ;)

== Screenshots ==

1. Settings