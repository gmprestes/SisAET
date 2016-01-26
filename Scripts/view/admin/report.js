
function ReportAlunosCtrl($scope, $http) {

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
      $scope.semestres = data;
      $scope.SemestreId = data[0]._id;
    });
  }

  $scope.baixar = function() {
      var url = '/report/alunos/' + $scope.SemestreId;
      downloadFile(guid(), url);
  }

  $scope.init();
}
