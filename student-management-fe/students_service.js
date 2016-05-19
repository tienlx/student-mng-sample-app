(function() {
  'use strict';
  var StudentsService = function($http, auth) {
    var host = 'http://localhost/student-management/public';
    var onDefaultError = function (data) {
        var error_str = '';
        angular.forEach(data.data.message, function(value, key){
          error_str = error_str + '\n' + key + ": " + value;
        });
        alert("Error: " + error_str);
      };

    var getStudents = function(onSuccess, onError) {
      $http({
        method: 'GET',
        url: host + '/students'
      }). then (onSuccess, onError);
    };

    var findStudent = function(student_id, onSuccess, onError) {
      $http({
        method: 'GET',
        url: host + '/students/' + student_id + '?access_token=' + auth.getAccessToken()
      }). then (onSuccess, onError);
    };

    var addStudent = function(student, onSuccess, onError) {
      $http({
        method: 'POST',
        url: host + '/students',
        data: student
      }). then (onSuccess, onError);
    };

    var editStudent = function(student_id, student, onSuccess, onError) {
      $http({
        method: 'PUT',
        url: host + '/students/' + student_id,
        data: student
      }). then (onSuccess, onError);
    };  

    var deleteStudent = function(student_id, onSuccess, onError) {
      $http({
        method: 'DELETE',
        url: host + '/students/' + student_id,
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        transformRequest: function(obj) {
            var str = [];
            for(var p in obj)
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
            return str.join("&");
        },
        data: {
          'access_token': auth.getAccessToken()
        }
      }). then (onSuccess, onError);
    };  

    return {
      getStudents: getStudents,
      findStudent: findStudent,
      addStudent: addStudent,
      editStudent: editStudent,
      deleteStudent: deleteStudent
    };
  };
  angular.module('users_management.student_service', ['users_management.auth_service'])
  .service('students', ['$http', 'auth',  StudentsService]);
}());