<?php
namespace App\Helpers;

class Base64WithKey {
	private static $private_key = 'vodxxx2019';
	
	public static function encode($str) {
		return strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(self::$private_key), $str, MCRYPT_MODE_CBC, md5(md5(self::$private_key)))), '+/=', '-_,');;
	}
	
	public static function decode($encoded_str) {
		return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(self::$private_key), base64_decode(strtr($encoded_str, '-_,', '+/=')), MCRYPT_MODE_CBC, md5(md5(self::$private_key))), "\0");
	}
}