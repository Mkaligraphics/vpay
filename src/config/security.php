<?php
	class security {
		private	  $encrypt_method = "AES-256-CBC";
		private   $secret_key = '353822AAC8268976952DC4AD2F9FFEF3';
		private   $secret_iv = '07070707070707070707070707070707';

		public function aes($action, $string) {
		    $output = false;
		    $key = hash('sha256', $this->secret_key); 
		    $iv = substr(hash('sha256', $this->secret_iv), 0, 16);
		    if ( $action == 'encrypt' ) {
		        $output = openssl_encrypt($string, $this->encrypt_method, $key, 0, $iv);
		        $output = base64_encode($output);
		    } else if( $action == 'decrypt' ) {
		    $output = openssl_decrypt(base64_decode($string), $this->encrypt_method, $key, 0, $iv);
		    }
		    return $output;
		}
	}


?>