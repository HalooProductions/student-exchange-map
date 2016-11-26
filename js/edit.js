$(document).ready(function(){
  $(".school-edit-btn").click(function(){
    $('#editmodal').modal('show');
    $('#country-input').dropdown("set selected", $(this).data('country'));
    $('#city-input').dropdown("set selected", $(this).data('city'));
    $('.ui.dropdown').dropdown('refresh');
    $('#school-input').val($(this).data("school"));
    var tempdepartments = [];
    tempdepartments = $(this).data('departments1');
    if (typeof tempdepartments === "number") {
      tempdepartments = tempdepartments + '';
    }
    
    if(tempdepartments.length > 0)
    {  
      var departments1 = tempdepartments.split(",");
    }
    else
    {
      var departments1 = [];
    }
    var deplength = departments1.length;
    console.log(deplength);
    var schoolid1 = $(this).data('id');
    var placeid1 = $(this).data('placeid');

    for (var i = 1; i < 9; i++) {
      $("#editmodal .checkbox").find('[value=' + [i] + ']').prop("checked", false);
    }

    for (var i = 0; i < deplength; i++) {
      $("#editmodal .checkbox").find('[value=' + departments1[i] + ']').prop("checked", true);
      console.log($("#editmodal .checkbox").find('[value=' + departments1[i] + ']'));
    }
    
    $("#save-edit").click(function(){
      var departments1 = [];
      var schoolname1 = $("#school-input").val();
      var city1 = $("#city-input").val();
      var country1 = $("#country-input").val();
      departments1 = $.map($('input[name="departments1"]:checked'), function(c){return c.value; });
      var cityint1 = parseInt(city1);
      var countryint1 = parseInt(country1);
      console.log(schoolid1);
      $.ajax({
        method: "POST",
        url: "api/edit.php",
        data: {
          schoolid: schoolid1,
          schoolname: schoolname1,
          city: cityint1,
          country: countryint1,
          placeid: placeid1,
          departments: departments1,
          action: 1
        },
        success: function(result){
          $("#editmodal").modal("hide");
          location.reload(true);
        }
      });
    })
  });

  $("#add-school-btn").click(function(){
  	$("#addmodal").modal("show");


    for (var i = 1; i < 9; i++) {
      $("#addmodal .checkbox").find('[value=' + [i] + ']').prop("checked", false);
    }
  });

  $('.ui.checkbox').checkbox();

  $('select.dropdown').dropdown();

  $("#saveschool").click(function(){

    var schoolname;
    var city;
    var country;
    var placeid;
    var departments = $.map($('input[name="departments"]:checked'), function(c){return c.value; });

    console.log(departments);

    schoolname = $("#addschoolname").val();
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

          schoolname = $("#addschoolname").val();
          city = $("#addcity").val();
          country = $("#addcountry").val();
          placeid = results[0].place_id;

          var cityint = parseInt(city);
          var countryint = parseInt(country);
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
                location.reload(true);
              }
            });
          }
      }   
    }
  });

  $(".school-delete-btn").click(function(){
    var schoolid = $(this).data('id');

    if(schoolid != 0)
    {
      $.ajax({
        method: "POST",
        url: "api/edit.php",
        data: { 
          schoolid: schoolid,
          action: 2,
        },
        success: function(result){
           location.reload(true);
        }
      })
    }
  });
});
// ajax action 0:luominen, 1:edit, 2:delete