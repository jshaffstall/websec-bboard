<?php

require 'config.php';

$error = null;

if(isset($_POST['content']))
{
    if (empty($_POST['content']))
        $error = "You must type something to post";
    
    if (! $user)
        $error = "You must be logged in to post";
    
    if (! $error)
    {
        add_post($user, $_POST['content']);
        header("Location: recent-posts.php");
        exit();
    }
}

$posts = get_recent_posts(15);

echo $twig->render('recent_posts.html',['error' => $error, 'posts' => $posts]);

?>