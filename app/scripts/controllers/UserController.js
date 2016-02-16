/* 
 * Reppier management system
 * Design and code - M82.eu
 */
mainModule.controller("UserController",
        function ($scope, $http, Session) {
            $scope.data;
            $scope.GetUserData = function(userId) {
                var data = {"session_id":Session.sessionId};
                $http({
                    url: "./api/user/getdata",
                    method: "GET",
                    params: data
                }).then(function(response){
                    $scope.data = response.data.data;
                });
            };
            $scope.GetUserData();
        });