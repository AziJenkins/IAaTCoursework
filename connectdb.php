<html>
<head>
<?php

$db_host = 'localhost';
$db_name = 'astonevents';
$username = 'guest';
$password = 'password';

try {
    $db = new PDO("mysql:dbname=$db_name;host=$db_host", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo("Sorry. Something went wrong when trying to establish connection to the database :(");
    echo($e->getMessage());
    exit;
}
?>
</head>
</html>
