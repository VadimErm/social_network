'use strict';

/**
 * @ngdoc function
 * @name arbaLiveApp.controller:NewcarsCtrl
 * @description
 * # NewcarsCtrl
 * Controller of the arbaLiveApp
 */
angular.module('arbaLiveApp')
  .controller('NewcarsCtrl', function ($scope, ArbaProfile, ArbaSocial) {
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
	 * @var $sort string
	 */
	$scope.list = function($page, $sort){
		
	};
	
	/**
	 * @method - get list item
	 * @var $id int
	 */
	$scope.get = function($id){
		
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
	 * @method - get list item
	 * @var $id int
	 */
	$scope.comment = function($id){
		
	};
	 
	
	/**
	 * @method - subscribe of this item
	 * @var $id int
	 */
	$scope.subscribe = function($id){
		
	};
	 
	
	/**
	 * @method - unsubscribe of this item
	 * @var $id int
	 */
	$scope.unsubscribe = function($id){
		
	};
	
	/**
	 * @method - get list item
	 * @var $id int
	 */
	$scope.bookmark = function($id){
		
	};
	
	/**
	 * @method - get list item
	 * @var $id int
	 */
	$scope.unbookmark = function($id){
		
	};
	
    //Launcher
    $scope.list();
    
  });
