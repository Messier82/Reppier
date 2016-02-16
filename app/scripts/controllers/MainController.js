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
            $('.parallax').parallax();
        },
        hideImageBar: function () {
            $("#imageBar").hide();
            $("#content").css("margin-top", "20px");
        },
        showTabsIndicator: function () {
            $("ul.tabs div.indicator").css("opacity", "1");
        },
        hideTabsIndicator: function () {
            $("ul.tabs div.indicator").css("opacity", "0");
        }
    };
});

var MainController = mainModule.controller('MainController', ['$scope', 'Page', 'Session', 
    function ($scope, Page, Session) {
        $scope.Page = Page;
        $scope.Session = Session;
    }]);

MainController.directive("navBar", function () {
    return {
        templateUrl: "./views/navbar.html"
    };
});

MainController.directive("menuBar", function () {
    return {
        templateUrl: "./views/menubar.html",
        controller: "MenuBarController"
    };
});