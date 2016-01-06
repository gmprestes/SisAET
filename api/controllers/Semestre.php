<?php

require_once '../db.php';

class Semestre
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
     * @url GET /semestre/GetAll
     */
    public function GetAll()
    {
        $db = DB::getInstance();
        $cursor = $db->DtoSemestre->find();
        $array = array();
        foreach ($cursor as $doc) {
            $doc['DataInicio'] = mgdt_to_string($doc['DataInicio']);
            $doc['DataTermino'] = mgdt_to_string($doc['DataTermino']);
            $doc['_id'] = mgid_to_string($doc['_id']);
            array_push($array, $doc);
        }

        return $array;
    }

    /**
     * @url GET /semestre/Get/$id
     */
    public function Get($id)
    {
        $semestre = array();
        if (!empty($id) && $id != 'undefined') {
            $db = DB::getInstance();
            $semestre = $db->DtoSemestre->findOne(array('_id' => new MongoId($id)));
        }
        if (!empty($semestre)) {
            $semestre['DataInicio'] = mgdt_to_string($semestre['DataInicio']);
            $semestre['DataTermino'] = mgdt_to_string($semestre['DataTermino']);
            $semestre['_id'] = mgid_to_string($semestre['_id']);
        } else {
            $semestre = array(
              '_id' => '',
              'DataInicio' => '',
              'DataTermino' => '',
              'Ativo' => false,
            );
        }

        return $semestre;
    }

    /**
     * @url POST /semestre/Save
     */
    public function Save($data)
    {
        $db = DB::getInstance();
        $semestre = $data->semestre;

        if (empty($semestre->_id)) {
            $semestre->DataInicio = new MongoDate(str_to_datetime($semestre->DataInicio));
            $semestre->DataTermino = new MongoDate(str_to_datetime($semestre->DataTermino));
            $semestre->_id = new MongoId();
            $db->DtoSemestre->insert($semestre);

            return mgid_to_string($semestre->_id);

        } else {
            $semestre->DataInicio = new MongoDate(str_to_datetime($semestre->DataInicio));
            $semestre->DataTermino = new MongoDate(str_to_datetime($semestre->DataTermino));
            $semestre->_id = str_to_mongoid($semestre->_id);

            $db->DtoSemestre->update(array('_id' => $semestre->_id), $semestre);

            return mgid_to_string($semestre->_id);
        }
    }

    /**
     * @url GET /semestre/Excluir/$id
     */
    public function Excluir($id)
    {
        $db = DB::getInstance();
        $db->DtoSemestre->remove(array('_id' => new MongoId($id)));

        return 'Semestre excluido com sucesso.';
    }
}
