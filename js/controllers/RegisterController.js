/* 
 * Reppier management system
 * Design and code - M82.eu
 */

var RegisterController = mainModule.controller("RegisterController", ["$scope", function ($scope) {
        initValidate();
    }]);

function initValidate() {
    $("#signupForm").validate({
        rules: {
            "first-name": {
                required: true,
                minlength: 2,
                maxlength: 15
            },
            "last-name": {
                required: true,
                rangelength: [2, 20]
            },
            "email": {
                required: true,
                email: true
            },
            "password": {
                required: true,
                minlength: 6,
                maxlength: 25
            },
            "repeat-password": {
                required: true,
                equalTo: "#password"
            }
        },
        success: function (label, element) {
            $(element).addClass("valid").removeClass("invalid");
        },
        errorPlacement: function (error, element) {
            $(element).removeClass("valid").addClass("invalid").next().attr("data-error",error.text());
        },
        /*Validation triggers fix*/
        onfocusout: function(element) {
            this.element(element);
        }
    });
}