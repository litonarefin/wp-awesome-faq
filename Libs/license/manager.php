<?php

if ( ! function_exists( 'jltwpafaq_license_client' ) ) {
	/**
	 * License Client function
	 *
	 * @author Jewel Theme <support@jeweltheme.com>
	 */
	function jltwpafaq_license_client() {
		global $jltwpafaq_license_client;

		if ( ! isset( $jltwpafaq_license_client ) ) {
			// Include SDK.
			require_once JLTWPAFAQ_LIBS . '/License/Loader.php';

			$jltwpafaq_license_client = new \JLTWPAFAQ\Libs\License\Loader(
				array(
					'plugin_root'      => JLTWPAFAQ_FILE,
					'software_version' => JLTWPAFAQ_VER,
					'software_title'   => 'wp-awesome-faq',
					'product_id'       => '',
					'redirect_url'     => admin_url( 'admin.php?page=' . JLTWPAFAQ_SLUG . '-license-activation' ),
					'software_type'    => 'plugin', // theme/plugin .
					'api_end_point'    => \JLTWPAFAQ\Libs\Helper::api_endpoint(),
					'text_domain'      => 'wp-awesome-faq',
					'license_menu'     => array(
						'icon_url'    => 'dashicons-image-filter',
						'position'    => 40,
						'menu_type'   => 'add_submenu_page', // 'add_submenu_page',
                        'parent_slug' => '-settings',
						'menu_title'  => __( 'License', 'wp-awesome-faq' ),
						'page_title'  => __( 'License Activation', 'wp-awesome-faq' ),
					),
				)
			);
		}

		return $jltwpafaq_license_client;
	}

	// Init JLT_Awesome_FAQ_Wc_Client.
	jltwpafaq_license_client();

	// Signal that JLT_Awesome_FAQ_Wc_Client was initiated.
	do_action( 'jltwpafaq_license_client_loaded' );
}