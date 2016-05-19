(function() {
  'use strict';
  var ListStudentController = function($scope, $http, $route, students, auth) {
    var onSuccessGetStudents = function (data) {
      $scope.students = data.data.data;
    }
    var onErrorGetStudents = function (data) {
      alert("Error: " + data.data.message);
    }
    students.getStudents(onSuccessGetStudents, onErrorGetStudents);

    $scope.student_info = {};
    $scope.is_authenticated = auth.checkAuth();
    $scope.order_options = [
      {name: "Name - Ascending", value:"+name"},
      {name: "Name - Descending", value:"-name"},
      {name: "Email address - Ascending", value:"+address"},
      {name: "Email address - Descending", value:"-address"}
    ];



    $scope.addStudent = function() {
      var onSuccessAddStudent = function (data) {
        alert("Success: " + data.data.data);
        students.getStudents(onSuccessGetStudents, onErrorGetStudents);
        $scope.student_info = {}; // reset student_info
      };
      var onErrorAddStudent = function (data) {
        var error_str = '';
        angular.forEach(data.data.message, function(value, key){
          error_str = error_str + '\n' + key + ": " + value;
        });
        alert("Error: " + error_str);
      };
      var student = {
        name: $scope.student_info.name,
        phone: $scope.student_info.phone,
        address: $scope.student_info.address,
        career: $scope.student_info.career,
        access_token: auth.getAccessToken()
      };
      students.addStudent(student, onSuccessAddStudent, onErrorAddStudent);
    };

    $scope.logout = function () {
      if (confirm("Do you want to logout?") == true) {
          auth.logout();
          $route.reload();
      }
      return false;
    };
  };
  angular.module('users_management.list_student', [
    'ngRoute',
    'users_management.student_service',
    'users_management.auth_service'
  ])

  .config(['$routeProvider', function($routeProvider) {
    $routeProvider.when('/', {
      templateUrl: 'list_student/list_student.html',
      controller: 'ListStudentController'
    });
  }])
  
  .controller('ListStudentController', ['$scope', '$http', '$route', 'students', 'auth', ListStudentController]);
}());
