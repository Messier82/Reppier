/* 
 * Reppier management system
 * Design and code - M82.eu
 */
mainModule.factory('Page', function () {
    var title = 'Home';
    var siteTitle = 'Reppier';
    var navbarTitle = 'Home';
    return {
        title: function () {
            return title + " - " + siteTitle;
        },
        setTitle: function (newTitle) {
            title = newTitle;
        },
        navbarTitle: function () {
            return navbarTitle;
        },
        setNavbarTitle: function (newTitle, isPageInMenu) {
            $(".currentPage").removeClass("projectTitle");
            if (isPageInMenu) {
                navbarTitle = 'Reppier';
                $(".currentPage").addClass("projectTitle");
            } else {
                navbarTitle = newTitle;
            }
        },
        showImageBar: function () {
            $("#imageBar").show();
            $("#content").css("margin-top", "-80px");
        },
        hideImageBar: function () {
            $("#imageBar").hide();
            $("#content").css("margin-top", "20px");
        }
    };
});

var MainController = mainModule.controller('MainController', ['$scope', 'Page',
    function ($scope, Page) {
        $scope.Page = Page;
    }]);

MainController.directive("navBar", function () {
    return {
        restrict: 'E',
        templateUrl: "./views/navbar.html"
    };
});