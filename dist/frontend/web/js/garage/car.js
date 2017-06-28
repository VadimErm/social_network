'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

(function () {
  var carUrls = {
    1: '/garage/api/add', // my car url
    2: '', // ex car url
    3: '', // wish car url
    4: '' // test drive car url
  };

  DocumentFragment.prototype.toString = function () {
    var element = document.createElement('div');
    element.appendChild(this);

    return element.innerHTML;
  };

  var carType = null;

  var CarController = function () {
    _createClass(CarController, [{
      key: 'attachAddBtnClick',
      value: function attachAddBtnClick() {
        $('.add-car-btn').on('click', CarFormEvents.addCarBtnClick);
      }
    }, {
      key: 'attachAddClick',
      value: function attachAddClick() {
        $('#add-car-btn').on('click', CarFormEvents.addClick);
      }
    }]);

    function CarController() {
      _classCallCheck(this, CarController);

      this.carsBlock = document.getElementById('garage-my-cars');
      this.template = document.getElementById('my-car-tpl');
    }

    _createClass(CarController, [{
      key: 'render',
      value: function render(carFields) {
        console.log(carFields);
        if (this.carsBlock == null) {
          throw Error('Cars block not founded');
        }

        console.log(this.template.content);
        var tplSource = this.template.content.cloneNode(true);

        var template = Handlebars.compile(tplSource.toString());
        var html = template(carFields);

        $(this.carsBlock).append(html);
      }

      /**
       *
       * @param {FormData} carFormData
       * @return {Promise}
       */

    }, {
      key: 'add',
      value: function add(carFormData) {
        return new Promise(function (resolve, reject) {
          $.ajax({
            url: carUrls[carFormData.get('Car[car_type]')], // get car type url
            data: carFormData,
            cache: false,
            type: "POST",
            processData: false,
            contentType: false,
            success: function success(response) {
              console.log(carFormData);

              console.log(response);
              response.status == 'success' ? resolve(JSON.parse(response.car)) : reject('Some error3');
            },
            error: function error() {
              return reject('Some error2');
            }
          });
        });
      }
    }]);

    return CarController;
  }();

  var CarFormEvents = {
    addCarBtnClick: function addCarBtnClick(e) {
      console.log('Add car btn click');
      // get car type from data attribute
      carType = $(e.target).data('car-type');
      e.preventDefault();
    },
    addClick: function addClick(e) {
      console.log('Add car');
      var carData = CarForm.data;
      var mainCar = false;
      if (carData.get('Car[main_car]') == 'on') {
        mainCar = true;
        carData.set('Car[main_car]', 1);
      }
      carData.append('Car[car_type]', carType);
      var promise = carController.add(carData);

      promise.then(function (carFields) {
        console.log(carFields);
        $('.mfp-close').click();
        carFields['main_car'] = mainCar;
        carController.render(carFields);
      }, function () {
        console.log('Error');
      });
      e.preventDefault();
    }
  };

  var CarForm = {
    id: 'addcar',
    get data() {
      return new FormData(document.getElementById(this.id));
    }
  };

  var carController = new CarController();

  // attach garage events
  carController.attachAddBtnClick();
  carController.attachAddClick();
})();
//# sourceMappingURL=car.js.map