<?php

require 'SimplePHPRoute.php';

// Do not run debug mode on production, because it exposes exception details
$route = new SimplePHPRoute('/404', true);

// Put your routes above
$route->add('/', 'View/home.php');
$route->add('/meuperfil', 'View/home.php');
$route->add('/alterarsenha', 'View/alterarsenha.php');
$route->add('/login', 'View/login.php');
//$route->add('/home', 'admin/home2.php');
//$route->add('/contact/{param}', 'contact.php');
//$route->add('/about', 'about.php');

// Error route
$route->add('/404', '404.php');

$route->handle();