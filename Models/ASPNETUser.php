<?php

require_once '../db.php';

class ASPNETUser
{

    private $db;

    function __construct()
    {
        $this->db = DB::getInstance();
    }


    public static function GetUserByName($usuario)
    {
       $db = DB::getInstance();
        $user = $db->ASPNETUsers->findOne(array("Username" => $usuario));

       return $user;
    }

    public static function GetUserById($id)
    {
        $db = DB::getInstance();
        $user = $db->ASPNETUsers->findOne(array("_id" => $id));

       return $user;
    }

    public static function ValidateUser($usuario, $senha)
    {
            $userOK = false;
            $db = DB::getInstance();

            $user = $db->ASPNETUsers->findOne(array("Username" => $usuario));
            if(!empty($user))
            {

              if($user['IsApproved'] == true)
              {

            $hashed_password = $user['Password'];
            $password_salt = $user['Salt'];
            $bytes = mb_convert_encoding($senha, 'UTF-16LE');
            $salt = base64_decode($password_salt);
            $password = base64_encode(sha1($salt . $bytes, true));

            if ($password == $hashed_password)
              $userOK = true;
            }
          }

          return $userOK;
    }

    public static function CreateUser($usuario, $senha)
    {
            $userOK = false;
            $db = DB::getInstance();

            $user = $db->ASPNETUsers->findOne(array("Username" => $usuario));
            if(!empty($user))
            {

              if($user['IsApproved'] == true)
              {

            $hashed_password = $user['Password'];
            $password_salt = $user['Salt'];
            $bytes = mb_convert_encoding($senha, 'UTF-16LE');
            $salt = base64_decode($password_salt);
            $password = base64_encode(sha1($salt . $bytes, true));

            if ($password == $hashed_password)
              $userOK = true;
            }
          }

          return $userOK;
    }

}
