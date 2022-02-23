<?php
	class Mo_Db_Queries{

		private $wpum_signup = array(
			'domain'         => '',
			'path'           => '',
			'title'          => '',
			'user_login'     => '',
			'user_email'     => '',
			'registered'     => '',
			'activation_key' => '',
			'active'		 => 0 ,
			'meta'           => '',
		);

		// main function to get signups from table
		public function get_customer_signups( $per_page = 5, $page_number = 1 , $usersearch = null ) {
			global $wpdb;
			$sql = "SELECT * FROM {$wpdb->prefix}signups";
		  	if (!empty( $_REQUEST['orderby'])){
		  		$orderby = $_REQUEST['orderby'] == 'email' || $_REQUEST['orderby'] == 'login' ? ' ORDER BY user_' : ' ORDER BY ';
		    	$sql .= $orderby.esc_sql($_REQUEST['orderby'] );
		    	$sql .= !empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
		  	}
		  	if (!is_null($usersearch)){
		  		$sql .= ' WHERE user_login LIKE "%'.$usersearch.'%" OR user_email LIKE "%'.$usersearch.'%" OR meta LIKE "%'.$usersearch.'%"';
		  	}
		  	$sql .= " LIMIT $per_page";
		  	$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;
		  	$paged_signups = $wpdb->get_results( $sql );
		  	
		  	$now = current_time( 'timestamp', true );

			foreach ( (array) $paged_signups as $key => $signup ) {

				$signup->id   = intval( $signup->signup_id );

				$signup->meta = ! empty( $signup->meta ) ? maybe_unserialize( $signup->meta ) : false;

				$signup->user_name = '';
				if ( ! empty( $signup->meta['field_1'] ) ) {
					$signup->user_name = wp_unslash( $signup->meta['field_1'] );
				}

				if ( ! empty( $signup->meta['sent_date'] ) ) {
					
					$signup->notif_sent = $signup->meta['sent_date'];
				} else {
					$signup->notif_sent = $signup->registered;
				}

				$sent_at = mysql2date('U', $signup->notif_sent );
				$diff    = $now - $sent_at;

				if ( $diff < 1 * DAY_IN_SECONDS ) {
					$signup->recently_sent = true;
				}

				if ( ! empty( $signup->meta['notif_count'] ) ) {
					$signup->notif_count = absint( $signup->meta['notif_count'] );
				} else {
					$signup->notif_count = 1;
				}

				$paged_signups[ $key ] = $signup;
			}

		  	return $paged_signups;
		}

		//delete customer signups from table
		public function delete_customer_signup( $id, $name, $sid ){
		  	global $wpdb;
             if(!is_array($id)){$ids=$id; $id=array($ids); }		
			$id= implode( ',', array_map( 'absint', $id));
		     $wpdb->query(" DELETE FROM {$wpdb->prefix}$name WHERE $sid IN($id) ");
		  
		}

		//function to get total row count of signup table
		public function signup_count() {
		  	global $wpdb;
		  	$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}signups";
		  	return $wpdb->get_var( $sql );
		}

		//function to add customer signup in the table
		public function add_customer_signup($user_id){
			global $wpdb;
			$user = get_userdata( $user_id );
			$activation_key = wp_hash( $user_id );
			update_user_meta( $user_id, 'activation_key', $activation_key, '');
			$user_signup = $this->wpum_signup;
			$user_signup['user_login'] = $user->user_login;
			$user_signup['user_email'] = $user->user_email;
			$user_signup['registered'] = current_time( 'mysql', true );
			$user_signup['activation_key'] = $activation_key;
			$user_signup['meta'] = maybe_serialize( array('first_name' => $user->first_name, 'last_name' => $user->last_name, 
															'display_name' => $user->display_name, 'user_pass' => $user->user_pass ) );
			$inserted = $wpdb->insert( $wpdb->prefix.'signups', $user_signup, array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s' ) );
		}

		//function to retrieve customer signup details - signup_id
		public function get_customer_signup_detail($signup_id){
			global $wpdb;
			$sql = "SELECT * FROM {$wpdb->prefix}signups";
			$sql .= ' WHERE signup_id LIKE "%'.$signup_id.'%"';
			$signup_user_detail = $wpdb->get_row( $sql);
			return $signup_user_detail;
		}

		public function get_customer_user_detail($signup_id,$signup_activation_key){
			global $wpdb;
			$user_name = $wpdb->get_var( $wpdb->prepare( "SELECT user_login FROM {$wpdb->prefix}signups WHERE activation_key = %d", $signup_activation_key ) );
			$user_detail = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->users} WHERE user_login LIKE %s", $user_name ) );
			return $user_detail;
		}

		public function update_notification_data( $signup_id ){
			global $wpdb;
			$signup = $this->get_customer_signup_detail($signup_id);
			$sent_date = current_time( 'timestamp', true );
			$signup->meta = ! empty( $signup->meta ) ? maybe_unserialize( $signup->meta ) : false;
			$signup->meta['notif_sent'] = $sent_date;
			$signup->meta['notif_count'] = ! array_key_exists( 'notif_count',$signup->meta ) ? 1 : absint($signup->meta['notif_count'])+1;
			$signup->meta = ! empty( $signup->meta ) ? maybe_serialize( $signup->meta ) : false;
			$test = $wpdb->update("{$wpdb->prefix}signups", array('meta'=>$signup->meta), array('signup_id'=>$signup->signup_id) );
		}
		
		public function mo_wpum_delete_field($id){
			global $wpdb;
			$delete = $wpdb->update("{$wpdb->prefix}wpum_fields", array('title'=>NULL, 'field_meta'=>NULL), array('id'=>$id) );
		}
	}
?>