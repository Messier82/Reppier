/* 
 * Reppier management system
 * Design and code - M82.eu
 */
mainModule.factory('Page', function () {
    var title = 'Home';
    var siteTitle = 'Admin - Reppier';
    var navbarTitle = 'Home';
    return {
        title: title + " - " + siteTitle,
        setTitle: function (newTitle) {
            title = newTitle;
        },
        navbarTitle: navbarTitle
        /*setNavbarTitle: function (newTitle, isPageInMenu) {
            $(".currentPage").removeClass("projectTitle");
            if (isPageInMenu) {
                navbarTitle = 'Reppier';
                $(".currentPage").addClass("projectTitle");
            } else {
                navbarTitle = newTitle;
            }
        }*/
    };
});

var MainController = mainModule.controller('MainController', ['$scope', 'Page'/*, 'Session'*/,
    function ($scope, Page/*, Session*/) {
        $scope.Page = Page;
//        $scope.Session = Session;
    }]);
