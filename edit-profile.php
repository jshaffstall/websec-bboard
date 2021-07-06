<?php

require 'config.php';

$error = null;
$person = null;

if (! isset($_GET['name']))
    $error = "No user name provided";
else
{
    $person = get_user_by_name($_GET['name']);
    
    if (! $person)
        $error = "No user found for that name";
    
}

//$person = $user;

if(! $error && isset($_POST['about']))
{
    //if ($_POST['password'] != $user['password'])
    //    $error = "Invalid password";
    
    //if (! password_verify ($_POST['password'], $user['password']))
    //    $error = "Invalid password";

    if (! $error)
    {
        update_user_profile($person, $_POST['about'], 'profilepic');
        $person = get_user_by_name($person['name']);
    }
}

echo $twig->render('profile_editor.html',['error' => $error, 'post' => $_POST, 'person' => $person]);

?>