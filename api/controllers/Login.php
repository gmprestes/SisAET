<?php

require_once '../db.php';
require_once '../Models/ASPNETUser.php';

class Login
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
         * @url GET /
         * @noAuth
         */
        public function Wellcome()
        {
          return "Bem vindo a API da AET";
        }

    /**
     * @url GET /login/GetNomePessoaCurrentUser
     */
    public function GetNomePessoaCurrentUser()
    {
        $db = DB::getInstance();
        $user = $db->DtoPessoa->findOne(array("UserId" => $_SESSION["userid"]));
        if(!empty($user))
        {
          return $user["Nome"];
        }
        else
          return '';
    }

    /**
     * @url GET /login/CurrentUserIsAdmin
     */
    public function CurrentUserIsAdmin()
    {
        $user = ASPNETUser::GetUserById($_SESSION["userid"]);
        if(!empty($user))
        {
          return $user["Comment"] == "ADMIN";
        }
        else
          return false;
    }

    /**
     * @url POST /login/Auth
     * @noAuth
     */
    public function Autenticar($data)
    {
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }

      $usuario = $data->usuario;
      $senha =  $data->senha;

      if(ASPNETUser::ValidateUser($usuario, $senha) == true)
      {
        $_SESSION["synctoken"] = uniqid();
        $_SESSION["userid"] = ASPNETUser::GetUserByName($usuario)['_id'];
        return true;
      }
      else {
        $_SESSION["synctoken"] = '';
        $_SESSION["userid"] = '';
        return false;
      }


    }

    /**
     * @url GET /logout
     * @noAuth
     */
    public function Sair()
    {
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }

      $_SESSION["synctoken"] = '';
      $_SESSION["userid"] = '';

      return true;
    }

    /**
     * @url POST /login/AlterarSenha
     */
    public function AlterarSenha($data)
    {
      $user = ASPNETUser::GetUserById($_SESSION["userid"]);

      if(ASPNETUser::ValidateUser($user["Username"], $data->atual) == true)
      {
        ASPNETUser::AlterarSenha($user["Username"], $data->nova);

        $_SESSION["synctoken"] = '';
        $_SESSION["userid"] = '';

        return array(true, $user["Username"]);
      }
      else
        return array(false, "");
    }

}
?>
