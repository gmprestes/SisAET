<?php

require_once 'PowerfulAPI.php';
require_once 'controllers/Login.php';
require_once 'controllers/Pessoa.php';



date_default_timezone_set("UTC");
function str_to_datetime($s)
{
  return strtotime(str_replace('/', '-',  $s));
}

function mgdt_to_string($s)
{
  return date('d/m/Y', $s->sec);
}

function str_to_mongoid($s)
{
  return new MongoId("$s");
}

function mgid_to_string($s)
{
  return (string) $s;
}

$server = new PowerfulAPI('debug');

$server->addClass('Login');
$server->addClass('Pessoa');
$server->handle();
?>
