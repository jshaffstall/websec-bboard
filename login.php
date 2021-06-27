<?php

require 'config.php';

$error = null;
if(isset($_POST['email'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	
    $user = login_user($email, $password);
    
	if($user != False){
		session_regenerate_id(true);
		$_SESSION['user'] = $email;
        update_user_last_login($user);
        
		header("Location: index.php");
		exit();
	}
	else{
		$error = "Email/Password combination not found";
	}
}

echo $twig->render('login.html',['error' => $error, 'post' => $_POST]);

?>