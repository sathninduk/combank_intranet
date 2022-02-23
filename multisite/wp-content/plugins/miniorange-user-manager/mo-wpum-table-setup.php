<?php
	Class Mo_Database_Setup{
		public function setup_signups_table(){
			global $wpdb;
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
			$wpdb->signups = $wpdb->base_prefix . 'signups';
			$queries = wp_get_db_schema( 'ms_global' );
			if ( ! is_array( $queries ) ) {
				$queries = explode( ';', $queries );
				$queries = array_filter( $queries );
			}
			foreach ( $queries as $key => $query ) {
				if ( preg_match( "|CREATE TABLE ([^ ]*)|", $query, $matches ) ) {
					if ( trim( $matches[1], '`' ) !== $wpdb->signups ) {
						unset( $queries[ $key ] );
					}
				}
			}

			if ( ! empty( $queries ) ) {
				dbDelta( $queries );
			}
		}
		
		public function setup_fields_table() {
			global $wpdb;
			$table_name = $wpdb->prefix . "wpum_fields"; 
			$charset_collate = $wpdb->get_charset_collate();
			$sql = "CREATE TABLE $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				title longtext ,
				field_meta longtext,
				field_value longtext,
				field_type longtext,
				options longtext,
				UNIQUE KEY id (id)
				) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
		
		public function fields_insert_default(){
			$title= array("First Name", "Last Name", "Nick Name", "Description", "Website");
			$field_meta = array("first_name","last_name", "nickname", "description", "user_url");
			$field_type = array("text", "text", "text", "text", "text");
			global $wpdb;
			$table_name = $wpdb->prefix . 'wpum_fields';
			for($i=0; $i<5; $i++){
				$wpdb->insert(
						$table_name,
							array(
								'title' => $title[$i],
								'field_meta' => $field_meta[$i],
								'field_type' => $field_type[$i],
							));
			}
		}
		
		public function fields_insert_data($label,$meta_key,$field_type,$option)	{
			global $wpdb;
			$table_name = $wpdb->prefix . 'wpum_fields';
			$wpdb->insert(
					$table_name,
						array(
							'title' => $label,
							'field_meta' => $meta_key,
							'field_type' => $field_type,
							'options' => $option,
						));
		}
		
		public function fields_update_data($id,$label,$meta_key,$field_type,$option) {
			global $wpdb;
			$field_label = $label;
			$field_type_new = $field_type;
			$field_meta_key = $meta_key;
			$option_new = $option;
			$table_name = $wpdb->prefix . 'wpum_fields';
			
			$wpdb->update( 
					$table_name, 
					array( 
						'title' => $field_label,
						'field_meta' => $field_meta_key,
						'field_type' => $field_type_new,
						'options' => $option_new, 
					), array('id'=>$id)
					);
		}
	}
?>