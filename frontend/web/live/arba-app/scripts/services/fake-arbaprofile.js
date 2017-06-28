'use strict';

/**
 * @ngdoc service
 * @name arbaLiveApp.ArbaProfile
 * @description
 * # ArbaProfile
 * Factory in the arbaLiveApp.
 */
angular.module('arbaLiveApp')
  .factory('FakeArbaProfile', function ($q) {
    // Service logic
    

    // Public API here
    return {
	    
		/**
		 * @method - fake get data
		 * @var $route string
		 * @return string
		 */
		get: function($route){
			var fakePromise = $q(function(resolve, reject){
				var result = {
					status: true,
					data: []
				};
				
				//Fake routes
				if($route === 'signin'){
					result.data = {
						'access_token': faker.lorem.word
					};
				}
				if($route === 'profile'){
					result.data = {"cars":{"id":"integer","main_car":"null","brand":"string","car_name":"string","engine":"string","engine_size":"string","model":"string","modification":"string","year":"integer","location":"string","images":"arra[object Image{src}]"},"mainCar":{"id":"inteder","main_car":"1","brand":"string","car_name":"string","engine":"string","engine_size":"string","model":"string","modification":"string","year":"integer","location":"string","images":"arra[object Image{src}]"},"posts":{"id":"","title":"","message":"","created_at":"","images":"array[object Image{src}]","videos":"array[object Video{src}]","comments":"array[object Comment{id, post_id, message, created_at, user_idm answer_comment_id, object account{} }]"},"account":{"id":"integer","username":"string","first_name":"string","last_name":"string","user_id":"integer","show_real_name":"integer","gender":"integer","birthday":"date","show_real_birthday":"integer","languages":"string","country":"string","city":"string","phone":"string","summary":"string","avatar":"string"},"followers":"array[object Account]","registered":"date","is_premium":"integer","access_token":"string"};
				}
				
				/*if($route.seach('journals') >= 0){
					result.data = {"status":"success or fail","journal":{"id":"integer","car":"object{id, main_car, car_type, brand, car_name, engine, engine_size, model, modification, year, location, score, used_year_from, used_year_to, testdrive_date, array images[object{src, description}], }","entries":"array[object{id, title, text, language, type, mileage, expenses, currency, hidden, created_at, journal_id, array images[objects{src, description}], array tags[objects {id, name}]}]","account":"object {id, username, first_name, last_name, user_id, show_real_name, gender, birthday, show_real_birthday, array languages[], country, city, cars, phone, summary, avatar}"},"access_token":"string"};
				}
				
				if($route.seach('') >= 0){
					result.data = ;
				}
				
				if($route.seach('') >= 0){
					result.data = ;
				}
				
				if($route.seach('') >= 0){
					result.data = ;
				}
				
				if($route.seach('') >= 0){
					result.data = ;
				}
				
				if($route.seach('') >= 0){
					result.data = ;
				}
				
				if($route.seach('') >= 0){
					result.data = ;
				}
				
				if($route.seach('') >= 0){
					result.data = ;
				}*/
				
				resolve(result);
			});
			
			return fakePromise;
		}
    };
  });
