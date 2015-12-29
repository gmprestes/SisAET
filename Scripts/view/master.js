function MasterCtrl($scope, $http) {

    $scope.username = '';
    $scope.isAdmin = false;

    $scope.init = function () {
        $http({
            method: 'GET',
            contentType: 'application/json; charset=utf-8',
            dataType: "json",
            url: '/api/login/GetNomePessoaCurrentUser'
        }).success(function (data, status) {
            $scope.username = data;

            $http({
                method: 'GET',
                contentType: 'application/json; charset=utf-8',
                dataType: "json",
                url: '/api/login/CurrentUserIsAdmin'
            }).success(function (data, status) {
                if (data == 'True')
                    $scope.isAdmin = true;
            });
        });
    }

    $scope.logout = function () {
        $http({
            method: 'GET',
            contentType: 'application/json; charset=utf-8',
            dataType: "json",
            url: '/api/login/Logout'
        }).success(function (data, status) {
            window.location = _baseURL + "/meuperfil";
        });
    }

    //$scope.init();
}
