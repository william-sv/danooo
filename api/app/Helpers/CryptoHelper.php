<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;

class CryptoHelper
{
    // 秘钥（你也可以从 .env 中读取）
    protected string $hmacSecret = '1221610';
    
    // 凭证有效时间（秒）
    protected int $ttl = 60;

    /**
     * 生成加密的 API Token，带时间戳和 HMAC 签名
     */
    public function encryptApiKey($data)
    {
        $timestamp = time();
        $payload = $data . '|' . $timestamp;

        $signature = hash_hmac('sha256', $payload, $this->hmacSecret);
        $full = $payload . '|' . $signature;

        return base64_encode(Crypt::encryptString($full));
    }

    /**
     * 解密并验证 API Token 是否有效
     */
    public function decryptApiKey($token)
    {
        try {
            $decrypted = Crypt::decryptString(base64_decode($token));
            [$data, $timestamp, $signature] = explode('|', $decrypted);

            // 时间戳校验
            if (abs(time() - (int)$timestamp) > $this->ttl) {
                return null; // 过期
            }

            // 签名校验
            $expected = hash_hmac('sha256', $data . '|' . $timestamp, $this->hmacSecret);
            if (!hash_equals($expected, $signature)) {
                return null; // 签名不匹配
            }

            return $data;
        } catch (\Exception $e) {
            return null; // 解密失败或格式错误
        }
    }
}