function progressBar(elemId) {
  var elem = document.getElementById(elemId);
  var width = 1;
  var id = setInterval(frame, 10);

  elem.style.background = '#999';
  elem.style.position = 'absolute';
  elem.style.height = '100%';

  function frame() {
    if (width >= 100) {
      clearInterval(id);
    } else {
      width++;
      elem.style.width = width + '%';
      if(elem.style.width == '100%'){
          elem.style.width = 0;

      }
    }
  }

}
