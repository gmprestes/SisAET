<?php

class DB
{

    private static $instance;

    public static function getInstance()
    {
        if (null == DB::$instance) {
            DB::$instance = new DB();
        }

        return DB::$instance;
    }


    private $connection;
    private $db;

    public $ASPNETUsers;
    public $DtoPessoa;


    function __construct()
    {
        $this->connection = new MongoClient("mongodb://aetadmin:64608099@mongodb.6nti.com.br:27017/aet");
        $this->db = $this->connection->aet;

        $this->ASPNETUsers = $this->db->ASPNETUsers;
        $this->DtoPessoa = $this->db->DtoPessoa;

    }
}

?>
