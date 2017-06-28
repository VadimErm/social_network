'use strict';

/**
 * @ngdoc function
 * @name arbaLiveApp.controller:FollowersCtrl
 * @description
 * # FollowersCtrl
 * Controller of the arbaLiveApp
 */
angular.module('arbaLiveApp')
  .controller('FollowersCtrl', function ($scope, ArbaProfile, ArbaSocial) {
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
	 * @method - search by query
	 * @var $query string
	 */
	$scope.search = function($query){
		
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
	 * @method - subscribe to this user
	 * @var $userID int
	 */
	$scope.subscribe = function($userID){
		
	};	 
	
	/**
	 * @method - unsubscribe of this user
	 * @var $userID int
	 */
	$scope.unsubscribe = function($userID){
		
	};
	
    //Launcher
    $scope.list();
    
  });
