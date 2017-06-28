// Safary form data fix
if (typeof FormData.prototype.get == "undefined") {
  FormData.prototype.get = function(name) {
    return $('[name="'+name+'"]').val();
  }
}

if (typeof FormData.prototype.set == "undefined") {
  FormData.prototype.set = function(name, value) {
    $('[name="'+name+'"]').val(value);
  }
}

if (typeof profileConfirmed == "undefined") {
  var profileConfirmed = false;
}

(function () {
  $.fn.openModal = function (parameters) {
    this.modal(parameters);
    this.modal('open');
  };
  const carUrls = {
    1: '/garage/api/add', // my car url
    2: '', // ex car url
    3: '', // wish car url
    4: '' // test drive car url
  };

  DocumentFragment.prototype.toString = function () {
    let element = document.createElement('div');
    element.appendChild(this);

    return element.innerHTML;
  };

  let carType = null;


  class CarController
  {
    attachUpdateClick() {
      $('.update-car').on('click', CarFormEvents.updateClick);
    }

    attachAddBtnClick() {
      $('.add-car-btn').on('click', CarFormEvents.addCarBtnClick);
    }
    attachAddClick() {
      $('#add-car-btn').on('click', CarFormEvents.addClick);
    }
    attachUploadBtnClick() {
      $('#car-images').on('click', CarFormEvents.uploadBtnClick);
    }
    attachUploadBtnChange(){
      $('.car-images').on('change', CarFormEvents.uploadBtnChange);
    }
    attachCropBtnClick() {
      $('.crop-button').on('click', CarFormEvents.cropBtnClick);
    }
    attachCloseBtnClick(){
      $('.mfp-close').on('click', CarFormEvents.closeBtnClick);
    }

    constructor() {
      this.carsBlock = document.getElementById('garage-my-cars');
      this.template = document.getElementById('my-car-tpl');
    }
    render(carFields) {
      console.log(carFields);
      if (this.carsBlock == null) {
        throw Error('Cars block not founded');
      }


      console.log(this.template.content);
      let tplSource = this.template.content.cloneNode(true);

      let template = Handlebars.compile(tplSource.toString());
      let html = template(carFields);

      $(this.carsBlock).append(html);
    }

    update(carFormData) {
      return new Promise(function (resolve, reject) {
        $.ajax({
          url: '/garage/api/update', // get car type url
          data: carFormData,
          cache: false,
          type: "POST",
          processData: false,

          contentType: false,
          beforeSend:(xhr) => {

          } ,
          success: (response) => {
            console.log(response);
            response.status == 'success' ? resolve(JSON.parse(response.car)) : reject('Some error3');
          },
          error: function (e) {
            console.log(e);
          }
        });
      });
    }
    /**
     *
     * @param {FormData} carFormData
     * @return {Promise}
     */
    add(carFormData) {
      return new Promise(function (resolve, reject) {
        $.ajax({
          url: '/garage/api/add', // get car type url
          data: carFormData,
          cache: false,
          type: "POST",
          processData: false,

          contentType: false,
          beforeSend:(xhr) => {

          } ,
          success: (response) => {

            response.status == 'success' ? resolve(JSON.parse(response.car)) : reject('Some error3');
          },
          error: () => reject('Some error2')
        });
      });
    }



    previewImage(images, update, formId) {

      // let previewOldImages = $("#"+formId+" .cars-preview img");

      // if(previewOldImages.length > 0){
      //     previewOldImages.remove();
      // }
      var photos = $('#add-car-images');
      var photo = $('<input type="file" style="display: none;" multiple name="Car[images][]">');
      photo[0].files = photos[0].files;

      if (photos[0].files.length > 1) {
        $('.cars-preview').append(photo[0]);
      }

      for(var i = 0; i < images.length; i++) {
        if (photos[0].files.length == 1) {
          $('.cars-preview').append(photo[0]);
        }
        if(update){
          $('.cars-preview').append("<div style='position: relative; display: inline-block'><img src=" + images[i].url+ " width='180' style='margin-right: 5px; margin-left: 5px' data-index = " + i +" /></div>");
        } else {
          $('.cars-preview').append("<div style='position: relative; display: inline-block'><img src=" + images[i].url+ " width='180' style='margin-right: 5px; margin-left: 5px' data-index = " + i +" /><a href='#' class='crop-button'><i class='small material-icons'>aspect_ratio</i></a></div>");
        }


      }
      carController.attachCropBtnClick();

    }

    validateImages(images) {

    var validate;

    for (var i = 0; i <images.length; i++) {
      var regexp = /\/(jpe?g|png|gif)$/ig;
      validate = regexp.test(images[i].type);
      if (validate === false) break;
    }

    return validate;

  }

    alertUnsupportType() {
      alert('Unsupported file type');
    }

  }

  const CarFormEvents = (function () {
    var self =this;
    var resp; //response
    var hiddenInputs = $('#hidden-inputs');
    return {
      addCarBtnClick: function (e) {
        console.log('Add car btn click');
        // get car type from data attribute
        carType = $(e.target).data('car-type');



        let usedField = "<div class='input-field col s12 used-years'>" +
                    "<select id='used_to' name='Car[used_year_to]'>" +
            "<option value='' disabled selected>To</option>" +
            "<option value='2014'>2014</option> " +
            "<option value='2015'>2015</option> " +
            "<option value='2016'>2016</option> " +
          "</select> "
          "</div>";

        let testdriveField = "<div class='input-field col s12 test-drive'>"+
          "<select id='score' name='Car[score]'>" +
            "<option value='' disabled selected>Score</option>" +
            "<option value='1'>1</option>"+
            "<option value='2'>2</option>"+
            "<option value='3'>3</option>"+
            "<option value='4'>4</option>"+
            "<option value='5'>5</option>"+
            "<option value='6'>6</option>"+
            "<option value='7'>7</option>"+
            "<option value='8'>8</option>"+
            "<option value='9'>9</option>"+
            "<option value='10'>10</option>"+
          "</select> "+
            "</div>"+
          "<div class='input-field col s12 test-drive'>"+
            "<input id='testdrive_date' name='Car[testdrive_date]' type='text'>"+
            "<label for='testdrive_date'>Testdrive date</label>"+
          "</div>";
        if($('#testdrive_date').length > 0 ){
            $('.test-drive').remove();
        }
        if($(".used-years").length > 0 ){
          $(".used-years").remove();
        }


        if(carType == 2) {

          $('.addishional-field').append(usedField);
          $("#used_from, #used_to").material_select();
          //$("#used_to").material_select();
        }
        if(carType == 4){

            $('.addishional-field').append(testdriveField);
            $("#score").material_select();
            Materialize.updateTextFields()

        }
        if(carType !==1){
          console.log('maincar hide');
          console.log($(".main-for-hide").parent());
          $(".main-for-hide").parent().css('display','none');
        } else {
          console.log('maincar show');
          $(".main-for-hide").parent().show();
        }

        // e.preventDefault();
        return false;

    },
      updateClick: function (e) {
        if (profileConfirmed) {
          console.log('Confirm alert');
          alert('Please, confirm your account by email');
        } else {
          console.log('Update car');

          var id = $(this).data('car-id');
          CarForm.id = 'addcar-id-' + id;
          let carData = CarForm.getData();
          CarForm.id = 'addcar';
          var mainCar = false;



          console.log(carData.get('Car[car_type]'));
          if (carData.get('Car[main_car]') == 'on') {
            mainCar = true;
            carData.set('Car[main_car]', 1);
          } else {
            mainCar = false;
            carData.set('Car[main_car]', -1);
          }
          //carData.append('Car[car_type]', carType);

          let promise = carController.update(carData);

          promise.then(function (carFields) {
            console.log(carFields);
            $('.mfp-close').click();
            location.reload();
          }, function () {
            console.log('Error');
          });
        }

        return false;
      },
    addClick: function (e) {
      console.log('Add car');
      if (profileConfirmed) {
        alert('Please, confirm your account by email');
      } else {
        let carData = CarForm.getData();
        var mainCar = false;

        console.log(carData.get('Car[main_car]'));

        if (carData.get('Car[main_car]') == 'on') {
          mainCar = true;
          carData.set('Car[main_car]', 1);
        }
        carData.append('Car[car_type]', carType);
        let promise = carController.add(carData);

        promise.then(function (carFields) {
          console.log(carFields);
          $('.mfp-close').click();
          carFields['main_car'] = mainCar;
          location.reload();
          // carController.render(carFields);
        }, function () {
          console.log('Error');
        });
      }
        // e.preventDefault();
      return false;
      },
      uploadBtnChange: function (e) {
        console.log('uploadBtnChange');
        console.log(e.currentTarget.files);
        console.log(e.currentTarget.dataset.update);

        carController.attachCloseBtnClick();

        var carImages = e.currentTarget.files;
        let update = Boolean(e.currentTarget.dataset.update);
        let formId = e.currentTarget.dataset.formId;
        console.log(formId);

        if(carImages.length >0) {

          if (!carController.validateImages(carImages)) {
            return (function () {
              $('.cars-preview').append("<span style='color: red'>Wrong format. Only JPEG, PNG, GIF.</span>");
            })();
          }

          var formData = new FormData();


          $.each(carImages, function (key, value) {
            formData.append('image[]', value);
          });


          var uploadImage = function () {
            $.ajax({
              url: '/api/image-resize/upload-image',
              type: 'POST',
              data: formData,
              dataType: 'json',
              cache: false,
              enctype: 'multipart/form-data',
              processData: false,
              contentType: false,
              success: function (response) {
                resp = response;
                carController.previewImage(resp, update, formId);
                for (var i = 0; i < response.length; i++) {
                  hiddenInputs.append("<input id='cropped-image-" + i + "'" + " type='hidden' name='Car[cropped_images][]' value='" + response[i].url + "'>");

                }
                //$('#progress-bar').css('width', 0);
              },
              error: function (response) {

                console.log('Error!')

              }
            });
          }

          progressBar('progress-bar');
          setTimeout(uploadImage, 1100);
        }

      },

      cropBtnClick: function(e) {

        // e.preventDefault();
        console.log('cropBtnClick');

        var cropper;

        var croppImage;

        var oldImage = $(this).prev();

        var image = oldImage.clone();

        var imgUrl = image[0].getAttribute('src');
        if(imgUrl.indexOf('?') !== -1 ){
          var arr = imgUrl.split('?');
          imgUrl = arr[0];
        }

        var cropModal = $('#crop-modal');

        var index = Number(image[0].dataset.index);
        //Modal window
        console.log(cropModal);

        cropModal.openModal({
          dismissible: true,

          ready: function(modal, trigger){
            console.log('modal');

            croppImage = $('#crop-modal .modal-content').append(image).children('img').css('max-width', '100%');

            croppImage[0].width = '480';

            cropper = new Cropper(croppImage[0],{
              aspectRatio: 618 / 440,

            });
          },
          complete: function(){

            var cropperData = cropper.getData();
            var imageData = cropper.getImageData();
            var data = {
              cropperData : cropperData,
              imageData : imageData,
              index : index,
              imgUrl : imgUrl

            };

            croppImage.remove();
            cropper.destroy();

            $.ajax({
              url: '/api/image-resize/crop-image',
              type: 'POST',
              data: {data :data},
              dataType: 'json',
              cache: false,
              success: function (response) {
                var imgParent = oldImage.parent();
                var timestamp = new Date().getTime();
                oldImage.remove();
                imgParent.prepend("<img src=" + response.url+ '?v='+timestamp+" width=\"180\" style=\"margin-right: 5px; margin-left: 5px\" data-index = " + index + "/>");
                $("#cropped-image-"+index).val(response.url);

              },
              error: function (response) {

                console.log('Error!')

              }
            })

          }

        });
        cropModal.css("z-index", 9999);
        return false;
      },

      closeBtnClick: function (e) {
        e.currentTarget.value = '';
        $('.cars-preview').find('*').remove();
        hiddenInputs.find('*').remove();

        console.log('Close btn click');

      }



    }
  })();

  const CarForm = {
    id: 'addcar',
    getData: function() {
      return new FormData(document.getElementById(this.id));
    }
  };

  var carController = new CarController();


  // attach garage events

  carController.attachUploadBtnChange();
  carController.attachAddBtnClick();
  carController.attachAddClick();
  carController.attachUpdateClick();
})();