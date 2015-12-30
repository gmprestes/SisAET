<?php

require_once '../Models/ASPNETUser.php';

class Login
{
    /**
     * @url GET /login/GetNomePessoaCurrentUser
     */
    public function GetNomePessoaCurrentUser()
    {
        session_start( );
        if (isset($_SESSION['synctoken']))
        return  $_SESSION["synctoken"];
        else {
        $_SESSION["synctoken"] = "heaheh";
          return  $_SESSION["synctoken"];
        }
    }

    /**
     * @url POST /login/Auth
     */
    public function Autenticar($data)
    {
      $usuario = $data->usuario;
      $senha =  $data->senha;

      session_start( );
      if(ASPNETUser::ValidateUser($usuario, $senha) == true)
      {
      $_SESSION["synctoken"] = uniqid();
      $_SESSION["userid"] = ASPNETUser::GetUser($usuario)['_id'];
      return true;
    }
    else {
      $_SESSION["synctoken"] = '';
      $_SESSION["userid"] = '';
      return false;
    }


    }

}
?>
