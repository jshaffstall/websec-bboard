<?php

require_once 'vendor/autoload.php';

if (!isset($TEMPLATES))
    $TEMPLATES = './templates/';

if (!isset($INCLUDES))
    $INCLUDES = './includes/';

if (!isset($PROFILES))
    $PROFILES = './profiles/';

require_once $INCLUDES.'db.php';

session_start();

if (isset($_SESSION['user']))
{
	$user = get_user($_SESSION['user']);
    
    if ($user['seconds'] > 1800)
    {
        $user = False;
        unset($_SESSION['user']);
    }
}
else
	$user = False;

if (!isset($twig))
{
    $twigloader = new \Twig\Loader\FilesystemLoader($TEMPLATES);
    $twig = new \Twig\Environment($twigloader, ['cache' => False]);
    $twig->addGlobal('user', $user);
}

function is_admin($user)
{
    return $user && $user['role'] == 1;
}

