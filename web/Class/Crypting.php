<?php

/**
 * Class Crypting generate encrypted key
 */
class Crypting
{
	/**
	 * @var string the encrypted key
	 */
	public $key;

	/**
	 * Crypting constructor.
	 * @param $sEncryptionKey string the key to encrypt the string
	 * @param $sStringToEncrypt string to encrypt
	 * @param $bSalt int set if the key must be salted
	 */
	public function __construct($sEncryptionKey, $sStringToEncrypt, $bSalt = 0)
	{
		if ($bSalt) {
			// Set a random salt
			$salt = openssl_random_pseudo_bytes(8);
		} else {
			// Or empty salt so that we'll be able to compare again
			$salt = "";
		}
		$salted = '';
		$dx = '';
		// Salt the key(32) and iv(16) = 48
		while (strlen($salted) < 48) {
			$dx = md5($dx . $sEncryptionKey . $salt, true);
			$salted .= $dx;
		}
		$key = substr($salted, 0, 32);
		$iv = substr($salted, 32, 16);
		$encrypted_data = openssl_encrypt($sStringToEncrypt, 'aes-256-cbc', $key, true, $iv);
		$this->key = base64_encode('Salted__' . $salt . $encrypted_data);
	}
}
