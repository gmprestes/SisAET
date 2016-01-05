<?php

require_once 'db.php';

$db = DB::getInstance();

$file = $db->DtoArquivo->findOne(array('_id' => new MongoId($params[0])));

$extencao = $file["ExtencaoArquivo"];
$nome = $file["Nome"];
header("Pragma: public"); // required
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false); // required for certain browsers
header("Content-Type: $extencao");
header("Content-Disposition: attachment; filename=\"$nome\"");
header("Content-Transfer-Encoding: binary");

echo $file['File']->bin;
exit;
//header("Content-Length: ".$size);
