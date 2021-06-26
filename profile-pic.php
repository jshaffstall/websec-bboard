<?php

require 'config.php';

if(isset($_GET['name']))
{
    // Vulnerable to directory traversal as is
    $file = $_GET['name'];
    
    // Uncomment to fix directory traversal vulnerability
    /*
    $person = get_user_by_name($_GET['name']);
    
    if (! $person)
        exit();
    
    $file = $person['profile_pic'];
    */
    
    $filename = $PROFILES.$file;
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $content_type = finfo_file($finfo, $filename);
    finfo_close($finfo);    
    
    header('Content-Type: '.$content_type);
    header("Content-Length: " . filesize($filename));
    readfile($filename);
}

?>