<!-- THIS IS AN EXAMPLE OF HOW TO USE -->
<?php



require_once "src/Token.php";
require_once "src/forcetoken/ForceToken.php";


$userid = "123456";
$secret = "ilovecookie";
$expiration = 1;

$mytoken = Token::create($userid, $secret, $expiration);

$customPayload = [
        "userid" => $userid,
        "by" => "localhost",
        "custom_field_1" => "value_of_custom_field_1"
];

$mycustompayloadtoken = Token::withCustomPayload($customPayload, $secret, $expiration);
?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Example</title>
</head>
<body>
    <h1 class="">Example :</h1>
    <p><?php echo $mytoken; ?></p>
    <h2>Example with custom payload :</h2>
    <p><?php echo $mycustompayloadtoken; ?></p>

</body>
</html>

