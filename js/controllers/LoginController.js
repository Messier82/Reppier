/* 
 * Reppier management system
 * Design and code - M82.eu
 */
var LoginController = mainModule.controller("LoginController", ["$scope", "Login",
    function ($scope, Login) {
        Login.hideSigninButton();
        $scope.$on("$destroy", function () {
            Login.showSigninButton();
        });
    }]);

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