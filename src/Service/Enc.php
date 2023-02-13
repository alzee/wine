<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @author Al Zee <z@alz.ee>
 * @version
 * @todo
 */

namespace App\Service;

class Enc
{
    private $key;
    private $cipher = "aes-128-gcm";

    public function __construct()
    {
        $key = $_ENV['AES_KEY'];
    }

    public function enc(string $plaintext)
    {
        $ivlen = openssl_cipher_iv_length($this->cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext = openssl_encrypt($plaintext, $this->cipher, $this->key, $options=0, $iv, $tag);
        return $ciphertext . '.' . base64_encode($iv) . '.' . base64_encode($tag);
    }

    public function dec(string $ciphertext_iv)
    {
        $t = explode('.', $ciphertext_iv);
        $ciphertext = $t[0];
        $iv = base64_decode($t[1]);
        $tag = base64_decode($t[2]);
        $original_plaintext = openssl_decrypt($ciphertext, $this->cipher, $this->key, $options=0, $iv, $tag);
        return $original_plaintext;
    }
}
