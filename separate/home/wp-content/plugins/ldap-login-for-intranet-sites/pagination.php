<?php

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class  Users_Report extends WP_List_Table {

	public function __construct() {

		parent::__construct( [
			'singular' => __( 'User', 'ldap' ),
			'plural'   => __( 'Users', 'ldap' ),
			'ajax'     => false
		] );

	}


	public static function get_users( $per_page, $page_number) {

		global $wpdb;

		$sql = "SELECT * FROM {$wpdb->prefix}user_report";

		if ( ! empty( $_REQUEST['orderby'] ) ) {
		    $order_by = sanitize_text_field($_REQUEST['orderby']);
		    $order = sanitize_text_field($_REQUEST['order']);

		    if(!in_array($order_by,array("time","user_name"))){
		       $order_by = "time";
            }

            if(!in_array($order,array("asc","desc"))){
                $order = 'ASC';
            }

			$sql .= ' ORDER BY ' . $order_by;
			$sql .= ' '.$order;
		} else {
			$sql .= ' ORDER BY time DESC';			
		}

		$sql .= " LIMIT $per_page";
		$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;

		$result = $wpdb->get_results( $sql, 'ARRAY_A' );

		$Total_records = count($result);
        for($i=0;$i<$Total_records;$i++)
        {
        	$j= $i+1; 
        	$result[$i]["id"] = (string) $j;	
        }

		return $result;
	}


	public static function record_count() {
		global $wpdb;

		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}user_report";

		return $wpdb->get_var( $sql );
	}

	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'id':
			case 'user_name':
			case 'time':
			case 'Ldap_status':
			case 'Ldap_error':
				return $item[ $column_name ];
			default:
				return print_r( $item, true );
		}
	}

	function get_columns() {
		return [
			'id' => __('Sr No.'),
			'user_name' => __( 'Username'),
			'time' => __( 'Time <br>(UTC + 0)'),
			'Ldap_status' => __( 'Status'),
			'Ldap_error' =>__('Additional Information')
		];
	}


	public function get_sortable_columns() {
        return array(
			'user_name' => array( 'user_name', true ),
			'time' => array( 'time', true ),
		);
	}

	

	public function prepare_items() {

		$this->_column_headers = $this->get_column_info();

		$per_page     = $this->get_items_per_page( 'Users_per_page', 10 );
		$current_page = $this->get_pagenum();
		$total_items  = self::record_count();

		$this->set_pagination_args( [
			'total_items' => $total_items,
			'per_page'    => $per_page
		] );

		$this->items = self::get_users( $per_page, $current_page);
	}

}


class MoLdapPluginPagination {

	static $instance;
	public $users_obj;

	public function __construct() {
        add_action( 'admin_menu', array($this, 'screen_option' ));
	}

	public function plugin_settings_page() {
		?>
		<div class="wrap">

			<div id="poststuff">
				<div id="post-body" class="metabox-holder">
					<div id="post-body-content">
						<div class="meta-box-sortables ui-sortable">
							<form method="post">
								<?php
								$this->users_obj->prepare_items();
								$this->users_obj->display(); ?>
							</form>
						</div>
					</div>
				</div>
				<br class="clear">
			</div>
		</div>
	<?php
	}

	public function screen_option() {

	$this->users_obj = new Users_Report();
	}

	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

add_action( 'plugins_loaded', function () {
	MoLdapPluginPagination::get_instance();
} );