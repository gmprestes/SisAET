<?php

require_once 'db.php';
require_once '/Models/TipoArquivo.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//print_r($_FILES);

//return;

// Array com as extensões permitidas
$extencoes = array('jpg', 'jpeg', 'pdf', 'png', 'gif');

$tipoArquivo = TipoArquivo::$ComprovanteEnderecoPerfil;
$FKId = '';

if ($params[0] == 'identidade') {
    $tipoArquivo = TipoArquivo::$ComprovanteIdentidadePerfil;
} elseif ($params[0] == 'eleitor') {
    $tipoArquivo = TipoArquivo::$ComprovanteTituloEleitor;
} elseif ($params[0] == 'cpf') {
    $tipoArquivo = TipoArquivo::$ComprovanteCPF;
} elseif ($params[0] == 'certidaonascimento') {
    $tipoArquivo = TipoArquivo::$ComprovanteCertidaoNascimento;
} elseif ($params[0] == 'matricula') {
    $tipoArquivo = TipoArquivo::$ComprovanteMatriculaSemestre;
    $FKId = $params[1];
} elseif ($params[0] == 'notas') {
    $tipoArquivo = TipoArquivo::$ComprovanteNotasUltimoSemestre;
    $FKId = $params[1];
}

//echo $_FILES['files']['size'];
//exit;

// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
//if ($_FILES['files']['error'] != 0) {
//die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['files']['error']]);
//exit; // Para a execução do script
//}

// Faz a verificação da extensão do arquivo
$nomeArquivo = $_FILES['files']['name'][0];
$split = explode('.', $nomeArquivo);
$extensao = strtolower(end($split));
if (array_search($extensao, $extencoes) === false) {
    echo 'Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif';
}

$fileBytes = file_get_contents($_FILES['files']['tmp_name'][0]);
//echo $fileBytes;

$db = DB::getInstance();
$query = array('UserId' => $_SESSION['userid'], 'TipoArquivo' => $tipoArquivo);

if (!empty($FKId)) {
    $query['FKId'] = $FKId;
}

$file = $db->DtoArquivo->findOne($query);

// se ele achar o arquivo faz update do mesmo, se ele não achar, ele cria um novo
if (!empty($file)) {
    $file['Aceito'] = false;
    $file['Verificado'] = false;
    $file['ExtencaoArquivo'] = '';
    $file['DataUpload'] = new MongoDate();
    $file['Nome'] = $nomeArquivo;
    $file['File'] = new MongoBinData($fileBytes, MongoBinData::GENERIC);
    $file['FKId'] = $FKId;
    $db->DtoArquivo->update(array('_id' => $file['_id']), $file);
} else {
    $file = array(
      'Nome' => $nomeArquivo,
      'Tamanho' => $_FILES['files']['size'][0],
      'DataUpload' => new MongoDate(),
      'UserId' => $_SESSION['userid'],
      'TipoArquivo' => $tipoArquivo,
      'ExtencaoArquivo' => $_FILES['files']['type'][0],
      'Verificado' => false,
      'Aceito' => false,
      'File' => new MongoBinData($fileBytes, MongoBinData::GENERIC),
      'FKId' => $FKId,
    );

    $db->DtoArquivo->insert($file);
}
echo true;
