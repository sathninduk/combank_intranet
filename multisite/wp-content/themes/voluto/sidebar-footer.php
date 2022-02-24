<?php
/**
 * Footer widget areas
 * 
 * @package Voluto
 */
?>

<?php
	if ( !is_active_sidebar( 'footer-1' ) ) {
		return;
	}


	$voluto_footer_widgets_layout 		= get_theme_mod( 'footer_widgets_layout', 'columns3' );
	$voluto_footer_widgets_container 	= get_theme_mod( 'footer_widgets_width', 'container' );

	switch ( $voluto_footer_widgets_layout ) {
		case 'columns1':
			$voluto_widget_areas = array(
				'no'	=> 1,
				'col'	=> 'col-lg-12',
			);
			break;

		case 'columns2':
			$voluto_widget_areas = array(
				'no'	=> 2,
				'col'	=> 'col-lg-6',
			);			
			break;
			 
		case 'columns3':
			$voluto_widget_areas = array(
				'no'	=> 3,
				'col'	=> 'col-lg-4',
			);			
			break;

		case 'columns4':
			$voluto_widget_areas = array(
				'no'	=> 4,
				'col'	=> 'col-lg-3',
			);			
			break;	

		default:
			return;
	}	
?>

<div class="footer-widgets <?php echo esc_attr( $voluto_footer_widgets_layout ); ?>">
	<div class="<?php echo esc_attr( $voluto_footer_widgets_container ); ?>">
		<div class="footer-widgets-inner">
			<div class="row">
			<?php for ( $voluto_counter = 1; $voluto_counter <= $voluto_widget_areas['no']; $voluto_counter++ ) { ?>
				<?php if ( is_active_sidebar( 'footer-' . $voluto_counter ) ) : ?>
				<div class="footer-column <?php echo esc_attr( $voluto_widget_areas['col'] ); ?>">
					<?php dynamic_sidebar( 'footer-' . $voluto_counter); ?>
				</div>
				<?php endif; ?>	
			<?php } ?>
			</div>
		</div>
	</div>
</div>
