(function() {
  'use strict';
  var app = angular.module('users_management', [
    'ngRoute',
    'users_management.list_student',
    'users_management.edit_student',
    'users_management.delete_student',
    'users_management.login'
  ]);
  
  app.config(function($routeProvider) {
    $routeProvider
      .otherwise({
        redirectTo: '/'
      });
  });
  app.run(function($rootScope, $location, auth) {
    $rootScope.$on('$routeChangeStart', function(event, next, current) {
        if(next.loginRequire && !auth.checkAuth()){
            $location.path("/login");
        }
      });
  });

}());