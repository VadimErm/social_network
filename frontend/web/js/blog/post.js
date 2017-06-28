"use strict";
var removeId;
if (typeof profileConfirmed == 'undefined') {
  var profileConfirmed = false;
}

var Post = (function () {
  var preloader = undefined;

  return {
    addBr: function (e) {
      console.log(e);
      console.log(this);
    },
    removeComment: function (id) {
      console.log(id);
      $.ajax({
        url: '/blog/api/remove-comment?id=' + id,
        success: function (response) {
          console.log(response);
          if (response.status == 'success') {
            console.log($('#comment-id-' + id));
            $('#comment-id-' + id).remove();
          }
        }
      });
    },
    removePost: function (id) {
      removeId = id;
    },
    confirmRemovePost: function (e) {

      $.ajax({
        url: '/blog/api/remove-post?id=' + removeId,
        success: function (response) {
          console.log(response);
          if (response.status == 'success') {
            $('#post-id-' + removeId).remove();
            $('.mfp-close').click();
          }
        }
      });

      e.preventDefault();
    },
    editPost: function(e){
      var $dropdown = $(e),
      $div = $dropdown.siblings('.c-menu-actions');
      $div.toggleClass('hide');
    },
    addComment: function (postId, answerCommentId = undefined) {

      if (profileConfirmed) {
        alert('Please, confirm your account by email');
      } else {

        if(answerCommentId!== undefined){
          var answerCommentId = answerCommentId;
          var comment = $('#comment-' + answerCommentId+' .entry-text');

        } else {
          var answerCommentId = null;
          var comment = $('#comment-' + postId);
        }

        //local time
        if (!Date.prototype.now) {
          Date.prototype.now = function() { return new Date().getTime(); }
        }

        var offset = (new Date).getTimezoneOffset();

        if (comment[0].value.length > 0 && comment[0].value.length <= 400) {
          $.ajax({
            url: '/blog/api/add-comment',
            method: 'POST',
            data: {
              Comment: {
                node_id: postId,
                message: comment[0].value,
                local_time: offset,
                answer_comment_id: answerCommentId,
              }
            },
            success: function (response) {
              console.log('success');
              $('#comment-' + answerCommentId).slideUp();
              $('#comment-' + answerCommentId+' .entry-text').val('');
              var commentsCount = $('#post-id-' + postId).find('.comment-count');
              commentsCount.text(parseInt(commentsCount.text()) + 1);

              var comment = JSON.parse(response.comment);
              var account = JSON.parse(response.account);

              if(response.answerAccount !== 'null'){
                var answerAccount = JSON.parse(response.answerAccount);
                var answerAccountTpl = `<span class="answer-comment">answer</span> <a href="" class="answer-comment"> `+ answerAccount.first_name + ` `+answerAccount.last_name +`</a>`;
              } else {
                var answerAccountTpl = '';
              }



              var tpl = `<div class="entry-comment" id="comment-id-` + comment.id + `">
                                <div class="c-menu-wrap" onclick="Post.editPost(this)">
                                            <span class="c-menu round"></span>
                                        </div>
                                        <ul class="c-menu-actions hide">
                                            
                                            <li><a href="javascript:void(0)" onclick="Post.removeComment(` + comment.id + `)">Delete comment</a></li>
                                        </ul>
                                <div class="u-avatar round small">
                                    <img src="` + response.avatar + `" alt="user avatar">
                                </div>
                                <div class="comment-body">
                                   
                                    <div class="top-entry-meta">
                                        <a href="#">` + account.first_name + ' ' + account.last_name + `</a>
                                       `+ answerAccountTpl +`
                                        
                                        <div class="u-rating"><span class="ico-favorites-star-outlined-symbol"></span>0</div>
                                        <div class="entry-date">
                                                    Comment on `+ comment.created_at+`
                                        </div>
                                    </div>
                                    <p>` + comment.message + `</p>
                                    <div class="comment-footer clearfix">
                                        
                                        <div class="like"><a href="#"><span class="ico-heart-outline"></span>0</a></div>
                                        <div class="c-options">
                                               <a href="#" class="spam">spam</a>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
              $('.entry-text ').removeClass('valid');

              if (response.status == "success") {
                $('#comments-' + postId).append(tpl);
                $('#comment-' + postId).val('');

              }
            }
          });
        } else if (comment[0].value.length > 400){
          comment.addClass('invalid');
          alert('Max 400 symbols');
        } else if(comment[0].value.length == 0){
          comment.removeClass('valid');
          comment.addClass('invalid');
        }
      }
    },
    addPost: function () {
      console.log('Add post');
      var form = $('#post-form form')[0];
      var tplSource = document
        .getElementById('blog-post-tpl')
        .content
        .cloneNode(true)
        .toString();


      if (form) {

        var formData = new FormData(form);

        /*if (!Date.prototype.now) {
          Date.prototype.now = function() { return new Date().getTime(); }
        }

        var offset = (new Date).getTimezoneOffset();

        formData.append('local_time', offset);*/


        if(Boolean($('#blog-title').val()) && Boolean($('#entry-text').val())) {


         $.ajax({
            url: '/blog/blog/add-post',
            method: 'post',
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
              console.log(response);
              if (response.status == 'success') {
                //location.reload();
                var template = Handlebars.compile(tplSource);
                var data = {post: JSON.parse(response.post), account: JSON.parse(response.account)};


                var html = template(data);

                $('#blog-posts').append(html);
                var main_image = $('#blog-posts').find('.main-image');
                $(main_image).attr('src', $(main_image).data('src'));
              }
            }
          });
        } else {
          alert('Title and text cannot be blank');
        }
      }
    },

    updatePost: function(e){
      e.preventDefault();
      var postId = e.currentTarget.dataset.postId;
      console.log('update post');
      console.log(postId);
      var form = $("#edit-post-" +postId)[0];

      console.log($("#edit-post-" +postId)[0]);

      if(form){
        var formData = new FormData(form);
        formData.append('post_id', postId);

        if(Boolean( $("#edit-post-"+postId+" .edit-title").val()) && Boolean($("#edit-post-"+postId+" .edit-text").val())) {
          $.ajax({
            url: '/blog/blog/update-post',
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
        } else {
          alert('Title and text cannot be blank');
        }

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
    showAll: function (e) {
      console.log('Show all');
      var main = $(e.target).parent().parent().parent().parent().parent();
      main.find('.gallery-item-preview').attr('style', '');
      e.preventDefault();
    },
    previewRemove: function (i) {

      console.log('Remove'+ i);

      var image = $("#image-id-" + i);

      //console.log($('#image-file'));
      $("#entry-post-form").append("<input type='hidden' name='deleted_images["+ i +"]' value="+ image[0].dataset.name +">");
      image.prev().remove();
      image.remove();
    },
    editImageRemove: function(e){
        e.preventDefault();
        console.log(e.currentTarget.dataset);
        if(e.currentTarget.dataset.postId !== undefined){

          var postId = e.currentTarget.dataset.postId;
          var imageName = e.currentTarget.dataset.name;
          var deletedImages = $('#edit-post-'+postId+' .deleted-images-count');
          var deletedImagesCount = Number(deletedImages.val());
          deletedImagesCount += 1;
          deletedImages.val(deletedImagesCount);
          $('#edit-post-'+postId).append("<input type='hidden' name='deleted_images["+ deletedImagesCount +"]' value='"+imageName +"'>");
          console.log($('#edit-post-'+postId+' .deleted-images-count').val());
        }
        $(e.currentTarget).parent().remove();

    },
    previewImage: function (e) {
      var fileList = this.files;
      var postId;
      console.log(e.currentTarget.dataset.postId);
      if(e.currentTarget.dataset.postId !== undefined){
        postId = e.currentTarget.dataset.postId;

      }
      console.log(fileList);
      var anyWindow = Post.getWindowUrl();

      for (var i = 0; i < fileList.length; i++) {
        //get a blob to play with
        var objectUrl = anyWindow.createObjectURL(fileList[i]);
        // for the next line to work, you need something class="preview-area" in your html
        if (fileList[i].type.match('image/*')) {

          if(postId !== undefined){
            $("#post-id-"+postId+" .image-preview").append('<li><a href="#" data-post-id="'+postId+'" data-name ="'+ fileList[i].name + '" class="image-edit-delete"><span class="ico-close-cross-circular-interface-button"></span></a> <img src="' + objectUrl + '" alt="image"></li>');

          } else {
            $('#preview-area').append('<img  src="' + objectUrl + '" width="150" height="100" style="margin-right: 15px;" /><img id="image-id-'+ i +'" onclick="Post.previewRemove('+ i +')" src="/images/close.svg" data-name ="'+ fileList[i].name + '" width="20" height="20" style="position: absolute;cursor:pointer;margin-left: -36px;"/>');

          }

          // get rid of the blob
          window.URL.revokeObjectURL(fileList[i]);
        } else {
          Post.alertUnsupportType();
        }
      }
    },
    validateVideo: function () {
      console.log('validate video');
      //var videoSource = $(this);
      var videoSource = $('#video-source');
      var videoLabel = $('#video-label');
      //var videoLabel = videoSource.siblings('label');
      //console.log(this);
      //console.log(videoLabel);

      console.log(videoLabel);
      console.log(videoSource);

      var value = videoSource.val();
      var reg = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;

      if (value.length == 0 || !reg.test(value)) {
        //  validate fail
        console.log('Fail');
        videoSource.removeClass('valid');
        videoSource.addClass('invalid');
      } else {
        // validate right
        console.log('Right');
        videoSource.removeClass('invalid');
        videoSource.addClass('valid');
      }
    },
    addVideo: function (e) {
      //Post.validateVideo();
      console.log(e.currentTarget);
      e.preventDefault();
      var postId;

      if(e.currentTarget.dataset.postId !== undefined){
        postId = e.currentTarget.dataset.postId;

      }
      console.log(postId);
      var postForm = $('#newblogvideo').find('.invalid');
      var videoSource = $('#video-source');
      var videoUrl = videoSource.val();

      console.log(Boolean(videoUrl));
      console.log('add video');

      var youtubeParser = function (url) {
        var videoid = url.match(/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
        if(videoid != null) {
          console.log('videoid:' + videoid);
          return videoid[1];
        }
      };

      var imageSrc = youtubeParser(videoUrl);
      var imageFullSrc;


      imageFullSrc = 'https://img.youtube.com/vi/' + imageSrc + '/0.jpg';
      videoUrl = 'https://www.youtube.com/embed/' + imageSrc;

      if (Boolean(videoSource.val())) {
        //Add video count for identification video
        var videoCount = Number($("#video-count").val());
        videoCount += 1;
        $("#video-count").val(videoCount);

        var videoInput = '<input type="hidden" id ="video-id-'+ videoCount +'" name="Post[videos][]" value="' + videoUrl + '">';

        if(postId !== undefined){
          console.log('preview video add');
          var videoPrev = "<div class='post-vid-item'>"
            +"<a href='#' class='image-edit-delete'>"
            +"<span class='ico-close-cross-circular-interface-button'></span></a>"
            +"<iframe width='204' height='150'src="+ videoUrl +" frameborder='0' allowfullscreen></iframe>"
            +"<input type='hidden' name='Post[videos][]' value="+ videoUrl +"></div>";
          $("#post-id-"+postId+" .if-has-video").append(videoPrev);
          //$('#preview-area').append(`<a href="#video_modal" id ="video-`+videoCount+`" style="height: 100%;" class="popup-form"><img class="video-popup" data-video-src="`+videoUrl+`" width="150" height="100" src="`+ imageFullSrc +`"></a><img  onclick="Post.videoRemove(`+videoCount+`)" src="/images/close.svg"  width="20" height="20" style="position: absolute;cursor:pointer;margin-left: -36px;"/>`);

        } else {
          $('#preview-area').append(`<a href="#video_modal" id ="video-`+videoCount+`" style="height: 100%;" class="popup-form"><img class="video-popup" data-video-src="`+videoUrl+`" width="150" height="100" src="`+ imageFullSrc +`"></a><img  onclick="Post.videoRemove(`+videoCount+`)" src="/images/close.svg"  width="20" height="20" style="position: absolute;cursor:pointer;margin-left: -36px;"/>`);
          $('#entry-post-form').append(videoInput);
        }


        // $('.video-popup').on('click', VideoClick);
        // Materialize.updateTextFields();

        $('.mfp-close').click();
      }

      videoSource.val('');
      e.preventDefault();
    },
    getWindowUrl: function () {
      return window.URL || window.webkitURL;
    },
    alertUnsupportType: function () {
      alert('Unsupported file type');
    },
    previewVideo: function () {
      var fileList = this.files;

      var anyWindow = Post.getWindowUrl();

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
          Post.alertUnsupportType();
        }
      }
    },
    addPostId: function(e){
      console.log(e.currentTarget);
      var postId;
      if(e.currentTarget.dataset.postId !== undefined){
        postId = e.currentTarget.dataset.postId;
        $("#add-blog-video").attr('data-post-id', postId);

      }


    },
    videoRemove: function(id){
     $("#video-"+id+", #video-"+id+"+img").remove();
     $("#video-id-"+id).remove();

    },
    sendEvent: function (e) {
      if (profileConfirmed) {
        alert('Please, confirm your account by email');
      } else {
        Post.addPost();
      }
      e.preventDefault();
    },

    titleBlur: function(postId = undefined){
      var title;
      if(postId !== undefined){
        title = $("#edit-post-"+postId+" .edit-title");
      } else {
        title = $('#blog-title');
      }


      if(!Boolean(title.val())){
        console.log('invalid');
        title.removeClass('valid');
        title.addClass('invalid');
      } else {
        title.removeClass('invalid');
        title.addClass('valid');
      }
    },

    textBlur: function(postId = undefined){
      var text;
      if(postId !== undefined){
        text = $("#edit-post-"+postId+" .edit-text");
      } else {
        text = $('#entry-text');
      }


      if(!Boolean(text.val())){
        text.removeClass('valid');
        text.addClass('invalid');
      } else {
        text.removeClass('invalid');
        text.addClass('valid');
      }
    },

    commentBlur: function (e) {
      var commentId = e.currentTarget.id;
      var comment = $("#" + commentId);
      if(!Boolean(comment.val())){
        comment.removeClass('valid');
        comment.addClass('invalid');
      } else {
        comment.removeClass('invalid');
        comment.addClass('valid');
      }
    },

    submit: function (e) {
      var postId = e.currentTarget.dataset.postId;
      console.log(postId);
      Post.titleBlur(postId);
      Post.textBlur(postId);
    }
  }
})();


function VideoClick(e){
  console.log(this);
  console.log('Click video event');
  var videoSrc = $(this).attr('data-video-src');

  $('#video-container').html('<iframe width="300" height="266" src="'+ videoSrc +'" frameborder="0" allowfullscreen></iframe>');
}
function ImageSrc(e) {
  var imageSrc = $(this).attr('src');
  $('#video-container').html('<img width="300" height="266" src="'+ imageSrc +'">');
};
var show = false;
$('.show-comments').on('click', function () {
  console.log('Bla');
  var text = show ? 'show more comments' : 'hide comments';

  $(this).text(text);

  if (show) {
    $(this).parent().find('.entry-comment[data-is-hidden]').hide();
  } else {
    $(this).parent().find('.entry-comment').show();
  }

  show = !show;
});
$('.image-popup').on('click', ImageSrc);
$('.video-popup').on('click', VideoClick);
$('#remove-post').on('click', Post.confirmRemovePost);
$('.show-all').on('click', Post.showAll);
$('#video-source').on('blur', Post.validateVideo);
//$('#video-source-edit').on('blur', Post.validateVideo);
$('#add-blog-video').on('click', Post.validateVideo);
$('#add-blog-video').on('click', Post.addVideo);

$('#send').on('click', Post.sendEvent);
$('#image-file').on('change', Post.previewImage);
//$('#video-file').on('change', Post.previewVideo);
$('#blog-title').on('blur',function(){ Post.titleBlur() });
$('#entry-text').on('blur', function(){ Post.textBlur() });
$('#send').on('click', Post.submit);
$('.entry-text').on('blur', Post.commentBlur);
$('.entry-text').characterCounter();
$('body').on('click', '.image-edit-delete', Post.editImageRemove);
$('.image-edit-file').on('change', Post.previewImage);
$(".edit-video").on('click', Post.addPostId);
$("#edit-video-add").on('click', Post.addVideo);
$(".update-post").on('click', Post.updatePost);
$(".update-post").on('click', Post.submit);

$('body').on('click', '.mfp-close', function (e) {
  console.log('close');
  $("#add-blog-video").removeAttr('data-post-id');
  $('#video-source').val('');
});

$(".edit-title").on('blur', function(e){
    var postId = e.currentTarget.dataset.postId;
    console.log(postId);
    Post.titleBlur(postId);
});
$(".edit-text").on('blur', function(e){
  var postId = e.currentTarget.dataset.postId;
  console.log(postId);
  Post.textBlur(postId);
});