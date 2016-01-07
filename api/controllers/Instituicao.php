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
}
