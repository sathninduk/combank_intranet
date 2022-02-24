<?php
/**
 * Single page and post metabox
 *
 * @package Voluto
 */


function voluto_page_metabox_init() {
    new Voluto_Page_Metabox();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'voluto_page_metabox_init' );
    add_action( 'load-post-new.php', 'voluto_page_metabox_init' );
}

class Voluto_Page_Metabox {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );

		
	}

	public function add_meta_box( $post_type ) {
        $post_types = array( 'post', 'page' );
        if ( in_array( $post_type, $post_types )) {
			add_meta_box(
				'voluto_single_page_metabox'
				,__( 'Voluto page options', 'voluto' )
				,array( $this, 'render_meta_box_content' )
				,array( 'post', 'page' )
				,'side'
				,'low'
			);
        }
	}

	public function save( $post_id ) {
	
		// Check if our nonce is set.
		if ( ! isset( $_POST['voluto_single_page_box_nonce'] ) )
			return $post_id;

		$nonce = sanitize_key( $_POST['voluto_single_page_box_nonce'] );

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'voluto_single_page_box' ) )
			return $post_id;


		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		}

		//Hide title
		$activate_title_hide = ( isset( $_POST['voluto_hide_title'] ) && '1' === $_POST['voluto_hide_title'] ) ? 1 : 0;
		update_post_meta( $post_id, '_voluto_hide_title', $activate_title_hide );	

		//Hide featured image
		$activate_featured_hide = ( isset( $_POST['voluto_hide_featured_image'] ) && '1' === $_POST['voluto_hide_featured_image'] ) ? 1 : 0;
		update_post_meta( $post_id, '_voluto_hide_featured_image', $activate_featured_hide );			

		//disable Header
		$activate_header_hide = ( isset( $_POST['voluto_hide_header'] ) && '1' === $_POST['voluto_hide_header'] ) ? 1 : 0;
		update_post_meta( $post_id, '_voluto_hide_header', $activate_header_hide );

		//disable Footer
		$activate_footer_hide = ( isset( $_POST['voluto_hide_footer'] ) && '1' === $_POST['voluto_hide_footer'] ) ? 1 : 0;
		update_post_meta( $post_id, '_voluto_hide_footer', $activate_footer_hide );		

		//Layout
		$layout_choices = array( 'regular', 'no-sidebar', 'stretched' );
		$post_layout = $this->sanitize_selects( sanitize_key( $_POST['voluto_page_layout'] ), $layout_choices ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated
		update_post_meta( $post_id, '_voluto_page_layout', $post_layout );
	}

	public function render_meta_box_content( $post ) {
	
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'voluto_single_page_box', 'voluto_single_page_box_nonce' );
		$header_hide 			= get_post_meta( $post->ID, '_voluto_hide_header', true );
		$footer_hide 			= get_post_meta( $post->ID, '_voluto_hide_footer', true );
		$title_hide 			= get_post_meta( $post->ID, '_voluto_hide_title', true );
		$featured_hide 			= get_post_meta( $post->ID, '_voluto_hide_featured_image', true );
		$post_layout 			= get_post_meta( $post->ID, '_voluto_page_layout', true );
	?>
	<p>
	<label for="voluto_page_layout"><?php esc_html_e( 'Page layout', 'voluto' ); ?></label>	
	<select style="max-width:200px;" name="voluto_page_layout">
		<option value="regular" <?php selected( $post_layout, 'regular' ); ?>><?php esc_html_e( 'Regular', 'voluto' ); ?></option>
		<option value="no-sidebar" <?php selected( $post_layout, 'no-sidebar' ); ?>><?php esc_html_e( 'No sidebar', 'voluto' ); ?></option>
		<option value="stretched" <?php selected( $post_layout, 'stretched' ); ?>><?php esc_html_e( 'Stretched (for page builders)', 'voluto' ); ?></option>
	</select>
	</p>
	<p>
		<label><input type="checkbox" name="voluto_hide_title" value="1" <?php checked( $title_hide, 1 ); ?> /><?php esc_html_e( 'Disable the title', 'voluto' ); ?></label>
	</p>
	<p>
		<label><input type="checkbox" name="voluto_hide_featured_image" value="1" <?php checked( $featured_hide, 1 ); ?> /><?php esc_html_e( 'Disable the featured image', 'voluto' ); ?></label>
	</p>	
	<p>
		<label><input type="checkbox" name="voluto_hide_header" value="1" <?php checked( $header_hide, 1 ); ?> /><?php esc_html_e( 'Disable the header', 'voluto' ); ?></label>
	</p>	
	<p>
		<label><input type="checkbox" name="voluto_hide_footer" value="1" <?php checked( $footer_hide, 1 ); ?> /><?php esc_html_e( 'Disable the footer', 'voluto' ); ?></label>
	</p>	
		
	<?php
	}

	/**
	 * Function to sanitize selects
	 */
	public function sanitize_selects( $input, $choices ) {

		$input = sanitize_key( $input );

		return ( in_array( $input, $choices ) ? $input : '' );
	}
}