<?php

class MoLdapLocalUtil{

	public static function is_customer_registered() {
		$email 			= get_option('mo_ldap_local_admin_email');
		$customerKey 	= get_option('mo_ldap_local_admin_customer_key');
		if( ! $email || ! $customerKey || ! is_numeric( trim( $customerKey ) ) ) {
			return 0;
		} else {
			return 1;
		}
	}


    public static function generateRandomString($length = 8) {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $crypto_rand_secure = function ( $min, $max ) {
            $range = $max - $min;
            if ( $range < 0 ) {
                return $min;
            }
            $log    = log( $range, 2 );
            $bytes  = (int) ( $log / 8 ) + 1;
            $bits   = (int) $log + 1;
            $filter = (int) ( 1 << $bits ) - 1;
            do {
                $rnd = hexdec( bin2hex( openssl_random_pseudo_bytes( $bytes ) ) );
                $rnd = $rnd & $filter;
            } while ( $rnd >= $range );
            return $min + $rnd;
        };

        $token = "";
        $max   = strlen( $pool );
        for ( $i = 0; $i < $length; $i++ ) {
            $token .= $pool[$crypto_rand_secure( 0, $max )];
        }
        return $token;
    }

	public static function check_empty_or_null( $value ) {
		if( ! isset( $value ) || empty( $value ) ) {
			return true;
		}
		return false;
	}
	
	public static function encrypt($str) {
		if(!MoLdapLocalUtil::is_extension_installed('openssl')) {
			return;
		}
		$key = get_option('mo_ldap_local_customer_token');
		$method = 'AES-128-ECB';
		$strCrypt = openssl_encrypt ($str, $method, $key,OPENSSL_RAW_DATA||OPENSSL_ZERO_PADDING);
		return base64_encode($strCrypt);
	}

	public static function decrypt($value) {
		if(!MoLdapLocalUtil::is_extension_installed('openssl')) {
			return;
		}

		$strIn = base64_decode($value);
		$key = get_option('mo_ldap_local_customer_token');
		$method = 'AES-128-ECB';
		$ivSize = openssl_cipher_iv_length($method);
		$data   = substr($strIn,$ivSize);
		return openssl_decrypt ($data, $method, $key, OPENSSL_RAW_DATA||OPENSSL_ZERO_PADDING);
	}
		
	public static function is_curl_installed() {
		return in_array  ('curl', get_loaded_extensions());
	}
	
	public static function is_extension_installed($name) {
        return in_array ($name, get_loaded_extensions());
	}
}
?>