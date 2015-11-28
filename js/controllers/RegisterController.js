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
                minlength: 2,
                maxlength: 20
            },
            "email": {
                required: true,
                maxlength: 30,
                email: true,
                remote: {
                    url: "./api/user/emailcheck",
                    type: "post",
                    dataType: "ajax",
                    success: function(data) {
                        return data['status'];
                    }
                }
            },
            "password": {
                required: true,
                minlength: 6,
                maxlength: 25
            },
            "repeat-password": {
                required: true,
                equalTo: "#password"
            },
            "phone-number": {
                required: true,
                minlength: 8,
                maxlength: 15,
                digits: true
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