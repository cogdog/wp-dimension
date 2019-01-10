<?php
/**
 * Inform a theme user of plugins that will extend their theme's functionality.
 *
 * @link https://github.com/Automattic/theme-tools/
 */

class Splot_Theme_Plugin_Enhancements {

	/**
	 * @var array; holds the information of the plugins declared as enhancements
	 */
	var $plugins;

	/**
	 * @var boolean; whether to display an admin notice or not.
	 */
	var $display_notice = false;

	/**
	 * Init function.
	 */
	static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new Splot_Theme_Plugin_Enhancements;
		}

		return $instance;
	}

	/**
	 * Determine the plugin enhancements declared by the theme.
	 *
	 * Themes must declare the plugins on which they depend by using
	 * add_theme_support( 'plugin-enhancements' ).
	 *
	 * If there are plugin enhancements and any of the enhancements are
	 * either not installed or not activated, alert the user.
	 */
	function __construct() {

		// We only want to display the notice on the Dashboard, Themes, and Plugins pages.
		// Return early if we are on a different screen.
		$screen = get_current_screen();
		if ( ! in_array( $screen->base, array( 'dashboard', 'themes', 'plugins' ) ) ) {
			return;
		}

		// Define plugins recommended / required
		$this->plugins = array(			
			array(
				'slug'    => 'font-awesome-5-menus',
				'name'    => 'Font Awesome 5 for Menus',
				'download' => 'https://github.com/cogdog/font-awesome-5-menus',
				'message' => sprintf(
					esc_html__( 'The %1$s allows you to create a menu of social icon links. If you have the version 4 plugin, please de-activate and delete.', 'dimension' ),
					'<strong>' . esc_html__( 'Font Awesome 5 for Menus plugin', 'dimension' ) . '</strong>' ),
			),
			
			
		);
		
		
		// Set the status of each of these enhancements and determine if a notice is necessary.
		$this->set_plugin_status();

		// Output the corresponding notices in the admin.
		if ( $this->display_notice && current_user_can( 'install_plugins' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		}
	}

	/**
	 * Determine the status of each of the plugins declared as a dependency
	 * by the theme and whether an admin notice is necessary or not.
	 */
	function set_plugin_status() {
		// Get the names of the installed plugins.
		$installed_plugin_names = wp_list_pluck( get_plugins(), 'Name' );
		
		foreach ( $this->plugins as $key => $plugin ) {

			// Determine whether a plugin is installed.
			if ( in_array( $plugin['name'], $installed_plugin_names ) ) {

				// Determine whether the plugin is active. If yes, remove if from
				// the array containing the plugin enhancements.
				if ( is_plugin_active( array_search( $plugin['name'], $installed_plugin_names ) ) ) {
					unset( $this->plugins[ $key ] );
				} // Set the plugin status as to-activate.
				else {
					$this->plugins[ $key ]['status'] = 'to-activate';
					$this->display_notice = true;
				}

				// Set the plugin status as to-install.
			} else {
				$this->plugins[ $key ]['status'] = 'to-install';
				$this->display_notice = true;
			}
		}
	}

	/**
	 * Display the admin notice for the plugin enhancements.
	 */
	function admin_notices() {
		// Bail if the user has previously dismissed the notice (doesn't show the notice)
		if ( get_user_meta( get_current_user_id(), 'splot_admin_notice', true ) === 'dismissed' ) {
			return;
		}

		$notice = '';

		// Loop through the plugins and print the message and the download or active links.
		foreach ( $this->plugins as $key => $plugin ) {
			$notice .= '<p>';

			// Custom message provided by the theme.
			if ( isset( $plugin['message'] ) ) {
				$notice .= $plugin['message'];
			}

			// Activation message.
			if ( 'to-activate' === $plugin['status'] ) {
				$activate_url = $this->plugin_activate_url( $plugin['slug'] );
				$notice .= sprintf(
					esc_html__( ' To do this, activate %1$s. %2$s', 'dimension' ),
					esc_html( $plugin['name'] ),
					( $activate_url ) ? '<a href="' . $activate_url . '">' . esc_html__( 'Activate Now', 'dimension' ) . '</a>' : ''
				);
			}

			// Download message.
			if ( 'to-install' === $plugin['status'] ) {
				$install_url = $this->plugin_install_url( $plugin['slug'] );
				
				if ($install_url) {
					// we have a wp rep install link
					$notice .= sprintf(
						esc_html__( ' To do this, install %1$s. %2$s', 'dimension' ),
						esc_html( $plugin['name'] ),
						( $install_url ) ? '<a href="' . $install_url . '">' . esc_html__( 'Install Now', 'dimension' ) . '</a>' : ''
					);
				} elseif ( $plugin['download']  ) {
					$notice .= sprintf(
						esc_html__( ' To use this plugin, download %1$s. %2$s and manually install.', 'dimension' ),
						esc_html( $plugin['name'] ),
						( $plugin['download'] ) ? '<a href="' . $plugin['download'] . '" target="_blank">' . esc_html__( 'Download source', 'dimension' ) . '</a>' : ''
					);	
				}
			}

			$notice .= '</p>';
		}

		// Output notice HTML.
		$allowed = array(
			'p'      => array(),
			'strong' => array(),
			'em'     => array(),
			'b'      => array(),
			'i'      => array(),
			'a'      => array( 'href' => array() ),
		);
		printf(
			'<div id="splot-notice" class="notice notice-warning is-dismissible">%s</div>',
			wp_kses( $notice, $allowed )
		);
	}

	/**
	 * Helper function to return the URL for activating a plugin.
	 *
	 * @param string $slug Plugin slug; determines which plugin to activate.
	 */
	function plugin_activate_url( $slug ) {
		// Find the path to the plugin.
		$plugin_paths = array_keys( get_plugins() );
		$plugin_path  = false;

		foreach ( $plugin_paths as $path ) {
			if ( preg_match( '|^' . $slug .'|', $path ) ) {
				$plugin_path = $path;
			}
		}

		if ( ! $plugin_path ) {
			return false;
		} else {
			return wp_nonce_url(
				self_admin_url( 'plugins.php?action=activate&plugin=' . $plugin_path ),
				'activate-plugin_' . $plugin_path
			);
		}
	}

	/**
	 * Helper function to return the URL for installing a plugin.
	 *
	 * @param string $slug Plugin slug; determines which plugin to install.
	 */
	function plugin_install_url( $slug ) {
		/*
		 * Include Plugin Install Administration API to get access to the
		 * plugins_api() function
		 */
		include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

		$plugin_information = plugins_api( 'plugin_information', array( 'slug' => $slug ) );

		if ( is_wp_error( $plugin_information ) ) {
			return false;
		} else {
			return wp_nonce_url(
				self_admin_url( 'update.php?action=install-plugin&plugin=' . $slug ),
				'install-plugin_' . $slug
			);
		}
	}
}
add_action( 'admin_head', array( 'Splot_Theme_Plugin_Enhancements', 'init' ) );

