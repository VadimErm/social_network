var car_id = null;

var CarActions = {
  toExCars: function (id, main = null) {
    console.log(main);
    let url = '';
    if(main == null) {
      url = '/garage/api/to-ex-cars?id=' + id;
    } else{
      url = '/garage/api/to-ex-cars?id=' + id+'&main=' + main
    }
    if(id !==null) {
      $.ajax({
        url: url,
        success: function (response) {
          console.log(response);

          if(response.status == 'success') {
            location.reload();
          }
        }
      });
    }
  },
  toMyCars: function (id) {
    if(id !==null) {
      $.ajax({
        url: '/garage/api/to-my-cars?id=' + id,
        success: function (response) {
          console.log(response);

          if(response.status == 'success') {
            location.reload();
          }
        }
      });
    }
  },
  remove: function (id) {
    console.log('Remove '+ id);
    car_id = id;
  },
  confirmRemove: function () {
    console.log('Remove confirm');
    console.log(car_id);
    if (car_id != null) {
      $.ajax({
        url: '/garage/api/remove?id='+car_id,
        success: function (response) {
          console.log(response);

          if (response.status == 'success') {
            $('#car-id-'+car_id).remove();
            $('#confirmBtn').click();
            car_id = null;
          }
        }
      });
    }
  }
};
$("#delete-car-cancel-btn").on("click", function(e){
  $("#confirmBtn").click();
});