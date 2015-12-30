<?php

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
     * @url GET /login/GetNomePessoaCurrentUser
     *
     */
    public function GetNomePessoaCurrentUser()
    {
        $user = ASPNETUser::GetUserById($_SESSION["userid"]);
        if(!empty($user))
        {
          return $user["Username"];
        }
        else
          return '';
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

}
?>
