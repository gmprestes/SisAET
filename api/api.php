<?php

require 'PowerfulAPI.php';
require 'controllers/Login.php';

$server = new PowerfulAPI('debug');

$server->addClass('Login');
$server->handle();
?>
