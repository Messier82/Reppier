/* 
 * Reppier management system
 * Design and code - M82.eu
 */
mainModule.factory("Session", function ($http, $cookies, $q) {
    var sessionId = null;
    var bLogged = false;
    return {
        sessionId: sessionId,
        bLogged: bLogged,
        isLogged: function () {
            if (sessionId !== null) {
                return true;
            }
            this.updateSession();
        },
        updateSession: function () {
            sessionId = $cookies.get("session_id");
            var data = {'session_id': sessionId};
            var defer = $q.defer();
            $http({
                url: "./api/user/logged",
                method: "GET",
                params: data
            }).then(function (response) {
                var data = response.data;
                sessionId = (data.logged) ? data.logged : false;
                if (sessionId) {
                    $cookies.put("session_id", sessionId);
                }
                defer.resolve((data.logged) ? true : false);
            });
            return defer.promise;
        }
    }
});