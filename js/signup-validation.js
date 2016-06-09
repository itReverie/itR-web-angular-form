(function() {
    angular.module('myApp', ['validation', 'validation.rule', 'ui.bootstrap', 'ui.bootstrap.tpls', 'ui.select', 'ngSanitize'])



    // -------------------
    // config phase
    // -------------------
    .config(['$validationProvider', function($validationProvider) {
        var defaultMsg;
        var expression;

        /**
         * Range Validation
         */
        $validationProvider
            .setExpression({
                range: function(value, scope, element, attrs) {
                    if (value >= parseInt(attrs.min) && value <= parseInt(attrs.max)) {
                        return value;
                    }
                }
            })
            .setDefaultMsg({
                range: {
                    error: 'Number should between 3 ~ 10',
                    success: 'good'
                }
            });
    }])


    // ---------------------
    // Directive to set a valid file based on the accept attribute of the element
    // For example: accept="image/*" or  accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
    // ---------------------

    .directive('validFile', function() {
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function(scope, el, attrs, ctrl) {
                ctrl.form3.logo.$setValidity('validFile', false);
                //change event is fired when file is selected
                el.bind('change', function() {
                    ctrl.$setValidity('validFile', el.val() != '');
                    scope.$apply(function() {
                        ctrl.$setViewValue(el.val());
                        ctrl.$render();
                    });
                });
            }
        }
    })


    // -------------------------------------------
    // Directive and Service for fileToUpload
    // -------------------------------------------

    //Assigns the value of the file on the change event
    .directive('fileModel', ['$parse', function($parse) {
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                var model = $parse(attrs.fileModel);
                var modelSetter = model.assign;

                element.bind('change', function() {
                    scope.$apply(function() {
                        modelSetter(scope, element[0].files[0]);
                    });
                });
            }
        };
    }])


    // We can write our own fileUpload service to reuse it in the controller
    .service('fileUpload', ['$http', function($http) {
        this.uploadFileToUrl = function(logo, members, clubName, category, country, state, members, firstName, lastName, email) {

            var fd = new FormData();
            fd.append('logo', logo);
            fd.append('members', members);
            fd.append('clubName', clubName);
            fd.append('category', category);
            fd.append('country', country);
            fd.append('state', state);
            fd.append('firstName', firstName);
            fd.append('lastName', lastName);
            fd.append('email', email);

            $http.post('SignupServer.php', fd, {
                    transformRequest: angular.identity,
                    headers: { 'Content-Type': undefined, 'Process-Data': false }
                })
                .success(function() {
                    console.log("Success");
                })
                .error(function() {
                    console.log("Success");
                });
        }
    }])

    // -------------------
    // controller phase
    // -------------------
    .controller('index', ['$scope', '$injector', '$document', 'fileUpload', function($scope, $injector, $document, fileUpload) {
        // Injector

        var $validationProvider = $injector.get('$validation');
        var $http = $injector.get('$http');

        $scope.form3 = {
            checkValid: $validationProvider.checkValid,
            submit: function(form) {
                $validationProvider.validate(form)
                    .success($scope.success)
                    .error($scope.error);
            },
            reset: function(form) {
                $validationProvider.reset(form);
            }
        };


        // Callback method
        $scope.success = function(message) {
            //file = $scope.fileToUpload;
            logo = $scope.myLogo;
            members = $scope.myMembers;
            clubName = $scope.form3.clubName;
            category = $scope.form3.category;
            country = $scope.form3.country;
            state = $scope.form3.state;
            firstName = $scope.form3.firstName;
            lastName = $scope.form3.lastName;
            email = $scope.form3.email;

            fileUpload.uploadFileToUrl(logo, members, clubName, category, country, state, members, firstName, lastName, email);
        };

        $scope.error = function(message) {
            var elementError = angular.element(errorMessage);
            elementError[0].innerText = 'Select a valid file.';
        };

    }]);
}).call(this);
