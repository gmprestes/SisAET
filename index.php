<?php

require 'SimplePHPRoute.php';

// Do not run debug mode on production, because it exposes exception details
$route = new SimplePHPRoute('/404', true);

// Put your routes above
$route->add('/', 'View/home.php');
$route->add('/meuperfil', 'View/home.php');
$route->add('/alterarsenha', 'View/alterarsenha.php');
$route->add('/login', 'View/login.php');
$route->add('/cadastro', 'View/cadastro.php');

$route->add('/report/alunos/{param}', 'View/reportalunos.php');

$route->add('/arquivo/get/{param}', 'View/filehandler.php');
$route->add('/arquivo/save/{param}', 'View/upload.php');
$route->add('/arquivo/save/{param}/{param}', 'View/upload.php');


// Error route
$route->add('/404', '404.php');

$route->handle();
