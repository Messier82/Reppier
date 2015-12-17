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
            this.updateSessionId();
            if (this.sessionId !== null) {
                return;
            }
            this.updateSession();
        },
        updateSession: function () {
            var s = this;
            sessionId = $cookies.get("session_id");
            var data = {'session_id': sessionId};
            var defer = $q.defer();
            $http({
                url: "./api/user/logged",
                method: "GET",
                params: data
            }).then(function (response) {
                var data = response.data;
                s.sessionId = (data.logged) ? data.logged : null;
                if (s.sessionId) {
                    $cookies.put("session_id", s.sessionId);
                }
                s.bLogged = (data.logged) ? true : false;
                defer.resolve((data.logged) ? true : false);
            });
            return defer.promise;
        },
        updateSessionId: function() {
            this.sessionId = $cookies.get("session_id");
        }
    }
});