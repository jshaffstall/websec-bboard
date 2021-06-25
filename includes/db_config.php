<?php

$user = "websecbboard";
$password = "websecbboardpassword";
$dbname = "WebSecurityBBoard";

try
{
    $pdo = new PDO('mysql:host=localhost;dbname='.$dbname, $user, $password);
    $pdo->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec ('SET NAMES "utf8"');
}
catch (PDOException $e)
{
    echo $e->getMessage ();
    exit ();
}


