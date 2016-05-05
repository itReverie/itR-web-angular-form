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






  // -------------------
  // controller phase
  // -------------------
  .controller('index', ['$scope', '$injector', function($scope, $injector) {
    // Injector

    var $validationProvider = $injector.get('$validation');
    var $http = $injector.get('$http');

    // Initial Value
    $scope.form = {
      requiredCallback: 'required',
      checkValid: $validationProvider.checkValid,
      submit: function() {
        // angular validation 1.2 can reduce this procedure, just focus on your action
        // $validationProvider.validate(form);
      },
      reset: function() {
        // angular validation 1.2 can reduce this procedure, just focus on your action
        // $validationProvider.reset(form);
      }
    };


    $scope.form3 = {
      checkValid: $validationProvider.checkValid,
      submit: function(form) {
        $validationProvider.validate(form)
          .success( $scope.success )
          .error($scope.error);
      },
      reset: function(form) {
        $validationProvider.reset(form);
      }
    };


    // Callback method
    $scope.success = function(message) {
     $http.post('SignupServer.php', {
            'clubName' : $scope.form3.clubName, 
            'category' : $scope.form3.category, 
            'country' : $scope.form3.country, 
            'state' : $scope.form3.state, 
            'logo' : $scope.form3.logo,
            'members' : $scope.form3.members,
            'firstName' : $scope.form3.firstName, 
            'lastName' : $scope.form3.lastName, 
            'email' : $scope.form3.email
        }
    ).success(function (data, status, headers, config) {
        console.log(data);
         alert('Sucesssssssssss');
    
    });
    };

    $scope.error = function(message) {
      alert('Errrrooorrr');
      //alert(message);
    };

  }]);
}).call(this);
