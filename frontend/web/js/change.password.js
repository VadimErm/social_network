var Api = (function (document) {
  var access_token;

  return {
    getAccessToken: function () {
      if (access_token) return access_token;

      return access_token = document.querySelector('meta[name="access-token"]').content;
    }
  }
})(document);

$('#change-password').on('click', function (e) {
  "use strict";
  // var elem = document.documentElement;
  // if (elem.requestFullscreen) {
  //   elem.requestFullscreen();
  // } else if (elem.mozRequestFullScreen) {
  //   elem.mozRequestFullScreen();
  // } else if (elem.webkitRequestFullscreen) {
  //   console.log(elem);
  //   elem.webkitRequestFullscreen();
  // }

  e.preventDefault();
  var password = document.getElementById('password-field'),
      newPassword = document.getElementById('new-password-field'),
      confirmPassword = document.getElementById('confirm-password-field');

  if (password.value.length > 0
      && newPassword.value.length > 0
      && confirmPassword.value.length > 0
  ) {
    if (newPassword.value == confirmPassword.value) {
      if (password.value == newPassword.value) {
        alert('Password must not be the same NewPassword');
      } else {
        console.log('Ajax');
        $.ajax({
          url: '/api/auth/change-password?access-token=' + Api.getAccessToken(),
          method: 'post',
          dataType: 'json',
          data: {
            newPassword: newPassword.value,
            password: password.value,
            confirmPassword: confirmPassword.value
          },
          success: function (data) {
            console.log(data);

            if (data.status) {
              alert(data.msg);
            }
          }
        });
      }
    } else {
      alert('New password not compare with confirm password');
    }
  } else {
    alert('Fill all fields');
  }

});