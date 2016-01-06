<?php
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }
   echo '<script>';
   if (isset($_SESSION['synctoken']) && !empty($_SESSION['synctoken'])) {
       echo 'var _token = "'.$_SESSION['synctoken'].'"';
   } else {
       header('Location: /login');
       die();
   }
   echo '</script>';
