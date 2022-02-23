<?php
/**
 * Title control
 *
 * @package Voluto
 */

class Voluto_Title extends WP_Customize_Control {
	public $type = 'voluto-title';
	public $label = '';
	public $description = '';

	public function render_content() {
	?>
		<h3><?php echo esc_html( $this->label ); ?></h3>
		<?php if ( $this->description ) : ?>
		<p><?php echo esc_html( $this->description ); ?></p>
		<?php endif; ?>
	<?php
	}
}   