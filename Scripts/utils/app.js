
var app = angular.module('aet', ['ngRoute']);


app.filter('date', function($filter) {
  return function(input) {
    if (input == null) {
      return "";
    }

    var _date = $filter('date')(new Date(input), 'dd/MM/yyyy');

    return _date.toUpperCase();

  };
});

app.config(function($routeProvider, $locationProvider) {
  $routeProvider
    .when('/meuperfil', {
      templateUrl: '/View/perfil.html'
    })
    .when('/auxilio', {
      templateUrl: '/View/meusauxilios.html'
    })
    .when('/semestres/list', {
      templateUrl: '/View/Semestres/list.html'
    })
    .when('/semestres/edit', {
      templateUrl: '/View/Semestres/edit.html'
    })
    .when('/semestres/edit/:Id', {
      templateUrl: '/View/Semestres/edit.html'
    })
    //.when('/Book/:bookId/ch/:chapterId', {
    //templateUrl: 'chapter.html',
    //controller: 'ChapterController'
    //});

  // configure html5 to get links working on jsfiddle
  $locationProvider.html5Mode(false);
});

app.config(function($provide, $httpProvider) {
  $provide.factory('AjaxHttpInterceptor', function($q, $injector) {
    return {
      // Não faça nada
      request: function(config) {
        return config || $q.when(config);
      },

      // Erro ao criar a request
      requestError: function(rejection) {
        return $q.reject(rejection);
      },

      //Não faça nada deu tudo certo
      response: function(response) {
        return response || $q.when(response);
      },

      // Aqui o bicho pega, se der erro refaz a conexão com um novo token
      responseError: function(rejection) {
        if (rejection.status == 401) {
          window.location = "/login";
        }

        // Se não for possivel refazer a conexão retorna o erro
        return $q.reject(rejection);
      }
    };
  });

  $httpProvider.interceptors.push('AjaxHttpInterceptor');

});



var _id = window.location.pathname.toString().getRotaID();
var _query = window.location.toString().getQueryString();

var _baseURL = "";
