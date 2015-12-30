
function LoginCtrl($scope, $http) {

  $scope.nome = "";
  $scope.senha = "";

  var nome = $.QueryString["n"];

  if (!stringIsNullOrEmpty(nome))
    $scope.nome = nome;

  $scope.auth = function() {

    if (stringIsNullOrEmpty($scope.nome)) {
      $("#txtNome").addClass("has-error");
      return;
    }

    if (stringIsNullOrEmpty($scope.senha)) {
      $("#txtPass").addClass("has-error");
      return;
    }

    $('#btnLogin').text("Pocessando...");
    $('#btnLogin').prop("disabled", true);

    var httpRequest = $http({
      method: 'POST',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/login/Auth',
      data: {
        usuario: $scope.nome,
        senha: $scope.senha
      }
    }).success(function(data, status) {
      console.log(data);
      if (data == "true")
        window.location = "/meuperfil";
      else {
        $("#txtNome").addClass("has-error");
        $("#txtPass").addClass("has-error");

        alert("Usuario ou senha invalidos");
      }

      $('#btnLogin').prop("disabled", false);
      $('#btnLogin').text("Login");

    });
  }

}
