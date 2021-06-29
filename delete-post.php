<?php

require 'config.php';

$error = null;

if(isset($_GET['id']))
{
    //if (is_admin($user))
        delete_post($_GET['id']);
}

header("Location: recent-posts.php");
?>