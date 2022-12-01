<?php

require_once "src/exceptions/FileException.php";
require_once "src/JWToken.php";

class ForceToken
{

    private $list_password = array();
    private const FILE_NAME = "src/forcetoken/pass.txt";
    private static $INSTANCE = null;

    /**
     * @throws FileException
     */
    private function __construct()
    {

        if ($passfile = fopen(self::FILE_NAME, "r")) {
            while (!feof($passfile)) {
                array_push($this->list_password, rtrim(fgets($passfile)));
            }
            fclose($passfile);

            self::$INSTANCE = $this;
        } else {
            throw new FileException("Unable to open the file !", 2);
        }

    }

    private static function getForceTokenInstance(): ForceToken
    {
        return (self::$INSTANCE == null) ? new ForceToken() : self::$INSTANCE;
    }

    public function getPasswordList() : array{
        return $this->list_password;
    }

    public static function tryCrackPassword(string $token) : string{

        $forceTokenInstance = self::getForceTokenInstance();

        $tokenObject = JWToken::tokenFromString($token);

        foreach ($forceTokenInstance->list_password as $line => $password){
            if($tokenObject->checkTokenSignature($password)){
                return $password;
            }
        }

        return "Password not found :(";
    }

}