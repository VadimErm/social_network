'use strict';

/**
 * @ngdoc function
 * @name arbaLiveApp.controller:MessagessCtrl
 * @description
 * # MessagessCtrl
 * Controller of the arbaLiveApp
 */
angular.module('arbaLiveApp')
  
  .controller('NewChatCtrl', function ($scope, $rootScope, $state, $stateParams, ArbaProfile, $arbaLiveService, $log, $timeout) {
    this.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
    
    //Redirect helper
    $scope.goTo = function(url){
		window.location.replace('/' + url);
		return false;
    };
    
    /**
	 * @var listType message
	 */
    $scope.userID = $stateParams.userID || null;
	if($scope.userID === null)
		return $scope.goTo('404');
    
    //Update title
    var pageTitle = 'New Message';
    $rootScope.$broadcast('live:update:title', pageTitle);
    
    //Selected Messages
    $scope.selectedMessages = [];
	
    //New Message
    $scope.$defs = {
	    receiver_id: $scope.userID,
	    title: 'New Message',
	    text: '',
	    images: [],
	    videos: [],
	    newVideo: false
    };
    $scope.$fields = angular.copy($scope.$defs);
    
	//Message Helper
	$scope.$helper = {
		images: [],
	    viewImages: []
	};
	
	//Add images
	$scope.addImages = function(event, reader, file, fileList, fileObjs, object){
		$scope.$helper.viewImages.unshift(URL.createObjectURL(file));
		$scope.$fields.images.unshift(object.base64);
	};
	
	//Remove image
	$scope.removeImage = function(i){
		if(typeof $scope.$fields.images[i] != 'undefined')
			$scope.$fields.images.splice(i, 1);
			
		if(typeof $scope.$helper.viewImages[i] != 'undefined')
			$scope.$helper.viewImages.splice(i, 1);
	}
	
	//Videos
	$scope.showVideo = function(){
		$scope.$fields.newVideo = '';
	};
	$scope.hideVideo = function(){
		$scope.$fields.newVideo = false;
		$scope.$fields.videos = [];
	}
	$scope.addVideo = function(){
		if(
			$scope.$fields.newVideo !== '' && 
			$scope.$fields.newVideo.search('youtu') >= 0 && 
			$scope.$fields.videos.indexOf($scope.$fields.newVideo) === -1
		){
			$scope.$fields.videos.unshift(angular.copy($scope.$fields.newVideo));
			$scope.$fields.newVideo = '';
		}
	};
	$scope.removeVideo = function(key){
		$scope.$fields.videos.splice(key, 1);
	};
    
    /**
	 * @event - profile loading
	 * @var event object
	 * @var viewConfig object
	 */
	$scope.profile = null;
    $scope.viewInit = function(e, profile){
	    $scope.profile = profile;
	    
		ArbaProfile.go('messages', 'GET').then(function(dialogs){
			var dialogID = false;
			if(dialogs.status === 'success' && dialogs.dialogs){
				angular.forEach(dialogs.dialogs, function(dialog, i){
					if(
						dialog.author_id === $scope.profile.user_id &&
						dialog.receiver_id === parseInt($scope.userID) &&
						dialog.isDeleted !== 1
					)
						dialogID = dialog.id;
				});
			}
			
			
			if(dialogID !== false)
				$state.go('dash.messages-chat', {dialogID: dialogID});
			else
				ArbaProfile.loading(true);
		});
    };
    $scope.$on('live:profile:get', $scope.viewInit);
    
    /**
	 * @event - view loaded
	 * @var event object
	 */
	$scope.$on('$viewContentLoaded', function(event){
		
		//Wait .75sec if loading profile or 0sec if it here
		var delay = (ArbaProfile.getProfile() !== null)? 0 : 250;
		
		$timeout(function(){
			
			if($scope.profile === null)
				$scope.viewInit(event, ArbaProfile.getProfile());
				
		}, delay);
		
	});
	
	//Send Message
	$scope.send = function(){		
	    ArbaProfile.go('messages', 'POST', null, { 'MessageRest': $scope.$fields }).then(function(response){			
		    if(response.status && response.status === 'success' && response.message.id){
				
				ArbaProfile.go('messages', 'GET', null).then(function(dialogs){
					var dialogID = false;
					if(dialogs.status === 'success' && dialogs.dialogs){
						angular.forEach(dialogs.dialogs, function(dialog, i){
							if(
								dialog.last_message && 
								dialog.last_message.text === $scope.$fields.text && 
								dialog.author_id === $scope.profile.user_id
							)
								dialogID = dialog.id;
						});
					}
					
					if(dialogID === false){
					    SweetAlert.alert(
							"Make sure that you fill all require fields, and try again...", 
							{title: "Server error!"}
						);
						return;
					}
				
					$scope.$fields = angular.copy($scope.$defs);
					$scope.$helper = {
						images: [],
					    viewImages: []
					};
					
					$arbaLiveService.send('update:messages:user_id:'+$scope.userID, 'newMessage', response.message);
					
					$state.go('dash.messages-chat', {dialogID: dialogID});
				});
				
		    }else{
			    SweetAlert.alert(
					"Make sure that you fill all require fields, and try again...", 
					{title: "Server error!"}
				);
		    }
	    });
	};
	
	ArbaProfile.loading();
	  
  })  
  
  .controller('ChatCtrl', function ($scope, $rootScope, $state, $stateParams, ArbaProfile, arbaCache, $arbaLiveService, SweetAlert, $log, $timeout) {
    this.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
    
    //Redirect helper
    $scope.goTo = function(url){
		window.location.replace('/' + url);
		return false;
    };
    
    /**
	 * @var $selected array - list of selected messagess
	 */
	$scope.$selected = [];
    
    /**
	 * @var Dialog ID
	 */
    $scope.dialogID = $stateParams.dialogID || null;
	if($scope.dialogID === null)
		return $scope.goTo('404');
    
    //Update title
    var pageTitle = 'New Message';
    $rootScope.$broadcast('live:update:title', pageTitle);
	
	//Receiver
	$scope.userID = null;
	
    //New Message
    $scope.$defs = {
	    receiver_id: $scope.userID,
	    title: 'New Message',
	    text: '',
	    images: [],
	    videos: [],
	    newVideo: false
    };
    $scope.$fields = angular.copy($scope.$defs);
    
	//Message Helper
	$scope.$helper = {
		images: [],
	    viewImages: []
	};
	
	//Add images
	$scope.addImages = function(event, reader, file, fileList, fileObjs, object){
		$scope.$helper.viewImages.unshift(URL.createObjectURL(file));
		$scope.$fields.images.unshift(object.base64);
	};
	
	//Remove image
	$scope.removeImage = function(i){
		if(typeof $scope.$fields.images[i] != 'undefined')
			$scope.$fields.images.splice(i, 1);
			
		if(typeof $scope.$helper.viewImages[i] != 'undefined')
			$scope.$helper.viewImages.splice(i, 1);
	}
	
	//Videos
	$scope.showVideo = function(){
		$scope.$fields.newVideo = '';
	};
	$scope.hideVideo = function(){
		$scope.$fields.newVideo = false;
		$scope.$fields.videos = [];
	}
	$scope.addVideo = function(){
		if(
			$scope.$fields.newVideo !== '' && 
			$scope.$fields.newVideo.search('youtu') >= 0 && 
			$scope.$fields.videos.indexOf($scope.$fields.newVideo) === -1
		){
			$scope.$fields.videos.unshift(angular.copy($scope.$fields.newVideo));
			$scope.$fields.newVideo = '';
		}
	};
	$scope.removeVideo = function(key){
		$scope.$fields.videos.splice(key, 1);
	};
	
	//Send Message
	$scope.send = function(){
		ArbaProfile.go('messages', 'POST', null, { 'MessageRest': $scope.$fields }).then(function(response){			
		    if(response.status && response.status === 'success' && response.message.id){
					
				$scope.messages.push(response.message);
				
				$scope.$fields = angular.copy($scope.$defs);
				$scope.$helper = {
					images: [],
				    viewImages: []
				};
				
				//Update chat messagess
				$arbaLiveService.send('update:messages:user_id:'+$scope.userID, 'newMessage', response.message);
				
		    }else{
			    SweetAlert.alert(
					"Make sure that you fill all require fields, and try again...", 
					{title: "Server error!"}
				);
		    }
	    });
	};
	
	//Select dialogs are readed
	$scope.selectReaded = function(i, callback){
		i = i || 0;
		callback = callback || function(){};
		
		if(typeof $scope.messages[i] !== typeof {}){
			$rootScope.$broadcast('update:messages');
			callback();
			return;
		}
		
		if($scope.messages[i].readed === 1 || $scope.messages[i].author_id === $scope.profile.user_id){
			$scope.selectReaded(i+1, callback);	
		}else{
			ArbaProfile.go('messages/readed', 'PUT', null, {message_id: $scope.messages[i].id}).then(function(result){
				if(result.status === 'success')
					$scope.messages[i].readed = 1;
				
				$scope.selectReaded(i+1, callback);
			});
		}
	}
	
	/**
	 * @method - search by query
	 * @var $query string
	 */
	$scope.searchString = '';
	$scope.search = function(){
		if($scope.searchString !== ''){
			$scope.messages = [];
			var searchStr = angular.copy($scope.searchString.toLowerCase());
			angular.forEach($scope.allMessages, function(message, i){
				if(message.text.toLowerCase().search(searchStr) >= 0)
					$scope.messages.push(angular.copy(message));
			});
		}else{
			$scope.messages = angular.copy($scope.allMessages);
		}
	};
	
	/**
	 * @method - update socket.io list
	 */
	$scope.messages = [];
	$scope.allMessages = [];
	$scope.update = function(silence){
		silence = silence || false;
		
		//Get user messages
		ArbaProfile.go('messages/view-dialog/'+$scope.dialogID, 'GET', null, {silence: silence}).then(function(messages){
		    var messagesList = [];
		    
		    if(messages.dialog.isDeleted === 1){
			    $state.go('dash.messages', {type: 'all'});
			    return;
		    }
		    
		    if(messages.dialog.messages.length){
			    angular.forEach(messages.dialog.messages, function(message, i){
					 if(message.isDeleted !== 1)
					 	messagesList.push(message);
			    });
		    }
		    
		    $scope.messages = messagesList;
		    $scope.allMessages = angular.copy($scope.messages);
		    
		    $scope.userID = (messages.dialog.author_id !== $scope.profile.user_id)? messages.dialog.author_id : messages.dialog.receiver_id;
		    
		    $scope.$defs.receiver_id = $scope.userID;
		    $scope.$fields = angular.copy($scope.$defs);
			
			$scope.selectReaded(0, function(){
				arbaCache.set($state.current.name +'::messages:'+$scope.dialogID, $scope.messages);
			});		
		});
	};
    
    /**
	 * @event - profile loading
	 * @var event object
	 * @var viewConfig object
	 */
	$scope.profile = null;
    $scope.viewInit = function(e, profile, delay){
	    $scope.profile = profile;
	    var timer = (delay === true)? 0 : 250;
		
		if(arbaCache.get($state.current.name +'::messages:'+$scope.dialogID)){
			$scope.messages = arbaCache.get($state.current.name +'::messages:'+$scope.dialogID);
		    $scope.allMessages = angular.copy($scope.messages);
			
			$timeout(function(){
				$scope.update(true);
			}, timer);
		}else{
			$timeout(function(){
				$scope.update();
			}, timer);
		}
    };
    $scope.$on('live:profile:get', $scope.viewInit);
	
	if(ArbaProfile.getProfile() !== null)
		$scope.viewInit(null, ArbaProfile.getProfile(), true);
		
	$scope.$on('update:messages', function(e, type, message){
		if(type === 'newMessage'){
			$scope.messages.unshift(message);
			
			$timeout(function(){
				$scope.selectReaded();
			}, 1000);
		}
	});
	
	$scope.clearDialog = function(){
		if(!$scope.messages.length){
			SweetAlert.alert(
				"You hadn't any messages with this user for clearing.", 
				{title: "Sorry!"}
			);
			return;	
		}
		
		SweetAlert.confirm('You realy want clear history for this dialog?', {title : "Clear history?"})
          .then(function(confirmed) {
	        if(confirmed){
				ArbaProfile.go('messages/clear-history', 'DELETE', null, {dialog_id: $scope.dialogID, silence: false}).then(function(response){
					if(response.status === 'success'){
						$scope.update();
					}else{
						SweetAlert.alert(
							"Make sure that you fill all require fields, and try again...", 
							{title: "Server error!"}
						);
					}
				});
			}else{
				$scope.update();
			}
	          
          });
	};
	
	/**
	 * View Helpers	
	 */
	$scope.isSelected = function(id){
		return ($scope.$selected.indexOf(id) === -1)? false : true;
	}
	$scope.selectItem = function(i){
		if($scope.messages[i]){
			if(!$scope.isSelected($scope.messages[i].id))
				$scope.$selected.push($scope.messages[i].id);
			else
				$scope.$selected.splice($scope.$selected.indexOf($scope.messages[i].id), 1);
		}
	}
	
  })  

  .controller('MessagessCtrl', function ($scope, $rootScope, ArbaProfile, arbaCache, $state, $stateParams, SweetAlert, $log, $timeout) {
    this.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
    
    //Redirect helper
    $scope.goTo = function(url){
		window.location.replace('/' + url);
		return false;
    };
    
    /**
	 * @var listType message
	 */
    $scope.listType = $stateParams.type || null;
	if($scope.listType === null)
		return $scope.goTo('404');
    
    //Update title
    var pageTitle = ' Messages';
    if($scope.listType === 'all')
    	pageTitle = '' + pageTitle;
    else if($scope.listType === 'unread')
    	pageTitle = 'Unread' + pageTitle;
    else if($scope.listType === 'blacklist')
    	pageTitle = 'Blacklist' + pageTitle;
    	
    $rootScope.$broadcast('live:update:title', pageTitle);
    
    /**
	 * @var $page int - default is 1
	 */
    $scope.$page = 1;
    
    /**
	 * @var $list array - list of items
	 */
    $scope.$list = [];
    
    /**
	 * @var $fields object - list of form fields
	 */
	$scope.$fields = {};
    
    /**
	 * @var $selected array - list of selected messagess
	 */
	$scope.$selected = [];
	
	
	
	/**
	 * @method - get list items
	 * @var $page int
	 */
	$scope.list = function($page){
		
	};
	
	/**
	 * @method - clean chat
	 * @var $id int
	 */
	$scope.clean = function($id){
		
	};
	
	$scope.clearAllDialog = function(){
		if(!$scope.dialogs.length){
			SweetAlert.alert(
				"You hadn't any dialogs for deleting.", 
				{title: "Sorry!"}
			);
			return;	
		}
			
		SweetAlert.confirm('You realy want remove all dialogs?', {title : "Remove dialogs?"})
          .then(function(confirmed) {
	        if(confirmed){
				ArbaProfile.go('messages/delete-all-dialogs', 'DELETE', null, {silence: false}).then(function(response){
					if(response.status === 'success'){
						$scope.update();
					}else{
						SweetAlert.alert(
							"Make sure that you fill all require fields, and try again...", 
							{title: "Server error!"}
						);
					}
				});
			}else{
				$scope.update();
			}
	          
          });
	};
	
	/**
	 * @method - search by query
	 * @var $query string
	 */
	$scope.searchString = '';
	$scope.search = function(){
		if($scope.searchString !== ''){
			$scope.dialogs = [];
			var searchStr = angular.copy($scope.searchString.toLowerCase());
			angular.forEach($scope.allDialogs, function(dialog, i){
				if(dialog.last_message.text.toLowerCase().search(searchStr) >= 0)
					$scope.dialogs.push(angular.copy(dialog));
			});
		}else{
			$scope.dialogs = angular.copy($scope.allDialogs);
		}
	};
	
	/**
	 * @method - add to blacklist user
	 * @var $userID int
	 */
	$scope.block = function($userID){
		
	};
	
	/**
	 * @method - get chat
	 */
	$scope.get = function(){
		
	};
	
	/**
	 * @method - add user to current chat
	 * @var $userID int
	 */
	$scope.addUser = function($userID){
		
	};
	
	/**
	 * @method - send message
	 */
	$scope.send = function(){
		
	};
	
	/**
	 * @method - re-send messagess to another user
	 * @var $userID int
	 */
	$scope.resend = function($userID){
		
	};
	
	$scope.clearDialog = function(dialog){
		SweetAlert.confirm('You realy want clear history for this dialog?', {title : "Clear history?"})
          .then(function(confirmed) {
	        if(confirmed){
				ArbaProfile.go('messages/clear-history', 'DELETE', null, {dialog_id: dialog.id, silence: false}).then(function(response){
					if(response.status === 'success'){
						$scope.update();
					}else{
						SweetAlert.alert(
							"Make sure that you fill all require fields, and try again...", 
							{title: "Server error!"}
						);
					}
				});
			}
          });
	};
	
	/**
	 * @method - update socket.io list
	 */
	$scope.update = function(silence){
		silence = silence || false;
		
		if($scope.dialogs.length){
			var isNone = true;
			angular.forEach($scope.dialogs, function(dialog, i){
				if($scope.listType === 'unread' && (dialog.last_message.readed === 0 && dialog.last_message.receiver_id === $scope.profile.user_id && dialog.last_message.author_id !== $scope.profile.user_id))
					isNone = false;
				else if($scope.listType === 'blacklist' && dialog.last_message.blocked === 1)
					isNone = false;
				
			});
			$scope.noneDialogs = ($scope.listType === 'all')? false : isNone;
		}
		
		//Get user messages
		ArbaProfile.go('messages', 'GET', null, {silence: silence}).then(function(dialogs){
			$scope.dialogs = dialogs.dialogs;
		
			if($scope.dialogs.length){
				var isNone = true;
				angular.forEach($scope.dialogs, function(dialog, i){
					if(dialog.isDeleted === 0){
						if($scope.listType === 'unread' && (dialog.last_message.readed === 0 && dialog.last_message.receiver_id === $scope.profile.user_id && dialog.last_message.author_id !== $scope.profile.user_id))
							isNone = false;
						else if($scope.listType === 'blacklist' && dialog.last_message.blocked === 1)
							isNone = false;
					}else{
						if($scope.dialogs.length === 1)
							$scope.dialogs = [];
						else
							$scope.dialogs.splice(i, 1);
					}
					
				});
				$scope.noneDialogs = ($scope.listType === 'all')? false : isNone;
			}
			
			$scope.allDialogs = angular.copy($scope.dialogs);
			
			arbaCache.set($state.current.name, $scope.dialogs);
		});
	};
	
	$scope.dialogs = [];
	$scope.allDialogs = [];
	$scope.noneDialogs = false;
	$scope.viewInit = function(e, profile, delay){
		$scope.profile = profile;
	    var timer = (delay === true)? 0 : 750;
		
		if(arbaCache.get($state.current.name)){
			$scope.dialogs = arbaCache.get($state.current.name);
			$scope.allDialogs = angular.copy($scope.dialogs);
			$timeout(function(){
				$scope.update(true);
			}, timer);
		}else{
			$timeout(function(){
				$scope.update();
			}, timer);
		}
		
    };
	
	$scope.$on('update:messages', function(e, type, message){
		if(type === 'newMessage')
			$scope.update(true);
	});
    
    /**
	 * @event - profile loading
	 * @var event object
	 * @var viewConfig object
	 */
    $scope.$on('live:profile:get', $scope.viewInit);
	
	if(ArbaProfile.getProfile() !== null)
		$scope.viewInit(null, ArbaProfile.getProfile(), true);
    
  });
