/* 
 * Reppier management system
 * Design and code - M82.eu
 */
var LoginController = mainModule.controller("LoginController", ["$scope", "$http", "Login",
    function ($scope, $http, Login) {
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

            });
        };

        initLoginValidate();
    }]);

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
            $(".accountPanel").css({"opacity": "1", "visibility": "visible"});
        },
        hideSigninButton: function () {
            $(".accountPanel").css({"opacity": "0", "visibility": "hidden"});
        }
    };
});