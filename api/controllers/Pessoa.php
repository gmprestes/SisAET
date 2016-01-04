<?php

require_once '../db.php';

class Pessoa
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
     * @url GET /pessoa/Get
     *
     */
    public function Get()
    {
          $db = DB::getInstance();
          $user = $db->DtoPessoa->findOne(array("UserId" => $_SESSION["userid"]));

          if(!empty($user)) {
            $user["DataNascimento"] = date('d/m/Y', $user["DataNascimento"]->sec);
            return $user;
          }
          else {
            return '';
          }
    }

}
?>
