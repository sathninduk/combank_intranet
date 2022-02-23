<?php
/**
 * Responsive number control
 *
 * @package Voluto
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Voluto_Responsive_Number extends WP_Customize_Control {

	public $type = 'voluto-responsive_number';

	public $html = array();

	public function build_field_html( $key, $setting, $devices ) {

		$has_units = '';
		if ( !empty( $this->input_attrs['unit'] ) ) {
			$has_units = 'has-units';
		}
				
		$value = '';
		if ( isset( $this->settings[ $key ] ) ) {
			$value = $this->settings[ $key ]->value();
		}
		if ( 'desktop' == $devices ) {
			$active = 'active';
		} else {
			$active = ''; 
		}
		$this->html[] = 
		'<div class="slider-custom-control ' . $active . ' voluto-preview-' . $devices . ' ' .  esc_attr( $has_units ) . '">
			<div class="slider-custom-control-inner">
				<div class="slider-range-wrapper">
					<input class="customize-control-slider-value" data-slider-max-value="' . esc_attr( $this->input_attrs['max'] ) . '" min="' . intval( $this->input_attrs['min'] ) . '" step="' . intval( $this->input_attrs['step'] ) . '" max="' . intval( $this->input_attrs['max'] ) . '" type="range" value="' . $value . '" '.$this->get_link( $key ).' />
					<span class="slider-fill"></span>
				</div>
				<div class="slider-output-wrapper">
					<input class="customize-control-slider-output" min="' . intval( $this->input_attrs['min'] ) . '" step="' . intval( $this->input_attrs['step'] ) . '" max="' . intval( $this->input_attrs['max'] ) . '" type="number" value="' . $value . '" '.$this->get_link( $key ).' />
					<span>' . $this->input_attrs['unit'] . '</span>
				</div>	
			</div>		
		</div>';
	}

	public function render_content() { ?>

		<div class="voluto-responsive-control-header">
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<ul class="voluto-devices-preview">
				<li class="desktop active">
					<button type="button" class="preview-desktop" data-device="desktop">
						<i class="dashicons dashicons-desktop"></i>
					</button>
				</li>
				<li class="tablet">
					<button type="button" class="preview-tablet" data-device="tablet">
						<i class="dashicons dashicons-tablet"></i>
					</button>
				</li>
				<li class="mobile">
					<button type="button" class="preview-mobile" data-device="mobile">
						<i class="dashicons dashicons-smartphone"></i>
					</button>
				</li>
			</ul>
		</div>
		<div class="voluto-responsive-wrapper">
		<?php
		$devices = array( 'desktop', 'tablet', 'mobile' );
		foreach( $this->settings as $key => $value ) {
			$this->build_field_html( $key, $value, $devices[$key] );
		}
		echo implode( '', $this->html ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php
	}

}