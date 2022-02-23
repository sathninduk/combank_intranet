<?php
/**
 * Slider control
 *
 * @package Voluto
 */

class Voluto_Slider_Control extends WP_Customize_Control {
	/**
	 * The type of control being rendered
	 */
	public $type = 'voluto-slider_control';

	/**
	 * Render the control in the customizer
	 */
	public function render_content() {
		$has_units = '';
		if ( !empty( $this->input_attrs['unit'] ) ) {
			$has_units = 'has-units';
		}
	?>
		<div class="slider-custom-control <?php echo esc_attr( $has_units ); ?>">
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<div class="slider-custom-control-inner">
				<div class="slider-range-wrapper">
					<input type="range" id="<?php echo esc_attr( $this->id ); ?>" data-slider-max-value="<?php echo esc_attr( $this->input_attrs['max'] ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-slider-value" <?php $this->link(); ?> min="<?php echo absint( $this->input_attrs['min'] ); ?>" max="<?php echo absint( $this->input_attrs['max'] ); ?>" step="<?php echo esc_attr( $this->input_attrs['step'] ); ?>"/>
					<span class="slider-fill"></span>
				</div>
				<div class="slider-output-wrapper">
					<input type="number" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-slider-output" <?php $this->link(); ?> min="<?php echo absint( $this->input_attrs['min'] ); ?>" max="<?php echo absint( $this->input_attrs['max'] ); ?>" step="<?php echo esc_attr( $this->input_attrs['step'] ); ?>"/>
					<?php if ( !empty( $this->input_attrs['unit'] ) ) : ?>
						<span><?php echo esc_html( $this->input_attrs['unit'] ); ?>
					<?php endif; ?>
				</div>
				<span class="slider-reset dashicons dashicons-image-rotate" slider-reset-value="<?php echo esc_attr( $this->value() ); ?>"></span>
			</div>
		</div>
	<?php
	}
} 