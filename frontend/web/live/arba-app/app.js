'use strict';

// Arba.Ae web application declaration
angular.module('arbaLiveApp', [
	/*************************
	 * System AngularJS
	 ************************/
	'ui.router',
    'ngAnimate',
    'ngCookies',
    'ngMessages',
    'ngResource',
    'ngSanitize',
    'ngTouch',
	
	/*************************
	 * Materialize AngularJS
	 ************************/
	'ngMaterial',
	
	
	/*************************
	 * BASE64 AngularJS
	 ************************/
	'naif.base64',
	'base64',
	
	
	/*************************
	 * Socket.IO AngularJS
	 ************************/
	'btford.socket-io',
	
	
	/*************************
	 * SweetAlert AngularJS
	 ************************/
	'ng-sweet-alert',
	
	
	/*************************
	 * Froala text editor AngularJS
	 ************************/
	'froala',
	
	
	/*************************
	 * Scroll View AngularJS
	 ************************/
	'duScroll',
	
	
	/*************************
	 * Fancybox AngularJS
	 ************************/
	'fancyboxplus',
	
	
	/*************************
	 * MOMENT AngularJS
	 ************************/
	'angularMoment',
	
	
	/*************************
	 * Notification Icons AngularJS
	 ************************/
	'angular-notification-icons',
	
	
	/*************************
	 * Youtube AngularJS
	 ************************/
	'youtube-embed',
	
	
	/*************************
	 * Filters AngularJS
	 ************************/
	'angular.filter',
	
	
	/*************************
	 * Cache AngularJS
	 ************************/
	'angular-cache',
	
	
	/*************************
	 * Web Notifications AngularJS
	 ************************/
	'angular-web-notification'
])

/*************************
 * Run Engine AngularJS
 ************************/
.run(function(amMoment, $rootScope, $notifyMe){
	amMoment.changeLocale('en');
	
	/*************************
	 * Trigger for notify method send();
	 ************************/
	$rootScope.$on('$notifyMe:send', function(e, name, type, object){
		$notifyMe.send(name, type, object);
	});
	
	/*************************
	 * Try request permissions for notifications
	 ************************/
	 if(Notification && typeof Notification.requestPermission === typeof {}) Notification.requestPermission().then(function(permission) {});
})

/**************************************
 * Config Engine & Routes AngularJS
 **************************************/
