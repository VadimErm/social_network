(function(window, document){
  'use strict';

  var CarEvents = {
    added: function (e) {
      CarController.add(new FormData($('form')[0]));
      e.preventDefault();
    },
    addCarBtnClick: function (e) {
      var car_type = $(this).data('car-type');
      $('input[name="Car[car_type]"]').remove();
      $('#addcar').append('<input type="hidden" name="Car[car_type]" value="'+ car_type +'">');
    },
    removed: function (e) {

    },
    edit: function () {

    }
  };

  var CarController = (function () {
    var addUrl = '/garage/api/add';

    var render = function (carType, options) {
      var view = '';
      carType = parseInt(carType);
      console.log(carType);
      switch (carType) {
        case 1:
          view = renderMyCar(options);
          console.log(view);
          $('#garage-cars').append(view);
          break;
        case 2:
          view = renderExCar(options);
          break;
        case 3:
          view = renderWishCar(options);
          break;
        case 4:
          view = renderTestDriveCar(options);
          break;
      }
    };

    var renderExCar = function (options) {

    };

    var renderWishCar = function (options) {

    };

    var renderTestDriveCar = function (options) {

    };

    var renderMyCar = function (options) {
      console.log(options);
      return '<div class="garage-car">' +
                        '<div class="row">' +
                              '<div class="col s12 m12 l6">' +
                                '<div class="garage-item big-car">' +
                                    '<div class="garage-car-wrap" style="background-image:url(/images/car4.jpg);">' +
                                        '<div class="preview-info clearfix">' +
                                            '<div class="badge1 award-badge">' +
                                                'main car' +
                                            '</div>' +
                                            '<div class="bookmark">' +
                                                '<a href="#"><img src="/images/bookmark.svg" alt="add to bookmarks"></a>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                            '<div class="col s12 m12 l6">' +
                                '<div class="car-info">' +
                                    '<h6 class="car-name"><a href="/garage/car/user-car/'+options.id+'">' + options.car_name + '</a></h6>' +
                                    '<div class="car-modification">' + options.brand +' / ' + options.model + ' / ' + options.modification + ' / ' + options.year + '</div>' +
                                    '<div class="block-meta">' +
                                        '<div class="meta-item"><a href="#"><span class="ico-heart-outline"></span>100</a></div>' +
                                        '<div class="meta-item"><a href="#"><span class="ico-user-outline-shape"></span>167 followers</a></div>' +
                                        '<div class="meta-item"><a href="#"><span class="ico-maps-placeholder-outlined-tool"></span>Dubai</a></div>' +
                                        '<div class="meta-item"><a href="#"><span class="ico-speech-bubble-rectangular-chat-symbol"></span>25</a></div>' +
                                    '</div>' +
                                    '<ul class="list-sep">' +
                                        '<li>Year of production: 2015. Use since: 2016</li>' +
                                        '<li>Engine: ' + options.engine + '</li>' +
                                        '<li>Engine size: ' + options.engine_size + '</li>' +
                                        '<li>Capacity: 240 Hp</li>' +
                                    '</ul>' +
                                    '<h6 class="car-arch">Car’s achivements</h6>' +
                                    '<ul class="achivements-list">' +
                                        '<li>' +
                                            '<div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>' +
                                            '<div class="ach-desc">Most popular blog in <a href="#">December 2017</a></div>' +
                                        '</li>' +
                                        '<li>' +
                                            '<div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>' +
                                            '<div class="ach-desc">Nullam posuere sem at justo sodales, in finibus in <a href="#">December 2017</a></div>' +
                                        '</li>' +
                                    '</ul>' +
                                    '<ul class="achivements-list full">' +
                                        '<li>' +
                                            '<div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>' +
                                            '<div class="ach-desc">Morbi tristique leo id odio condimentum euismod</div>' +
                                        '</li>' +
                                        '<li>' +
                                            '<div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>' +
                                            '<div class="ach-desc">Praesent gravida fringilla velit, ac hendrerit orci</div>' +
                                        '</li>' +
                                        '<li>' +
                                            '<div class="icon-left"><span class="ico-sports-or-education-trophy-cup"></span></div>' +
                                            '<div class="ach-desc">Duis ultricies pulvinar orci ut sagittis.</div>' +
                                        '</li>' +
                                    '</ul>' +
                                    '<div class="see-all hide">see all →</div>' +
                                    '<div class="btns-w clearfix">' +
                                        '<a href="#" class="btn-large btn-gray waves-effect">move to "ex-cars"</a>' +
                                        '<a class="btn-gray btn-ui waves-effect" href="#"><span class="ico-edit-pencil-symbol"></span></a>' +
                                        '<a class="btn-gray btn-ui waves-effect popup-form" href="#remove-item"><span class="ico-close-cross-circular-interface-button"></span></a>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
    };

    var successHandler = function (response) {
      if (response.status == 'success') {
        console.log(response);
        render(JSON.parse(response.car).car_type, JSON.parse(response.car));
        location.reload();
      } else {
        alert('Fail');
      }
    };

    return {
      /**
       * @param {FormData} carForm
       * @return boolean
       */
      add: function (carForm) {
        console.log(carForm);
        $.ajax({
          url: addUrl,
          method: 'POST',
          cache: false,
          contentType: false,
          processData: false,
          data: carForm,
          success: successHandler
        });

        console.log('Add send');
      },
      /**
       * @param {integer} carId
       */
      remove: function (carId) {
        $.ajax({
        });
      },
      /**
       * @param {Car} car
       */
      edit: function (car) {

        $.ajax({

        });
      }
    };
  })();

  // Attach form events
  $('#add-car-btn').on('click', CarEvents.added);
  $('.add-car-btn').on('click', CarEvents.addCarBtnClick);

})(window, document);