(function() {
  'use strict';
  var DeleteStudentController = function($scope, $http, $routeParams, $location, students) {
    var
      student_id = $routeParams.student_id,
      onSuccessFindStudent = function (data) {
        $scope.student_info = data.data.data;
      },
      onErrorFindStudent = function (data) {
        alert("Error: " + data.data.message);
      };
    students.findStudent(student_id, onSuccessFindStudent, onErrorFindStudent);

    $scope.deleteStudent = function() {
      var onSuccessDeleteStudent = function (data) {
        alert("Success: " + data.data.data);
        $location.path('/');
      };
      var onErrorDeleteStudent = function (data) {
        var error_str = '';
        angular.forEach(data.data.message, function(value, key){
          error_str = error_str + '\n' + key + ": " + value;
        });
        alert("Error: " + error_str);
      };
      students.deleteStudent(student_id, onSuccessDeleteStudent, onErrorDeleteStudent);
    };
  };
  angular.module('users_management.delete_student', ['ngRoute', 'users_management.student_service'])

  .config(['$routeProvider', function($routeProvider) {
    $routeProvider.when('/delete/:student_id', {
      templateUrl: 'delete_student/delete_student.html',
      controller: 'DeleteStudentController',
      loginRequire: true
    });
  }])
  
  .controller('DeleteStudentController', ['$scope', '$http', '$routeParams', '$location', 'students', DeleteStudentController]);
}());