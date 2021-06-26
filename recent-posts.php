<?php

require 'config.php';

$error = null;

echo $twig->render('recent_posts.html',['error' => $error, 'post' => $_POST]);

?>