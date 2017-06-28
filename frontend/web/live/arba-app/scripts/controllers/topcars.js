'use strict';

/**
 * @ngdoc function
 * @name arbaLiveApp.controller:TopcarsCtrl
 * @description
 * # TopcarsCtrl
 * Controller of the arbaLiveApp
 */
angular.module('arbaLiveApp')
  .controller('TopcarsCtrl', function ($scope, ArbaProfile, ArbaSocial) {
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
	 * @var $count int - default is 10
	 */
    $scope.$count = 10;
    
    /**
	 * @var $list array - list of items
	 */
    $scope.$list = [];
	
	
	
	/**
	 * @method - get list items
	 * @var $page int
	 * @var $type string
	 */
	$scope.list = function($page, $type){
		
	};
	
	/**
	 * @method - set count items on page
	 * @var $count int
	 */
	$scope.setCount = function($count){
		
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
	 * @method - bookmark to this item
	 * @var $id int
	 */
	$scope.bookmark = function($id){
		
	};	 
	
	/**
	 * @method - unbookmark of this item
	 * @var $id int
	 */
	$scope.unbookmark = function($id){
		
	};
	
    //Launcher
    $scope.list();
    
  });
