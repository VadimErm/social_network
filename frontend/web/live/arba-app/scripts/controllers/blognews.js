'use strict';

/**
 * @ngdoc function
 * @name arbaLiveApp.controller:BlognewsCtrl
 * @description
 * # BlognewsCtrl
 * Controller of the arbaLiveApp
 */
angular.module('arbaLiveApp')
  .controller('BlognewsCtrl', function ($scope, ArbaProfile) {
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
	 * @var $filters array
	 */
	$scope.list = function($page, $filters){
		
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
	 * @method - hide post
	 * @var $id int
	 */
	$scope.hidePost = function($id){
		
	};
	 
	
	/**
	 * @method - hide blog
	 * @var $id int
	 */
	$scope.hide = function($id){
		
	};
	
    //Launcher
    $scope.list();
    
  });
