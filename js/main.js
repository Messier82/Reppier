/* 
 * Reppier management system
 * Design and code - M82.eu
 */
var mainModule = angular.module('Reppier', ['ngRoute']);

mainModule.config(function ($routeProvider) {
    $routeProvider
            .when("/", {
                redirectTo: "/home"
            })
            .when("/home", {
                templateUrl: "./views/home.html"
            })
            .when("/register", {
                templateUrl: "./views/register.html"
            });
});

$(document).ready(function () {
    $('.parallax').parallax();
    $('ul.tabs').tabs();
});