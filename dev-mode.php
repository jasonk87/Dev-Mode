<?php
/*
Plugin Name: Dev Mode
Description: Add a development mode, which will warn users you are currently working on their site.
Author: Jason Kinslow
Version: 0.0.1
Author URI: https://www.makespaceweb.com
*/

//this will include my plugin options folder
//@include 'options.php';

defined( 'ABSPATH' ) or die( 'This plugin requires WordPress' );

define( 'DEVMODE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

if( WP_DEBUG ){
	ini_set( 'error_log', DEVMODE_PLUGIN_DIR . '/debug.log' );
}

class Dev_Mode {

	function __construct(){
		add_action('admin_bar_menu', array( $this, 'add_development_mode_button' ), 999);
		
		// Set options on registration
		register_activation_hook( __FILE__, array( $this, 'set_options_on_load' ) );

		// Add settings page to plugin
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		
		// Add modal to admin footer
		add_action('admin_footer', array( $this, 'add_development_modal' ) );
		
		// Prerequisite Styles
		add_action( 'admin_enqueue_scripts', array( $this, 'registerDependencies' ) );
	}

	function add_admin_menu(){
		add_menu_page( 'Dev Mode Settings', 'Dev Mode', 'manage_options', 'dev-mode', array( $this, 'settings' ) );
	}

	function add_development_modal(){
		// Get Variables
		$header = get_option( 'dm_modal_header' );
		$content = get_option( 'dm_modal_content' );
		
		?>
			<?php if ( get_option( 'dm_modal_active' ) && ! is_plugin_page()  ): ?>
				<a href="#development_modal" class="development_mode_button"></a>
				<div id="development_modal" class="development_modal white-popup mfp-hide">
					<div class="header">
						<h2><?php echo $header; ?></h2>
					</div>

					<p class="content"><?php echo $content; ?></p>

					<!-- Close -->
					<button class="development-modal-close">I Agree</button>
				</div>
			<?php endif ?>
		<?php 
	}

	function add_development_mode_button( $wp_admin_bar ) {
	    $dev_active = get_option( 'dm_modal_active' );
	    $active_class = ( $dev_active ) ? 'active' : 'inactive';

	    $args = array(
	        'id' => 'development_mode_admin_button',
	        'title' => strtoupper( 'Dev Mode ' . $active_class ), 
	        'href' => admin_url('admin.php?page=dev-mode'), 
	        'meta' => array(
	            'class' => 'development_mode_admin_button ' . $active_class, 
	            'title' => 'Development Mode'
	            )
	    );
	    
	    $wp_admin_bar->add_node($args);
	}

	function registerDependencies(){

		wp_enqueue_style( 'Dev_ModeAdminPluginScss', plugins_url( '/scss/Dev_ModeAdminPluginScss.scss', __FILE__ ) );
		wp_enqueue_style( 'MagnificPopupCSS_CDN', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css' );

		wp_enqueue_script( 'Dev_ModeAdminPluginJs', plugins_url( '/js/Dev_ModeAdminPluginJs.js', __FILE__ ) );
		wp_enqueue_script( 'MagnificPopupJS_CDN', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js' );
	}

	function set_active_status( $value ){
		if ( $value == 'on' ){
			update_option( 'dm_modal_active', true );
		} else {
			update_option( 'dm_modal_active', false );
		} 
	}

	function set_options_on_load(){
		// Form Content
		update_option( 'dm_modal_active', false );

		// Modal Header
		update_option( 'dm_modal_header', 'Development Mode Is Active' );

		// Modal Content
		update_option( 'dm_modal_content', 'This website is currently under development. Any changes from the admin screen may be lost when updated by the developers. If you have any questions please contact your development team.' );
	}

	function settings(){
		// If POST, save options
		if ( $_POST ){
			$this->set_active_status( $_POST[ 'dev_mode_active' ] );
			echo '<script type="text/javascript">sessionStorage.setItem( "dm_agreed", false );</script>';
			
			update_option( 'dm_modal_header', $_POST[ 'development_modal_header' ] );
			update_option( 'dm_modal_content', $_POST[ 'development_modal_content' ] );
		}

		// Form Variables
		$dev_mode_active = get_option( 'dm_modal_active' );
		$header = get_option( 'dm_modal_header' );
		$content = get_option( 'dm_modal_content' );
		
		?>
			<div class="wrap-dev-mode">
				<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
				<p class="options">
					Welcome to Dev Mode. Dev Mode is a plugin, which adds the ability to inform the client or other users, that the website is in development.
				</p>
				
				<div class="options">
					<form method="POST" id="dev-mode-options">
						<ul>
							<li class="horizontal">
								<p class="label">Toggle Dev Mode</p>
								<label class="switch">
								  	<input type="checkbox" name="dev_mode_active" <?php checked( $dev_mode_active, true ) ?>>
									<span class="slider round"></span>
								</label>
							</li>
							
							<li class="horizontal">
								<p class="label">Set Modal Header</p>
								<input type="text" name="development_modal_header" maxlength="26" value="<?php echo $header; ?>">
							</li>

							<li class="vertical">
								<p class="label">Set Modal Content</p>
								<textarea name="development_modal_content" rows="3"><?php echo $content; ?></textarea>
							</li>
						
							<button type="submit" class="button button-primary button-large" form="dev-mode-options" value="Submit">Save Options</button>
						</ul>
					</form>
				</div>
			</div> 
		<?php
	}
}

new Dev_Mode();