<?php

require_once 'PowerfulAPI.php';
require_once 'controllers/Login.php';
require_once 'controllers/Pessoa.php';

$server = new PowerfulAPI('debug');

$server->addClass('Login');
$server->addClass('Pessoa');
$server->handle();
?>
