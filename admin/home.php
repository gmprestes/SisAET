<?php

  require 'db.php';

 ?>

  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
  <html lang="pt-BR">

  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Sistema AET</title>
    <?php
      require 'admin/head.php';
     ?>
  </head>

  <body>
    <div ng-app="aet">
      <div id="wrapper">
        <?php
          require 'admin/nav.php';
        ?>
      <div id="page-wrapper">
            <div ng-view>
            </div>


        </div>
        <h5>Criado por :
          <br/>
          Gilvani Schneider
          <br/>
          Guilherme M. P. Silva
          <br/>
          Marco A. Brand
        </h5>
      </div>
      <!-- /#wrapper -->
    </div>

  </body>

  </html>
