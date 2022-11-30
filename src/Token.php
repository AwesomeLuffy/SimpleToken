<?php
require "JWToken.php";

class Token
{
    private const HEADER = [
        "alg" => "HS256",
        "type" => "JWT"
    ];

    /**
     * @param string $userid Id of the user
     * @param string $secret Secret (private key) that will be use
     * @param int $expiration Expiration (in day) on the token
     * @return string token like "dzgkjzgzeEFegrz.ezogijzeJEFZjklg.jiO305jhf"
     * @throws Exception Throw validity exception when validity is not correct
     */
    public static function create(string $userid, string $secret, int $expiration): string{
        return JWToken::generateJWToken(self::HEADER, ["userid" => $userid], $secret, $expiration);
    }

    /**
     * @param array $payload Custom payload as an associative array
     * @param string $secret Secret (private key) that will be use
     * @param int $expiration Expiration (in day) on the token
     * @return string token like "dzgkjzgzeEFegrz.ezogijzeJEFZjklg.jiO305jhf"
     * @throws Exception Throw validity exception when validity is not correct
     */
    public static function withCustomPayload(array $payload, string $secret, int $expiration): string {
        return JWToken::generateJWToken(self::HEADER, $payload, $secret, $expiration);
    }
}