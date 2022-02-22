<?php
/**
 * Plugin install helper.
 *
 */

class Voluto_Install_Plugins {
	/**
	 * Instance of class.
	 *
	 * @var bool $instance instance variable.
	 */
	private static $instance;

	/**
	 * Check if instance already exists.
	 *
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Main ) ) {
			self::$instance = new Voluto_Install_Plugins();
		}

		return self::$instance;
	}

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}	

	public function do_plugin_install(){

		$plugins_base_name = array(
			'izo-companion/izo-companion.php',
			'advanced-import/advanced-import.php'
		);
		$plugins_slug      = array(
			'izo-companion',
			'advanced-import'
		);
		$plugins_filename  = array(
			'izo-companion.php',
			'advanced-import.php'
		);
		$plugins_title     = array(
			esc_html__( 'Voluto Companion', 'voluto' ),
			esc_html__('Starter Sites', 'voluto')
		);
		// Classess to check if plugins are active or not
		$class_check = array(
			'Izo_Companion',
			'Advanced_Import'
		);
	
		if ( !function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
		}	
		$installed_plugins  = get_plugins();
	
		// find required plugins which is not installed or active
		$not_installed_or_activated_plugins_id = array();
		foreach ( $plugins_base_name as $key => $plugin_base_name ) {
			if( ! isset( $installed_plugins[ $plugin_base_name ] ) || ! class_exists( $class_check[$key] ) ){
				$not_installed_or_activated_plugins_id[] = $key;
			}
		}
	
		// get information of required plugins which is not installed or not activated
		foreach ( $not_installed_or_activated_plugins_id as $key => $value ) {
	
			$not_installed_plugins_number = count( $not_installed_or_activated_plugins_id );
			$progress_text = $not_installed_plugins_number > 1 ? ( $key + 1 ). " / {$not_installed_plugins_number}" : "";
			$progress_text_and_title = $progress_text . ': ' . $plugins_title[ $value ];
	
			$links_attrs[$key] = array(
				'data-plugin-slug'      => $plugins_slug[$value],
	
				'data-activating-label' => /* translators: %s: plugin name */ sprintf( __( 'Activating %s', 'voluto' ), $progress_text_and_title ),
				'data-installing-label' => /* translators: %s: plugin name */ sprintf( __( 'Installing %s', 'voluto' ), $progress_text_and_title ),
				'data-activate-label'   => /* translators: %s: plugin name */ sprintf( __( 'Activate %s'  , 'voluto' ), $progress_text_and_title ),
				'data-install-label'    => /* translators: %s: plugin name */ sprintf( __( 'Install %s'   , 'voluto' ), $progress_text_and_title ),
	
				'data-activate-url'     => $this->get_plugin_activation_link( $plugins_base_name[$value], $plugins_slug[$value], $plugins_filename[$value] ),
				'data-install-url'      => $this->get_plugin_install_link( $plugins_slug[$value] ),
	
				'data-redirect-url'     => self_admin_url( 'themes.php?page=advanced-import.php' ),
				'data-num-of-required-plugins' => $not_installed_plugins_number,
				'data-plugin-order'     => $key + 1,
				'data-wpnonce'          => wp_create_nonce( 'voluto-pi_setup_nonce' )
			);
	
			if( ! isset( $installed_plugins[ $plugins_base_name[$value] ] ) ){
				$links_attrs[$key]['data-action'] = 'install';
				$links_attrs[$key]['href'] = $links_attrs[ $key ]['data-install-url'];
				$links_attrs[$key]['button_label'] =  /* translators: %s: plugin name */ sprintf( esc_html__( 'Install %s', 'voluto' ), $progress_text_and_title );
			} elseif( ! class_exists( $class_check[ $value ] ) ) {
				$links_attrs[$key]['data-action'] = 'activate';
				$links_attrs[$key]['href'] = $links_attrs[ $key ]['data-activate-url'];
				$links_attrs[$key]['button_label'] =  /* translators: %s: plugin name */ sprintf( esc_html__( 'Activate %s', 'voluto' ), $progress_text_and_title );
			}
		}

	?>
		<?php if ( empty( $not_installed_or_activated_plugins_id ) ) : ?>
		<div class="voluto-message voluto-pi-notice-wrapper voluto-pi-notice-install-now" style="display:inline-block;">
			<a class="button" href="<?php echo esc_url( admin_url( 'themes.php?page=advanced-import.php' ) ); ?>"><?php echo esc_html__( 'Import a demo', 'voluto' ); ?></a>
		</div>		
		<?php else : ?>
		<div class="voluto-message voluto-pi-notice-wrapper voluto-pi-notice-install-now" style="display:inline-block;">
			<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<a class="button button-primary voluto-install-now voluto-pi-not-installed" data-info='<?php echo wp_json_encode( $links_attrs);?>' ><?php echo $links_attrs[0]['button_label']; ?></a>
		</div>
		<?php endif; ?>
	<?php
	}

	public function get_plugin_activation_link( $plugin_base_name, $slug, $plugin_filename ) {
		$activate_nonce = wp_create_nonce( 'activate-plugin_' . $slug .'/'. $plugin_filename );
		return self_admin_url( 'plugins.php?_wpnonce=' . $activate_nonce . '&action=activate&plugin='. str_replace( '/', '%2F', $plugin_base_name ) );
	}

	function get_plugin_install_link( $plugin_slug ) {

		// sanitize the plugin slug
		$plugin_slug = esc_attr( $plugin_slug );
	
		$install_link  = wp_nonce_url(
			add_query_arg(
				array(
					'action' => 'install-plugin',
					'plugin' => $plugin_slug,
				),
				network_admin_url( 'update.php' )
			),
			'install-plugin_' . $plugin_slug
		);
	
		return $install_link;
	}
		 
	/**
	 * Enqueue Function.
	 */
	public function enqueue_scripts() {

		global $pagenow;
		
		wp_register_script( 'voluto-plugin-install', get_template_directory_uri() . '/inc/onboarding/plugin-install.js', array( 'jquery' ), '', true );

		wp_localize_script(
			'voluto-plugin-install',
			'volutoPluginInstall',
			array(
				'activating' => esc_html__( 'Activating ', 'voluto' ),
			)
		);

		if ( 'theme-install.php' !== $pagenow ) {
			wp_enqueue_script( 'plugin-install' );
			wp_enqueue_script( 'updates' );
		}

		wp_enqueue_script( 'voluto-plugin-install' );

	}
}

$voluto_plugin_install = new Voluto_Install_Plugins();