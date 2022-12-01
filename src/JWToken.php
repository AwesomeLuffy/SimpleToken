<?php

require "exceptions/ValidityException.php";

class JWToken
{

    private $header; //What algo. is used
    private $payload; //Arbitrary data
    private $signature; //Signature (combination of header and payload re-encoded with a secret)

    private function __construct($head, $payl, $sig){
        $this->header = $head;
        $this->payload = $payl;
        $this->signature = $sig;
    }


    /** Generate a token
     * @param $header -> Header of the token
     * @param $payload -> payload of the token
     * @param $secret -> Secret that defined in code
     * @param $validity -> Validity (in day) of the token
     * @return JWToken
     *
     * @throws Exception when validity < 1
     */
    public static function generateJWToken(array $header, array $payload, string $secret, int $validity = 7): JWToken{

        if($validity < 1){
            throw new ValidityException("Validity should be 1 day or highter !", 0);
        }
        $now = new DateTime();
        $payload["iat"] = $now->getTimestamp();
        $payload["exp"] = $now->add(new DateInterval("P".$validity."D"))->getTimestamp();

        $headerEncoded = self::b64_encode(json_encode($header));
        $payloadEncoded = self::b64_encode(json_encode($payload));

        $signature = self::generate($headerEncoded, $payloadEncoded, $secret);
        $signature = self::b64_encode($signature);
        return new JWToken($headerEncoded, $payloadEncoded, $signature);
    }

    private static function generate($headerEncoded, $payloadEncoded, $secret){
        $secretEncoded = self::b64_encode($secret);
        //Encode header & payload with a secret in SHA256 and set the algo to return binary data
        return hash_hmac("SHA256", $headerEncoded . "." . $payloadEncoded, $secretEncoded, true);
    }

    /** Check if a token has the good signature
     * @param string $secret
     * @return bool
     */
    public function checkTokenSignature(string $secret): bool{
        //Rencode header and payload of a received token and check if the signature is ok
        return self::b64_encode(self::generate($this->header, $this->payload, $secret)) === $this->signature;
    }

    /** Check if a token has expired
     * @return bool
     */
    public function isExpired(): bool{
        $payload = $this->readPayload();
        $now = new DateTime();

        return $payload["exp"] < $now->getTimestamp();
    }

    /** Check if the token have the good form --
     * Source of the code : https://github.com/NouvelleTechno/JWT-en-PHP/blob/main/classes/JWT.php
     * @param string $token
     * @return bool
     */
    public static function isValid(string $token): bool{
        return preg_match(
                '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
                $token
            ) === 1;
    }

    public function __toString(): string{
        return $this->header . "." . $this->payload . "." . $this->signature;
    }

    /** Get a token object from a string, return null if the format is not valid
     * @param string $token
     * @return JWToken|null
     */
    public static function tokenFromString(string $token): ?JWToken{
        if(self::isValid($token)){
            $tokenExploded = explode(".", $token);
            return new JWToken($tokenExploded[0], $tokenExploded[1], $tokenExploded[2]);
        }
        return null;
    }


    private static function b64_encode(string $data): string{
        // 1 - Encode in base64 the data (payload or header)
        // 2 - Replace + to - & / to _ with strtr (Not in JWT chart)
        // 3 - Remove the "=" with trim (Not in JWT chart)
        return trim(strtr(base64_encode($data), "+/", "-_"), "=");
    }

    private function readHeader(): array{
        return (array) json_decode(base64_decode($this->header, true));
    }

    public function readPayload(): array{
        return (array) json_decode(base64_decode($this->payload, true));
    }


}