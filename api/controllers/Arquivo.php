<?php

require_once '../db.php';
require_once '../Models/TipoArquivo.php';

class Arquivo
{
    public function authorize()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SERVER['Authorization']) && isset($_SESSION['synctoken'])) {
            return $_SESSION['synctoken'] == $_SERVER['Authorization'];
        } else {
            return false;
        }
    }

    /**
     * @url GET /arquivo/GetAllFilesPerfil
     */
    public function GetAllFilesPerfil()
    {
        $db = DB::getInstance();
        $cursor = $db->DtoArquivo->find(
          array('UserId' => $_SESSION['userid'],
          'TipoArquivo' => array('$in' => array(
            TipoArquivo::$ComprovanteIdentidadePerfil,
            TipoArquivo::$ComprovanteEnderecoPerfil,
            TipoArquivo::$ComprovanteTituloEleitor,
            TipoArquivo::$ComprovanteCPF,
            TipoArquivo::$ComprovanteCertidaoNascimento, )),
        ),
          array('_id' => true,
                'Nome' => true,
                'TipoArquivo' => true,
                'DataUpload' => true,
                'Verificado' => true,
                'Aceito' => true, ));

        $array = array();
        foreach ($cursor as $doc) {
            $doc['DataUpload'] = mgdt_to_string($doc['DataUpload']);
            $doc['_id'] = mgid_to_string($doc['_id']);
            array_push($array, $doc);
        }

        return $array;
    }

    /**
     * @url GET /arquivo/GetAllFilesPessoa/$id
     */
    public function GetAllFilesPessoa($id)
    {
        $db = DB::getInstance();
        $pessoa = $db->DtoPessoa->findOne(array('_id' => str_to_mongoid($id)));

        $cursor = $db->DtoArquivo->find(
          array('UserId' => $pessoa['UserId'],
          'TipoArquivo' => array('$in' => array(
            TipoArquivo::$ComprovanteIdentidadePerfil,
            TipoArquivo::$ComprovanteEnderecoPerfil,
            TipoArquivo::$ComprovanteTituloEleitor,
            TipoArquivo::$ComprovanteCPF,
            TipoArquivo::$ComprovanteCertidaoNascimento, )),
        ),
          array('_id' => true,
                'Nome' => true,
                'TipoArquivo' => true,
                'DataUpload' => true,
                'Verificado' => true,
                'Aceito' => true, ));

        $array = array();
        foreach ($cursor as $doc) {
            $doc['DataUpload'] = mgdt_to_string($doc['DataUpload']);
            $doc['_id'] = mgid_to_string($doc['_id']);
            array_push($array, $doc);
        }

        return $array;
    }

    /**
     * @url GET /arquivo/GetAllFilesSemestre/$id
     */
    public function GetAllFilesSemestre($id)
    {
        if (!empty($id) && $id != 'undefined') {
            $db = DB::getInstance();

            $cursor = $db->DtoArquivo->find(
              array('UserId' => $_SESSION['userid'],
                'FKId' => $id,
                'TipoArquivo' => array('$in' => array(
                  TipoArquivo::$ComprovanteMatriculaSemestre,
                  TipoArquivo::$ComprovanteNotasUltimoSemestre, )),
              ),
              array('_id' => true,
                'Nome' => true,
                'TipoArquivo' => true,
                'DataUpload' => true,
                'Verificado' => true,
                'Aceito' => true, ));

            $cursor->sort(array('DataUpload' => -1));
            $array = array();
            foreach ($cursor as $doc) {
                $doc['DataUpload'] = mgdt_to_string($doc['DataUpload']);
                $doc['_id'] = mgid_to_string($doc['_id']);
                array_push($array, $doc);
            }

            return $array;
        }
    }

    /**
     * @url GET /arquivo/GetAllFilesSemestre/$id/$idUser
     */
    public function GetAllFilesSemestreUser($id, $idUser)
    {
        if (!empty($idUser) && $idUser != 'undefined') {
            $db = DB::getInstance();
            $pessoa = $db->DtoPessoa->findOne(array('_id' => str_to_mongoid($idUser)));

            $cursor = $db->DtoArquivo->find(
              array('UserId' => $pessoa['UserId'],
                'FKId' => $id,
                'TipoArquivo' => array('$in' => array(
                  TipoArquivo::$ComprovanteMatriculaSemestre,
                  TipoArquivo::$ComprovanteNotasUltimoSemestre, )),
              ),
              array('_id' => true,
                'Nome' => true,
                'TipoArquivo' => true,
                'DataUpload' => true,
                'Verificado' => true,
                'Aceito' => true, ));

            $cursor->sort(array('DataUpload' => -1));
            $array = array();
            foreach ($cursor as $doc) {
                $doc['DataUpload'] = mgdt_to_string($doc['DataUpload']);
                $doc['_id'] = mgid_to_string($doc['_id']);
                array_push($array, $doc);
            }

            return $array;
        }
    }

    /**
     * @url POST /arquivo/Save
     */
    public function Save($data)
    {
            $db = DB::getInstance();
            $data->arquivo->_id = str_to_mongoid($data->arquivo->_id);
            $arq = $db->DtoArquivo->findOne(array('_id' => $data->arquivo->_id));

            $arq['Aceito'] = $data->arquivo->Aceito;

            if($data->arquivo->Aceito == true)
            $arq['Verificado'] = true;
            else {
              $arq['Verificado'] = $data->arquivo->Verificado;
            }


            $db->DtoArquivo->update(array('_id' => $data->arquivo->_id), $arq);

            return true;
    }
}
