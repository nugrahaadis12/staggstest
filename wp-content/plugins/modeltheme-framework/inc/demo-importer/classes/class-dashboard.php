<?php if ( ! defined( 'ABSPATH' ) ) {exit;} // Exit if accessed directly.

/**
 * Theme dashboard, activtion, importer, plugins, system status, etc.
 * 
 * @since  4.3.0
 */

if ( ! class_exists( 'Modeltheme_Framework_Dashboard' ) ) {

	class Modeltheme_Framework_Dashboard extends Modeltheme_Sites {
		private static $instance = null;
		public function __construct() {
			add_action( 'init', [ $this, 'init' ] );
		}

		public $theme;
		public $slug;
		public $menus;
		public $plugins;
		public $demos;

		public function init() {

			// Check white label for menu.
			if ( ! isset( $this->disable[ 'menu' ] )) {

				// Theme info.
				$this->theme = wp_get_theme();

				//Set Theme Name
				$theme = strtolower(modeltheme_get_theme('Name'));
				$this->theme->version = empty( $this->theme->parent() ) ? $this->theme->get( 'Version' ) : $this->theme->parent()->Version;
				// IDs.
				$this->slug 	= 'theme-activation';
				// Admin menus.
				$this->menus 	= [
					'importer' 		=> esc_html__( 'Demo Importer', 'modeltheme' ),

				];

				// Theme plugins.
				$this->plugins 	= apply_filters( 'mt_config_list', [
					'elementor' 	=> [
						'name' 				=> esc_html__( 'Elementor Page Builder', 'modeltheme' ),
						'recommended' 		=> true,
						'function_exists' 	=> 'elementor_load_plugin_textdomain'
					],
					'woocommerce' 	=> [
						'name' 				=> esc_html__( 'Woocommerce', 'modeltheme' ),
						'recommended' 		=> true,
						'class_exists' 		=> 'WooCommerce'
					],
					'contact-form-7' => [
						'name' 				=> esc_html__( 'Contact Form 7', 'modeltheme' ),
						'recommended' 		=> true,
						'class_exists' 		=> 'WPCF7'
					],
				] );

				// List of demos.
				$request = wp_remote_get(MODELTHEME_DEMO_DATA_FOLDER.$theme.'1.json');
            	$json = json_decode(wp_remote_retrieve_body($request), true);

				$this->demos = apply_filters( 'mt_config_demos', $json['posts']);

				// Actions.
				add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ] );
				add_action( 'modeltheme_demos', [ $this, 'importer' ] );
				add_action( 'wp_ajax_mt_wizard', [ $this, 'wizard' ] );
			}
		}

		public static function instance() {
			if ( self::$instance === null ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Load admin dashboard assets
		 * 
		 * @return -
		 */
		public function enqueue( $hook ) {

			// Assets.
			wp_enqueue_style( 'mt-dashboard', PLUGIN_URL . '/assets/css/dashboard.css', [], $this->theme->version, 'all' );
			wp_enqueue_script( 'mt-dashboard', PLUGIN_URL . '/assets/js/dashboard.js', [], $this->theme->version, true );

			$plugins = [];
			// List of inactive plugins.
			foreach( $this->plugins as $slug => $plugin ) {
				if ( ! $this->plugin_is_active( $slug ) ) {
					$plugins[ $slug ] = true;
				}
			}

			// Translations for scripts.
			wp_localize_script( 'mt-dashboard', 'mtWizard', [
				'plugins' 			=> $plugins,
				'of' 				=> esc_html__( 'of', 'modeltheme' ),
				'close' 			=> esc_html__( 'Close', 'modeltheme' ),
				'plugin_before' 	=> esc_html__( 'Installing', 'modeltheme' ),
				'plugin_after' 		=> esc_html__( 'Activated', 'modeltheme' ),
				'import_before' 	=> esc_html__( 'Importing', 'modeltheme' ),
				'import_after' 		=> esc_html__( 'Imported', 'modeltheme' ),
				'js_composer' 		=> esc_html__( 'WPBakery Page Builder', 'modeltheme' ),
				'elementor' 		=> esc_html__( 'Elementor Page Builder', 'modeltheme' ),
				'modeltheme_addons_for_wpbakery' => esc_html__( 'Modeltheme Addons for WPBakery', 'modeltheme' ),
				'cf7' 				=> esc_html__( 'Contact Form 7', 'modeltheme' ),
				'woocommerce' 		=> esc_html__( 'Woocommerce', 'modeltheme' ),
				'downloading' 		=> esc_html__( 'Downloading', 'modeltheme' ),
				'demo_files' 		=> esc_html__( 'Demo Files', 'modeltheme' ),
				'downloaded' 		=> esc_html__( 'Downloaded', 'modeltheme' ),
				'options' 			=> esc_html__( 'Theme Options', 'modeltheme' ),
				'widgets' 			=> esc_html__( 'Widgets', 'modeltheme' ),
				'posts' 			=> esc_html__( 'Pages & Posts', 'modeltheme' ),
				'images' 			=> esc_html__( 'Images', 'modeltheme' ),
				'error_500' 		=> esc_html__( 'PHP error 500, Internal server error, Please check your server error log file or contact with support.', 'modeltheme' ),
				'error_503' 		=> esc_html__( 'PHP error 503, Internal server error, Please try again with same import demo.', 'modeltheme' ),
				'ajax_error' 		=> esc_html__( 'An error has occured, Please deactivate all plugins except theme plugins and try again, If still have same issue, Please submit ticket to theme author.', 'modeltheme' ),
				'features' 			=> esc_html__( 'Choose at least one feature to import.', 'modeltheme' ),
				'page_importer_empty' => esc_html__( 'URL input is empty, Please fill the input then submit.', 'modeltheme' )
			]);
		}

		/**
		 * Demo importer tab content.
		 * 
		 * @return string.
		 */
		public function importer($active = null) {
		
		echo '<div class="wrap mt-dashboard-' . esc_attr( $active ) . '">';
		echo '<div class="mt-demo-dashboard">';
			echo '<div class="mt-dashboard-main">';
				echo '<div class="mt-demo-wrapper">';
					echo '<div class="mt-demos lazyload clearfix">';
                        if (modelthemeav3_is_license_activated()) {
							if ($this->demos) {
								foreach( $this->demos as $demo => $args ) {

									//Set Theme Name
									$theme = MODELTEMA_THEME_NAME;

									$args[ 'demo' ] = $demo;
									$args[ 'image' ] = MODELTHEME_DEMO_DATA_FOLDER.esc_attr( $demo ) . '/screen-image.jpg';

									if($demo == 'main-home') {
										$args[ 'preview' ] = 'https://'.$theme.'.modeltheme.com/';
									}else{
										$args[ 'preview' ] = 'https://'.$theme.'.modeltheme.com/' . esc_attr( $demo );
									}

									echo '<div class="mt-demo">';
										// Preview image.
										echo '<img data-src="' . esc_attr( $args[ 'image' ] ) . '" />';

										// Demo title.
										echo '<div class="mt-demo-title">' . esc_html( ucwords( str_replace( '-', ' ', isset( $args[ 'title' ] ) ? $args[ 'title' ] : $args[ 'demo' ] ) ) ) . '</div>';

										// Buttons.
										echo '<div class="mt-demo-buttons">';
											echo '<a href="#" class="demo-button-primary" data-args=\'' . esc_html( json_encode( $args ) ) . '\'>' . esc_html__( 'Import', 'modeltheme' ). '</a>';
												$args[ 'preview' ] = str_replace( $demo, '' . $demo, $args[ 'preview' ] );					
												echo '<a href="' . esc_url( $args[ 'preview' ] ) . '" class="demo-demo-button-secondary" target="_blank">' . esc_html__( 'Live Demo', 'modeltheme' ) . '</a>';
										echo '</div>';
									echo '</div>';
								}
							}else{
								echo '<h3>Unable to retrieve demos. Please contact support for assistance. (Make sure that ModelTheme.com is not blocked/blacklisted by your hosting or security plugin.)</h3>';
							}
                        }else{
                            echo "<h3>Your license has not been activated yet. Please navigate to the <a href=".admin_url('admin.php?page=modeltheme-license').">Theme License Manager</a> tab to activate your license key.</h3>";
                        }
					echo '</div>';
				echo '</div>';

				// Wizard.
				echo '<div class="mt-wizard hidden" data-nonce="' . esc_attr( wp_create_nonce( 'mt-wizard' ) ) . '">';
					echo '<i class="mt-back-button dashicons dashicons-arrow-left-alt"><span>'.esc_html__('Back to demos','modeltheme').'</span></i>';
					echo '<div class="mt-wizard-main">';
						echo '<div class="wizard-preview">';

							// Demo image.
							echo '<img class="mt-demo-image" src="#" alt="Demo preview" />';

							// Progress bar.
							echo '<img class="importer-spinner" src="' . PLUGIN_URL . '/assets/img/importing.png" />';
							echo '<div class="wizard-progress"><div data-current="0"><span></span></div></div>';

						echo '</div>';

						echo '<div class="mt-wizard-content">';

							// Step 1.
							echo '<div data-step="1" class="current">';
								echo '<div class="selected-demo"><span>'.esc_html__('Selected demo:','modeltheme').'</span><strong>...</strong></div>';
								echo '<div class="selected-demo"><span>'.esc_html__('Live preview:','modeltheme').'</span><br /><br />';
									echo '<a href="#" class="live-preview live-preview-elementor demo-button-primary" target="_blank">' . esc_html__('Check Live Demo','modeltheme').'</a>';
								echo '</div>';
							echo '</div>';

							// Step 2.
							echo '<div data-step="2">';
								echo '<div class="mt-step-title">'.esc_html__('Choose page builder:','modeltheme'). '</div>';

								echo '<div class="builders-image-radios">';
									echo '<label class="builders-image-radio"><input type="radio" name="pagebuilder" value="elementor" checked /><span><img src="'.PLUGIN_URL.'/assets/img/elementor.jpg"><b>'.esc_html__('Elementor','modeltheme'). '</b></span></label>';
								echo '</div>';
							echo '</div>';

							// Step 3.
							echo '<div data-step="3">';

								echo '<label class="mt-radio"><input type="radio" name="config" value="full" checked /><b>' . esc_html__('Full Import','modeltheme'). '</b><span class="checkmark" aria-hidden="true"></span></label>';
								echo '<label class="mt-radio"><input type="radio" name="config" value="custom" /><b>' . esc_html__('Custom Import','modeltheme'). '</b><span class="checkmark" aria-hidden="true"></span></label>';

								echo '<div class="mt-checkboxes clearfix" disabled>';
									echo '<label class="mt-checkbox">' . esc_html__('Theme Options','modeltheme'). '<input type="checkbox" name="options" checked /><span class="checkmark" aria-hidden="true"></span></label>';
									echo '<label class="mt-checkbox">' . esc_html__('Widgets','modeltheme'). '<input type="checkbox" name="widgets" checked /><span class="checkmark" aria-hidden="true"></span></label>';
									echo '<label class="mt-checkbox">' . esc_html__('Pages & Posts','modeltheme'). '<input type="checkbox" name="content" checked /><span class="checkmark" aria-hidden="true"></span></label>';
									echo '<label class="mt-checkbox">' . esc_html__('Images','modeltheme'). '<input type="checkbox" name="images" checked /><span class="checkmark" aria-hidden="true"></span></label>';
									echo '<label class="mt-checkbox">' . esc_html__('WooCommerce','modeltheme'). '<input type="checkbox" name="woocommerce" checked /><span class="checkmark" aria-hidden="true"></span></label>';
									echo '<label class="mt-checkbox">' . esc_html__('Revolution Slider','modeltheme'). '<input type="checkbox" name="slider" checked /><span class="checkmark" aria-hidden="true"></span></label>';
								echo '</div>';

							echo '</div>';

							// Step 4.
							echo '<div data-step="4"><ul class="mt-list"></ul></div>';

							// Step 5.
							echo '<div data-step="5">';

								// Success.
								echo '<div class="importer-done demo-success">';

									echo '<span>' . esc_html__('All Done !','modeltheme'). '</span>';
									echo '<p>' . esc_html__('The demo has been imported successfully.','modeltheme'). '</p>';

									echo '<a href="' . esc_url( get_home_url() ) . '" class="demo-button-primary" target="_blank">' . esc_html__( 'View your website', 'modeltheme' ) . '</a>';
									echo '<a href="' . esc_url( get_admin_url() ) . 'customize.php" class="demo-button-secondary" target="_blank">' . esc_html__( 'Go to Customizer', 'modeltheme' ) . '</a>';

								echo '</div>';

								// Error.
								echo '<div class="importer-done demo-error hidden">';
									echo '<span>' . esc_html__( 'Error!', 'modeltheme' ) . '</span>';
									echo '<p>' . esc_html__( 'An error has occured, Please try again.', 'modeltheme' ) . '</p>';
									echo '<a href="#" class="demo-button-secondary back-to-demos">'.esc_html__('Back to Demos','modeltheme').'</a>';
								echo '</div>';

							echo '</div>'; // step 5.

						echo '</div>';

					echo '</div>';

					// Wizard footer.
					echo '<div class="wizard-footer">';
						echo '<a href="#" class="demo-button-primary wizard-prev">' .esc_html__( 'Prev Step', 'modeltheme' ). '</a>';
						echo '<ul class="wizard-steps clearfix">';
							echo '<li data-step="1" class="current"><span>' . esc_html__( 'Getting Started', 'modeltheme' ) . '</span></li>';
							echo '<li data-step="2"><span>' . esc_html__( 'Choose Builder', 'modeltheme' ) . '</span></li>';
							echo '<li data-step="3"><span>' . esc_html__( 'Configuration', 'modeltheme' ) . '</span></li>';
							echo '<li data-step="4"><span>' . esc_html__( 'Please wait, Importing', 'modeltheme' ) . '</span></li>';
						echo '</ul>';

						echo '<a href="#" class="demo-button-primary wizard-next">' . esc_html__( 'Next Step', 'modeltheme' ) . '</a>';

					echo '</div>';
				echo '</div>';
			echo '</div>';

			echo '</div>';

			echo '</div>'; // Wrap.

		}

		/**
		 * Plugin installation and importer AJAX function.
		 * @return string
		 */
		public function wizard() {
			check_ajax_referer( 'mt-wizard', 'nonce' );
			if ( ! empty( $_POST ) ) {

				$_POST = wp_unslash( $_POST );

			}

			// Import posts meta.
			if ( ! empty( $_POST[ 'meta' ] ) ) {

				wp_send_json(
					Modeltheme_Demo_Importer::import_process(
						[ 'meta' => 1 ]
					)
				);

			}

			// Check name.
			if ( empty( $_POST[ 'name' ] ) ) {

				wp_send_json(
					[
						'status' 	=> '202',
						'message' 	=> esc_html__( 'AJAX requested name is empty, Please try again.', 'modeltheme' )
					]
				);

			}

			// Fix redirects after plugin installation.
			if ( $_POST[ 'name' ] === 'redirect' ) {

				wp_send_json(
					[
						'status' 	=> '200',
						'message' 	=> esc_html__( 'Redirected successfully.', 'modeltheme' )
					]
				);

			}

			// Vars.
			$data = [];
			$name = isset( $_POST[ 'name' ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'name' ] ) ) : '';
			$type = isset( $_POST[ 'type' ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'type' ] ) ) : '';
			$demo = isset( $_POST[ 'demo' ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'demo' ] ) ) : '';

			// Install & activate plugin.
			if ( $type === 'plugin' ) {

				$data = $this->install_plugin( $name );

				if ( is_string( $data ) ) {

					$data = [

						'status' 	=> '202',
						'message' 	=> esc_html__( 'Could not find plugin "%s" API, Please refresh page and try again.', 'modeltheme' )

					];

				}

			// Download demo files.
			} else if ( $type === 'download' ) {
				$folder = isset( $_POST[ 'folder' ] ) ? sanitize_text_field( wp_unslash( $_POST[ 'folder' ] ) ) : '';

				$data = Modeltheme_Demo_Importer::download( $demo, $folder );

			// Import demo data.
			} else if ( $type === 'import' ) {

				$data = Modeltheme_Demo_Importer::import_process(
					[
						'demo' 			=> $demo,
						'features' 		=> [ $name ],
						'posts' 		=> empty( $_POST[ 'posts' ] ) ? 1 : sanitize_text_field( wp_unslash( $_POST[ 'posts' ] ) )
					]
				);

			} else {

				$data = [
					'status' 	=> '202',
					'message' 	=> esc_html__( 'An error has occured, Please try again.', 'modeltheme' )
				];

			}

			wp_send_json( $data );

		}

		/**
		 * Plugin installation and activation process.
		 * 
		 * @return array
		 */
		protected function install_plugin( $plugin = '' ) {

			// Plugin slug.
			$slug = esc_html( urldecode( $plugin ) );

			// Check plugin inside plugins.
			if ( ! isset( $this->plugins[ $slug ] ) ) {

				return [

					'status' 	=> '202',
					'message' 	=> esc_html__( 'Plugin  is no listed as a valid plugin.', 'modeltheme' )

				];

			}

			// Pass necessary information via URL if WP_Filesystem is needed.
			$url = wp_nonce_url(
				add_query_arg(
					array(
						'plugin' 	=> urlencode( $slug )
					),
					admin_url( 'admin-ajax.php' )
				),
				'mt-wizard',
				'nonce'
			);

			if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), '', false, false, [] ) ) ) {

				return [

					'status' 	=> '202',
					'message' 	=> esc_html__( 'WordPress required FTP login details', 'modeltheme' )

				];

			}

			// Prep variables for Plugin_Installer_Skin class.
			if ( isset( $this->plugins[ $slug ][ 'source' ] ) ) {
				$api = null;
				$source = $this->plugins[ $slug ][ 'source' ];
			} else {
				$api = $this->plugins_api( $slug );
				if ( is_string( $api ) ) {
					return [

						'status' 	=> '202',
						'message' 	=> wp_kses_post( esc_html__( 'WordPress API Error:', 'modeltheme' ) . ' ' . $api )

					];
				}
				$source = isset( $api->download_link ) ? $api->download_link : '';
			}

			// Check ZIP file.
			if ( ! $source ) {

				return [

					'status' 	=> '202',
					'message' 	=> esc_html__( 'Could not download "%s" plugin ZIP file, Please go to Appearance > Install Plugins and install it manually, and try again demo importer.', 'modeltheme' )

				];

			}

			$url = add_query_arg(
				array(
					'plugin' => urlencode( $slug )
				),
				'update.php'
			);

			if ( ! class_exists( 'Plugin_Upgrader', false ) ) {
				require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			}

			$skin_args = array(
				'type'   => 'web',
				'title'  => $this->plugins[ $slug ]['name'],
				'url'    => esc_url_raw( $url ),
				'nonce'  => 'mt-wizard',
				'plugin' => '',
				'api'    => $source ? null : $api,
				'extra'  => [ 'slug' => $slug ]
			);

			$skin = new Plugin_Installer_Skin( $skin_args );

			// Create a new instance of Plugin_Upgrader.
			$upgrader = new Plugin_Upgrader( $skin );

			// File path.
			$file = $this->plugin_file( $slug, true );

			// FIX: Check if file is not exist but folder exist. 
			$folder = dirname( $file );

			if ( ! file_exists( $file ) && is_dir( $folder ) ) {

				rename( $folder, $folder . '_backup_' . rand( 111, 999 ) );

			}

			// Install plugin.
			if ( ! file_exists( $file ) ) {

				$upgrader->install( $source );

			}

			// Install plugin manually.
			if ( ! file_exists( $file ) ) {

				$plugin_dir = dirname( $file );

				// Final check if plugin installed?
				if ( ! file_exists( $file ) || is_dir( $plugin_dir ) ) {

					return [

						'status' 	=> '202',
						'message' 	=> esc_html__( 'Error, Through FTP delete plugins > "%s" folder & increase PHP max_execution_time to 300 then try again.', 'modeltheme' )

					];

				}

			}

			if ( ! $this->plugin_is_active( $slug ) ) {

				// Activate plugin.
				$activate = activate_plugin( $this->plugin_file( $slug ) );

				// Check activation error.
				if ( is_wp_error( $activate ) ) {

					return [

						'status' 	=> '202',
						'message' 	=> esc_html__( 'Plugin activation error, ', 'modeltheme' ) . $activate->get_error_message()

					];

				}

			}

			return [

				'status' 	=> '200',
				'message' 	=> esc_html__( 'Plugin  installed and activated successfully.', 'modeltheme' )
			];

		}

		/**
		 * Try to grab information from WordPress API.
		 *
		 * @param string $slug Plugin slug.
		 * @return object Plugins_api response object on success, WP_Error on failure.
		 */
		protected function plugins_api( $slug ) {

			static $api = [];
			if ( ! isset( $api[ $slug ] ) ) {
				if ( ! function_exists( 'plugins_api' ) ) {

					require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

				}
				$response = plugins_api( 'plugin_information', array( 'slug' => $slug, 'fields' => array( 'sections' => false ) ) );

				$api[ $slug ] = false;

				if ( is_wp_error( $response ) ) {
					return esc_html__( 'Plugin API error:', 'modeltheme' ) . ' ' . $response->get_error_message();
				} else {
					$api[ $slug ] = $response;
				}

			}
			return $api[ $slug ];

		}

		/**
		 * Check if plugin is active with file_exists function.
		 *
		 * @param string $slug Plugin slug.
		 * @return bool
		 */
		private function plugin_file( $slug, $full_path = false ) {
			if ( $slug === 'contact-form-7' ) {
				$file = 'wp-contact-form-7';
			} else {
				$file = $slug;
			}
			return $full_path ? WP_PLUGIN_DIR . '/' . $slug . '/' . $file . '.php' : $slug . '/' . $file . '.php';

		}

		/**
		 * Check if plugin is active with file_exists function.
		 *
		 * @param string $slug Plugin slug.
		 * @return bool
		 */
		function plugin_is_active( $slug ) {
			if ( isset( $this->plugins[ $slug ][ 'class_exists' ] ) && class_exists( $this->plugins[ $slug ][ 'class_exists' ] ) ) {
				return true;
			} else if ( isset( $this->plugins[ $slug ][ 'function_exists' ] ) && function_exists( $this->plugins[ $slug ][ 'function_exists' ] ) ) {
				return true;
			}
			return false;
		}
	}

	// Run dashboard.
	Modeltheme_Framework_Dashboard::instance();

}
