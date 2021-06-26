<?php

require 'config.php';

$error = null;

if(isset($_GET['id']))
{
    delete_post($_GET['id']);
}

header("Location: recent-posts.php");
?>