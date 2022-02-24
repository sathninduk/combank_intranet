<?php

class MoLdapPointersManager {

    private $ptr_file;
    private $ptr_version;
    private $prefx;

    public function __construct( $file, $ptr_version, $prefx ) {
        $this->ptr_file = file_exists( $file ) ? $file : FALSE;
        $this->ptr_version = str_replace( '.', '_', $ptr_version );
        $this->prefx = $prefx;
    }

    public function parse() {
        if ( empty( $this->ptr_file ) ){
            return;
        }
        $ptr = (array) require_once $this->ptr_file;
        if ( empty($ptr) ) {
            return;
        }
        foreach ( $ptr as $i => $pointer ) {
            $pointer['id'] = "{$this->prefx}{$this->ptr_version}_{$i}";
            $this->ptr[$pointer['id']] = (object) $pointer;
        }
    }

    public function filter( $page ) {
        if ( empty( $this->ptr ) ) {
            return array();
        }
        $userid = get_current_user_id();
        $meta_data = explode( ',', (string) get_user_meta( $userid, 'dismissed_wp_pointers', TRUE ) );
        $active_ids = array_diff( array_keys( $this->ptr ), $meta_data );
        $info = array();
        foreach( $this->ptr as $i => $pointer ) {
            if (
                in_array( $i, $active_ids, TRUE )
                && isset( $pointer->where )
                && in_array( $page, (array) $pointer->where, TRUE )
            ) {
                $info[] = $pointer;
            }
        }
        $counter = count( $info );

        if ( $info === 0 ) {
            return array();
        }
        foreach( array_values( $info ) as $i => $pointer ) {
            $info[$i]->next = $i+1 < $counter ? $info[$i+1]->id : '';
        }

        return $info;
    }
}