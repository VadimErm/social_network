"use strict";

function addToBookmarks(type, id) {
  var token = localStorage.getItem('_ARBA_STORAGE_DEBUG___token');

  $.ajax({
    url: '/api/v1/bookmarks/add/'+type+'/'+id,
    method: 'PUT',
    headers: {
      'Authorization':'Bearer '+token,
      'Content-Type':'application/x-www-form-urlencoded'
    },
    success: function (response) {
      console.log(response);

    }

  });
  
}
