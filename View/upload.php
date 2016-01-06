<?php


require_once 'db.php';
require_once '../Models/TipoArquivo.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//$_SESSION["userid"]

$db = DB::getInstance();

$file = $db->DtoArquivo->findOne(array('_id' => new MongoId($params[0])));

// Array com as extensões permitidas
$extencoes = array('jpg', 'png', 'gif');

$tipoArquivo = TipoArquivo::ComprovanteEnderecoPerfil;

if ($params[0] == 'identidade') {
    $tipoArquivo = TipoArquivo::ComprovanteIdentidadePerfil;
} elseif ($params[0] == 'eleitor') {
    $tipoArquivo = TipoArquivo::ComprovanteTituloEleitor;
} elseif ($params[0] == 'cpf') {
    $tipoArquivo = TipoArquivo::ComprovanteCPF;
} elseif ($params[0] == 'certidaonascimento') {
    $tipoArquivo = TipoArquivo::ComprovanteCertidaoNascimento;
}

//echo $_FILES['files']['size'];
//exit;

// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
//if ($_FILES['files']['error'] != 0) {
//die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['files']['error']]);
//exit; // Para a execução do script
//}

// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar

// Faz a verificação da extensão do arquivo
$split = explode('.', $_FILES['files']['name'][0]);
$extensao = strtolower(end($split));
if (array_search($extensao, $extencoes) === false) {
    echo 'Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif';

    return;
}

// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
else {
    // Primeiro verifica se deve trocar o nome do arquivo
if ($_UP['renomeia'] == true) {
    // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
$nome_final = time().'.jpg';
} else {
    // Mantém o nome original do arquivo
$nome_final = $_FILES['files']['name'][0];
}

    $fileBytes = file_get_contents($_FILES['files']['tmp_name'][0]);
    echo $fileBytes;
//$profile = array(
//    "username" => "foobity",
//    "pic" => new MongoBinData(file_get_contents("gravatar.jpg"), MongoBinData::GENERIC),
//);

// Depois verifica se é possível mover o arquivo para a pasta escolhida
//if (move_uploaded_file($_FILES['files']['tmp_name'][0], $_UP['pasta'] . $nome_final)) {
// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
//echo "Upload efetuado com sucesso!";
//echo '<br /><a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
//} else {
// Não foi possível fazer o upload, provavelmente a pasta está incorreta
//echo "Não foi possível enviar o arquivo, tente novamente";
//}
}
