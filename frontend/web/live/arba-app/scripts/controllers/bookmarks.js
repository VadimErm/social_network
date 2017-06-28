'use strict';

/**
 * @ngdoc function
 * @name arbaLiveApp.controller:BookmarksCtrl
 * @description
 * # BookmarksCtrl
 * Controller of the arbaLiveApp
 */
angular.module('arbaLiveApp')

.controller('BookmarksCtrl', function (
	/*************************
	 * Native
	 ************************/
	$scope, $rootScope, $state, $stateParams, $document, $timeout, $log, 
	
	/*************************
	 * Arba Services
	 ************************/
	$arbaLiveService, ArbaProfile, ArbaSocial, arbaCache, $notifyMe, 
	
	/*************************
	 * Angular Dependencies
	 ************************/
	$base64, SweetAlert, orderByFilter
){
    this.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
    
    
    /*********************************************
	 *
	 * Helpers
	 *
	 ********************************************/
	
	/**
	 * @method - Redirect to url
	 * @var url string
	 */
    $scope.goTo = function(url){
		window.location.replace('/' + url);
		return false;
    };
	
	/**
	 * @method - Scroll to DOM element
	 * @var id string - id of element
	 */
    $scope.scrollTo = function(id){
		var element = angular.element(document.getElementById(id));
		$document.scrollToElement(element, 0);
    };
	
	/**
	 * @method - Sorting items
	 * @var use $sorting string
	 */
    $scope.sorting = function(){
	    
    };
	
	/**
	 * @method - Show all items
	 * @var use $all_list array - list of all items
	 * @var use $pre_list array - list of default show items
	 */
    $scope.showAll = function(){
	    
    };
	 
    
	/*********************************************
	 * END Helpers
	 ********************************************/
	 
	 
	 
    
    /*********************************************
	 *
	 * Variables
	 *
	 ********************************************/
	 
    
    /**
	 * @var profile object - profile data
	 */
    $scope.profile = null;
    
    /**
	 * @var $page int - default is first page view
	 */
    $scope.$page = 1;
    
    /**
	 * @var $all_list array - list of all items
	 */
    $scope.$all_list = [];
    
    /**
	 * @var $pre_list array - list of default show items
	 */
    $scope.$pre_list = [];
    
    /**
	 * @var $list array - list of items
	 */
    $scope.$list = [];
    
    /**
	 * @var $count integer || null - count of showed items
	 */
    $scope.$count = null;
    
    /**
	 * @var $sorting string || null - sort option
	 */
    $scope.$sorting = null;
    
    /**
	 * @var $search string || null - search value
	 */
    $scope.$search = null;
    
    /**
	 * @var $options object - controller view options
	 */
    $scope.$options = {
	    type: $stateParams.type || null
	    // owner userID
	    // others...
    };
    
    /* ----------------------------------------------- */
    
    /**
	 * @var $helper object - forms helper object
	 */
    $scope.$helper = {};
    
    /**
	 * @var $defaults object - forms fields defaults object
	 */
    $scope.$defaults = {};
    
    /**
	 * @var $fields object - forms fields current object
	 */
    $scope.$fields = {};
    
    /**
	 * @var $edits object - forms fields for edit item
	 */
    $scope.$edits = {
	    //id: itemID
    };
	 
    
	/*********************************************
	 * END Variables
	 ********************************************/
	 
	 
	 
    
    /*********************************************
	 *
	 * Methods
	 *
	 ********************************************/
	 
	/**
	 * @method - Add new item
	 */
    $scope.addItem = function(){
	    // Default implemetns
		
		var route = '';
		
		//Live event
		var liveEvent = {
			name:    '',
			type:    '', // 'like': 1, 'follow': 2, 'subscribe': 3, 'bookmark': 4, 'favorite': 5, 'new-comment': 6
			object:  '', // 'car': 1, 'journal': 2, 'account': 3, 'blog': 4, 'comment': 5
			user_id: ''
		};
		
		//Item fields
		var params = {
			'Item': $scope.$fields
		};
		
		//Prepare and send
		ArbaProfile.prepare({
		   type: 'POST',
		   route: route,
		   params: { 'JournalEntryRest': $scope.$fields }
	    });
	    
		ArbaProfile.send().then(function(response){
		    if(response.status && response.status === 'success'){
								
				//Trigger live event
				$notifyMe.send(liveEvent.name, liveEvent.type, {
					
				    id_object: $scope.$edits.id,
					user_id: liveEvent.user_id,
					object_type: liveEvent.object,
				    data: $scope.$edits
				    
				});
				
				//Update
				$scope.update(true);
				
				//Clear fields object				
				$scope.$fields = angular.copy($scope.$defaults);
				
				SweetAlert.success("Item was created.", {title: "Successful!"});
				
		    }else{
			    
			    SweetAlert.alert(
					"Make sure that you fill all require fields, and try again...", 
					{title: "Server error!"}
				);
		    }
	    });
    };
    
	/**
	 * @method - Edit item
	 */
	$scope.editItem = function(){
	    // Default implemetns
		
		var route = '';
		
		//Live event
		var liveEvent = {
			name:    '',
			type:    '', // 'like': 1, 'follow': 2, 'subscribe': 3, 'bookmark': 4, 'favorite': 5, 'new-comment': 6
			object:  '', // 'car': 1, 'journal': 2, 'account': 3, 'blog': 4, 'comment': 5
			user_id: ''
		};
		
		//Item fields
		var params = {
			'Item': $scope.$edits
		};
		
		ArbaProfile.prepare({
		   type: 'PATCH',
		   route: route + $scope.$edits.id,
		   params: params
	    });
	    
	    ArbaProfile.send().then(function(response){
		    if(response.status && response.status === 'success'){
								
				//Trigger live event
				$notifyMe.send(liveEvent.name, liveEvent.type, {
					
				    id_object: $scope.$edits.id,
					user_id: liveEvent.user_id,
					object_type: liveEvent.object,
				    data: $scope.$edits
				    
				});
				
				//Update
				$scope.update(true);
				
				//Clear fields object				
				$scope.$edits = {};
				
				SweetAlert.success("Item was updated.", {title: "Successful!"});
				
			}else{
				SweetAlert.alert(
					"Make sure that you fill all require fields, and try again...", 
					{title: "Server error!"}
				);
			}
		});
	};
	 
	/**
	 * @method - Remove item
	 * @var item mixed - item data or other id item
	 */
    $scope.removeItem = function(item){
	    // Default implemetns
		
		var route = '';
		
	    ArbaProfile.go(route + item.id, 'DELETE', null, {silence: false}).then(function(response){
			if(response.status === 'success'){
				
				//Update items
				$scope.update(true);
				
				SweetAlert.success("Item was removed.", {title: "Successful!"});
			}else{
				SweetAlert.alert(
					"Make sure that you have internet connection, and try again...", 
					{title: "Server error!"}
				);
			}
		});
    };
	 
	/**
	 * @method - Init list of items
	 * @var response mixed - items response
	 * @var base_object string - items base key
	 * @var object string - items current key
	 */
    $scope.list = function(response, object, base_object){
	    	    
		//Update object
		if(base_object !== '')
			$scope.$list = response[base_object][object] || [];
		else
			$scope.$list = response[object] || [];
		
		//To do
		
		//Splice counts and init view objects
		$scope.$all_list = angular.copy($scope.$list);
		$scope.$pre_list = ($scope.$count !== null)? angular.copy($scope.$all_list.slice(0, $scope.$count)) : angular.copy($scope.$all_list);
		
		//All object in response
		$scope.$all = response;
		
		$scope.$list = angular.copy($scope.$pre_list);
		
		//Cache object
		arbaCache.set($state.current.name +'::all', $scope.$all);
    }
	 
	/**
	 * @method - Update list of items
	 * @var silence boolean - load items without spinner (default: false)
	 */
    $scope.update = function(silence){
	    silence = silence || false;
	    
	    //View route
	    var route = 'bookmarks';
	    
	    //Object of response
	    var base_object = '';
	    var object = $scope.$options.type;

		//If already cached	    
	    if(arbaCache.get($state.current.name +'::all')){
			$scope.list(arbaCache.get($state.current.name +'::all'), object, base_object);
		    
			//Cached always silence update
			silence = true;
			
			//Stop loading
			ArbaProfile.loading(true);
		}
	    
	    //Update
	    ArbaProfile.go(route, 'GET', null, {silence: silence}).then(function(response){
		    
			//Update object
			$scope.list(response, object, base_object);
			
			//Debug
			$log.warn('BOOKMARKS::UPDATE', $scope.$list);
		});
    };
	 
	/**
	 * @method - Update list of items
	 * @var e object || null - event object
	 * @var profile object - about profile
	 * @var delay int - wait before load items (default: .75sec)
	 */
    $scope.init = function(e, profile, delay){	    
	    //Update profile
	    $scope.profile = profile || null;
	    
	    if($scope.profile === null)
	    	return;
	    
		delay = delay || 750;
		
		//Wait and load
		$timeout(function(){
			$scope.update();
		}, delay);
		  
    };
    
	/*********************************************
	 * END Methods
	 ********************************************/
	 
	 
	 
	 
    /*********************************************
	 *
	 * Others
	 *
	 ********************************************/
	 
	 
	/**
	 * @method - Seach in list by string
	 */
    $scope.search = function(){
		if($scope.$search === '')
			$scope.$search = null;
			
		if($scope.$search !== null){
			var $new_list = [];
			
			var searchStr = angular.copy($scope.$search).toLowerCase();
			angular.forEach($scope.$all_list, function(item, i){
				if($scope.$options.type === 'users'){
					
					if(
						item.first_name.toLowerCase().search(searchStr) >= 0 ||
						item.last_name.toLowerCase().search(searchStr) >= 0 ||
						item.country.toLowerCase().search(searchStr) >= 0 ||
						item.city.toLowerCase().search(searchStr) >= 0 ||
						item.username.toLowerCase().search(searchStr) >= 0						
					)
						$new_list.push(angular.copy(item));
						
				}else if($scope.$options.type === 'journals'){
					
				}else if($scope.$options.type === 'journalEntries'){
					
				}else if($scope.$options.type === 'blogPosts'){
					
				}else if($scope.$options.type === 'communities'){
					
				}
			});
		
			//Splice counts and init view objects
			$scope.$list = angular.copy($new_list);
			
		}else{
			$scope.$list = angular.copy($scope.$pre_list);
		}
    };
	 
	/**
	 * @method - Remove bookmark
	 * @var item mixed - item data or other id item
	 */
    $scope.unbookmarked = function(item){
	    // Default implemetns
		
		var route = 'bookmarks/';
		
	    ArbaProfile.go(route + item.id, 'DELETE', null, {silence: false}).then(function(response){
			if(response.status === 'success'){
				
				if($scope.$options.type === 'users'){
					$notifyMe.single(item.user_id);
				}else if($scope.$options.type === 'journals'){
					
				}else if($scope.$options.type === 'journalEntries'){
					
				}else if($scope.$options.type === 'blogPosts'){
					
				}else if($scope.$options.type === 'communities'){
					
				}
				
				//Update items
				$scope.update(true);
				
				SweetAlert.success("Bookmark removed.", {title: "Successful!"});
			}else{
				SweetAlert.alert(
					"Make sure that you have internet connection, and try again...", 
					{title: "Server error!"}
				);
			}
		});
    };
	 
    
	/*********************************************
	 * END Others
	 ********************************************/
	 
	 
	 
	 
    /*********************************************
	 *
	 * Events
	 *
	 ********************************************/
    
    /**
	 * @event - profile uploaded
	 * @var event object
	 * @var viewConfig object
	 */
    $scope.$on('live:profile:get', $scope.init);
    
    /**
	 * @event - view loaded
	 * @var event object
	 */
	$scope.$on('$viewContentLoaded', function(event){
		
		//Wait .75sec if loading profile or 0sec if it here
		var delay = (ArbaProfile.getProfile() !== null)? 0 : 250;
		
		$timeout(function(){
			
			if($scope.profile === null)
				$scope.init(event, ArbaProfile.getProfile(), 0);
				
		}, delay);
		
	});
    
	/*********************************************
	 * END Events
	 ********************************************/
    
    
    
	/*********************************************
	 * Check type for ctrl
	 ********************************************/
    if($scope.$options.type === null || $scope.$options.type === '')
    	return $scope.goTo('/user/account/profile'); // To profile
    
    //Make loading
	ArbaProfile.loading();
  
  });
