'use strict';

/**
 * @ngdoc function
 * @name arbaLiveApp.controller:MycarsjournalCtrl
 * @description
 * # MycarsjournalCtrl
 * Controller of the arbaLiveApp
 */
angular.module('arbaLiveApp')
  .value('froalaConfig', {
	  placeholderText: 'Entry text'
  })  
  
  .controller('CarsjournalToolbarCtrl', function($scope, $rootScope){
	  
  })
  
  .controller('MycarsjournalCtrl', function ($scope, $rootScope, $state, $stateParams, $arbaLiveService, $notifyMe, ArbaProfile, arbaCache, ArbaSocial, $timeout, $log, $base64, $document, SweetAlert, orderByFilter, $mdPanel) {
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
	 * @var $page int - default is 1
	 */
    $scope.$page = 1;
    
    /**
	 * @var $list array - list of items
	 */
    $scope.$list = [];
    
    $scope.viewMore = function(entry){
	    $log.warn(entry);
    }
    
    //Toolbar templates
    $scope.$templates = {};
    $scope.$templates['default-toolbar'] = '' +
    	'<div class="menu-panel" md-whiteframe="4">' +
        '  <div class="menu-content">' +
        '    <div class="menu-item">' +
        '      <button class="md-button">' +
        '        <span>Move to "ex-cars"</span>' +
        '      </button>' +
        '    </div>' +
        '    <md-divider></md-divider>' +
        '    <div class="menu-item">' +
        '      <button class="md-button">' +
        '        <span>Edit</span>' +
        '      </button>' +
        '    </div>' +
        '    <md-divider></md-divider>' +
        '    <div class="menu-item">' +
        '      <button class="md-button">' +
        '        <span>Delete</span>' +
        '      </button>' +
        '    </div>' +
        '  </div>' +
        '</div>';
    
    //Toolbar
    $scope.$toolbar = function(itemID){
	    var template = $scope.$templates[itemID];
	    
	    var position = $mdPanel.newPanelPosition()
			.relativeTo('#'+itemID)
			.addPanelPosition(
				$mdPanel.xPosition.ALIGN_START,
				$mdPanel.yPosition.BELOW
			);
		
		var config = {
			id: 'toolbar_cars_journal',
			attachTo: angular.element(document.body),
			controller: 'CarsjournalToolbarCtrl',
			controllerAs: 'toolCtrl',
			template: template,
			position: position,
			panelClass: 'menu-panel-container cars-toolbar-container',
			locals: {},
			openFrom: $event,
			focusOnOpen: false,
			zIndex: 5000,
			propagateContainerEvents: true,
			groupName: ['toolbar', 'menus']
		};
		
		$mdPanel.open(config);
    };
    
    //Sorting
    $scope.$sorting = 'created_at';
    $scope.entriesSort = function(){
	    var sort = $scope.$sorting !== ''? $scope.$sorting : 'created_at';
	    $scope.all_entries = orderByFilter($scope.all_entries, sort, true);
	    
		$scope.pre_entries = angular.copy($scope.all_entries);
		if($scope.all_entries && $scope.all_entries !== null && $scope.all_entries.length > 10){
			$scope.pre_entries = $scope.pre_entries.slice(0, 10);
			$scope.currentCar.journal.entries = angular.copy($scope.pre_entries);
		}else{
			$scope.currentCar.journal.entries = angular.copy($scope.all_entries);
		}
			
    };
    
    $scope.showAllImages = function(entry){
	    entry.showAllImages = true;
    }
    
    //Scroller
    $scope.scrollView = function(id){
		var element = angular.element(document.getElementById(id));
		$document.scrollToElement(element, 0);
    };
    
    //Helpers form
    $scope.$helper = {
	    languages: ['English', 'Arabic', 'French', 'German', 'Italian', 'Russian'],
	    types: [{value: 1, label: 'Expenses'}, {value: 2, label: 'Mileage'}],
	    currencies: ['USD', 'AED'],
	    
	    //For multiply images
	    images: [],
	    viewImages: [],
	    proccessed: []
	};
	
	//Comments
	$scope.$helper_comment = {
		images: [],
	    viewImages: []
	};
	$scope.$defs_comment = {
		text: '',
		images_base64: []		
	};
	$scope.$comment = angular.copy($scope.$defs_comment);
	
	//Add images
	$scope.addImages = function(event, reader, file, fileList, fileObjs, object){
		$scope.$helper.viewImages.push(URL.createObjectURL(file));
		$scope.$fields.images_base64.push(object.base64);
	};
	
	//Remove image
	$scope.removeImage = function(i){
		if(typeof $scope.$fields.images_base64[i] != 'undefined')
			$scope.$fields.images_base64.splice(i, 1);
			
		if(typeof $scope.$helper.viewImages[i] != 'undefined')
			$scope.$helper.viewImages.splice(i, 1);
	}
	
	//Comment images
	$scope.addCommentImages = function(event, reader, file, fileList, fileObjs, object){
		$scope.$helper_comment.viewImages.push(URL.createObjectURL(file));
		$scope.$comment.images_base64.push(object.base64);
	};
	$scope.removeCommentImage = function(i){
		if(typeof $scope.$comment.images_base64[i] != 'undefined')
			$scope.$comment.images_base64.splice(i, 1);
			
		if(typeof $scope.$helper_comment.viewImages[i] != 'undefined')
			$scope.$helper_comment.viewImages.splice(i, 1);
	}
    
    /**
	 * @var $defs object - list of form fields
	 */
	$scope.$defs = {
		title: '',
		text: '',
		language: null,
		type: 1,
		mileage: 0.0,
		expenses: 0.0,
		currency: null,
		hidden: false,
		images_base64: [],
		tags: [],
		journal_id: null
	};
	$scope.$fields = angular.copy($scope.$defs);
    
    /**
	 * @var profile object - profile data
	 */
    $scope.profile = null;
    
    /**
	 * @var cars object - user cars data
	 */
    $scope.cars = [];
    
    /**
	 * @var carID integer & currentCar object
	 */
    $scope.carID = $stateParams.carID || null;
	if($scope.carID === null)
		return $scope.goTo('garage');
		
    $scope.carID = parseInt($scope.carID);
    $scope.currentCar = null;
    
    $scope.carOwner = 0;
	
    //Update title
    $rootScope.$broadcast('live:update:title', 'My car`s journal');
	
	
	/**
	 * @method - get list items
	 * @var $page int
	 * @var $sort string
	 */
	$scope.list = function(){
		
	};
	
	/**
	 * @method - get list item
	 * @var $id int
	 */
	$scope.get = function($id){
		
	};
	
	$scope.removeEntry = function(entry){
		SweetAlert.confirm('You realy want remove entry "'+entry.title+'"?', {title : "Remove this entry?"})
          .then(function(confirmed) {
	        if(confirmed){
				ArbaProfile.go('journals/'+entry.id, 'DELETE', null, {silence: false}).then(function(response){
					if(response.status === 'success'){
						$scope.update();
						SweetAlert.success("Entry was removed.", {title: "Successful!"});
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
	
	$scope.getBase64Image = function(url, callback) {
	    var xhr = new XMLHttpRequest();
	    xhr.onload = function() {
	        var reader = new FileReader();
	        reader.onloadend = function() {
	            callback(reader.result);
	        }
	        reader.readAsDataURL(xhr.response);
	    };
	    xhr.open('GET', url);
	    xhr.responseType = 'blob';
	    xhr.send();
	};
	
	$scope.$edit_fields = {};
	$scope.$edit_fields_helper = {};
	$scope.editEntry = function(entry){
		$scope.$edit_fields = angular.copy(entry);
		$scope.$edit_fields_helper = {
		    images: [],
		    viewImages: entry.images,
		    proccessed: []
		}
		
		var tags = [];
		angular.forEach($scope.$edit_fields.tags, function(tag, i){
			tags.push(tag.name);
		});
		$scope.$edit_fields.tags = tags;
		
		var images = [];
		angular.forEach($scope.$edit_fields.images, function(image, i){
			$scope.getBase64Image(image.src, function(myBase64){
				images.push($base64.encode(myBase64));
			});
		});
		$scope.$edit_fields.images_base64 = images;
	};
	$scope.edit = function(){
		ArbaProfile.prepare({
		   type: 'PATCH',
		   route: 'journals/'+$scope.$edit_fields.id,
		   params: { 'JournalEntryRest': $scope.$edit_fields }
	    });
	    
	    ArbaProfile.send().then(function(response){
		    if(response.status && response.status === 'success'){
				$scope.$edit_fields = {};
				$scope.$edit_fields_helper = {};
				
				$scope.update();
				SweetAlert.success("Entry was updated.", {title: "Successful!"});
			}else{
				SweetAlert.alert(
					"Make sure that you fill all require fields, and try again...", 
					{title: "Server error!"}
				);
			}
		});
	};
	$scope.disableEditEntry = function(){
		$scope.$edit_fields = {};
		$scope.$edit_fields_helper = {};
	};
	$scope.addEditImages = function(event, reader, file, fileList, fileObjs, object){
		$log.warn(event, reader, file, fileList, fileObjs, object);
	};
	
	/**
	 * @method - add new item
	 */
	$scope.add = function(){
		//Send to server new entry
		ArbaProfile.prepare({
		   type: 'POST',
		   route: 'journals',
		   params: { 'JournalEntryRest': $scope.$fields }
	    });
	    
	    ArbaProfile.send().then(function(response){
		    if(response.status && response.status === 'success'){
		
				//Trigger new entry event
				SweetAlert.success(
					"Entry was created.", 
					{title: "Successful!"}
				).then(function(){
					if(typeof response.journal_entry === typeof {})
						$arbaLiveService.send('cars:journal:update:'+$scope.carID, 'addEntry', response.journal_entry);
					else
						$arbaLiveService.send('cars:journal:update:'+$scope.carID, 'addEntry', $scope.$fields);
					
					//Scroll to view entries
					$scope.scrollView('add-new-entry-form');
										
					$scope.$fields = angular.copy($scope.$defs);
					
				    $scope.$helper.images = [];
				    $scope.$helper.viewImages = [];
				    $scope.$helper.proccessed = [];
				    
				    //hide form
				    var addEntryForm = document.getElementById('new-entry-form');
				    if(addEntryForm !== null) addEntryForm.style = "margin-top: 15px; display: none;";
				});
				
		    }else{
			    SweetAlert.alert(
					"Make sure that you fill all require fields, and try again...", 
					{title: "Server error!"}
				);
		    }
	    });
	};
	
	/**
	 * @method - update socket.io list
	 */
	$scope.update = function(e, type, response){
		e = e || null; 
		type = type || ''; 
		response = response || {};
		
		if(type === 'addEntry'){
			$scope.currentCar.journal.entries.unshift(response);
			
			if($scope.currentCar.journal.entries.length > 10){
				$scope.currentCar.journal.entries = $scope.currentCar.journal.entries.slice(0, 10);
				$scope.pre_entries = angular.copy($scope.currentCar.journal.entries);
			}
			
			$scope.all_entries.unshift(response);
		}else{
			ArbaProfile.viewLoaded(true);
			$scope.viewInit(null, $scope.profile, true);
		}
	};
	$scope.$on('cars:journal:update:'+$scope.carID, $scope.update);	
	
	//Likes
	$scope.$on('cars:journal:like:'+$scope.carID, $scope.update);
	
	$scope.viewInit = function(e, profile, silence){
		profile = profile || false;
		silence = silence || false;
		
		if(profile === false || (angular.equals(profile, $scope.profile) && silence === false))
			return;
			
		if(silence === false && arbaCache.get($state.current.name + ':' +$scope.carID)){
			$scope.currentCar = arbaCache.get($state.current.name + ':' +$scope.carID);
			silence = true;
			
			ArbaProfile.loading(true);
			ArbaProfile.viewLoaded(true);
		}
		
		$scope.profile = profile || null;
		
		var delay = silence === true? 0 : 250;
		
		$timeout(function(){
			//Get user cars
			ArbaProfile.go('cars/'+$scope.carID, 'GET', null, {silence: silence}).then(function(cars){
				var imageChanged = ($scope.currentCar !== null && angular.equals($scope.currentCar.images, cars.car.images))? false : true;
				
				if(imageChanged === true){
					$scope.currentCar = null;
					silence = false;
				}
				
				if(silence === false)
					$scope.currentCar = cars.car;
				
				$scope.carOwner = cars.user_id;
				
				if($scope.currentCar === null)
					return $scope.goTo('garage');
				
				//Update Breadcrums
				$rootScope.$broadcast('live:update:breadcrums', cars.breadcrumbs);
					
				$scope.currentCar.comments = cars.comments.count || 0;
				$scope.currentCar.commentsAll = [];
				$scope.currentCar.commentsList = [];
				$scope.currentCar.commentsCut = [];
				if(Object.keys(cars.comments).length > 1){
					angular.forEach(cars.comments, function(comment, key){
						if(key !== 'count')
							$scope.currentCar.commentsAll.unshift(comment);
					});
					
					$scope.currentCar.commentsAll.reverse();
					$scope.currentCar.commentsList = $scope.currentCar.commentsAll.slice(0, 10);
					$scope.currentCar.commentsCut = angular.copy($scope.currentCar.commentsList);
				}
				
				$scope.currentCar.car_type = cars.car.drive_type || 'Empty';
				
				//Add default tag
				$scope.$fields.tags = [];
				$scope.$fields.tags.push(cars.car.car_name);
				
				//TO DO
				$scope.currentCar.favorites = cars.car.favorites || 0;
				$scope.currentCar.about = cars.car.about || 'About my car is empty.';
				
				$scope.currentCar.live_likes = cars.car.live_likes || 0;
				$scope.currentCar.likes = cars.car.likes || 0;
				$scope.currentCar.followers = cars.car.followers || 0;
				
				$scope.currentCar.buildDate = cars.car.build_date || '';
				$scope.currentCar.useSience = cars.car.use_since || '';
				
				$scope.currentCar.capacity = cars.car.capacity || 240;
				$scope.currentCar.car_number = cars.car.car_number || false;
				$scope.currentCar.reg_date = cars.car.use_since || '';
				
				//Fix data null
				if(!$scope.currentCar.journal && !angular.equals($scope.all_entries, cars.journal.entries)){
					$scope.currentCar.journal = cars.journal;
					
					//Slice journal entries
					$scope.all_entries = angular.copy($scope.currentCar.journal.entries);
			    
				    //Fix dates
				    angular.forEach($scope.all_entries, function(entry, i){
					    $scope.all_entries[i].created_at = parseInt(entry.created_at);
				    });
				    
				    $log.warn($scope.all_entries);
				    
				    //Fill objects
					$scope.pre_entries = angular.copy($scope.all_entries);
					if($scope.all_entries.length > 10){
						$scope.pre_entries = $scope.pre_entries.slice(0, 10);
						
						$scope.currentCar.journal.entries = angular.copy($scope.pre_entries);
					}
				
					$scope.currentCar.journal.entries.reverse();
				}
				
				//Add journal ID
				$scope.$defs.journal_id = $scope.currentCar.journal.id;
				$scope.$fields = angular.copy($scope.$defs);
				
				if(silence === false)
					ArbaProfile.viewLoaded(true);
				
				arbaCache.set($state.current.name + ':' +$scope.carID, $scope.currentCar);
				
		    	//Launcher
			    $scope.list();
			    
			    //Sorting
			    $scope.entriesSort();
			});
		}, delay);
		
    };
    
    /**
	 * @event - profile uploaded
	 * @var event object
	 * @var viewConfig object
	 */
    $scope.$on('live:profile:get', $scope.viewInit);
    $scope.$on('live:profile:get:false', function(){
	    $scope.goTo('');
    });
	
	$scope.$on('$viewContentLoaded', function(event){
		
		//Wait .75sec if loading profile or 0sec if it here
		var delay = (ArbaProfile.getProfile() !== null)? 0 : 1000;
		
		$timeout(function(){
			if($scope.profile === null && ArbaProfile.getProfile() !== null)
				$scope.viewInit(event, ArbaProfile.getProfile());
				
		}, delay);
		
	});
		
	ArbaProfile.loading();
	
	/**
	 * View Helpers
	 */
	
	
	/**
	 * @method - add new comment
	 */
	$scope.addComment = function(answer_comment_id, user_id){
		answer_comment_id = answer_comment_id || false;
		user_id = user_id || false;
		
		var params = {
		   'Comment': {
				node_id: $scope.carID,
				message: $scope.$comment.text,
				answer_comment_id: 0
			}
		};
		
		if(answer_comment_id !== false)
			params['Comment'].answer_comment_id = answer_comment_id;
		
		//Send to server new entry		
		ArbaProfile.prepare({
		   type: 'POST',
		   route: 'comments',
		   params: params
		});
		
		ArbaProfile.send(true).then(function(response){
		    if(response.status === 'success'){
			    $scope.$comment = angular.copy($scope.$defs_comment);
				
				$scope.update();
			    
			    $notifyMe.send('cars:journal:update:'+$scope.carID, 'new-comment', {
				    id_object: $scope.carID,
					user_id: user_id || $scope.carOwner,
					object_type: 'comment',
				    data: response.comment
				});
		    }
		});
	};
	
	//Answer comment
	$scope.answerForm = function(comment){
		comment.answerForm = (comment.answerForm === true)? false : true;
	}
	$scope.answerSubmit = function(comment){
		$scope.addComment(comment.id, comment.user_id);
		comment.answerForm = false;
	}
	
	$scope.getAnswerUser = function(id){
		var user_fname = '';
		angular.forEach($scope.currentCar.commentsList, function(comment, i){
			if(parseInt(comment.id) === parseInt(id))
				user_fname = comment.account.first_name;
		});
		
		return user_fname;
	}
	
	$scope.followed = function(){
		$scope.currentCar.followers = $scope.currentCar.followers + 1;
		
		ArbaProfile.go('followers/follow', 'PUT', null, {id: $scope.carID}).then(function(result){
			if(result.status === 'fail'){
				 $scope.currentCar.followers = $scope.currentCar.followers - 1;
				 if($scope.currentCar.followers < 0)
				 	$scope.currentCar.followers = 0;
			}else{
				$notifyMe.send('car:new:followed:'+$scope.carID, 'follow', {
				    id_object: $scope.currentCar.journal.id,
					user_id: $scope.carOwner,
					object_type: 'car',
				    data: {}
				});
			}
	    });
	};
	
	/**
	 * @method - get list item
	 * @var $id int
	 */
	$scope.bookmark = function($id, type){
		type = type || 2;
		
		ArbaProfile.go('bookmarks/add/'+type+'/'+$id, 'PUT', null, {silence: false}).then(function(result){
			if(result.status === 'success'){
				SweetAlert.success("Entry was updated.", {title: "Successful!"});
			}else{
				SweetAlert.alert(
					"Make sure that you fill all require fields, and try again...", 
					{title: "Server error!"}
				);
			}
	    });
	};
	
	window.bookmark = function(id){
		$scope.bookmark(id);
	}
	
	/**
	 * @method - get list item
	 * @var $id int
	 */
	$scope.unbookmark = function($id){
		
	};
     
    //Check if full journals showed
    $scope.allEntries = false;
    
    //Show all
    $scope.showAll = function(){
	    if($scope.allEntries === false){
		    $scope.allEntries = true;
			$scope.currentCar.journal.entries = angular.copy($scope.all_entries);
	    }else{
		    $scope.allEntries = false;
			$scope.currentCar.journal.entries = angular.copy($scope.pre_entries);
	    }
    }
    
     
    //Check if full comments
    $scope.allComments = false;
    
    //Show all
    $scope.showAllComments = function(){
	    if($scope.allComments === false){
		    $scope.allComments = true;
			$scope.currentCar.commentsList = angular.copy($scope.currentCar.commentsAll);
	    }else{
		    $scope.allComments = false;
			$scope.currentCar.commentsList = angular.copy($scope.currentCar.commentsCut);
	    }
    }
     
    //Show entry pictures
    $scope.showPics = function(id_elem){
	    var item = document.getElementById('entry_pic_'+id_elem);
	    if(item !== null){
		    if(item.className.search('hide') >= 0){
			    item.className = item.className.replace('hide', '');
		    }else{
			    item.className = item.className + 'hide';
		    }
	    }
    }
    
    //Like entry
    $scope.like = function(item, object_type){
	    object_type = object_type || 'journal';
	    
	    item.likes = item.likes || 0;
	    item.likes = item.likes + 1;
		
		ArbaProfile.like(item, {
			name: 'cars:journal:like:'+$scope.carID,
			object_type: object_type,
		}).then(function(result){
			if(!result){
				item.likes = parseInt(item.likes) - 1;
				if(item.likes <= 0)
					item.likes = 0;
			}
		});	
    }
    
  })
  
  
//Cars Journal List
.controller('CarsjournalCtrl', function (
	/*************************
	 * Native
	 ************************/
	$scope, $rootScope, $state, $stateParams, $document, $timeout, $interval, $log, 
	
	/*************************
	 * Arba Services
	 ************************/
	arbaCache, $arbaLiveService, ArbaProfile, ArbaSocial, $notifyMe, 
	
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
		$document.scrollToElement(element, 65);
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
    
	/**
	 * @method - Scroll to item if needed
	 */
    $scope.scrollToEntry = function(){
	    if($scope.$options.$scrolledTo && $scope.$options.$scrolledTo === true)
	    	return;
	    	
	    if($scope.$options.entryID && $scope.$options.entryID > 0){
		 	$scope.$options.$scrolledTo = true; 
		 	$scope.$options.$scrolledInterval = $interval(function(){
			 	if(document.getElementById('journal_entry_'+$scope.$options.entryID) !== null){
			 		$scope.scrollTo('journal_entry_'+$scope.$options.entryID);
			 		
				 	$interval.cancel($scope.$options.$scrolledInterval);
			 	}
		 	}, 250, 10);  
	    }
    }
	 
    
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
	 * @var $all object - all object in response
	 */
    $scope.$all = [];
    
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
    $scope.$count = 10;
    
    /**
	 * @var $sorting string || null - sort option
	 */
    $scope.$sorting = 'created_at';
    
    /**
	 * @var $options object - controller view options
	 */
    $scope.$options = {
	    //Type of response
	    type: 'entries',
	    
	    // $stateParams.options
	    journalID: parseInt($stateParams.journalID),
	    entryID: parseInt($stateParams.entryID) || 0,
	    
	    //Check if update
	    '$updating': false,
	    
	    //Car of this journal
	    '$car': {},
	    //Account of this journal
	    '$account': {}
    };
    
    /**
	 * @var $sorting object - Live event
	 */
	$scope.$liveEvent = {
		name:    $state.current.name +':update:'+ $scope.$options.journalID,
	    id_object: 0,
	    data: {},
		//'like': 1, 'follow': 2, 'subscribe': 3, 'bookmark': 4, 'favorite': 5, 'new-comment': 6
		object_type:  'journal', // 'car': 1, 'journal': 2, 'account': 3, 'blog': 4, 'comment': 5
		user_id: 0
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
	 * @method - Sort items
	 */
	$scope.sorting = function(lists, scope){
	    scope = scope || null;
	    if(scope !== null && scope.$sorting !== '' && scope.$sorting !== null)
	    	$scope.$sorting = scope.$sorting;
	    
	    var items = lists? angular.copy(lists) : angular.copy($scope.$all_list);
	    var sort = ($scope.$sorting !== '' && $scope.$sorting !== null)? $scope.$sorting : 'created_at';
	    
	    var reversed = (sort !== 'created_at')? false : true;
	    
	    //Sort items
	    items = orderByFilter(items, sort, reversed);
	    
		//Make prepare
		$scope.prepare(angular.copy(items));
	};
	 
	/**
	 * @method - Add new item
	 */
    $scope.addItem = function(){
	    // Default implemetns
		
		var route = '';
		
		//Live event
		var liveEvent = angular.merge(angular.copy($scope.$liveEvent), {
			name:    '',
			type:    '', // 'like': 1, 'follow': 2, 'subscribe': 3, 'bookmark': 4, 'favorite': 5, 'new-comment': 6
			object:  '', // 'car': 1, 'journal': 2, 'account': 3, 'blog': 4, 'comment': 5
			user_id: ''
		});
		
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
	 * @method - Prepare list of items
	 */
    $scope.prepare = function(items, autoSort){
	    autoSort = autoSort || false;
		
	    $scope.$all_list = angular.copy(items);
		
		//Fix this API - created_at
	    angular.forEach($scope.$all_list, function(item, i){
		    $scope.$all_list[i].created_at = parseInt(item.created_at);
		    
		    //If needed entry hide
		    if($scope.$options.entryID > 0 && $scope.$options.entryID === item.id && parseInt(i+1) > $scope.$count)
		    	$scope.$count = parseInt(i+1);
	    });
		
		$scope.$pre_list = ($scope.$count !== null)? angular.copy($scope.$all_list.slice(0, $scope.$count)) : angular.copy($scope.$all_list);
		
		//Check object for updates
		if($scope.$list !== null && $scope.$list.length){
			angular.forEach($scope.$pre_list, function(item, i){
				if(
					typeof $scope.$list[i] == 'undefined' || 
				   (typeof $scope.$list[i] != 'undefined' && !angular.equals($scope.$list[i], item))
				){
					$scope.$list[i] = item;				
				}
			});
		}else{
			$scope.$list = angular.copy($scope.$pre_list);
		}
			    	
	    //Updated
	    $scope.$options.$updating = false;
		
		if(autoSort === true){
			$scope.sorting();
			return;
		}
		
		//Debug
		$log.warn('JOURNAL::PREPARED', $scope.$list, $scope.$options);
    }
	 
	/**
	 * @method - Init list of items
	 * @var response mixed - items response
	 * @var base_object string - items base key
	 * @var object string - items current key
	 */
    $scope.list = function(response, object, base_object){
	   	
		//Update object
		if(base_object !== '' && response[base_object])
			var $all_list = response[base_object][object] || [];
		else
			var $all_list = response[object] || [];
		
		//Save car & account of this journal
		$scope.$options.$car = response.car || {};
		$scope.$options.$account = response[base_object].account || {};
		
		//All object in response
		$scope.$all = response;
		
		//Prepare list items
		$scope.prepare($all_list, true);
		
		//Cache object
		arbaCache.set($state.current.name +'::'+ $scope.$options.journalID, $scope.$all);
		
		//Set Page title
		var user = $scope.$options.$account.first_name || $scope.$options.$account.username
		$scope.$options.$pageTitle = user + "'s car's journal";
		
		ArbaProfile.pageTitle($scope.$options.$pageTitle);
		
		if($scope.$options.$account.user_id === $scope.profile.user_id){
			$scope.$options.$breadcrums = [
				{
					name: 'My Profile',
					href: 'user/account/profile'
				},
				{
					name: 'My Garage',
					href: 'garage'
				},
				{
					name: 'My Favorite Car ' + $scope.$options.$car.car_name,
					href: $state.href('dash.myjournal-my', {carID: $scope.$options.$car.id})
				},
				{
					name: $scope.$options.$pageTitle,
					link: true,
					href: $state.href('dash.myjournal-list', {journalID: $scope.$options.journalID})
				},
			];
		}else{
			$scope.$options.$breadcrums = [
				{
					name: user + "'s Profile",
					href: 'user/account/view?id=' + $scope.$options.$account.user_id
				},
				{
					name: user + "'s Garage",
					href: 'garage/account/view?id=' + $scope.$options.$account.user_id
				},
				{
					name: user + "'s Favorite Car" + $scope.$options.$car.car_name,
					href: $state.href('dash.myjournal-my', {carID: $scope.$options.$car.id})
				},
				{
					name: $scope.$options.$pageTitle,
					link: true,
					href: $state.href('dash.myjournal-list', {journalID: $scope.$options.journalID})
				},
			];
		}
		
		//Set Breadcrumbs
		ArbaProfile.breadcrums($scope.$options.$breadcrums);
    }
	 
	/**
	 * @method - Update list of items
	 * @var silence boolean - load items without spinner (default: false)
	 */
    $scope.update = function(silence){
	    silence = silence || false;
	    
	    //If update return;
	    if($scope.$options.$updating === true)
	    	return;
	    	
	    //Init update
	    $scope.$options.$updating = true;
	    
	    //View route
	    var route = 'journals/'+$scope.$options.journalID;
	    
	    //Object of response
	    var base_object = 'journal';
	    var object = $scope.$options.type || '';

		//If already cached	    
	    if(arbaCache.get($state.current.name +'::'+ $scope.$options.journalID)){
			$scope.list(arbaCache.get($state.current.name +'::'+ $scope.$options.journalID), object, base_object);
		    
			//Cached always silence update
			silence = true;
			
			//Stop loading
			ArbaProfile.loading(true);
		}
	    
	    //Update
	    ArbaProfile.go(route, 'GET', null, {silence: silence}).then(function(response){
		    		    
			//Update object
			$scope.list(response, object, base_object);
			
		});
    };
	 
	/**
	 * @method - Update list of items
	 * @var e object || null - event object
	 * @var profile object - about profile
	 * @var delay int - wait before load items (default: .75sec)
	 */
    $scope.init = function(e, profile, delay){	    
	    //Prevent double request
	    if(
	    	$scope.$options.$updating === true || 
	    	Object.keys($scope.$all).length > 0 ||
	    	Object.keys($scope.$list).length > 0 ||
	    	(
	    		profile === false || 
	    		(profile !== false && angular.equals(profile, $scope.profile))
	    	)
	    ) return;
	    
	    //Update profile
	    $scope.profile = profile || null;
	    
		delay = delay || 750;
		
		if(delay === 0){
			$scope.update();
	    	
		    //Init update
		    $scope.$options.$updating = true;
		}else{
			//Wait and load
			$timeout(function(){
				$scope.update();
	    	
			    //Init update
			    $scope.$options.$updating = true;
			}, delay);
		}
		  
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
	 * @method - like item
	 * @var item object
	 * @var object_type string
	 */
	$scope.like = function(item, object_type){
		item.likes = item.likes || 0;
		item.likes = parseInt(item.likes) + 1;
		
		ArbaProfile.like(item, {
			name: $scope.$liveEvent.name,
			object_type: object_type || $scope.$liveEvent.object_type,
		}).then(function(result){
			if(!result){
				item.likes = parseInt(item.likes) - 1;
				if(item.likes <= 0)
					item.likes = 0;
			}
		});		 
	};
	
	
	/**
	 * @method - Show full text for current item
	 * @var item object
	 */
	$scope.showItem = function(item){
		if(item.fullText === true){
			item.fullText = false;
		}else{
			item.fullText = true;
		}
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
	 * @event - journal live update
	 * @var event object
	 * @var type string
	 * @var request object
	 */
    $scope.$on($scope.$liveEvent.name, function(event, type, request){
	    $scope.update(true);
    });
	
    
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
		
		//Wait 1sec if loading profile
		$timeout(function(){
			
			if(ArbaProfile.getProfile() !== null && $scope.profile === null)
				$scope.init(event, ArbaProfile.getProfile(), 0);
				
		}, 1000);
		
	});
    
	/*********************************************
	 * END Events
	 ********************************************/
    
    
    
	/*********************************************
	 * Check type for ctrl
	 ********************************************/
    if($scope.$options.journalID === null || $scope.$options.journalID === '')
    	return $scope.goTo('404'); // To 404
    
    //Make loading
	ArbaProfile.loading();
});
