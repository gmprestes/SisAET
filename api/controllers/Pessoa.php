<?php

require_once '../db.php';

class Pessoa
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
     * @url GET /pessoa/Get
     */
    public function Get()
    {
        $db = DB::getInstance();
        $user = $db->DtoPessoa->findOne(array('UserId' => $_SESSION['userid']));

        if (!empty($user)) {
            $user['DataNascimento'] = mgdt_to_string($user['DataNascimento']);
            $user['_id'] = mgid_to_string($user['_id']);

            return $user;
        } else {
            return '';
        }
    }

    /**
     * @url POST /pessoa/Save
     */
    public function Save($data)
    {
        $db = DB::getInstance();
        $data->pessoa->_id = str_to_mongoid($data->pessoa->_id);
        $data->pessoa->DataNascimento = new MongoDate(str_to_datetime($data->pessoa->DataNascimento));
        $db->DtoPessoa->update(array('UserId' => $_SESSION['userid']), $data->pessoa);

        return 'Salvo com sucesso';
    }


}
