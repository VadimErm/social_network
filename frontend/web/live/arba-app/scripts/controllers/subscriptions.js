'use strict';

/**
 * @ngdoc function
 * @name arbaLiveApp.controller:SubscriptionsCtrl
 * @description
 * # SubscriptionsCtrl
 * Controller of the arbaLiveApp
 */
angular.module('arbaLiveApp')
  .controller('SubscriptionsCtrl', function ($scope, ArbaProfile, ArbaSocial) {
    this.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
    
    /**
	 * @var $page int - default is 1
	 */
    $scope.$page = 1;
    
    /**
	 * @var $list array - list of items
	 */
    $scope.$list = [];
	
	
	
	/**
	 * @method - get list items
	 * @var $page int
	 */
	$scope.list = function($page){
		
	};
	
	/**
	 * @method - update socket.io list
	 */
	$scope.update = function(){
		
	};
	
	
	/**
	 * View Helpers
	 */
	 
	
	/**
	 * @method - unsubscribe of this item
	 * @var $id int
	 */
	$scope.unsubscribe = function($id){
		
	};
	
    //Launcher
    $scope.list();
    
  });
