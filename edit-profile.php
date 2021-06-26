<?php

require 'config.php';

$error = null;

// Take the profile to edit from the URL as an example of a URL manipulation vulnerability
// Also show a fixed version that takes the user to edit from the session

echo $twig->render('profile_editor.html',['error' => $error, 'post' => $_POST]);

?>