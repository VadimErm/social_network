console.log('Upload preview');

function readURL(input) {
  progressBar('progress-bar');

  var preview = function () {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#avatar').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }
  setTimeout(preview, 1100);

}

$("#avatar-file").change(function(){
  console.log('This is bla');
  $('input [name="SignupForm[noAvatar]"]').remove();
    readURL(this);

});