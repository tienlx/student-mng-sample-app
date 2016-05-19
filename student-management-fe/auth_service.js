(function() {
  'use strict';
  var AuthService = function ($http) {
    var host = 'http://localhost/student-management/public';
    var is_authenticated = false;
    var access_token = '';

    var checkAuth = function () {
     return is_authenticated;
   };

   var getAccessToken = function () {
     if (is_authenticated) {
      return access_token;	
    }
    return false;
  };  	

  var login = function (login_info, onSuccess, onError) {
   $http({
    method: 'POST',
    url: host + '/oauth/access_token',
    data: login_info
  }). then (onSuccess, onError);
 };

 var setAccessToken = function (data_access_token) {
   access_token = data_access_token;
 };

 var setAuth = function () {
   is_authenticated = true;
 };
 var logout = function () {
   is_authenticated = false;
   access_token = '';
 };

 return {
   checkAuth: checkAuth,
   getAccessToken: getAccessToken,
   setAccessToken: setAccessToken,
   setAuth: setAuth,
   login: login,
   logout: logout
 }
};

angular.module('users_management.auth_service', ['ngRoute'])
.service('auth', ['$http', AuthService]);
}());