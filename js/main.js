/* 
 * Reppier management system
 * Design and code - M82.eu
 */
var mainModule = angular.module('Reppier', ['ngRoute', 'angular-loading-bar', 'ngAnimate']);

mainModule.config(function ($routeProvider) {
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
});

mainModule.config(['cfpLoadingBarProvider', function (cfpLoadingBarProvider) {
                cfpLoadingBarProvider.includeBar = false;
                cfpLoadingBarProvider.spinnerTemplate = '<div class="loading-bar-spinner z-depth-2"><svg class="spinner" width="30px" height="30px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg></div>';
            }]);

$(document).ready(function () {
    $('.parallax').parallax();
});