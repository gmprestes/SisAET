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
}
