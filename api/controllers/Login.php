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
      $h = ASPNETUser::ValidateUser($usuario, $senha);
      if($h == true)
      {
      $_SESSION["synctoken"] = uniqid();
      return $h;
    }
    else {
      $_SESSION["synctoken"] = '';
      return $h;
    }


    }

}
?>
