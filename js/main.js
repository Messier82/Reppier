/* 
 * Reppier management system
 * Design and code - M82.eu
 */
//If this var set to true, then hashtag from url will be removed
//BUT this requires active htaccess rules, that are already written
//And I made this, cuz GitHub Pages does not support htaccess files :/
var removeHashtagFromUrl = false;

var mainModule = angular.module('Reppier', ['ngRoute', 'angular-loading-bar', 'ngAnimate']);

mainModule.config(["$routeProvider", "$locationProvider", function ($routeProvider, $locationProvider) {
    $routeProvider
            .when("/", {
                redirectTo: "/home"
            })
            .when("/home", {
                templateUrl: "./views/home.html"
            })
            .when("/register", {
                templateUrl: "./views/register.html",
                controller: "RegisterController"
            })
            .when("/login", {
                templateUrl: "./views/login.html",
                controller: "LoginController"
            });
    if (window.history && window.history.pushState && removeHashtagFromUrl) {
        $locationProvider.html5Mode({
            enabled: true,
            requireBase: false
        });
    }
}]);

mainModule.config(['cfpLoadingBarProvider', function (cfpLoadingBarProvider) {
        cfpLoadingBarProvider.includeBar = false;
        cfpLoadingBarProvider.spinnerTemplate = '<div class="loading-bar-spinner z-depth-2"><svg class="spinner" width="30px" height="30px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg></div>';
    }]);

$(document).ready(function () {
    $('.parallax').parallax();
    jQuery.extend(jQuery.validator.messages, {
        required: " "
    });
});