function splot_enqueue_scripts() {
	// Add the admin JS if the notice has not been dismissed
	if ( is_admin() && get_user_meta( get_current_user_id(), 'splot_admin_notice', true ) !== 'dismissed' ) {

		// Adds our JS file to the queue that WordPress will load
		wp_enqueue_script( 'splot_admin_script', get_stylesheet_directory_uri() . '/includes/splot-plugins.js', array( 'jquery' ), '20180901', true );

		// Make some data available to our JS file
		wp_localize_script( 'splot_admin_script', 'splot_admin', array(
			'splot_admin_nonce' => wp_create_nonce( 'splot_admin_nonce' ),
		));
	}
}
add_action( 'admin_enqueue_scripts', 'splot_enqueue_scripts' );

/**
 *	Process the AJAX request on the server and send a response back to the JS.
 *	If nonce is valid, update the current user's meta to prevent notice from displaying.
 */
function splot_dismiss_admin_notice() {
	// Verify the security nonce and die if it fails
	if ( ! isset( $_POST['splot_admin_nonce'] ) || ! wp_verify_nonce( $_POST['splot_admin_nonce'], 'splot_admin_nonce' ) ) {
		wp_die( __( 'Your request failed permission check.', 'dimension' ) );
	}
	// Store the user's dimissal so that the notice doesn't show again
	update_user_meta( get_current_user_id(), 'splot_admin_notice', 'dismissed' );
	// Send success message
	wp_send_json( array(
		'status' => 'success',
		'message' => __( 'Your request was processed. See ya!', 'dimension' )
	) );
}
add_action( 'wp_ajax_splot_admin_notice', 'splot_dismiss_admin_notice' );

