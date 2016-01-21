<?php

require_once '../db.php';

class Instituicao
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
     * @url GET /instituicao/GetAllAtivos
     */
    public function GetAllAtivos()
    {
        $db = DB::getInstance();
        $cursor = $db->DtoInstituicao->find(array('Ativo' => true));
        $array = array();
        foreach ($cursor as $doc) {
            $doc['_id'] = mgid_to_string($doc['_id']);
            array_push($array, $doc);
        }

        return $array;
    }

    /**
     * @url GET /instituicao/GetAll
     */
    public function GetAll()
    {
        $db = DB::getInstance();
        $cursor = $db->DtoInstituicao->find();
        $array = array();
        foreach ($cursor as $doc) {
            $doc['_id'] = mgid_to_string($doc['_id']);
            array_push($array, $doc);
        }

        return $array;
    }

    /**
     * @url GET /instituicao/Get/$id
     */
    public function Get($id)
    {
        $instituicao = array();
        if (!empty($id) && $id != 'undefined') {
            $db = DB::getInstance();
            $instituicao = $db->DtoInstituicao->findOne(array('_id' => new MongoId($id)));
        }

        if (!empty($instituicao)) {
            $instituicao['_id'] = mgid_to_string($instituicao['_id']);
        } else {
            $instituicao = array(
              '_id' => '',
              'Nome' => '',
              'Descricao' => '',
              'Ativo' => false,
            );
        }

        return $instituicao;
    }

    /**
     * @url POST /instituicao/Save
     */
    public function Save($data)
    {
        $db = DB::getInstance();
        $instituicao = $data->instituicao;

        if (empty($instituicao->_id)) {

            $instituicao->_id = new MongoId();
            $db->DtoInstituicao->insert($instituicao);

            return mgid_to_string($instituicao->_id);
        } else {

            $instituicao->_id = str_to_mongoid($instituicao->_id);

            $db->DtoInstituicao->update(array('_id' => $instituicao->_id), $instituicao);

            return mgid_to_string($instituicao->_id);
        }
    }


    /**
     * @url GET /instituicao/Excluir/$id
     */
    public function Excluir($id)
    {
      $db = DB::getInstance();
      $db->DtoInstituicao->remove(array('_id' => new MongoId($id)));

      return 'Instituicao excluida com sucesso.';
    }
}
