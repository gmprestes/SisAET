<?php

require_once 'PowerfulAPI.php';
require_once 'controllers/Login.php';
require_once 'controllers/Pessoa.php';
require_once 'controllers/Arquivo.php';
require_once 'controllers/Cadastro.php';
require_once 'controllers/Semestre.php';
require_once 'controllers/Instituicao.php';
require_once 'controllers/Auxilio.php';

$server = new PowerfulAPI('debug');
$server->addClass('Login');
$server->addClass('Pessoa');
$server->addClass('Arquivo');
$server->addClass('Semestre');
$server->addClass('Instituicao');
$server->addClass('Auxilio');
$server->addClass('Cadastro');

$server->handle();

date_default_timezone_set('UTC');
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

function GUID()
{
    if (function_exists('com_create_guid') === true) {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}
