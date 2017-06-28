(function(){
  const Login = {
    validateFields() {
      var login = $('#login').val();
      var password = $('#password').val();
      var errors = {
        hasErrors: false,
        login: [],
        password: []
      };

      if (login.length == 0) {
        errors.login.push('Empty login');
      }

      if (password.length == 0) {
        errors.password.push('Empty password');
      }

      if (errors.login.length > 0 || errors.password.length > 0) {
        errors.hasErrors = true;
        return errors;
      }

      return true;
    },
    login(login, password) {
      $.ajax({
        url: '/site/login',
        method: 'POST',
        data: {
          LoginForm: {
            username: login,
            password: password
          }
        },
        success: function (response) {
          console.log(response);
          if (response.status == 'success') {
            
            localStorage.setItem('_ARBA_STORAGE_DEBUG___username', login);
            localStorage.setItem('_ARBA_STORAGE_DEBUG___password', password);
			localStorage.removeItem('_ARBA_STORAGE_DEBUG___token');
            
            setTimeout(function(){ window.location.replace('/'); }, 750);
          } else if (response.status == 'fail') {
            let password = $('#password');
            
            localStorage.removeItem('_ARBA_STORAGE_DEBUG___username');
            localStorage.removeItem('_ARBA_STORAGE_DEBUG___password');
            localStorage.removeItem('_ARBA_STORAGE_DEBUG___token');

            password.next().attr('data-error', response.message);
            password.addClass('invalid');
          }
        }
      });
    },
    loginBtnClick(e) {
      console.log('Login btn click');
      let errors = Login.validateFields();
      var login = $('#login');
      var password = $('#password');

      if (typeof errors == 'object') {
        // has

        if (errors.login.length > 0) {
          login.addClass('invalid');
        }

        if (errors.password.length > 0) {
          password.addClass('invalid');
        }
      } else {
        Login.login(login.val(), password.val());
      }

      e.preventDefault();
    }
  };

  $('#login-btn').on('click', Login.loginBtnClick);
})();