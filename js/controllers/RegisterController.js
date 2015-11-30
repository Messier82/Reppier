/* 
 * Reppier management system
 * Design and code - M82.eu
 */

var RegisterController = mainModule.controller("RegisterController",  function ($scope, $http) {
        $scope.register = function(data) {
            if(!$("#signupForm").valid()){
                return false;
            }
            $http({
                url:"./api/user/register",
                method: 'GET',
                params: data
            }).success(function(data){
                if(data['status'] === "success") {
                    $scope.showSuccess();
                }
                if(data['status'] === "error") {
                    $scope.showError(data['errors']);
                }
            });
        };
        $scope.showSuccess = function() {
            $("#registerCard").before("<div class='card green lighten-2 black-text' id='registerSuccessCard'><div class='card-content'><span class='card-title' style='line-height: 1;'><b>Success!</b></span></div></div>");
            $("#registerCard").remove();
            $("#registerSuccessCard .card-content").append("<div>You have successfully signed up. Now you can sign in!</div>");
        };
        $scope.showError = function(errors) {
            $("#registerCard").before("<div class='card red lighten-2 black-text' id='registerErrorCard'><div class='card-content'><span class='card-title' style='line-height: 1;'><b>Error!</b></span></div></div>");
            errors.forEach(function(value){
                $("#registerErrorCard .card-content").append("<li>" + value + "</li>");
            });
        };
        initRegisterValidate();
    });

function initRegisterValidate() {
    $("#signupForm").validate({
        rules: {
            "first_name": {
                required: true,
                minlength: 2,
                maxlength: 15
            },
            "last_name": {
                required: true,
                minlength: 2,
                maxlength: 20
            },
            "email": {
                required: true,
                maxlength: 30,
                email: true,
                remote: {
                    url: "./api/user/check/email",
                    type: "get"
                }
            },
            "password": {
                required: true,
                minlength: 6,
                maxlength: 50
            },
            "repeat_password": {
                required: true,
                equalTo: "#password"
            },
            "phone_number": {
                required: true,
                minlength: 8,
                maxlength: 15,
                digits: true,
                remote: {
                    url: "./api/user/check/phone_number",
                    type: "get"
                }
            }
        },
        messages: {
            "email": {
                remote: "Already taken"
            },
            "repeat_password": {
                equalTo: "Passwords should match"
            },
            "phone_number": {
                remote: "Already taken"
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