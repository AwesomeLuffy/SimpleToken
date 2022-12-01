<?php
require_once "JWToken.php";

class Token
{
    private const HEADER = [
        "alg" => "HS256",
        "type" => "JWT"
    ];

    /**
     * Generate easily a token just using an user id
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
     * Generate a token with a custom payload
     * @param array $payload Custom payload as an associative array
     * @param string $secret Secret (private key) that will be use
     * @param int $expiration Expiration (in day) on the token
     * @return string token like "dzgkjzgzeEFegrz.ezogijzeJEFZjklg.jiO305jhf"
     * @throws Exception Throw validity exception when validity is not correct
     */
    public static function withCustomPayload(array $payload, string $secret, int $expiration): string {
        return JWToken::generateJWToken(self::HEADER, $payload, $secret, $expiration);
    }

    /**
     * Get the payload of a token
     * @param string $token
     * @return array Payload of the token
     */
    public static function getTokenPayload(string $token): array{
        return JWToken::tokenFromString($token)->readPayload();
    }
}