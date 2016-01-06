
function MeuPerfilCtrl($scope, $http) {

  $scope.tipoComprovante = 'identidade';
  $scope.pessoa = new Object();
  $scope.arquivos = [];

  $scope.init = function() {
    $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/pessoa/Get',
      headers: {
        'Authorization': _token,
      }
    }).success(function(data, status) {
      console.log('Buscou user');
      $scope.pessoa = data;
      $scope.tipoComprovanteChange();
      $scope.buscaArquivos();

    });
  }

  $scope.salvar = function() {
    $("#bntSalvar").prop("disabled", true);
    $("#bntSalvar").val("Salvando...");
    $http({
      method: 'POST',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/pessoa/Save',
      headers: {
        'Authorization': _token,
      },
      data: {
        pessoa: $scope.pessoa
      }
    }).success(function(data, status) {
      console.log(data);
      $("#bntSalvar").prop("disabled", false);
      $("#bntSalvar").val("Salvar");
      $("#msgSucesso").fadeIn(1500).delay(3000).fadeOut(500);
    });
  }

  $scope.buscaArquivos = function() {
    $http({
      method: 'GET',
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      url: '/api/arquivo/GetAllFilesPerfil',
      headers: {
        'Authorization': _token,
      }
    }).success(function(data, status) {
      console.log('Buscou Files');
      $scope.arquivos = data;
    });
  }

  $scope.tipoComprovanteChange = function() {
    $('#fileUploadArquivos').fileupload({
      url: '/arquivo/save/' + $scope.tipoComprovante,
      dataType: 'json',
      pasteZone: null,
      done: function(e, data) {
        //console.log(e.responseText);
        console.log(data.result);
        if (data.result == true) {
          $scope.buscaArquivos();
          $('#spanMsgSucessoFile').fadeIn(1500).delay(5000).fadeOut(500);
        } else
          alert(data.result);
      },
      error: function(e, data) {
        alert("Erro ao fazer o upload do arquivo. Somente arquivos .jpg, .png e .pdf podem ser anexados.");
      }
    });
  }

  $scope.baixarArquivo = function(id) {

    var url = '/arquivo/get/' + id;
    downloadFile(guid(), url);
  }

  $scope.init();
}
