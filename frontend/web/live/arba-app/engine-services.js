'use strict';

// Arba.Ae web application declaration
angular.module('arbaLiveApp')

    
/*********************************************
 *
 * Socket Factory Initialized
 *
 ********************************************/
.factory('$arbaSocket', function (socketFactory) {
	return socketFactory({
		ioSocket: io.connect('http://arba.local:3000/')
	});
})
 
/*********************************************
 *
 * Arba Socket service Initialized
 *
 ********************************************/
.service('$arbaLiveService', function ($arbaSocket) {
		
	this.send = function(event, type, data){
		var request = {
			event: event,
			type: type,
			data: data
		};
		
		$arbaSocket.emit('live:event:trigger', request);
	};
	
});