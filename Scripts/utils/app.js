
var app = angular.module('aet', ['ngRoute']);

app.config(function($routeProvider, $locationProvider) {
  $routeProvider
    .when('/meuperfil', {
      templateUrl: '/View/perfil.html'
    })
    .when('/auxilio', {
      templateUrl: '/View/meusauxilios.html'
    })
    //.when('/Book/:bookId/ch/:chapterId', {
    //templateUrl: 'chapter.html',
    //controller: 'ChapterController'
    //});

  // configure html5 to get links working on jsfiddle
  $locationProvider.html5Mode(false);
});

var _id = window.location.pathname.toString().getRotaID();
var _query = window.location.toString().getQueryString();

var _baseURL = "";
