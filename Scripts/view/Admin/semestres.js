
var _id = window.location.pathname.toString().getRotaID();

function SemestresListCtrl($scope, $http) {
  $scope.init = function() {
    $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: 'api/semestre/GetAll',
      headers: {
        'Authorization': _token,
      }
    }).success(function(data, status) {
      console.log("Buscou semestres");
      $scope.semestres = data;

      $('#tableSemestres').paginartable({
        tamPagina: 10
      });
    });
  }

  $scope.editItem = function(id) {
    window.location = "#/semestres/edit/" + id;
  }

  $scope.novo = function() {
    window.location = "#/semestres/edit/";
  }

  $scope.excluirItem = function(id) {
    $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/semestre/Excluir/' + id,
      headers: {
        'Authorization': _token,
      }
    }).success(function(data, status) {
      if (data != true) {
        alert(data);
        $scope.init();
      }
    });
  }

  $scope.init();
}

function SemestresEditCtrl($scope, $http, $routeParams) {

  //var id = "";
  //if ($routeParams.Id)
  var id = $routeParams.Id;

  $scope.semestre = new Object();

  $scope.init = function() {
    $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/semestre/Get/' + id,
      headers: {
        'Authorization': _token,
      }
    }).success(function(data, status) {
      console.log("Buscou semestre");
      console.log(data);
      $scope.semestre = data;
    });
  }


  $scope.saveSemestre = function() {
    $http({
      method: 'POST',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/semestre/Save',
      headers: {
        'Authorization': _token,
      },
      data: {
        semestre: $scope.semestre
      }
    }).success(function(data, status) {
      if (data == "ERRO")
        alert("Ocorreu um erro ao salvar este item, tente novamente em alguns instantes.");
      else
        window.location = "#/semestres/edit/" + JSON.parse(data);
    });
  }

  $scope.voltar = function() {
    window.location = "/semestres/list";
  }

  $scope.init();
}
