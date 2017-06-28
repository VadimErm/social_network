'use strict';

/**
 * @ngdoc function
 * @name arbaLiveApp.controller:HomeCtrl
 * @description
 * # TopcarsCtrl
 * Controller of the arbaLiveApp
 */
angular.module('arbaLiveApp')
  .controller('BlankCtrl', function($scope, $rootScope, ArbaProfile, SweetAlert){ 
	   
	    /**
		 * @event - profile loading
		 * @var event object
		 * @var viewConfig object
		 */
		$scope.profile = null;
	    $scope.viewInit = function(e, profile){
		    $scope.profile = profile;
		    
		    $rootScope.$broadcast('live:update:breadcrums', []);
		    
		    ArbaProfile.loading(true);
		    
		    SweetAlert.alert(
				"Make sure that your internet connection isn't broken or try again...", 
				{title: "Live server not responding!"}
			);
	    };
	    $scope.$on('live:profile:get', $scope.viewInit);
		
		if(ArbaProfile.getProfile() !== null)
			$scope.viewInit(null, ArbaProfile.getProfile()); 
  })
  
  .controller('HomePageCtrl', function($scope, $rootScope, $state, $arbaSocket, ArbaProfile, ArbaRest, SweetAlert, $http, $timeout, $log){
	//Init loading view
	$rootScope.$broadcast('live:view:loading');	
				
	//View loaded
	$rootScope.$broadcast('live:view:loading', true);
	
	//Auth credentials
	$scope.$fields = {
		username: ArbaProfile.get('username') || '',
		password: ArbaProfile.get('password') || ''
	};
	
	$scope.profile = null;
	
	//Home blocks
	$scope.cities = null;
	$scope.journals = null;
	$scope.blogs = null;
	$scope.communities = null;
	$scope.companies = null;
	$scope.promo = null;
	
	
	//Init View
	$scope.viewInit = function(e, profile){		
		$scope.profile = profile || null;
		
		$rootScope.$broadcast('live:update:breadcrums', null);
		$rootScope.$broadcast('live:update:title', 'Home Page');
		
		//For unregistered users TO DO...
		if($scope.profile === null){
			$timeout(function(){
				ArbaProfile.loading(true);
				
				$scope.cities = [];
				$scope.journals = [];
				$scope.blogs = [];
				$scope.communities = [];
				$scope.companies = [];
				$scope.promo = [];
				
				//Clear breadcrumbs
				$rootScope.$broadcast('live:update:breadcrums', null);
			}, 1500);
		}else{
			$timeout(function(){
				ArbaProfile.loading(true);
				
				$scope.cities = [];
				$scope.journals = [];
				$scope.blogs = [];
				$scope.communities = [];
				$scope.companies = [];
				$scope.promo = [];
				
				//Clear breadcrumbs
				$rootScope.$broadcast('live:update:breadcrums', null);
			}, 1500);
		}
	}
	
	$scope.signin = function(){
		ArbaProfile.signin($scope.$fields, true).then(function(result){			
			if(result.status && result.status === 'success'){
				
				ArbaRest.single('/site/login', 'POST', { LoginForm: $scope.$fields }).then(function(response){
					ArbaProfile.loading(true);
					
					if (
						(response.data && response.data.status && response.data.status == 'success') ||
						(response.data.message && response.data.message === 'Logined')
					){	 
						
						ArbaProfile.set('username', $scope.$fields.username);
						ArbaProfile.set('password', $scope.$fields.password);
						
						$rootScope.$broadcast('update:home:profile');
						
						$scope.viewInit();
						
						window.jQuery.magnificPopup.instance.close();
						 
					}else{
						var errMsg = response.data.message || "Make sure that your internet connection isn't broken or try again...";
					    SweetAlert.alert(
							errMsg, 
							{title: "Authorization error!"}
						);
					}
				}).catch(function(){
					ArbaProfile.loading(true);
					SweetAlert.alert(
						"Make sure that your internet connection isn't broken or try again...", 
						{title: "Authorization error!"}
					);
				});
				
			}else{		  
				ArbaProfile.loading(true);
				
				var errMsg = result.message || "Make sure that your internet connection isn't broken or try again...";
			    SweetAlert.alert(
					errMsg, 
					{title: "Authorization error!"}
				);
			}
		});
	};
	
	//Start homepage
	angular.element(document).ready(function(){
		$scope.viewInit(null, false);
	});
	$scope.$broadcast('live:profile:get', $scope.viewInit);
	$scope.$broadcast('live:profile:get:false', function(){
		$scope.viewInit(null, false);
	});
		  
  })
  
  .controller('HomeNotifyCtrl', function($scope, $rootScope, mdPanelRef, ArbaProfile){
	  	
	  	$scope.setReaded = function(i, items){
			$rootScope.$broadcast('live:set:loading', true);
			
		  	if(parseInt(items.length) <= parseInt(i)){
			  	$rootScope.$broadcast('live:update:profile');
			  	return;
		  	}
		  	
		  	if(typeof items[i] == 'undefined' || (typeof items[i] != 'undefined' && items[i].readed === 1)){
			  	$scope.setReaded(i+1, items);
		  	}else{
				ArbaProfile.go('notifications/read', 'PUT', null, {id: items[i].id}).then(function(result){
					$scope.setReaded(i+1, items);
				});
		  	}
	  	}
	  	
		$scope.closeMenu = function(readed, items) {
			readed = readed || false;
			
			if(readed){
				$scope.setReaded(0, items);
			}
			
			mdPanelRef && mdPanelRef.close();
		}
	  
  })
  
  .controller('GetStateCtrl', function ($scope, $state) {
    this.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
    
    $scope.states = $state.get().map(function(state) { 
    	var result = {};
    	result[state.name] = $state.href(state.name);
	    return result;
	});
	
	$scope.states = JSON.stringify($scope.states);
	    
  })
  
  .controller('HomeCtrl', function ($scope, $rootScope, $state, $mdPanel, $viewLoaded, $arbaSocket, ArbaProfile, $notifyMe, ArbaSocial, $http, $timeout, $log, $document, webNotification) {
    this.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
	
    $scope.notAngularSystem = window.isNotAngularSystem || false;
    
    //View Preloaders
   	$scope.profileWakeUp = false;
   	$scope.itemWakeUp = false;
   	$scope.itemWakeUpFinish = false;
   	
   	$scope.$homeNonRegSliderTimer = null;
   	
   	$scope.viewLoaded = function(){
	   	$timeout(function(){
		   $scope.profileWakeUp = true;
		}, 250);
		
		$timeout(function(){
		   $scope.itemWakeUp = true;
		}, 500);
		
		$timeout(function(){
		   $scope.itemWakeUpFinish = true;
		}, 2000);
		
		if($scope.$homeNonRegSliderTimer === null)
			$timeout.cancel($scope.$homeNonRegSliderTimer);
		
		$scope.$homeNonRegSliderTimer = $timeout(function(){
			if($scope.$homeNonRegSliderTimer !== null)
				$timeout.cancel($scope.$homeNonRegSliderTimer);
				
			$log.warn('UPDATED!!');
			window.homeNonRegSlider();
		}, 2250);
   	}
    
    $scope.isLoading = false;
    $scope.$on('live:set:loading', function(e, status){
	    $scope.isLoading = status;
    });
    
    $scope.statesUrls = {
	    "":null,
	    "dash":"#",
	    "dash.all-states":"#/states/all",
	    "dash.home-page":"#/home",
	    "dash.myjournal-list":"#/cars/journal/list",
	    "dash.myjournal-my":"#/cars/journal/my",
	    "dash.messages":'#/messages',
	    "dash.messages-new":'#/messages/new',
	    "dash.messages-chat":'#/messages/chat',
	    "dash.notifications":"#/notifications",
	    "dash.bookmarks":'#/bookmarks',
	    "dash.my-subscriptions":'#/subscriptions',
	    "dash.my-followers":'#/followers',
	    "dash.top-cars":"#/top/cars",
	    "dash.blogs":"#/blogs",
	    "dash.communities":"#/communities",
	    "dash.achievements":"#/achievements",
	    "dash.companies":"#/companies",
	    "dash.news":"#/news",
	    "dash.live-likes":"#/live/likes",
	    "dash.signout":"#/signout",
	    
	    "dash.promo": '#'
	};
    
    //Loading configs
    $rootScope.loadingTitle = 'Please wait, loading...';
    
    $rootScope.loadingHide = false;
    
    $rootScope.loadedContent = false; //Page view loading
    $rootScope.loadedContentTimer = null; //Page view loading
    
    $scope.afterLoaded = function(e){
		$rootScope.loadingHide = true;
		
		$timeout(function(){
			window.mainInited();
		}, 500);
    };
    $rootScope.$on('live:view:page:loading', function(e, isLoaded){
	    $rootScope.loadingHide = isLoaded;
    });
    
    /**
	 * @event - view loaded
	 * @var event object
	 */
	$viewLoaded.onLoaded().then(function(){
		window.initArbaScripts(jQuery);
	});
    $rootScope.$on('live:view:loaded:update', function(e, delay){
		$log.warn('SET:LOADED', delay);
		
		delay = (angular.isNumber(delay))? delay : 750;
		
		setTimeout(function(){ 
			window.initArbaScripts(jQuery);
		}, delay);
	});
    
    $rootScope.$on('live:profile:get:false', $scope.afterLoaded);
    $rootScope.$on('live:profile:get', $scope.afterLoaded);
    
    $rootScope.$on('live:view:loading', function(e, isLoaded){
	    $rootScope.loadedContent = isLoaded || false;
	    if($rootScope.loadedContent === false){
		    //var element = angular.element(document.getElementsByTagName('body'));
			//$document.scrollToElement(element, 0);
	    }
    });
	
	
    
    /**
	 * @var profile object - about current profile
	 */
	$scope.profile = null;
	
	//Cars
	$scope.cars = [];
	
	//Connect socket
	$arbaSocket.connect();
			   
	//Connected
	$arbaSocket.on('live:connected', function(){
		$log.log('Socket :: Connected');
	});
	
	window.debugNotif = function(event, type, response){
		$notifyMe.send(event, type, response);
	}
	
	//Events get from socket
	$arbaSocket.on('live:event:getting', function(response){
		var event = response.event;
		
		$notifyMe.watchResponse(event, response.type, response.data);
	});
    
    $rootScope.pageTitle = null;
    
    $scope.pageBreadcrums = null;
    $scope.breadcrums = [];
    
    //Signout
    $scope.signout = function(){
	    ArbaProfile.signout();
    };
    
    //Update breadcrums
    $scope.$on('live:update:breadcrums', function(e, breadcrums){
		 $scope.breadcrums = breadcrums || [];
		 
		 if($state.current.name === 'dash.home-page'){
		 	$scope.breadcrums = [];
		 	return;
		 }
		 
		 //$scope.breadcrums.reverse();
    });
    
    //Update title
    $scope.$on('live:update:title', function(e, pageTitle){
		 $rootScope.pageTitle = pageTitle;
    });
    
    //Prepare profile
    $scope.prepareProfile = function(profile, full, silence){
	   silence = silence || false;
	   
	   $scope.$broadcast('live:set:loading', false);
	   $scope.$broadcast('live:main:loading:title', 'Please wait, loading...');
	   
	   if(silence === false)
		   $scope.profile = angular.copy(profile);
	   
	   if($scope.profile === null)
	   		return;
	   
	   //Fix counters
	   $scope.profile.messages = full.messages || 0;
	   
	   var oldNotifications = (typeof $scope.profile.notificationsList != 'undefined')? angular.copy($scope.profile.notificationsList) : null;
	   
	   $scope.profile.notifications = parseInt(full.notifications.unreaded_count) || 0;
	   $scope.profile.notificationsList = [];
	   if(Object.keys(full.notifications).length > 1){
		   angular.forEach(full.notifications, function(notif, i){
			   if(i !== 'unreaded_count' && notif.readed === 0){
			   		$scope.profile.notificationsList.push(notif);
			   		
			   		if(oldNotifications !== null){
				   	   var newNotify = true;
				   	   angular.forEach(oldNotifications, function(old, i){
						   if(parseInt(notif.id) === parseInt(old.id))
						   		newNotify = false;
					   });
					   
					   if(newNotify === true){
						   webNotification.showNotification(notif.title, {
				                body: 'For see more, click here.',
				                icon: notif.avatar,
				                onClick: function onNotificationClicked() {
				                    $log.warn('Notification clicked.');
				                },
				                autoClose: 25000 //auto close the notification after 4 seconds (you can manually close it via hide function)
				            }, function onShow(error, hide) {
				                if (error) {
				                    $log.warn('Unable to show notification: ', error);
				                } else {
				                    $log.warn('Notification Shown.');
				                }
				            });
					   }
			   		}
			   }
		   });
	   }
	   
	   $scope.profile.favorites = full.favorites || 0;
	   $scope.profile.journals = full.journals || 0;
	   $scope.profile.journals_likes = full.journals_likes || 0;
	   $scope.profile.photos = full.photos || 0;
	   $scope.profile.photos_likes = full.photos_likes || 0;
	   $scope.profile.achievements = full.achievements || 0;
	   $scope.profile.achievements_likes = full.achievements_likes || 0;
	   $scope.profile.followers = full.followers || 0;
	   $scope.profile.bookmarks = full.bookmarks || 0;
	   $scope.profile.live_likes = full.live_likes || 0;
	   
	   ArbaProfile.saveProfile(angular.copy($scope.profile));
	   
	   if(silence === false){
		   //Message
		   $arbaSocket.on('message:get:'+ $scope.profile.id, function(data){
		   		$rootScope.$broadcast('update:messages', data);
		   });
		   
		   //Notification
		   $arbaSocket.on('notification:get:'+ $scope.profile.id, function(data){
		   		$rootScope.$broadcast('update:notification', data);
		   });
	   
		   $scope.$broadcast('update:messages');
		   $scope.$broadcast('update:notification');
		   
		   //Profile get event
		   $rootScope.$broadcast('live:profile:get', profile);
		   
		   $timeout(function(){
		       window.promoItems(jQuery);
		   }, 1250);
	   }	   
	   
	   $scope.viewLoaded();
    }
    
    $scope.initHome = function(){ 
		//$scope.pageBreadcrums = $scope.breadcrums[$state.current.name] || null;
    	
    	//GET Profile
    	if($scope.profile === null && ArbaProfile.get('token') !== null){
		    
		    ArbaProfile.go('account', 'GET', {notHideSpinner: true}).then(function(profile){
			   if($scope.profile !== null && !profile.account){
				   
			   }else if(profile && profile.account){
				   $scope.profile = profile.account || null;
				   
				   $scope.cars = profile.cars || [];
				   if(profile.mainCar && profile.mainCar.id)
				   		$scope.cars.unshift(profile.mainCar);
				   
				   if($scope.profile === null || typeof $scope.profile !== typeof {}){
					   $scope.profile = null;
			   
					   $rootScope.$broadcast('live:profile:get:false');
					   
					   return;
				   }
			   }else{
				   $scope.profile = null;
		   
				   $rootScope.$broadcast('live:profile:get:false');
			   }
			   
			   $scope.prepareProfile($scope.profile, profile);
		    });
		    
    	}else if($scope.profile === null && ArbaProfile.get('token') === null && ArbaProfile.get('username') !== null && ArbaProfile.get('password') !== null){
			ArbaProfile.signin().then(function(result){
				if(result === true){
					$scope.initHome();
				}
			});
		}else if($scope.profile === null && ArbaProfile.get('token') === null && ArbaProfile.get('username') === null && ArbaProfile.get('password') === null){
		   $scope.profile = null;
		   
		   $rootScope.$broadcast('live:profile:get:false');
	   
		   $scope.viewLoaded();
    	}
    	
	};
    
    /**
	 * @event - view loading
	 * @var event object
	 * @var viewConfig object
	 */
	angular.element(document).ready($scope.initHome);
    $scope.$on('update:home:profile', $scope.initHome);
    
    $scope.$on('arba-api:authorized', $scope.initHome);
    
    /**
	 * @event - view loaded
	 * @var event object
	 */
    $scope.$signinTimer = null;
    $scope.$on('$viewContentLoaded', 
	function(event){
		if($scope.$signinTimer !== null)
			$timeout.cancel($scope.$signinTimer);
			
		$scope.$signinTimer = $timeout(function(){
			$scope.initHome()
		}, 1000);
	}); 
	
	/**
	 * Live - Update Profile
	 */
	$scope.$on('live:update:profile', function(e){
		if(ArbaProfile.get('token') !== null){
		    ArbaProfile.go('account', 'GET').then(function(profile){
			   if(profile.account){
					$scope.cars = profile.cars || [];
					if(profile.mainCar && profile.mainCar.id)
						$scope.cars.unshift(profile.mainCar);
						
					$scope.prepareProfile(profile.account, profile, true);
			   }
		    });
    	}
	});
	
	
	//Show notifications
	$scope.notifyTemplate = '' +
    '<div id="notify-popup" class="menu-panel" md-whiteframe="4">' +
    '  <div class="menu-content">' +
    '    <div class="row menu-item" ng-repeat="notify in notif.items" ng-if="notify.readed === 0">' +
    '      <div class="col s12" style="padding-left: 0;">' +
    '        <div class="col s3"><img style="width: 100%;" src="{{ notify.avatar }}" /></div>' +
    '        <div class="col s9 no-padding">' +
    '        	<div class="col s12 no-padding">' +
    '        		<span class="notify-title" ng-model="notify.title">{{ notify.title }}</span>' +
    '        	</div>' +
    '        	<div class="col s12 no-padding">' +
    '        		<div class="col s8 no-padding" style="text-align: left;">' +
    '        		     <span style="opacity: .3;padding: 5px;display: block;" am-time-ago="notify.created_at | amFromUnix"></span>' +
    '        		</div>' +
    '        		<div class="col s4 no-padding" style="text-align: right;"><a href="javascript:void(0)">More</a></div>' +
    '        	</div>' +
    '        </div>' +
    '      </div>' +
    '    </div>' +
    '    <md-divider></md-divider>' +
    '    <div class="menu-item">' +
    '      <button class="md-button" ng-click="closeMenu(true, notif.itemsAll)">' +
    '        READED' +
    '      </button>' +
    '    </div>' +
    '    <md-divider></md-divider>' +
    '    <div class="menu-item">' +
    '      <button class="md-button" ng-click="closeMenu()">' +
    '        CLOSE' +
    '      </button>' +
    '    </div>' +
    '  </div>' +
    '</div>';
    
	$scope.showNotifications = function($event){
		var template = $scope.notifyTemplate;
		
		var position = $mdPanel.newPanelPosition()
			.relativeTo('#notify-item')
			.addPanelPosition(
				$mdPanel.xPosition.ALIGN_START,
				$mdPanel.yPosition.BELOW
			);
		
		var config = {
			id: 'toolbar_notifications',
			attachTo: angular.element(document.body),
			controller: 'HomeNotifyCtrl',
			controllerAs: 'notif',
			template: template,
			position: position,
			panelClass: 'menu-panel-container notify-toolbar-container',
			locals: {
				items: $scope.profile.notificationsList.slice(0, 5),
				itemsAll: $scope.profile.notificationsList
			},
			openFrom: $event,
			focusOnOpen: false,
			zIndex: 5000,
			propagateContainerEvents: true,
			groupName: ['toolbar', 'menus']
		};
		
		$mdPanel.open(config);
	}
	
	/**
	 * Notifications	
	 */
	$scope.$on('home:notification:add', function(e, type, response){
		$scope.profile.notifications += 1;
		
		if(type === 'journals_likes')
			$scope.profile.journals_likes += 1;
	}); 
	
	$scope.$on('update:messages', function(e, message){
		//$scope.profile.messages += 1;
		ArbaProfile.go('messages/unreaded-count').then(function(unmessagess){
			if($scope.profile !== null)
				$scope.profile.messages = (typeof unmessagess != 'undefined' && unmessagess.unreaded_count)? unmessagess.unreaded_count : 0;
		});
	});
	$scope.$on('update:notification', function(e, notification){
		/*$scope.profile.notifications = 0;
		ArbaProfile.go('bookmarks/count').then(function(bookmarks){
			$scope.profile.notifications += bookmarks.bookmark_count || 0;
			ArbaProfile.go('subscriptions/count', 'GET', null, {silence: true}).then(function(subscriptions){
				$scope.profile.notifications += subscriptions.subscriptions_count || 0;
			});
		});*/
	});
    
  });
