<?php
namespace JLTWPAFAQ\Libs;

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Recommended global class
 */

if ( ! class_exists( 'Recommended' ) ) {

	/**
	 * Recommended Class
	 *
	 * Jewel Theme <support@jeweltheme.com>
	 */
	class Recommended {


		public $menu_items;
		public $plugins_list;
		public $sub_menu;
		public $menu_order;


		/**
		 * Constructor method
		 *
		 * @param integer $menu_order .
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function __construct( $menu_order = 99 ) {
			$this->menu_order   = $menu_order;
			$this->menu_items   = $this->menu_items();
			$this->plugins_list = $this->plugins_list();

			$this->includes();

			add_action( 'admin_menu', array( $this, 'admin_menu' ), $this->menu_order );
			add_action( 'wp_ajax_jltwpafaq_recommended_upgrade_plugin', array( $this, 'jltwpafaq_recommended_upgrade_plugin' ) );
			add_action( 'wp_ajax_jltwpafaq_recommended_activate_plugin', array( $this, 'jltwpafaq_recommended_activate_plugin' ) );
		}

		/**
		 * Includes
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function includes() {
			if ( ! function_exists( 'install_plugin_install_status' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
			}
		}

		/**
		 * Menu Items
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function menu_items() {
			return array();
		}

		/**
		 * Plugins list
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function plugins_list() {
			return array();
		}

		/**
		 * Admin submenu
		 */
		public function admin_menu() {
		}

		/**
		 * Render recommended plugins body
		 */
		public function render_recommended_plugins() { ?>
			<div class='jltwpafaq-recommended-wrapper'>
				<?php $this->header(); ?>
				<?php $this->body(); ?>
			</div>
			<?php
		}

		/**
		 * Header
		 */
		public function header() {
			?>
			<div class='jltwpafaq-recommended-header'>
				<div class='jltwpafaq-recommended-title'>
					<h2>
						<?php echo esc_html__( 'Recommended Plugins', 'wp-awesome-faq' ); ?>
					</h2>
				</div>
				<div class='jltwpafaq-recommended-menu'>
					<div class="wp-filter">
						<ul class="filter-links">
							<?php
								$i = 0;

							foreach ( $this->menu_items as $menu ) {
								$class = str_replace( ' ', '-', strtolower( $menu['key'] ) );
								?>
								<li class="plugin-install-<?php echo esc_attr( $class ); ?>">
									<a href="#" class="<?php echo esc_attr( 0 === $i ? 'current' : '' ); ?>" data-type="<?php echo esc_attr( $menu['key'] ); ?>"><?php echo esc_html( $menu['label'] ); ?></a>
								</li>
								<?php
								$i++;
							}
							?>
						</ul>

						<form class="search-form jltwpafaq-search-plugins mr-0" method="get">
							<input type="hidden" name="tab" value="search">
							<label class="screen-reader-text" for="search-plugins">
								<?php echo esc_html__( 'Search Plugins', 'wp-awesome-faq' ); ?>
							</label>
							<input type="search" name="s" id="search-plugins" value="" class="wp-filter-search" placeholder="<?php echo esc_html__( 'Search plugins...', 'wp-awesome-faq' ); ?>">
							<input type="submit" id="search-submit" class="button hide-if-js" value="<?php echo esc_html__( 'Search Plugins', 'wp-awesome-faq' ); ?>">
						</form>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * Body
		 */
		public function body() {
			?>
			<div class="wp-list-table widefat plugin-install">
				<div id="the-list">
					<?php
						$this->plugins();
					?>
				</div>
			</div>
			<?php
		}

		/**
		 * Body
		 */
		public function plugins() {
			foreach ( $this->plugins_list as $key => $plugin ) {
				$install_status = \install_plugin_install_status( $plugin );
				$classes        = implode( ' ', $plugin['type'] );

				$more_details = self_admin_url(
					'plugin-install.php?tab=plugin-information&amp;plugin=' . esc_attr( $plugin['slug'] ) .
						'&amp;TB_iframe=true&amp;width=600&amp;height=550'
				);
				?>
				<div class="plugin-card plugin-card-<?php echo esc_attr( $key ); ?> <?php echo esc_attr( $classes ); ?>">
					<div class="plugin-card-top">
						<div class="name column-name">
							<h3>
								<a href="<?php echo esc_url( $more_details ); ?>" class="thickbox open-plugin-details-modal">
									<?php echo esc_html( $plugin['name'] ); ?>
									<img src="<?php echo esc_url( $plugin['icon'] ); ?>" class="plugin-icon" alt="">
								</a>
							</h3>
						</div>
						<div class="desc column-description">
							<p><?php echo wp_kses_post( $plugin['short_description'] ); ?></p>
						</div>
					</div>
					<div class="plugin-card-bottom">
						<div class="column-downloaded">
							<span class="plugin-status">
								<?php
								echo esc_html__( 'Status:', 'wp-awesome-faq' );

								if ( 'install' === $install_status['status'] ) {
									?>
									<span class="plugin-status-not-install" data-plugin-url="<?php echo esc_attr( $plugin['download_link'] ); ?>"><?php echo esc_html__( 'No Installed', 'wp-awesome-faq' ); ?></span>
									<?php
								} elseif ( 'update_available' === $install_status['status'] ) {
									if ( is_plugin_active( $install_status['file'] ) ) {
										?>
										<span class="plugin-status-active">
											<?php echo esc_html__( 'Active', 'wp-awesome-faq' ); ?>
										</span>
										<?php
									} else {
										?>
										<span class="plugin-status-inactive" data-plugin-file="<?php echo esc_attr( esc_attr( $install_status['file'] ) ); ?>">
											<?php echo esc_html__( 'Inactive', 'wp-awesome-faq' ); ?>
										</span>
										<?php
									}
								} elseif ( ( 'latest_installed' === $install_status['status'] ) || ( 'newer_installed' === $install_status['status'] ) ) {
									if ( is_plugin_active( $install_status['file'] ) ) {
										?>
										<span class="plugin-status-active">
											<?php echo esc_html__( 'Active', 'wp-awesome-faq' ); ?>
										</span>
										<?php
									} elseif ( current_user_can( 'activate_plugin', $install_status['file'] ) ) {
										?>
										<span class="plugin-status-inactive" data-plugin-file="<?php echo esc_attr( $install_status['file'] ); ?>">
											<?php echo esc_html__( 'Inactive', 'wp-awesome-faq' ); ?>
										</span>
										<?php
									} else {
										?>
										<span class="plugin-status-inactive" data-plugin-file="<?php echo esc_attr( $install_status['file'] ); ?>">
											<?php echo esc_html__( 'Inactive', 'wp-awesome-faq' ); ?>
										</span>
										<?php
									}
								}
								?>
							</span>
						</div>
						<div class="column-compatibility">
							<ul class="plugin-action-buttons mr-0">
								<?php
								if ( 'install' === $install_status['status'] ) {
									?>
									<li class="mr-0">
										<button class="install-now button button-primary" data-install-url="<?php echo esc_attr( $plugin['download_link'] ); ?>">
											<?php echo esc_html__( 'Install Now', 'wp-awesome-faq' ); ?>
										</button>
									</li>
									<?php
								} elseif ( 'update_available' === $install_status['status'] ) {
									?>
									<li class="mr-0">
										<button class="update-now button" data-plugin="<?php echo esc_attr( $install_status['file'] ); ?>" data-slug="<?php echo esc_attr( $plugin['slug'] ); ?>" data-update-url="<?php echo esc_attr( $install_status['url'] ); ?>">
											<?php echo esc_html__( 'Update Now', 'wp-awesome-faq' ); ?>
										</button>
									</li>
									<?php
								} elseif ( ( 'latest_installed' === $install_status['status'] ) || ( 'newer_installed' === $install_status['status'] ) ) {
									if ( is_plugin_active( $install_status['file'] ) ) {
										?>
										<li class="mr-0">
											<button type="button" class="button button-disabled" disabled="disabled">
												<?php echo esc_html__( 'Activated', 'wp-awesome-faq' ); ?>
											</button>
										</li>
										<?php
									} elseif ( current_user_can( 'activate_plugin', $install_status['file'] ) ) {
										?>
										<button class="button activate-now" data-plugin-file="<?php echo esc_attr( $install_status['file'] ); ?>">
											<?php echo esc_html__( 'Activate', 'wp-awesome-faq' ); ?>
										</button>
										<?php
									} else {
										?>
										<li class="mr-0">
											<button type="button" class="button button-disabled" disabled="disabled">
												<?php echo esc_html__( 'Installed', 'wp-awesome-faq' ); ?>
											</button>
										</li>
										<?php
									}
								}
								?>
							</ul>
						</div>
					</div>
				</div>
				<?php
			}
		}

		/**
		 * Activate Plugins
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltwpafaq_recommended_activate_plugin() {
			try {
				if ( isset( $_POST['file'] ) ) {
					$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

					if ( ! wp_verify_nonce( $nonce, 'jltwpafaq_recommended_nonce' ) ) {
						wp_send_json_error( array( 'mess' => __( 'Nonce is invalid', 'wp-awesome-faq' ) ) );
					}
					$file   = sanitize_text_field( wp_unslash( $_POST['file'] ) );
					$result = activate_plugin( $file );

					if ( is_wp_error( $result ) ) {
						wp_send_json_error(
							array(
								'mess' => $result->get_error_message(),
							)
						);
					}
					wp_send_json_success(
						array(
							'mess' => __( 'Activate success', 'wp-awesome-faq' ),
						)
					);
				}
			} catch ( \Exception $ex ) {
				wp_send_json_error(
					array(
						'mess' => __( 'Error exception.', 'wp-awesome-faq' ),
						array(
							'error' => $ex,
						),
					)
				);
			} catch ( \Error $ex ) {
				wp_send_json_error(
					array(
						'mess' => __( 'Error.', 'wp-awesome-faq' ),
						array(
							'error' => $ex,
						),
					)
				);
			}
		}

		/**
		 * Upgrade Plugins required Libraries
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltwpafaq_recommended_upgrade_plugin() {
			try {
				require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
				require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
				require_once ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php';
				require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';

				if ( isset( $_POST['plugin'] ) ) {
					$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';

					if ( ! wp_verify_nonce( $nonce, 'jltwpafaq_recommended_nonce' ) ) {
						wp_send_json_error( array( 'mess' => __( 'Nonce is invalid', 'wp-awesome-faq' ) ) );
					}
					$plugin   = sanitize_text_field( wp_unslash( $_POST['plugin'] ) );
					$type     = isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : 'install';
					$skin     = new \WP_Ajax_Upgrader_Skin();
					$upgrader = new \Plugin_Upgrader( $skin );

					if ( 'install' === $type ) {
						$result = $upgrader->install( $plugin );

						if ( is_wp_error( $result ) ) {
							wp_send_json_error(
								array(
									'mess' => $result->get_error_message(),
								)
							);
						}
						$args        = array(
							'slug'   => $upgrader->result['destination_name'],
							'fields' => array(
								'short_description' => true,
								'icons'             => true,
								'banners'           => false,
								'added'             => false,
								'reviews'           => false,
								'sections'          => false,
								'requires'          => false,
								'rating'            => false,
								'ratings'           => false,
								'downloaded'        => false,
								'last_updated'      => false,
								'added'             => false,
								'tags'              => false,
								'compatibility'     => false,
								'homepage'          => false,
								'donate_link'       => false,
							),
						);
						$plugin_data = plugins_api( 'plugin_information', $args );

						if ( $plugin_data && ! is_wp_error( $plugin_data ) ) {
							$install_status = \install_plugin_install_status( $plugin_data );
							$active_plugin  = activate_plugin( $install_status['file'] );

							if ( is_wp_error( $active_plugin ) ) {
								wp_send_json_error(
									array(
										'mess' => $active_plugin->get_error_message(),
									)
								);
							} else {
								wp_send_json_success(
									array(
										'mess' => __( 'Install success', 'wp-awesome-faq' ),
									)
								);
							}
						} else {
							wp_send_json_error(
								array(
									'mess' => 'Error',
								)
							);
						}
					} else {
						$is_active = is_plugin_active( $plugin );
						$result    = $upgrader->upgrade( $plugin );

						if ( is_wp_error( $result ) ) {
							wp_send_json_error(
								array(
									'mess' => $result->get_error_message(),
								)
							);
						} else {
							activate_plugin( $plugin );
							wp_send_json_success(
								array(
									'mess'   => __( 'Update success', 'wp-awesome-faq' ),
									'active' => $is_active,
								)
							);
						}
					}
				}
			} catch ( \Exception $ex ) {
				wp_send_json_error(
					array(
						'mess' => __( 'Error exception.', 'wp-awesome-faq' ),
						array(
							'error' => $ex,
						),
					)
				);
			} catch ( \Error $ex ) {
				wp_send_json_error(
					array(
						'mess' => __( 'Error.', 'wp-awesome-faq' ),
						array(
							'error' => $ex,
						),
					)
				);
			}
		}
	}
}