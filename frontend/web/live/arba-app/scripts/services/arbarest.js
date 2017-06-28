'use strict';

/**
 * @ngdoc service
 * @name arbaLiveApp.ArbaRest
 * @description
 * # ArbaRest
 * Factory in the arbaLiveApp.
 */
angular.module('arbaLiveApp')
  .factory('ArbaRest', function ($http, $rootScope, $httpParamSerializerJQLike, FakeArbaProfile) {
    // Service logic
    
    /**
	 * @var $url string - api http url
	 */
    var $uri = '/api/v1/';
    
    /**
	 * @var $routes object - api routes
	 */
    var $routes = {
	    'signin': 'auth/login',
	    
	    //profile data
	    'account': 'account/profile',
	    
	    //Albums user
	    'albums': 'albums',
    };  
    
    /**
	 * @var $configs object - request $http configs
	 */
    var $configs = {
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded', 
			'Cache-Control' : 'no-cache'
		}
	}
    
    
    //Debug fake data
    var isFake = false;

    // Public API here
    return {
	    
	    /**
		 * Prepare request params
		 */
		requestPrepare: function(params){
			return $httpParamSerializerJQLike(params);
		},
		
	    /**
		 * Custom request
		 */
		single: function(url, method, params, _csrf){
			_csrf = _csrf || false;
			
			params = params || null;
			if(params)
				params = this.requestPrepare(params);
				
			var headers = {
				'Content-Type': 'application/x-www-form-urlencoded', 
				'Cache-Control' : 'no-cache'
			};
			
			if(_csrf !== false && _csrf !== '')
				headers['X-CSRF-Token'] = _csrf;
				
			return $http({
					method : method || 'GET',
					url: url,
					data: params || {},
					headers: headers
				});
		},
	    
		/**
		 * @method - GET method
		 * @var $route string
		 * @var $args object
		 * @var $token string
		 * @return Promise
		 */
		get: function($route, $args, $token){
			if(isFake === true)
				return FakeArbaProfile.get($route);
			
			$route = (typeof $routes[$route] != 'undefined')? $routes[$route] : $route;
			
			var request = this.requestPrepare($args);
				
			if(typeof $token != 'undefined'){
				$configs.headers['Authorization'] = 'Bearer ' + $token;
			}
			
			//request
			return $http({
					method :'GET',
					url: $uri + $route,
					data: request,
					headers: $configs.headers
				});
		},
	    
		/**
		 * @method - POST method
		 * @var $route string
		 * @var $args object
		 * @var $token string
		 * @return Promise
		 */
		post: function($route, $args, $token){
			
			if(isFake === true)
				return FakeArbaProfile.get($route);
			
			$route = (typeof $routes[$route] != 'undefined')? $routes[$route] : $route;
			$args = (typeof $args === typeof {})? $args : {};
			
			var request = this.requestPrepare($args);
			
			if(typeof $token != 'undefined'){
				$configs.headers['Authorization'] = 'Bearer ' + $token;
			}
			
			//request
			return $http({
					method :'POST',
					url: $uri + $route,
					data: request,
					headers: $configs.headers
				});
		},
	    
		/**
		 * @method - DELETE method
		 * @var $route string
		 * @var $token string
		 * @return Promise
		 */
		'delete': function($route, $args, $token){
			
			if(isFake === true)
				return FakeArbaProfile.get($route);
			
			$route = (typeof $routes[$route] != 'undefined')? $routes[$route] : $route;
			$args = (typeof $args === typeof {})? $args : {};
			
			var request = this.requestPrepare($args);
			
			if(typeof $token != 'undefined'){
				$configs.headers['Authorization'] = 'Bearer ' + $token;
			}
			
			//request
			return $http({
					method :'DELETE',
					url: $uri + $route,
					data: request,
					headers: $configs.headers
				});
		},
	    
		/**
		 * @method - PUT method
		 * @var $route string
		 * @var $args object
		 * @var $token string
		 * @return Promise
		 */
		put: function($route, $args, $token){
			
			if(isFake === true)
				return FakeArbaProfile.get($route);
			
			$route = (typeof $routes[$route] != 'undefined')? $routes[$route] : $route;
			$args = (typeof $args === typeof {})? $args : {};
			
			var request = this.requestPrepare($args);
			
			if(typeof $token != 'undefined'){
				$configs.headers['Authorization'] = 'Bearer ' + $token;
			}
			
			//request
			return $http({
					method :'PUT',
					url: $uri + $route,
					data: request,
					headers: $configs.headers
				});
		},
	    
		/**
		 * @method - PATCH method
		 * @var $route string
		 * @var $args object
		 * @var $token string
		 * @return Promise
		 */
		patch: function($route, $args, $token){
			
			if(isFake === true)
				return FakeArbaProfile.get($route);
			
			$route = (typeof $routes[$route] != 'undefined')? $routes[$route] : $route;
			$args = (typeof $args === typeof {})? $args : {};
			
			var request = this.requestPrepare($args);
			
			if(typeof $token != 'undefined'){
				$configs.headers['Authorization'] = 'Bearer ' + $token;
			}
			
			//request
			return $http({
					method :'PATCH',
					url: $uri + $route,
					data: request,
					headers: $configs.headers
				});
		},
		
	    
		/**
		 * @method - Make like
		 * @var item object
		 * @var $object object
		 * @return Promise
		 */
		like: function(item, $object, $token){
			item = angular.copy(item) || null;
			$object = angular.merge({
				name: '',
			    id_object: 0,
				user_id: 0,
				object_type: '',
			    data: {},
				user_id: 0
			}, $object || null);
			
			var type = 'like';
		    if(item === null || $object === null)
		    	return false;
		    
		    var params = {id: item.id || item.node_id};
		    
		    //Set ID
		    $object.id_object = params.id;
		    
		    return this.post('likes', params, $token).then(function(result){
				if(result.data && result.data.status && result.data.status === 'success'){	
									
					$rootScope.$broadcast('$notifyMe:send', $object.name, type, {
					    id_object: $object.id_object,
						user_id: (item.account && item.account.user_id)? item.account.user_id : false,
						object_type: $object.object_type,
						data: $object
					});
					
					return true;
				}
				
				return false;
		    });
		}
	    
    };
  });
