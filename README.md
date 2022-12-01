[![-](https://img.shields.io/badge/PHP->=7.0.0-4e147a.svg)](https://www.php.net/)
[![--](https://img.shields.io/badge/Made%20with-PHPStorm%20IDE-8547b5.svg)](https://www.jetbrains.com/phpstorm/promo/?source=google&medium=cpc&campaign=14335686201&term=phpstorm)
[![---](https://img.shields.io/badge/With-JWT-c215bc.svg)](https://jwt.io/)
# 📌 SimpleToken

SimpleToken is a small code part that you can include in your project to generate a token.
This is a college project.

# 🗒 What is JWT ?
JWT (JSON Web Token) is a token based on JSON encode.
This allow you to generate something like :
```
eyJhbGciOiJIUzI1NiIsInR5cGUiOiJKV1QifQ.eyJ1c2VyaWQiOiIxMjM0NTYiLCJpYXQiOjE2Njk3NjgxNTUsImV4cCI6MTY2OTg1NDU1NX0.8X9484DESNXzbKwuLxtVjhoc8o9N-2G0e2Cd9UT-tYk
```
That mean :
```json
{ "header":
  {
    "alg":"HS256",
    "type":"JWT"
  }, "payload":
  {
    "userid":"123456",
    "iat":10000,
    "exp":10001
  }
}
```
For more information about it go to [JWT Website](https://jwt.io/)
# 🛠 How to install
Simply drag and drop the src file in your project, you can rename it if you want.

# 🪛 How to use

You have to import the Token class and call the method "create".
If you want to do a custom payload, simply call the method "withCustomPayload"

If you want to personnalize the wole token, just use the JWToken class.

```php
<?php

require "src/Token.php";


$userid = "123456";
$secret = "ilovecookie";
$expiration = 1;

$mytoken = Token::create($userid, $secret, $expiration);

$customPayload = [
        "userid" => $userid,
        "by" => "localhost",
        "custom_field_1" => "value_of_custom_field_1"
];

$mycustompayloadtoken = Token::withCustomPayload($customPayload, $secret, $expiration)
?>

//YOUR HTML CODE
```
