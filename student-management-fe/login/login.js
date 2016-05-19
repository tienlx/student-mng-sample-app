(function() {
	'use strict';
	var LoginController = function($scope, $http, $routeParams, $location, auth) {
		var onSuccess = function (response) {
			auth.setAccessToken(response.data.access_token);
			auth.setAuth();
			$location.path('/');
		};

		var onError = function (response) {
			var error_str = response.data.error_description;
	        alert("Error: " + error_str);
		};

		$scope.login = function () {
			var login_info = {
				'grant_type': 'password',
				'client_id': 'id1',
				'client_secret': 'secret1',
				'username': $scope.username,
				'password': $scope.password,
			}
			auth.login(login_info, onSuccess, onError);
		};
	};
	angular.module('users_management.login', ['ngRoute'])

	.config(['$routeProvider', function($routeProvider) {
		$routeProvider.when('/login', {
			templateUrl: 'login/login.html',
			controller: 'LoginController'
		});
	}])

	.controller('LoginController', [ '$scope', '$http', '$routeParams', '$location', 'auth', LoginController]);
})();