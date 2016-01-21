
function InstituicoesListCtrl($scope, $http) {
  $scope.init = function() {
    var httpRequest = $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/instituicao/GetAll',
      headers: {
        'Authorization': _token,
      }
    }).success(function(data, status) {
      $scope.instituicoes = data;
      console.log(data);

      $('#tableInstituicoes').paginartable({
        tamPagina: 10
      });
    });
  }

  $scope.editItem = function(id) {
    window.location = "#/instituicoes/edit/" + id;
  }

  $scope.novo = function() {
    window.location = "#/instituicoes/edit";
  }

  $scope.excluirItem = function(id) {
    var httpRequest = $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/instituicao/Excluir/' + id,
      headers: {
        'Authorization': _token,
      }
    }).success(function(data, status) {
      if (data != "true")
        alert(data);
        $scope.init();
    });
  }

  $scope.init();

}

function InstituicoesEditCtrl($scope, $http, $routeParams) {

  $scope.instituicao = new Object();

  var id = $routeParams.Id;

  $scope.init = function() {
    $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/instituicao/Get/' + id,
      headers: {
        'Authorization': _token,
      }
    }).success(function(data, status) {
      console.log("Buscou instituicao");
      console.log(data);

      $scope.instituicao = data;
    });
  }

  $scope.save = function() {
    $http({
      method: 'POST',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/instituicao/Save',
      headers: {
        'Authorization': _token,
      },
      data: {
        instituicao: $scope.instituicao
      }
    }).success(function(data, status) {
      console.log(data);
      if (data == "ERRO")
        alert("Ocorreu um erro ao salvar este item, tente novamente em alguns instantes.");
      else
      {
        $("#msgSucesso").fadeIn(1500).delay(3000).fadeOut(500);
        window.location = "#/instituicoes/edit/" + JSON.parse(data);
      }
    });
  }

  $scope.voltar = function() {
    window.location = "#/instituicoes/list";
  }

  $scope.init();
}
