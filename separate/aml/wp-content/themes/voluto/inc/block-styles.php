<?php
/**
 * Block styles
 *
 * @package Voluto
 */


/**
 * Register theme based blog styles
 */
function voluto_register_block_styles() {

	register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
		'core/post-template',
		array(
			'name'  => 'voluto-counter',
			'label' => __( 'With counter', 'voluto' ),		
		)
	);

	register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
		'core/post-terms',
		array(
			'name'  => 'voluto-solid-cats',
			'label' => __( 'Solid', 'voluto' ),
			'isdefault' => true,		
		)
	);

	register_block_style( // phpcs:ignore WPThemeReview.PluginTerritory.ForbiddenFunctions.editor_blocks_register_block_style
		'core/heading',
		array(
			'name'  => 'voluto-no-margins',
			'label' => __( 'No margins', 'voluto' ),
		)
	);
	
}
add_action( 'init', 'voluto_register_block_styles' );