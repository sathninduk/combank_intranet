<?php
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
	require_once( ABSPATH . 'wp-admin/includes/class-wp-users-list-table.php' );

	// Class to show the Customer SignUps list
	class Mo_User_List extends WP_Users_List_Table{

		private $table_columns = array(
		    'cb'		 => '<input type="checkbox" />',
		    'username'   => 'Username',
			'name'       => 'Name',
			'email'      => 'Email',
			'registered' => 'Registered On',
			'notif_sent' => 'Last Notification',
			'notif_count'=> 'Emails Sent',
		);

		private $bulk_action =  array(
			'activate' => 'Activate',
			'resend'   => 'Email',
		);

		public function __construct(){
			parent::__construct( array(
				'ajax'     => false,
				'plural'   => 'signups',
				'singular' => 'signup',
				'screen'   => get_current_screen()->id,
			) );
		}

		// Specify the columns of the table
		function get_columns(){
		  return $this->table_columns;
		}

		// Get the customer list for the current page
		public function prepare_items() {
			global $db_queries;
			$this->_column_headers = $this->get_column_info();
			$usersearch = isset( $_REQUEST['s'] ) ? $_REQUEST['s'] : null ;
		  	$per_page = $this->get_items_per_page('wpum_signups_per_page', 5);
		  	$current_page = $this->get_pagenum();
		  	$total_items  = $db_queries->signup_count();

		  	$this->set_pagination_args( array(
		    	'total_items' => $total_items,                  
		    	'per_page'    => $per_page  
		  	) );
		  	$this->items = $db_queries->get_customer_signups( $per_page, $current_page, $usersearch );
		}

		// Set the current page as Registered users
		public function views() {
			global $role;
			$reset_role = $role;
			$role = 'registered';
			$reset_screen_id = $this->screen->id;
			$this->screen->id = 'users';
			parent::views();
			$role = $reset_role;
			$this->screen->id = $reset_screen_id;
		}

		// Bulk Action
		public function get_bulk_actions() {
			$actions = $this->bulk_action;
			if ( current_user_can( 'delete_users' ) ) {
				$actions['delete'] = 'Delete';
			}
			return $actions;
		}

		public function display_rows() {
			$style = '';
			foreach ( $this->items as $userid => $signup_object ) {
				if (isset($signup_object->id)) {
					$signup_object->ID = $signup_object->id;
				}

				$style = ' class="alternate"' == $style ? '' : ' class="alternate"';
				echo "\n\t" . $this->single_row( $signup_object, $style );
			}
		}

		public function single_row( $signup_object = null, $style = '', $role = '', $numposts = 0 ) {
			echo '<tr' . $style . ' id="signup-' . esc_attr( $signup_object->id ) . '">';
			echo $this->single_row_columns( $signup_object );
			echo '</tr>';
		}

		function get_sortable_columns() {
		  	$sortable_columns = array(
				'username'   => 'login',
				'email'      => 'email',
				'registered' => 'registered',
			);
		  	return $sortable_columns;
		}

		// Add Activate,Delete and Send Email options for each customer row
		public function column_username( $signup_object = null ) {
			$avatar	= get_avatar( $signup_object->user_email, 32 );
			$_SESSION['signup_id']=$signup_object->id;
			$email_link = $email_link = add_query_arg(
				array(
					'page'	    => 'mo_wpum_user_signups',
					'signup_id' => $signup_object->id,
					'action'    => 'resend',
				),
				admin_url( 'users.php' )
			);
			$activate_link =  $activate_link = add_query_arg(
				array(
					'page'      => 'mo_wpum_user_signups',
					'signup_id' => $signup_object->id,
					'action'    => 'activate',
				),
				admin_url( 'users.php' )
			);
			$delete_link = $delete_link = add_query_arg(
				array(
					'page'      => 'mo_wpum_user_signups',
					'signup_id' => $signup_object->id,
					'action'    => 'delete',
				),
				admin_url( 'users.php' )
			);
			$email_link = esc_url( $email_link );
			$activate_link = esc_url( $activate_link );
			$delete_link = esc_url( $delete_link );
			$actions = array();

			echo $avatar . '<strong><a href="'.$activate_link.'" class="edit" title="Activate">'.$signup_object->user_login.'</a></strong><br/>';
			$actions['activate'] = '<a href="'.$activate_link .'">Activate</a>';
			$actions['resend']   = '<a href="'.$email_link.'">Email</a>';
			if ( current_user_can( 'delete_users' ) ) {
				$actions['delete'] = '<a href="'.$delete_link.'" class="delete">Delete</a>';
			}

			echo $this->row_actions( $actions );
		}

		public function column_cb($signup_object = null) {
	        return '<input type="checkbox" name="signup_id[]" value="'.$signup_object->id.'" />';
	    }

		public function column_name( $signup_object = null ) {
			return esc_html( $signup_object->user_name );
		}

		public function column_email( $signup_object = null ) {
			return '<a href="mailto:'.esc_attr( $signup_object->user_email ).'">'.esc_html( $signup_object->user_email).'</a>';
		}

		public function column_registered( $signup_object = null ) {
			return mysql2date( 'Y/m/d', $signup_object->registered );
		}

		public function column_notif_sent( $signup_object = null ) {
			return mysql2date( 'Y/m/d', $signup_object->notif_sent );
		}

		public function column_notif_count( $signup_object = null ) {
			return absint( $signup_object->notif_count );
		}

		//Don't show navigation dropdown
		public function extra_tablenav( $which ) {
			return;
		}

		public function no_items() {
			echo 'No pending accounts found.';
		}

	}
?>