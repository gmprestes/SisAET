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
     * @url POST /pessoa/GetList
     */
    public function GetList($data)
    {

        $db = DB::getInstance();

        $query = array();
        if (!empty($data->nome)) {
          $regex = new MongoRegex("/(?i).*$data->nome.*/i");
            $query['Nome'] = $regex;
        }

        //if (isset($data->docspendentes) && $data->docspendentes) {
        //  $usersIds = array();
        //  $cursor = $db->DtoArquivo->find(array('Verificado' =>false));
        //  foreach ($cursor as $doc) {
        //    array_push($usersIds, str_to_mongoid($doc['_id']);

        //      $query['UserId'] => array('$in' => $usersIds);
        //  }
        //}
        if(sizeof($query) > 0)
        {
        $cursor = $db->DtoPessoa->find($query);
      }
      else {
        $list = array();
        $cursor = $db->DtoPessoa->find();
        foreach ($cursor as $doc) {
          $doc['DataNascimento'] = mgdt_to_string($doc['DataNascimento']);
          $doc['_id'] = mgid_to_string($doc['_id']);

          array_push($list,$doc);
        }

        return $list;
      }

          // terminar o metodo
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
