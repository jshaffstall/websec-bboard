<?php

require 'config.php';

$error = null;
$person = null;

if(isset($_GET['name']))
{
    $person = get_user_by_name($_GET['name']);
    
    if (! $person)
        $error = "User not found";
}
else
{
    $error = "No user name given";
}

echo $twig->render('profile.html',['error' => $error, 'person' => $person]);

?>