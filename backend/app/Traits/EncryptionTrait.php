<?php

namespace App\Traits;

use phpseclib3\Crypt\AES;

trait EncryptionTrait
{
    // Function to encrypt data
    private function encryptData($data, $secretKey)
    {
        $iterations = 1000;

        // Generate a random salt (16 bytes for this example)
        $salt = random_bytes(16);

        // Generate a random IV (16 bytes for AES-128, 32 bytes for AES-256)
        $iv = random_bytes(16);

        // Generate the key using PBKDF2
        $key = hash_pbkdf2('sha256', $secretKey, $salt, $iterations, 32, true);

        // Initialize AES cipher in CBC mode
        $aes = new AES('cbc');
        $aes->setKey($key);
        $aes->setIV($iv);

        // Encrypt the data
        $encryptedData = $aes->encrypt($data);

        if ($encryptedData === false) {
            throw new \Exception('Encryption failed.');
        }

        // Return the encrypted data, IV, and salt, all base64-encoded
        return [
            'encryptedData' => base64_encode($encryptedData),
            'iv' => base64_encode($iv),
            'salt' => base64_encode($salt),
        ];
    }

    // Function to decrypt data
    private function decryptData($encryptedData, $iv, $salt, $secretKey)
    {
        $iterations = 1000;

        // Decode base64-encoded parameters
        $encryptedData = base64_decode($encryptedData);
        $iv = base64_decode($iv);
        $salt = base64_decode($salt);

        // Generate the key using PBKDF2
        $key = hash_pbkdf2('sha256', $secretKey, $salt, $iterations, 32, true);

        // Initialize AES cipher in CBC mode
        $aes = new AES('cbc');
        $aes->setKey($key);
        $aes->setIV($iv);

        // Decrypt the data
        $decryptedData = $aes->decrypt($encryptedData);

        if ($decryptedData === false) {
            throw new \Exception('Decryption failed.');
        }

        return $decryptedData;
    }
}