.config(function($stateProvider, $locationProvider, $urlRouterProvider) {
	
	//Set prefix of routes
	$locationProvider.hashPrefix('');
	
	//Initialize routes
	$stateProvider
	
	/**
	 * @state dash - base view
	 * @abstract
	 **/
	.state('dash', {
		url: '',
	    abstract: true,
		views: {
			'layout': {
				templateUrl: 'arba-app/views/default/home.html',
				controller: 'HomeCtrl'
			},
			'header@dash': {
			    templateUrl: 'arba-app/views/default/header.html'
			},
			'top-nav@dash': {
			    templateUrl: 'arba-app/views/default/top-nav.html'
			},
			'breadcrumbs@dash': {
			    templateUrl: 'arba-app/views/default/breadcrumbs.html'
			},
			'footer@dash': {
			    templateUrl: 'arba-app/views/default/footer.html'
			},
			'popups@dash': {
			    templateUrl: 'arba-app/views/default/popups.html'
			}
		}
	})
	
	/**
	 * @state dash.home-page - Main Page
	 **/
	.state('dash.home-page', {
	    url: '/home',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/home-page.html',
				controller: 'HomePageCtrl'
			}
		}
	})
		
		
	/**
	 * @state dash.myjournal-list - Car's journal route
	 **/
	.state('dash.myjournal-list', {
	    url: '/cars/journal/list/:journalID/:entryID',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/mycarsjournal-list.html',
				controller: 'CarsjournalCtrl',
				resolve:{
				  deviceID: ['$stateParams', function($stateParams){
				      return {
				          journalID: parseInt($stateParams.journalID),
				          entryID: parseInt($stateParams.journalID) || 0,
				      };
				  }]
				}
			}
		},
		onEnter: function(ArbaProfile){
			//Check access
		    ArbaProfile.access();
		}
	})
	/**
	 * @state dash.myjournal-my - My Car's journal route
	 **/
	.state('dash.myjournal-my', {
	    url: '/cars/journal/my/:carID',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/mycarsjournal-my.html',
				controller: 'MycarsjournalCtrl',
				resolve:{
				  deviceID: ['$stateParams', function($stateParams){
				      return {
				          carID: parseInt($stateParams.carID)
				      };
				  }]
				}
			}
		},
		onEnter: function(ArbaProfile){
			//Check access
		    ArbaProfile.access();
		}
	})
		
		
	/**
	 * @state dash.messages - Messages Dialogs view
	 **/
	.state('dash.messages', {
	    url: '/messages/:type',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/messages.html',
				controller: 'MessagessCtrl',
				resolve:{
				  type: ['$stateParams', function($stateParams){
				      return {
				          type: $stateParams.type 
				      };
				  }]
				}
			}
		},
		onEnter: function(ArbaProfile){
			//Check access
		    ArbaProfile.access();
		}
	})
	/**
	 * @state dash.messages-new - Create New Messages to user
	 **/
	.state('dash.messages-new', {
	    url: '/messages/new/:userID',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/messages-chat.html',
				controller: 'NewChatCtrl',
				resolve:{
				  type: ['$stateParams', function($stateParams){
				      return {
				          userID: parseInt($stateParams.userID)
				      };
				  }]
				}
			}
		},
		onEnter: function(ArbaProfile){
			//Check access
		    ArbaProfile.access();
		}
	})
	/**
	 * @state dash.messages-chat - Chat with user
	 **/
	.state('dash.messages-chat', {
	    url: '/messages/chat/:dialogID',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/messages-chating.html',
				controller: 'ChatCtrl',
				resolve:{
				  type: ['$stateParams', function($stateParams){
				      return {
				          dialogID: parseInt($stateParams.dialogID) 
				      };
				  }]
				}
			}
		},
		onEnter: function(ArbaProfile){
			//Check access
		    ArbaProfile.access();
		}
	})
	
	
	/**
	 * @state dash.notifications - Notifications view
	 **/
	.state('dash.notifications', {
	    url: '/notifications',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/notifications.html',
				controller: 'NotificationsCtrl'
			}
		},
		onEnter: function(ArbaProfile, SweetAlert){
			//Check access
		    ArbaProfile.access();
		}
	})
	
	/**
	 * @state dash.bookmarks -My Bookmarks
	 **/
	.state('dash.bookmarks', {
	    url: '/bookmarks/:type',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/bookmarks.html',
				controller: 'BookmarksCtrl',
				resolve:{
				  type: ['$stateParams', function($stateParams){
				      return {
					      /*
						      users - default
						      blogPosts
						      journals
						      journalEntries
						      communities
						      companies
						      promoActions
					      */
				          type: $stateParams.type 
				      };
				  }]
				}
			}
		},
		onEnter: function(ArbaProfile){
			//Check access
		    ArbaProfile.access();
		}
	})
	
	
	/**
		EMPTY ROUTER FOR COPY PAST
	
	
	.state('dash.', {
	    url: '//:itemID',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/.html',
				controller: 'Ctrl',
				resolve:{
				  type: ['$stateParams', function($stateParams){
				      return {
				          itemID: $stateParams.itemID 
				      };
				  }]
				}
			}
		},
		onEnter: function(ArbaProfile, SweetAlert){
			//Check access
		    ArbaProfile.access();
		}
	})
	
	
	
	
	/******************************************
	 *
	 *
	 * TO DO ROUTES.....
	 *
	 *
	 ******************************************/
		
	//My Subscriptions
	/*.state('dash.my-subscriptions', {
	    url: '/subscriptions/:type',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/subscriptions.html',
				controller: 'SubscriptionsCtrl'
			}
		},
		onEnter: function(ArbaProfile){
			//Check access
		    ArbaProfile.access();
		}
	})
	
	//My Followers
	.state('dash.my-followers', {
	    url: '/followers/:type',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/followers.html',
				controller: 'FollowersCtrl'
			}
		},
		onEnter: function(ArbaProfile){
			//Check access
		    ArbaProfile.access();
		}
	})*/
	
	
	//My Subscriptions
	.state('dash.my-subscriptions', {
	    url: '/subscriptions/:type',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/blank-page.html',
				controller: 'BlankCtrl'
			}
		},
		onEnter: function(ArbaProfile, SweetAlert){
			//Check access
		    ArbaProfile.access();
		}
	})
	
	//My Followers
	.state('dash.my-followers', {
	    url: '/followers/:type',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/blank-page.html',
				controller: 'BlankCtrl'
			}
		},
		onEnter: function(ArbaProfile, SweetAlert){
			//Check access
		    ArbaProfile.access();
		}
	})
	.state('dash.top-cars', {
	    url: '/top/cars',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/blank-page.html',
				controller: 'BlankCtrl'
			}
		},
		onEnter: function(ArbaProfile, SweetAlert){
			//Check access
		    ArbaProfile.access();
		}
	})
	
	.state('dash.blogs', {
	    url: '/blogs',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/blank-page.html',
				controller: 'BlankCtrl'
			}
		},
		onEnter: function(ArbaProfile, SweetAlert){
			//Check access
		    ArbaProfile.access();
		}
	})
	
	.state('dash.communities', {
	    url: '/communities',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/blank-page.html',
				controller: 'BlankCtrl'
			}
		},
		onEnter: function(ArbaProfile, SweetAlert){
			//Check access
		    ArbaProfile.access();
		}
	})
	
	.state('dash.achievements', {
	    url: '/achievements',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/blank-page.html',
				controller: 'BlankCtrl'
			}
		},
		onEnter: function(ArbaProfile, SweetAlert){
			//Check access
		    ArbaProfile.access();
		}
	})
	
	.state('dash.companies', {
	    url: '/companies',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/blank-page.html',
				controller: 'BlankCtrl'
			}
		},
		onEnter: function(ArbaProfile, SweetAlert){
			//Check access
		    ArbaProfile.access();
		}
	})
	
	.state('dash.news', {
	    url: '/news',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/blank-page.html',
				controller: 'BlankCtrl'
			}
		},
		onEnter: function(ArbaProfile, SweetAlert){
			//Check access
		    ArbaProfile.access();
		}
	})
	
	.state('dash.live-likes', {
	    url: '/live/likes',
		views: {
			'app-view': {
				templateUrl: 'arba-app/views/blank-page.html',
				controller: 'BlankCtrl'
			}
		},
		onEnter: function(ArbaProfile, SweetAlert){
			//Check access
		    ArbaProfile.access();
		}
	})
	
	/**
	 * @state dash.signout - Do signout
	 **/
	.state('dash.signout', {
	    url: '/signout',
		views: {
			'app-view': {
				template: '<h2 style="margin: 35px; text-align: center; width: 100%">Please wait! Disconnection...</h2>',
				controller: function(ArbaProfile){
					ArbaProfile.signout('/');
				}
			}
		}
	})
	
	//END Routes
	;
	
	//Default router configs
	$urlRouterProvider.otherwise('/home');
	
	//Old router
	/*$urlRouterProvider.otherwise(function ($injector, $location) {
        window.location.replace('/404/');
    });*/
	
});