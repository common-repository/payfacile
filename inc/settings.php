<?php

if ( ! class_exists( 'PAYFACILE_SETTINGS' ) ) {

	class PAYFACILE_SETTINGS {

		
		private $slug;

		public function __construct() {
			global $PAYFACILE;
			$this->slug = $PAYFACILE->plugin_slug;
			add_action( 'admin_menu', array( &$this, 'add_menu' ) );
		} 

		/**
		 * Add settings menu
		 */
		public function add_menu() {
			add_options_page(
				__( 'Payfacile', 'payfacile' ),
				__( 'Payfacile', 'payfacile' ),
				'manage_options',
				$this->slug,
				array( &$this, 'plugin_settings_page' )
			);
		} 

		public function plugin_settings_page() {

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
			}
			require_once( 'settings-template.php' );
		} 
		
		

	} 

} 
