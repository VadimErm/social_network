'use strict';

/**
 * @ngdoc function
 * @name arbaLiveApp.controller:CarsjournalCtrl
 * @description
 * # CarsjournalCtrl
 * Controller of the arbaLiveApp
 */
angular.module('arbaLiveApp')
  .controller('CarsjournalCtrl', function ($scope, ArbaProfile) {
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
	
    //Launcher
    $scope.list();
    
  });
