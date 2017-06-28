"use strict";
// photo id = photo src
var selectedPhotos = [];
var removedPhotos = [];
var removePhotoId;
var changedDescriptions = [];
var selectedAll = false;
var selectedPhotosLength = 0;
var saveAfterConfirm = false;

(function ($) {
  var AlbumPhoto = {
    saveDescriptionEvent: function (e) {
      console.log('Safe');

      var id = $(e.target).data('id');
      var src = $(e.target).data('src');
      console.log(src);


      $('#image-description-text-' + id).show();
      var desc = $('#image-description-textarea-' + id).val();
      $('#image-description-text-' + id).text(desc);
      $('#desc-field-' + id).hide();

      AlbumPhoto.descriptionChange(src, desc);
      console.log(changedDescriptions);
      AlbumPhoto.saveChanges();

      e.preventDefault();
    },
    // Photo events
    saveChangesEvent: function (e) {
      console.log('Save changes');
      AlbumPhoto.saveChanges();
      e.preventDefault();
    },
    saveChanges: function () {
      console.log(removedPhotos);
      console.log(changedDescriptions);

      if (removedPhotos.length > 0 || changedDescriptions.length > 0) {
        // update album photos
        $.ajax({
          url: '/user/api/update-album',
          method: 'PUT',
          data: {
            removed: removedPhotos,
            changed: changedDescriptions
          },
          success: function (response) {
            console.log(response);

            if (response.status == 'success') {
              alert('Updated success');
            }
          }
        });
      } else {
        // nothing to update
        alert('Nothing to update');
      }
    },
    cancelDeleteEvent: function (e) {
      console.log('Cancel delete event');
      $('#delete button').click();
      e.preventDefault();
    },
    descriptionRemove: function (src) {
      $(changedDescriptions).each(function (i) {
        if (changedDescriptions[i].src == src) {
          // update only description
          delete changedDescriptions[i];
          changedDescriptions.length--;
          // like a break for .each
          return false;
        }
      });
    },
    descriptionChange: function (src, value) {
      console.log('Description change');
      console.log(changedDescriptions);
      console.log(changedDescriptions.length);

      var updated = false;

      if (changedDescriptions.length > 0) {
        $(changedDescriptions).each(function (i) {
          console.log('Try change');
          console.log(src);
          if (changedDescriptions[i].src == src) {
            // update only description
            changedDescriptions[i].description = value;

            updated = true;

            // like a break for .each
            return false;
          }
        });
      }

      if (!updated) {
        console.log('photo Push');
        changedDescriptions.push({src: src, description: value});
      }

      console.log(changedDescriptions);
    },
    descriptionBlurEvent: function (e) {
      // photo description changed
      console.log('description blur event');

      var input = $(e.target);
      var src = input.data('src');
      AlbumPhoto.descriptionChange(src, input.val());
    },
    addChanged: function (src) {
      var deleted = false;

      if (selectedPhotos.length == 0) {
        selectedPhotos.push(src);
        selectedPhotosLength++;
      } else {
        selectedPhotos.forEach(function (selectedCar, i) {
          if (selectedCar == src) {
            // element is exist need remove (deselect event)
            delete selectedPhotos[i];
            selectedPhotosLength--;

            deleted = true;
            selectedAll = false;
          }
        });

        if (!deleted) {
          selectedPhotos.push(src);
          selectedPhotosLength++;
        }
      }

      $('#selected-items').text(selectedPhotosLength);
      console.log(selectedPhotos);
    },
    selectEvent: function (e) {
      var src = $(this).data('src');
      AlbumPhoto.addChanged(src);
    },
    selectAllEvent: function (e) {
      var selected = AlbumPhoto.selectAll();

      if (!selectedAll) {
        selectedPhotos = [];

        selected.each(function (i) {
          AlbumPhoto.addChanged($(selected[i]).data('src'));
        });
      }

      selectedAll = true;
      e.preventDefault();
    },
    selectAll: function () {
      var selected = $('.sel-photo');
      selected.addClass('active');
      $('#selected-items').text(selected.length);

      return selected;
    },
    deselectEvent: function (e) {
      AlbumPhoto.deselect();
      selectedAll = false;

      e.preventDefault();
    },
    deselect: function () {
      var selected = $('.sel-photo');
      selected.removeClass('active');
      selectedPhotosLength = 0;
      selectedPhotos = [];

      $('#selected-items').text(selectedPhotos.length);
    },
    createEvent: function (e) {
    },
    editEvent: function (e) {
      var id = $(e.target).data('id');
      $('#image-description-text-' + id).hide();
      $('#desc-field-' + id).show();
      e.preventDefault();
    },
    removeEvent: function (e) {
      console.log('Remove event');
      console.log(e.target);
      removePhotoId = $(e.target).attr('data-src');
    },
    removeConfirmEvent: function (e) {
      console.log('Remove photo');
      AlbumPhoto.remove();
      $('#delete button').click();
      e.preventDefault();
    },
    remove: function () {
      console.log(removePhotoId);
      var removedItemsCount = 0;

      if (typeof removePhotoId == 'undefined') {
        // remove all selected
        removedPhotos = selectedPhotos.slice(0);

        $(removedPhotos).each(function (i) {
          $('.sel-photo[data-src="'+ removedPhotos[i] +'"]')
            .parent()
            .parent()
            .remove();

          AlbumPhoto.descriptionRemove(removedPhotos[i]);
          AlbumPhoto.addChanged(removedPhotos[i]);
          removedItemsCount++;
        });
        console.log(removedPhotos);
      } else {
        removedPhotos.push(removePhotoId);

        $('.sel-photo[data-src="'+ removePhotoId +'"]')
          .parent()
          .parent()
          .remove();

        AlbumPhoto.descriptionRemove(removePhotoId);

        removedItemsCount = 1;
      }

      var itemsCount = $('#items-count');

      console.log(removedItemsCount);
      // update items count
      itemsCount.text(parseInt(itemsCount.text()) - removedItemsCount);

      if (saveAfterConfirm) {
        AlbumPhoto.removeSinglePhoto();
        AlbumPhoto.saveChanges();
      }

      removePhotoId = undefined;
    },
    removeSinglePhoto: function () {
      console.log('Simple photo remove');
      $('li[data-src="'+removePhotoId+'"]').remove();
      $('div[data-src="'+removePhotoId+'"]').remove();
      $('.close-gallery').click();
    },
    uploadPhotosEvent: function (e) {
      console.log('Upload event');

      var newPhotos = $('#new-photos');

      var form = new FormData(newPhotos[0]);
      console.log(form);

      $.ajax({
        url: '/user/api/append-photos',
        data: form,
        type: "POST",
        processData: false,
        contentType: false,
        success: function (response) {
          console.log(response);
          console.log('Here upload');
          if (response.status == 'success') {
            location.reload();
          } else if (response.status == 'fail') {
            alert('Fail');
          }
        }
      });

      console.log(newPhotos);
    }
  };

  var removeAlbumId;

  var Album = {
    previews: function (input) {
      if (input.files) {
        var photos = $('#upload-photos');
        var photo = $('<input type="file" style="display: none;" multiple name="Album[images][]">');
        photo[0].files = photos[0].files;

        if (input.files.length > 1) {
          $('#album-images-preview').append(photo[0]);
        }

        $(input.files).each(function(i){
          var reader = new FileReader();

          if (input.files.length == 1) {
            $('#album-images-preview').append(photo[0]);
          }

          reader.onload = function (e) {
             $('#album-images-preview').append('<img src="'+ e.target.result +'" width="180" style="margin-right: 5px; margin-left: 5px" data-index="0">');
          };

          reader.readAsDataURL(input.files[i]);

        });
      }
    },
    moveEvent: function(e){
      console.log('Move event');

      selectedPhotos.push($(e.target).data('src'));
      selectedPhotosLength = 1;
      e.preventDefault();
    },
    move: function(fromAlbumId, toAlbumId) {
      console.log(fromAlbumId);
      console.log(toAlbumId);

      $.ajax({
        url: '/user/api/move-album',
        method: "POST",
        data: {
          from: fromAlbumId,
          to: toAlbumId,
          photos: selectedPhotos
        },
        success: function (response) {
          console.log(response);
          if (response.status == "success") {
            location.reload();
            $('.mfp-close').click();
          }
        }
      });
    },
    moveEventConfirm: function (e) {
      console.log('Move event confirm');
      var fromAlbumId;
      var albumIdInput = $('#album-id');

      fromAlbumId = albumIdInput.val();
      var toAlbumId = $('#choosed-album option:selected').val();
      var select = albumIdInput.next().find('.select-dropdown');

      if (selectedPhotosLength == 0) {
        alert('No photo selected');
      } else if (toAlbumId == 0) {
        console.log('Here');
        select.removeClass('valid');
        select.addClass('invalid');
      } else {
        select.removeClass('invalid');
        select.addClass('valid');

        Album.move(fromAlbumId, toAlbumId);
      }

      e.preventDefault();
    },
    validateTitle: function () {
      console.log('Validate title');
      var title = $('#album-title');

      if (title.val().length > 0) {
        // valid
        title.removeClass('invalid');
        title.addClass('valid');

        return true;
      }

      // invalid
      title.removeClass('valid');
      title.addClass('invalid');

      return false;
    },
    // Album events
    createEvent: function (e) {
      console.log('Album create event');
      e.preventDefault();

      if (Album.validateTitle()) {
        console.log('Title is valid');
        var data = $('#newalbum');
        console.log(data);

        $.ajax({
          url: '/user/api/add-album',
          method: 'POST',
          data: new FormData(data[0]),
          contentType: false,
          processData: false,
          success: function (response) {
            console.log(response);
            if (response.status == 'success') {
              location.reload()
            } else {
              alert('Error');
            }
          }
        });
      }
    },
    editEvent: function (e) {

    },
    removeEvent: function (e) {
      console.log('Remove album event');
      removeAlbumId = $(e.target).data('id');
      console.log(removeAlbumId);

      e.preventDefault();
    },
    removeEventConfirm: function (e) {
      console.log('Remove confirm event');
      Album.remove();

      e.preventDefault();
    },
    remove: function (id) {
      if (typeof id == 'undefined') id = removeAlbumId;

      if (id) {
        $.ajax({
          url: '/user/api/remove-album',
          method: 'DELETE',
          data: {
            id: id
          },
          success: function (response) {
            if (response.status == 'success') {
              $('div[data-id="'+ id + '"]').remove();
              $('.mfp-close').click();
            }
          }
        });
      }
    },
    changeEvent : function (e) {
      if(e.currentTarget.files.length > 0 ){
        progressBar('progress-bar');
      }
    }
  };

  $('#upload-photos').on('change', function(){
    progressBar('progress-bar');
    var input = this;
    var preloader = $('.preloader-wrapper');
    preloader.addClass('active');

    setTimeout(function () {
      Album.previews(input);
      preloader.removeClass('active');
    }, 1100);
  });
  $('#new-photos-input').on('change', function () {
    progressBar('single-progress');
  });
  $('.save-image-desc').on('click', AlbumPhoto.saveDescriptionEvent);
  $('body').on('click', '.edit-image-description', AlbumPhoto.editEvent);
  $('#move-album-confirm').on('click', Album.moveEventConfirm);
  $('.move-album-single').on('click', Album.moveEvent);
  $('#new-photos-input').on('change', function(){
    progressBar('single-progress');
    setTimeout(AlbumPhoto.uploadPhotosEvent, 1100);
  });
  $('.remove-album').on('click', Album.removeEvent);
  $('#remove-album-confirm').on('click', Album.removeEventConfirm);
  $('.remove').on('click', AlbumPhoto.removeEvent);
  $('#remove-photo').on('click', AlbumPhoto.removeConfirmEvent);
  $('#cancel-photo-delete').on('click', AlbumPhoto.cancelDeleteEvent);
  $('.description').on('blur', AlbumPhoto.descriptionBlurEvent);
  $('#select-all').on('click', AlbumPhoto.selectAllEvent);
  $('#deselect').on('click', AlbumPhoto.deselectEvent);
  $('.sel-photo').on('click', AlbumPhoto.selectEvent);
  $('#create-album').on('click', Album.createEvent);
  $('#album-title').on('blur', Album.validateTitle);
  $('#save-photo-changes').on('click', AlbumPhoto.saveChangesEvent);
  $('#upload-photos').on('change', Album.changeEvent);
})(jQuery);