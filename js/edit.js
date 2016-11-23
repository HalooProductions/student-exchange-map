$(document).ready(function(){
  $(".school-edit-btn").click(function(){
    $('#editmodal').modal('show');
    $('#country-input').dropdown("set selected", $(this).data('country'));
    $('#city-input').dropdown("set selected", $(this).data('city'));
    $('.ui.dropdown').dropdown('refresh');
    $('#school-input').val($(this).data("school"));


  });

  $("#add-school-btn").click(function(){
  	$("#addmodal").modal("show");
  });

  $('.ui.checkbox').checkbox();

  $('select.dropdown').dropdown();

  $("#saveschool").on("click", function(){

    var departments = $.map($('input[name="departments"]:checked'), function(c){return c.value; });

    var schoolname = $("#addschoolname").val();
    var map;
    var service;
    var infowindow;
    initialize();
    function initialize() {

      map = new google.maps.Map(document.getElementById('map'));

      var request = {
        query: schoolname,
      };

      service = new google.maps.places.PlacesService(map);
      service.textSearch(request, callback);
    }

    function callback(results, status) {
      if (status == google.maps.places.PlacesServiceStatus.OK) {
          console.log(results);
          var schoolname = $("#addschoolname").val();
          var city = $("#addcity").val();
          var country = $("#addcountry").val();
          var placeid = results[0].place_id;

          var cityint = parseInt(city);
          var countryint = parseInt(country);
          console.log(city);
          console.log(country);
          if (schoolname != '' && city != '' && country != '' && placeid != '')
          {
            $.ajax({
              method: "POST",
              url: "api/edit.php",
              data: {
                schoolname: schoolname,
                city: cityint,
                country: countryint,
                placeid: placeid,
                departments: departments,
                action: 0
              },
              success: function(result){
                $("#addmodal").modal("hide");
              }
            });
          }
      }   
    }
  });
});
// ajax action 0:luominen, 1:edit, 2:delete