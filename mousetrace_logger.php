<?php
/*
Plugin Name: MouseTrace Logger
Plugin URI: http://mousetrace.com/wordpress.aspx
Description: A brief description of the Plugin.
Version: 1.0
Author: Dan Field
Author URI: http://uk.linkedin.com/in/danfield
License: GPL2
*/

/*  Copyright 2010 Dan Field  (email : dan.field@mailsuite.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( !is_admin() ) { // instruction to only load if it is not the admin area
	// register your script location, dependencies and version
	$site_id = get_option('mousetrace_site_id');
	$url = 'http://s.mousetrace.com/s.aspx?sid=';
	wp_register_script('mousetrace_logger',
		$url.$site_id,
		false,
		'1.0', false );
	// enqueue the script
	wp_enqueue_script('mousetrace_logger');
}


/* admin options */
add_action('admin_menu', 'mousetrace_logger_menu');

function mousetrace_logger_menu() {

	add_options_page('MouseTrace Options', 'MouseTrace Logger', 'manage_options', 'mousetrace_logger_options_id', 'mousetrace_logger_options');

}

function mousetrace_logger_options() {

	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	$hidden_field_name = 'mt_submit_hidden';
	$data_field_name = 'mousetrace_site_id';
	$site_id = get_option('mousetrace_site_id');

	if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val = $_POST[ $data_field_name ];

        // Save the posted value in the database
        update_option( $data_field_name, $opt_val );

        // Put an settings updated message on the screen
?>
<div class="updated"><p><strong><?php _e('settings saved.', 'mousetrace_logger_menu' ); ?></strong></p></div

<?php
	}
	
	// Now display the settings editing screen
	echo '<div class="wrap">';

	// header
	echo "<h2>" . __( 'MouseTrace Logger Plugin Settings', 'mousetrace_logger_menu' ) . "</h2>";

	// settings form
?>

<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><?php _e("MouseTrace Site ID:", 'mousetrace_logger_menu' ); ?> 
<input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $site_id; ?>" size="20">
</p><hr />

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>
<hr>
<p>
	<strong>About MouseTrace</strong>
</p>
<p>
MouseTrace offers a simple solution which allows any website owner or designer to monitor exactly how their visitors really use their blog, no more guessing why people aren't engaging more, buying or signing up for your newsletters.
</p>
<p>
Register for your account MouseTrace account (<a href="http://mousetrace.com/" target="_blank">http://mousetrace.com</a>), configure this WordPress extension and then sit back and watch all of your visitors actions in real-time...
</p>
<p>
	<a href="http://mousetrace.com" target="_blank">http://mousetrace.com</a>
</p>
<p>
<strong>Support</strong>
</p>
<p>
	<a href="http://support.mousetrace.com" target="_blank">http://support.mousetrace.com</a>
</p>






</form>
</div>

<?php
}

?>
