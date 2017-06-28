"use strict";

var Profile = (function () {

  return {
    
    follow: function (userId, elem) {
      console.log('follow');
      console.log($(elem));
        $.ajax({
          url: '/user/api/follow',
          method: 'POST',
          data: {user_id: userId},
          success: function (response) {
            console.log(response);
            if(response.status == 'success'){
              $(elem).removeClass('btn-gray');
              $(elem).text('unfollow');
            }
          }

        });
    },
    
    unfollow: function (userId, elem) {
      console.log('unfollow');
      $.ajax({
        url: '/user/api/unfollow',
        method: 'POST',
        data: {user_id: userId},
        success: function (response) {
          console.log(response);
          if(response.status == 'success'){
            $(elem).addClass('btn-gray');
            $(elem).text('follow');
          }
        }
      });
      
    },

    toggleFollow: function (userId, elem){
      if($(elem).hasClass('btn-gray')){

        this.follow(userId, elem);

      } else {

        this.unfollow(userId, elem);

      }
    }


  }
  
})();
