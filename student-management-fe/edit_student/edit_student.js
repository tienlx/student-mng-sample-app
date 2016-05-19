(function() {
'use strict';
  var EditStudentController = function($scope, $http, $routeParams, $location, students, auth) {
    var
      student_id = $routeParams.student_id,
      onSuccessFindStudent = function (data) {
        $scope.student_info = data.data.data;
      },
      onErrorFindStudent = function (data) {
        alert("Error: " + data.data.message);
      };
    students.findStudent(student_id, onSuccessFindStudent, onErrorFindStudent);

    
    $scope.editStudent = function() {
      var onSuccessEditStudent = function (data) {
        alert("Success: " + data.data.data);
        $scope.student_info = {}; // reset student_info
        $location.path('/');
      };
      var onErrorEditStudent = function (data) {
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
      students.editStudent(student_id, student, onSuccessEditStudent, onErrorEditStudent);

    };
  };
  angular.module('users_management.edit_student', ['ngRoute', 'users_management.student_service'])

  .config(['$routeProvider', function($routeProvider) {
    $routeProvider.when('/edit/:student_id', {
      templateUrl: 'edit_student/edit_student.html',
      controller: 'EditStudentController',
      loginRequire: true
    });
  }])
  
  .controller('EditStudentController', ['$scope', '$http', '$routeParams', '$location', 'students', 'auth', EditStudentController]);
}());