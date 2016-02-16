/* 
 * Reppier management system
 * Design and code - M82.eu
 */
var LoginController = mainModule.controller("LoginController",
        function ($scope, $http, $cookies, Login, $location, $timeout, Session) {
            Login.hideSigninButton();
            $scope.$on("$destroy", function () {
                Login.showSigninButton();
            });

            $scope.login = function (data) {
                if (!$("#signinForm").valid()) {
                    return false;
                }
                $http({
                    url: "./api/user/login",
                    method: "GET",
                    params: data
                }).success(function (data) {
                    if (data['status'] === 'success') {
                        $cookies.put("session_id", data['session_id']);
                        $("#loginMessage .card-content").html("You have successfully signed in. You will be redirected to main page shortly.");
                        $("#loginMessage").addClass("green").show();
                        $("#loginCard").hide();
                        Session.updateSession();
                        $timeout(function () {
                            $location.path("/home");
                        }, 5000);
                    } else if (data['status'] === "error") {
                        $("#loginMessage .card-content").html("Error occured during authorization.");
                        $("#loginMessage").addClass("red").show();
                    }
                });
            };

            $scope.timeoutRedirect = function () {
                $location.path("/home");
            };

            $scope.logout = function () {
                $cookies.put("session_id", null);
                Session.updateSession();
            };

            $scope.$on("refresh", function () {
                $scope.$apply;
            });

            initLoginValidate();
        });

function initLoginValidate() {
    $("#signinForm").validate({
        rules: {
            "email": {
                required: true,
                maxlength: 30
            },
            "password": {
                required: true,
                maxlength: 50
            }
        },
        success: function (label, element) {
            $(element).addClass("valid").removeClass("invalid");
        },
        errorPlacement: function (error, element) {
            $(element).removeClass("valid").addClass("invalid").next().attr("data-error", error.text());
        },
        /*Validation triggers fix*/
        onfocusout: function (element) {
            this.element(element);
        }
    });
}

mainModule.factory("Login", function () {
    return {
        showSigninButton: function () {
            $(".accountPanel .notlogged").css({"opacity": "1", "visibility": "visible"});
        },
        hideSigninButton: function () {
            $(".accountPanel .notlogged").css({"opacity": "0", "visibility": "hidden"});
        }
    };
});