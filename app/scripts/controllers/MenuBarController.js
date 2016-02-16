/* 
 * Reppier management system
 * Design and code - M82.eu
 */
var MenuBarController = mainModule.controller("MenuBarController", ["$scope", function ($scope) {
        $scope.items = [
            {
                name: "Home",
                url: "#home"
            },
            {
                name: "About Us",
                url: "#about"
            },
            {
                name: "Contacts",
                url: "#contacts"
            },{
                name: "Contact Us",
                url: "#contact"
            }
        ];
        $scope.itemWidth = {"width":"130px"};
    }]);