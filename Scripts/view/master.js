
function MasterCtrl($scope, $http) {

  $scope.username = '';
  $scope.isAdmin = false;

  $scope.init = function() {
    if (stringIsNullOrEmpty(_token))
      window.location = "/login";

    $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/login/GetNomePessoaCurrentUser',
      headers: {
        'Authorization': _token,
      }
    }).success(function(data, status) {
      $scope.username = JSON.parse(data);

      $http({
        method: 'GET',
        contentType: 'application/json; charset=utf-8',
        dataType: "json",
        url: '/api/login/CurrentUserIsAdmin'
      }).success(function(data, status) {
        if (data == true)
          $scope.isAdmin = true;
      });
    });
  }

  $scope.logout = function() {
    $http({
      method: 'GET',
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      url: '/api/logout'
    }).success(function(data, status) {
      _token = '';
      window.location = "/login";
    });
  }

  $scope.init();
}
