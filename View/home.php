<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="pt-BR">

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>Sistema AET</title>
  <!-- Core CSS - Include with every page -->
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
  <!-- SB Admin CSS - Include with every page -->
  <link href="/css/sb-admin.css" rel="stylesheet">
  <!-- Custom CSS - Include with every page -->
  <link href="/css/autocomplete.css" rel="stylesheet">
  <link href="/css/datepicker.css" rel="stylesheet">
  <link href="/css/modal.css" rel="stylesheet">

  <!-- Core Scripts - Include with every page -->
  <script src="/js/jquery-1.10.2.js"></script>
  <script src="/js/bootstrap.min.js"></script>
  <script src="/js/plugins/metisMenu/jquery.metisMenu.js"></script>

  <!-- SB Admin Scripts - Include with every page -->
  <script src="/js/sb-admin.js"></script>

  <!-- Custom Scripts - Include with every page -->
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.19/angular.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.19/angular-route.js"></script>
  <script type="text/javascript" src="/Scripts/utils/downloadFile.js"></script>
  <script type="text/javascript" src="/Scripts/utils/helpers.js?v=1451931154"></script>
  <script type="text/javascript" src="/Scripts/utils/app.js?v=1451931160"></script>

  <script src="/Scripts/utils/alertExtend.js"></script>
  <script src="/Scripts/utils/angularMethods.js"></script>
  <script src="/Scripts/utils/bootstrap-datepicker.js"></script>
  <script src="/Scripts/utils/jquery.autocomplete.js"></script>
  <script src="/Scripts/utils/jquery.maskedinput.min.js"></script>
  <script src="/Scripts/utils/modalpopup.js"></script>
  <script src="/Scripts/utils/tablePagination.js"></script>

  <script src="/js/jquery.cookie.js"></script>

  <!-- MASTER SCRIPT -->
  <script type="text/javascript" src="/Scripts/view/master.js?v=1451931154"></script>

  <?php
      require_once "token.php";
     ?>
</head>

<body>
  <div ng-app="aet">
    <div id="wrapper">
      <?php
          require_once 'View/nav.php';
        ?>
        <div id="page-wrapper">
          <div ng-view>
          </div>
        </div>
        <h5>Criado por :
          <br/> Gilvani Schneider
          <br/> Guilherme M. P. Silva
          <br/> Marco A. Brand
        </h5>
    </div>
    <!-- /#wrapper -->
  </div>

</body>

</html>
