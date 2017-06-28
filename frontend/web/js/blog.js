"use strict";

var Blog = (function(){
  var  preloader = undefined;

  return  {
    addPost: function () {
      console.log('Add post');
      var form = $('#post-form form')[0];

      console.log(form);
      if (form) {
        var formData = new FormData(form);

        $.ajax({
          url: '/blog/blog/add-post',
          method: 'post',
          processData: false,
          contentType: false,
          data: formData,
          success: function (response) {
            console.log(response);
            if (response.status == 'success') {
              location.reload();
            }
          }
        });
      }
    },
    getPreloader: function () {
      return preloader ? preloader : $('#send .preloader');
    },
    showPreload: function () {
      console.log(this.getPreloader());
    },
    hidePreloader: function () {
      console.log(this.getPreloader());
    },
    previewImage: function () {
      var fileList = this.files;
      var anyWindow = Blog.getWindowUrl();

      for (var i = 0; i < fileList.length; i++) {
        //get a blob to play with
        var objectUrl = anyWindow.createObjectURL(fileList[i]);
        // for the next line to work, you need something class="preview-area" in your html
        if (fileList[i].type.match('image/*')) {
          $('#preview-area').append('<img src="' + objectUrl + '" width="150" height="100" />');
          // get rid of the blob
          window.URL.revokeObjectURL(fileList[i]);
        } else {
          Blog.alertUnsupportType();
        }
      }
    },
    getWindowUrl: function() {
      return window.URL || window.webkitURL;
    },
    alertUnsupportType: function () {
      alert('Unsupported file type');
    },
    previewVideo: function () {
      var fileList = this.files;

      var anyWindow = Blog.getWindowUrl();

      for (var i = 0; i < fileList.length; i++) {
        //get a blob to play with
        var objectUrl = anyWindow.createObjectURL(fileList[i]);
        // for the next line to work, you need something class="preview-area" in your html
        if (fileList[i].type.match('video/*')) {
          var vid = document.createElement('video');
          vid.width = 177;
          vid.src = objectUrl;
          anyWindow.revokeObjectURL(fileList[i]);
          document.getElementById('preview-area').appendChild(vid);
        } else {
          Blog.alertUnsupportType();
        }
      }
    },
    sendEvent: function (e) {
      console.log('Bla bla bla bla bla bla bla bla bla bla')
      Blog.addPost();
      e.preventDefault();
    }
  }
})();

$('#send').on('click', Blog.sendEvent);
$('#image-file').on('change', Blog.previewImage);
$('#video-file').on('change', Blog.previewVideo);