/* 
 * Reppier management system
 * Design and code - M82.eu
 */

var RegisterController = mainModule.controller("RegisterController", ["$scope", function ($scope) {

    }]);

RegisterController.directive("registerForm", function(){
    return {
        templateUrl: "../views/register.html"
    };
});
