(function () {
  var avatarFile = $('#avatar-file');
  var avatar = $('#avatar');
  var avatarRemove = $('#delete-avatar');

  avatarRemove.on('click', function () {
    console.log('Click');
    console.log(avatarFile);
    avatarFile.after('<input type="hidden" name="SignupForm[noAvatar]" value="1">');
    avatar.attr('src', '/images/no-avatar.png');
  });

})();