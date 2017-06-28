'use strict';

/**
 * @ngdoc function
 * @name arbaLiveApp.controller:NotificationsCtrl
 * @description
 * # NotificationsCtrl
 * Controller of the arbaLiveApp
 */
angular.module('arbaLiveApp')
  .controller('NotificationsCtrl', function ($scope, ArbaProfile) {
    this.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
    
    
    $scope.viewInit = function(){
    	ArbaProfile.loading(true);
    }
    
    /**
	 * @event - profile loading
	 * @var event object
	 * @var viewConfig object
	 */
    $scope.$on('live:profile:get', $scope.viewInit);
    
  });
