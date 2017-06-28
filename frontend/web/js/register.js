(function () {
  const Register = {
    birthdayBlur() {
      console.log('Birthday blur');
      var birthday = $('#datepick');
      var labelForBirthday = $('#datepick-label');

      console.log(birthday.val().length);

      if (birthday.val().length == 0) {
        console.log(birthday.val().length);
        console.log('Invalid');
        birthday.removeClass('valid');
        birthday.addClass('invalid');
      } else {
        console.log('valid');
        console.log(birthday);
        birthday.removeClass('ddate');
        birthday.removeClass('validate');
        birthday.removeClass('picker__input');
        birthday.removeClass('invalid');
        birthday.removeClass('picker__input--active');
        birthday.addClass('valid');
      }
    },
    languageClick() {
      console.log('language blur');
    },
    firstNameBlur() {
      console.log('First Name blur');
      var firstName = $('#fname');
      var firstNameLabel = $('#fname-label');
      var reg = new RegExp(/[0-9]/);

      if (reg.test(firstName.val())) {
        // invalid first name
        firstNameLabel.attr('data-error', 'wrong, contain digist');
        firstName.removeClass('valid');
        firstName.addClass('invalid');
      } else if (firstName.val().length == 0) {
        firstNameLabel.attr('data-error', 'wrong');
        firstName.removeClass('valid');
        firstName.addClass('invalid');
      } else {
        firstName.removeClass('invalid');
        firstName.addClass('valid');
      }
    },
    lastNameBlur() {
      console.log('First Name blur');
      var firstName = $('#lname');
      var firstNameLabel = $('#lname-label');

      var reg = new RegExp(/[0-9]/);

      if (reg.test(firstName.val())) {
        // invalid first name
        firstNameLabel.attr('data-error', 'wrong, contain digist');
        firstName.removeClass('valid');
        firstName.addClass('invalid');
      } else if (firstName.val().length == 0) {
        firstNameLabel.attr('data-error', 'wrong');
        firstName.removeClass('valid');
        firstName.addClass('invalid');
      } else {
        firstName.removeClass('invalid');
        firstName.addClass('valid');
      }

    },
    aboutMeBlur() {
      console.log('About me blur');
      var aboutMe = $('#ab-text');

      if (aboutMe.val().length > 400) {
        aboutMe.removeClass('valid');
        aboutMe.addClass('invalid');
      } else {
        aboutMe.removeClass('invalid');
        aboutMe.addClass('valid');
      }
    },
    phoneBlur() {
      console.log('Phone blur');

      var phone = $('#phone');
      var labelForPhone = $('#phone-label');

      // +971-50-948-0064, 050-948-0064, +7(919) 999-0575 и тд

      var reg = new RegExp(/^\+[0-9]{10,20}$/);
      var regWithout = new RegExp(/^[0-9]{10,20}$/);


      if (phone.val().length > 0 && !(reg.test(phone.val()) || regWithout.test(phone.val())))
      {
        console.log('Invalid phone');
        labelForPhone.attr('data-error', 'wrong phone, example: +50683123456 or 50683123456');
        phone.removeClass('valid');
        phone.addClass('invalid');
      } else {
        phone.removeClass('invalid');
        phone.addClass('valid');
      }

    },
    loginInput() {
      console.log('Key up login');

      var login = $('#login');
      var labelForLogin = $('#login-label');

      console.log(login);

      if (login.val().length > 0) {
        console.log(login.val());
        // try validate login
        $.ajax({
          url: '/api/validate/login?username=' + login.val(),
          contentType: 'json',
          success: function (response) {
            if (response.status == 'fail') {
              login.removeClass('valid');
              login.addClass('invalid');
              labelForLogin.attr('data-error', 'Username already exists');

            } else if (response.status == 'success') {
              login.removeClass('invalid');
              login.addClass('valid');
            }
          }
        });
      }
    },
    loginBlur() {
      console.log('Login blur');
      Register.loginInput();
      var login = $('#login');
      var labelForLogin = $('#login-label');

      if (login.val().length == 0) {
        login.removeClass('valid');
        login.addClass('invalid');
      } else {
        login.removeClass('invalid');
        login.addClass('valid');
      }
    },
    passBlur(e) {
      console.log(e);
      console.log('Validate');
      var validate = Register.compareValidate();
      console.log(validate);
      var password = $('#pass');
      var passwordLabel = $('#password-label');
      var passwordConfirm = $('#confirm-password');

      if (password.val().length < 6) {
        console.log('Here');
        passwordLabel.attr('data-error', 'Short password min 6');
        password.removeClass('valid');
        password.addClass('invalid');
        passwordConfirm.addClass('invalid');
      } else {
        password.removeClass('invalid');
        password.addClass('valid');
        passwordConfirm.addClass('valid');
      }

      if (validate < 0) {
        passwordLabel.attr('data-error', 'wrong');
        password.removeClass('valid');
        password.addClass('invalid');
        passwordConfirm.removeClass('valid');
        passwordConfirm.addClass('invalid');
      } else {
        password.removeClass('invalid');
        password.addClass('valid');
        passwordConfirm.removeClass('invalid');
        passwordConfirm.addClass('valid');
      }
    },
    compareValidate() {
      var password = $('#pass');
      var passwordConfirm = $('#confirm-password');

      if (password.val() == 0 && passwordConfirm.val() == 0) {
        // empty fields
        return -1;
      }

      if (password.val() != passwordConfirm.val()) {
        // not compare
        return -2;
      }
    },
    validateCountry() {
      console.log('Country validate');
      var country = $('#country');
      var countryInput = country.prev().prev();
      console.log(country.val());

      countryInput.addClass('validate');

      if (country.val() == null || country.val().length == 0) {
        countryInput.removeClass('valid');
        countryInput.addClass('invalid');
      } else {
        console.log('Is valid');
        countryInput.removeClass('invalid');
        countryInput.addClass('valid');
      }
    },
    emailBlur() {
      console.log('Email blur');
      var email = $('#email');
      var reg = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      var val = email.val();

      if (val.length == 0 || !reg.test(val)) {
        email.removeClass('valid');
        email.addClass('invalid');
      } else {
        // console.log('here');
        email.removeClass('invalid');
        email.addClass('valid');
      }
    },
    validateCity() {
      var city = $('#city');

      if (city.val().length == 0) {
        city.removeClass('valid');
        city.addClass('invalid');
      } else {
        city.removeClass('invalid');
        city.addClass('valid');
      }
    },
    validateLanguage() {
      console.log('Language validate');
      var language = $('#languages');
      var languageInput = language.prev().prev();

      languageInput.addClass('validate');
      console.log(language.val().length);

      if (language.val() == null || language.val().length == 0) {
        languageInput.removeClass('valid');
        languageInput.addClass('invalid');
      } else {
        console.log('Is valid');
        languageInput.removeClass('invalid');
        languageInput.addClass('valid');
      }
    },
    validateAbout() {
      var about = $('#ab-text');

      if (about.val().length > 400) {
        about.removeClass('valid');
        about.addClass('invalid');
      } else {
        about.removeClass('invalid');
        about.addClass('valid');
      }
    },
    submit(e) {
      console.log('Submit form');
      Register.passBlur();
      Register.passBlur();
      Register.loginBlur();
      Register.loginInput();
      Register.phoneBlur();
      Register.firstNameBlur();
      Register.lastNameBlur();
      Register.birthdayBlur();
      Register.emailBlur();
      Register.validateLanguage();
      // Register.validateCountry();
      Register.validateCity();
      Register.aboutMeBlur();

      var invalids = $('.invalid');

      if (invalids.length > 0) {
            
        localStorage.removeItem('_ARBA_STORAGE_DEBUG___username');
        localStorage.removeItem('_ARBA_STORAGE_DEBUG___password');
        localStorage.removeItem('_ARBA_STORAGE_DEBUG___token');
	            
        e.preventDefault();
      }else{
        localStorage.setItem('_ARBA_STORAGE_DEBUG___username', $('#login').val());
        localStorage.setItem('_ARBA_STORAGE_DEBUG___password', $('#pass').val());
        localStorage.removeItem('_ARBA_STORAGE_DEBUG___token');
      }
    }
  };

  $('#pass').on('blur', Register.passBlur);
  $('#confirm-password').on('blur', Register.passBlur);
  $('.picker__day').on('click', Register.birthdayBlur);
  $('#ab-text').on('keyup', Register.aboutMeBlur);
  $('#login').on('blur', Register.loginBlur);
  $('#login').on('keyup', Register.loginInput);
  $('#phone').on('blur', Register.phoneBlur);
  $('#fname').on('blur', Register.firstNameBlur);
  $('#lname').on('blur', Register.lastNameBlur);
  $('#datepick').on('blur', Register.birthdayBlur);
  $('#datepick').on('change', Register.birthdayBlur);
  $('#email').on('blur', Register.emailBlur);
  $('#languages').on('click', Register.validateLanguage);
  $('#city').on('blur', Register.validateCity);
  $('#submit-form').on('click', Register.submit);
  
  
  //Country & Cities #country
  $.getJSON('/api/v1/catalogs/get-countries', function (countries) {
  	  var result = '<option value="" disabled="" selected="">Country</option>';
	  $.each(countries.countries, function(i, country){
		  if(i !== 0)
			  result += '<option value="'+country.cc_fips+'" >'+country.country+'</option>';
	  });
	  $('#country').html(result);
	  $('#country').material_select();
  });
  
	//Change country
	$('#country').on('change', function(e) {
		var countryCode = $(this).val();
		
		$.getJSON('/api/v1/catalogs/get-cities/'+countryCode, function (result) {
			var cities = {};
			$.each(result.cities, function(i, city){
				cities[city.city] = null;
			});
			$('.autocomplete').autocomplete({
				data: cities
			});
		});
	});
  
})();