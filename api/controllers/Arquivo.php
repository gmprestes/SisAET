<?php

require_once '../db.php';
require_once '../Models/TipoArquivo.php';

class Arquivo
{
    function authorize()
    {
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
        if (isset($_SERVER["Authorization"]) && isset($_SESSION['synctoken']))
          return $_SESSION['synctoken'] == $_SERVER["Authorization"];
        else
          return false;
    }

    /**
     * @url GET /arquivo/GetAllFilesPerfil
     *
     */
    public function GetAllFilesPerfil()
    {
          $db = DB::getInstance();
          $cursor = $db->DtoArquivo->find(
          array('UserId' => $_SESSION["userid"],
          'TipoArquivo' => array('$in' => array(
            TipoArquivo::$ComprovanteIdentidadePerfil,
            TipoArquivo::$ComprovanteEnderecoPerfil,
            TipoArquivo::$ComprovanteTituloEleitor,
            TipoArquivo::$ComprovanteCPF,
            TipoArquivo::$ComprovanteCertidaoNascimento))
        ),
          array("_id" => true,
                "Nome" => true,
                "TipoArquivo" => true,
                "DataUpload" => true,
                "Verificado" => true,
                "Aceito" => true));

            $array = iterator_to_array($cursor);
            return $array;
    }

}
?>