'use strict';

/**
 * @ngdoc service
 * @name arbaLiveApp.ArbaProfile
 * @description
 * # ArbaProfile
 * Factory in the arbaLiveApp.
 */
angular.module('arbaLiveApp')
  .factory('ArbaProfile', function ($rootScope, SweetAlert, ArbaRest, $viewLoaded, arbaCache, $state, $timeout, $log) {
    // Service logic
    
    /**
	 * @var $isAuth boolean - auth indetificate
	 */
    var $isAuth = false;
    
    /**
	 * @var $token string - api token for requests
	 */
    var $token = null;    
    
    /**
	 * @var $credentials object - auth credentials
	 */
    var $credentials = null;
    
    /**
	 * @var $prepare object - prepare request 
	 */
    var $prepare = null;
    
    
    /**
	 * @var $profilePrefix string - storage data prefix
	 */
    var $profilePrefix = '_ARBA_STORAGE_DEBUG___';
    
    /**
	 * @var $loading DOM - loading DOM element
	 */
    var $loading = document.getElementById('arba-loading');
    
    var $loadingDelay = false;

    // Public API here
    return {
	    
		/**
		 * @method - get value from localStorage
		 * @var $key string
		 * @var $json boolean
		 * @return string
		 */
		get: function($key, $json){
			var res = localStorage.getItem($profilePrefix + $key);
			
			if($json === true)
				return JSON.parse(res);
				
			return res;
		},
	    
		/**
		 * @method - set value from localStorage
		 * @var $key string
		 * @var $value string
		 * @return boolean
		 */
		set: function($key, $value){
			if(typeof $value === typeof [] || typeof $value === typeof {})
				$value = JSON.stringify($value);
			
			localStorage.setItem($profilePrefix + $key, $value);
			
			return ($value === this.get($key))? true : false;
		},
	    
		/**
		 * @method - remove value from localStorage
		 * @var $key string
		 */
		remove: function($key){
			localStorage.removeItem($profilePrefix + $key);
		},
		
		/**
		 * @method - spinner for loading page
		 * @var $hide boolean
		 */
		fullLoading: function($hide){
			$hide = $hide || false;
			
			$rootScope.$broadcast('live:view:page:loading', $hide);
		},
	    
		/**
		 * @method - spinner for loading view
		 * @var $hide boolean
		 */
		loading: function($hide){
			$hide = $hide || false;
			
			$rootScope.$broadcast('live:view:loading', $hide);
		},
	    
		/**
		 * @method - catch failed request
		 * @return Promise
		 */
		failed: function(){
			this.loading(true);
			
			SweetAlert.alert(
				"Please check your internet connection or access rights, and try again...", 
				{title: "Error! Server not response..."}
			).then(function(){
				window.location.replace('/');
			});
		},
		
		token: function(token){
			if(typeof token === typeof 'string'){
				this.set('token', token);
				$token = token;
				
				return true;
			}
			
			return false;
		},
	    
		/**
		 * @method - SignOut
		 * @return Promise
		 */
		signout: function(redirect){
			redirect = redirect || '/site/logout';
			
			var self = this;
			$timeout(function(){
				self.remove('username');
				self.remove('password');
				self.remove('token');
				
			    self.loading(true);
			    
			    window.location.href = redirect;
				    
			}, 500);
		    
			return false;
		},
	    
		/**
		 * @method - SignIn 
		 * @var $credentials object
		 * @return Promise
		 */
		signin: function($credentials, returnResponse){
			$credentials = $credentials || {
				username: this.get('username'),
				password: this.get('password'),
			};
			returnResponse = returnResponse || false;
			
			if($credentials.username === null || $credentials.password === null)
				return this.failed();
			
			//send request
			var self = this;
			
			this.loading();
			return ArbaRest.post('signin', $credentials).then(function(response){
				if(returnResponse === true){
					if(response.data && response.data.access_token)
						self.token(response.data.access_token);
						
					return response.data;
				}
				
				if(response.data.status === 'success' && self.token(response.data.access_token)){
					return true;
				}else{
					return self.signout();
				}	
			}).catch(function(){ 
				return self.signout(); 
			});
		},
	    
		/**
		 * @method - prepare request
		 * @var $args object
		 * @return Promise
		 */
		prepare: function($args){
			$prepare = $prepare || {};
			
			$prepare = angular.merge($prepare, $args);
		},
	    
		/**
		 * @method - request token
		 * @var $credentials object
		 * @return Promise
		 */
		requestToken: function($credentials){
			
		},
		
		/**
		 * @method - filter response data
		 * @var response object
		 * @var route string
		 * @return mixed
		 */
		filter: function(response, requestParams, notHideSpinner, fullLoading){
			$prepare = null;
			fullLoading = fullLoading || false;
			
			if(fullLoading === true)
				this.fullLoading(true);
			
			if(response.data){
				if(notHideSpinner !== true)
					this.loading(true);
			
				//Breadcrums
				if(response.data.breadcrumbs){
					$rootScope.$broadcast('live:update:breadcrums', response.data.breadcrumbs);
				}
			
				this.token(response.data.access_token);
				try{ 
					delete response.data.access_token;
				}catch(e){}
				
				var result = response.data;
				
				if(requestParams.route !== 'account')
					result = response.data[requestParams.route] || response.data;
				
				if(typeof result == 'undefined'){
					return this.go(requestParams.route, requestParams.type, requestParams.after || null, requestParams.params, requestParams.withoutToken);
				}
				
				return result;
			}
			
			if($state.current.name === 'dash.home-page'){
				this.loading(true);
				return null;	
			}
			
			this.failed();
			return null;
		},
	    
		/**
		 * @method - send $prepare request
		 * @var silence boolean
		 * @return Promise
		 */
		send: function(silence){
			silence = silence || false;
			
			if($token === null && this.get('token') !== null)
				$token = this.get('token');
				
			if($prepare !== null){
				$prepare.params = $prepare.params || {};
				
				$prepare.notHideSpinner = $prepare.notHideSpinner || false;			
			
				var fullLoading = $prepare.doFullLoading || false;
				
				if((!silence && $prepare.type !== 'GET') || fullLoading){
					if(fullLoading === true)
						silence = true;
					
					this.fullLoading();
					fullLoading = true;
				}
			
				if(silence === true)
					$prepare.notHideSpinner = true;
				
				//View spinner
				if(!silence)
					this.loading();
					
				var $requestParams = {
					route: $prepare.route, 
					type: $prepare.type, 
					after: null, 
					params: $prepare.params, 
					withoutToken: $token? true : false
				};
				
				//Use Request API
				var self = this;
				if($prepare.type === 'GET')
					return ArbaRest.get($prepare.route, $prepare.params, $token).then(function(response){
						return self.filter(response, $requestParams, $prepare.notHideSpinner, fullLoading);
					}).catch(function(){ self.failed() });
				else if($prepare.type === 'POST')
					return ArbaRest.post($prepare.route, $prepare.params, $token).then(function(response){
						return self.filter(response, $requestParams, $prepare.notHideSpinner, fullLoading);
					}).catch(function(){ self.failed() });
				else if($prepare.type === 'PUT')
					return ArbaRest.put($prepare.route, $prepare.params, $token).then(function(response){
						return self.filter(response, $requestParams, $prepare.notHideSpinner, fullLoading);
					}).catch(function(){ self.failed() });
				else if($prepare.type === 'DELETE')
					return ArbaRest.delete($prepare.route, $prepare.params, $token).then(function(response){
						return self.filter(response, $requestParams, $prepare.notHideSpinner, fullLoading);
					}).catch(function(){ self.failed() });
				else if($prepare.type === 'PATCH')
					return ArbaRest.patch($prepare.route, $prepare.params, $token).then(function(response){
						return self.filter(response, $requestParams, $prepare.notHideSpinner, fullLoading);
					}).catch(function(){ self.failed() });
				else 
					this.loading(true);
			}
			
			//Clear prepare
			$prepare = null;
		},
		
	    
		/**
		 * @method - send without prepare request
		 *
		 * @return Promise
		 */
		go: function(route, type, after, params, withoutToken){
			params = params || {};
			withoutToken = withoutToken || false;
			
			var silence = (typeof params.silence === typeof true)? params.silence : true;
			
			var args = {
				route: route,
				type: type || 'GET',
				after: after || '',
				params: params,
				notHideSpinner: params.notHideSpinner || false
			};
			
			$token = ($token === null && this.get('token') !== null)? this.get('token') : $token;
			if($token === null && withoutToken === false){
				this.failed();
				return;	
			}				
			
			var fullLoading = params.doFullLoading || false;
			
			if((!silence && args.type !== 'GET') || fullLoading){
				if(fullLoading === true)
					silence = true;
					
				this.fullLoading();
				fullLoading = true;
			}
			
			if(silence === true)
				args.notHideSpinner = true;
			
			//View spinner
			if(!silence){
				this.loading();
			}			
					
			var $requestParams = {
				route: route, 
				type: type, 
				after: after, 
				params: params, 
				withoutToken: withoutToken
			};
			
			//Use Request API
			var self = this;
			if(args.type === 'GET')
				return ArbaRest.get(args.route, args.params, $token).then(function(response){
					return self.filter(response, $requestParams, args.notHideSpinner, fullLoading);
				}).catch(function(){ self.failed() });
			else if(args.type === 'POST')
				return ArbaRest.post(args.route, args.params, $token).then(function(response){
					return self.filter(response, $requestParams, args.notHideSpinner, fullLoading);
				}).catch(function(){ self.failed() });
			else if(args.type === 'PUT')
				return ArbaRest.put(args.route, args.params, $token).then(function(response){
					return self.filter(response, $requestParams, args.notHideSpinner, fullLoading);
				}).catch(function(){ self.failed() });
			else if(args.type === 'DELETE')
				return ArbaRest.delete(args.route, args.params, $token).then(function(response){
					return self.filter(response, $requestParams, args.notHideSpinner, fullLoading);
				}).catch(function(){ self.failed() });
			else if(args.type === 'PATCH')
				return ArbaRest.patch(args.route, args.params, $token).then(function(response){
					return self.filter(response, $requestParams, args.notHideSpinner, fullLoading);
				}).catch(function(){ self.failed() });
			else 
				this.loading(true);
		},
		
		/**
		 * @method - access callback action
		 */
		accessAction: function(status){
		    if(status === false)
			 	return this.signout(); 	    
		    
		    $rootScope.$broadcast('arba-api:authorized');
		    
		    try{
			    var loader = document.getElementById('arba-app-loader');
			    if(loader !== null){
				    loader.style.opacity = 0;
				    $timeout(function(){
					    if(loader !== null) loader.parentNode.removeChild(loader);
				    }, 1000);
			    }
			}catch(e){}
		},
	    
		/**
		 * @method - check access token or credentials
		 */
		access: function(){
			var status = false;
			
			if($credentials === null)
				$credentials = {
					username: this.get('username'),
					password: this.get('password')
				}
			
			if($token === null && $credentials.username !== null && $credentials.password !== null){
				//request token
				var self = this;
				this.signin($credentials).then(this.accessAction);
				
				return;
			}
			
			if($token === null && this.get('token') !== null){
				$token = this.get('token');
				status = true;
			}
			
			if($token !== null)
				status = true;
			
			
			this.accessAction(status);
		},
		
		getProfile: function(){
			return arbaCache.get('currentProfile');
		},
		
		saveProfile: function($profile){
			arbaCache.set('currentProfile', $profile);
		},
		
		viewLoaded: function(updated, quick){
			if(quick){
				$rootScope.$broadcast('live:view:loaded:update', 0);
				return;
			}
			
			if(updated)
				$rootScope.$broadcast('live:view:loaded:update');
			else
				$viewLoaded.triggerLoaded();
		},
		
		//View methods
		
		pageTitle: function(title){
			title = title || 'Welcome';
			$rootScope.$broadcast('live:update:title', title);
		},
		
		/*
			[{
				name: 'PAGE NAME',
				link: true||false - current page,
				href: '/link'
			}]
		*/
		breadcrums: function(breadcrums){
			breadcrums = breadcrums || null;
			
			if(breadcrums !== null)
				breadcrums.unshift({
					name: 'MAIN',
					href: '/'
				});
			
			$rootScope.$broadcast('live:update:breadcrums', breadcrums);
		},
		
		//Make like
		like: function(item, $object){
			$token = ($token === null && this.get('token') !== null)? this.get('token') : $token;
			if($token === null && withoutToken === false){
				this.failed();
				return;	
			}
			
			return ArbaRest.like(item, $object, $token).then(function(response){
				return response;
			});
		}
			
    };
  })
  
  //Session cache service
  .service('arbaCache', function (CacheFactory) {
	
	this.$arbaCache = CacheFactory('$arbaCache');
	
	this.get = function(key){
		var $cache = this.$arbaCache.get(key);
		
		if(typeof $cache == 'undefined')
			return false;
		
		return angular.copy($cache);
	};
			
	this.set = function(key, val){
		if(this.get(key))
			this.$arbaCache.remove(key);
		
		this.$arbaCache.put(key, angular.copy(val));
	};
	  
  })
  
  //Live notifications
  .service('$notifyMe', function($rootScope, $arbaLiveService, ArbaProfile){
	  
	  //Send notification
	  /*
		  request = {
	          id_object: 0,
	          user_id: 0,
	          event_type: 1 - like, 2 follow, 3 subscribe, 4 bookmark, 5 favorite, 6 new comment
	          object_type: 1
	      }
	  */
	  
	  this.eventTypes = {
	  		'like': 1,  
	  		'follow': 2,
	  		'subscribe': 3,
	  		'bookmark': 4,
	  		'favorite': 5,
	  		'new-comment': 6
	  };
	  
	  this.objectTypes = {
	  		'car': 1,  
	  		'journal': 2,
	  		'account': 3,
	  		'blog': 4,
	  		'comment': 5
	  };
	  
	  this.send = function(slug, type, request){
		var profile = ArbaProfile.getProfile();
		
		request = angular.merge({id_object: 0,user_id: 0,object_type: 0}, request);
		
		//add notification
		var self = this;		
		ArbaProfile.go('notifications', 'POST', null, {
			'Notification': {
	          id_object: request.id_object,
	          user_id: request.user_id || profile.user_id,
	          event_type: self.eventTypes[type] || type,
	          object_type: self.objectTypes[request.object_type] || request.object_type
			}
		}).then(function(result){
			
			if(result.status === 'success')
				$arbaLiveService.send(slug, type, request);
			
		});
		
	  }
	  
	  //Watch incomming notifications
	  this.watchResponse = function(slug, type, request){
		var profile = ArbaProfile.getProfile();
		if(request.user_id === profile.user_id){
			$rootScope.$broadcast('live:update:profile');
		}
		
		if(slug !== 'live:update:profile' && type !== null)
			$rootScope.$broadcast(slug, type, request);
	  }
	  
	  //Local update
	  this.single = function(user_id){
		$arbaLiveService.send('live:update:profile', null, { user_id: user_id });
	  
		$rootScope.$broadcast('live:update:profile');
	  };
  })

  .factory('$viewLoaded', function($q, $rootScope, $timeout) {
	var viewContentLoaded = $q.defer();
	
	return {
		onLoaded: function() {      
			return viewContentLoaded.promise;
		},
		
		triggerLoaded: function(){
			$timeout(function() {
				viewContentLoaded.resolve();
			}, 500);//Timeout
		}
	};
	
  })
  
  ;
