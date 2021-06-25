<?php

require 'config.php';

$error = null;
if(isset($_POST['email'])){
    if (empty($_POST['password']) || empty($_POST['password2']))
        $error = "Both password fields must be filled out";
    else
    {
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        
        if ($password != $password2)
            $error = "Passwords did not match";
    }
    
    if (! $error && empty($_POST['name']))
        $error = "Name field must be filled out";
    
    if (! $error)
	{
        $error = add_user($_POST['name'], $_POST['email'], $password);
        
        if(! $error){
            header("Location: index.php");
            exit();
        }
    }
}

echo $twig->render('register.html',['error' => $error, 'post' => $_POST]);

?>