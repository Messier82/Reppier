/* 
 * Reppier management system
 * Design and code - M82.eu
 */
mainModule.factory('Page', function () {
    var title = 'Def Title';
    return {
        title: function () {
            return title;
        },
        setTitle: function (newTitle) {
            return title = newTitle;
        }
    };
});

var MainController = mainModule.controller('MainController', ['$scope', 'Page',
    function ($scope, Page) {
        $scope.Page = Page;
    }]);

MainController.directive("navBar", function(){
    return {
        restrict: 'E',
        templateUrl: "./views/navbar.html"
    };
});