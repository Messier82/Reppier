/* 
 * Reppier management system
 * Design and code - M82.eu
 */
mainModule.factory("Session",
        function ($http, $cookies) {
            var session_id = 'dasd';
            return {
                logged: function () {
                    console.log('dadad');
                    session_id = $cookies.get("session_id");
                    var data = {'session_id': session_id};
                    $http({
                        url: "./api/user/logged",
                        method: "GET",
                        params: data
                    }).success(function (data) {
                        console.log(data);
                    });
                }
            }
        });