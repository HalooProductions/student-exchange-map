$(document).ready(function () {
	//your code here
	$('.small.modal')
	.modal({
		autofocus: true,
		blurring: true
	}).modal('show');

	$("#log").click(function() {
		var username = $("#username").val();
		var password = $("#password").val();
		$.ajax({
			method: "POST",
			url: "api/login.php",
			data: {name: username, pwd: password},
			success: function(response){
				var responseJSON = JSON.parse(response);
				if(responseJSON.success)
				{
					window.location="index.html";
				}
				else
				{
					alert("Tarkista käyttäjätunnus ja salasana!");
				}
			}
		})
	});
});



		/*var username = $("#username").val();
		var password = $("#password").val();

		if (username == '' || password == ''){
			alert("Täytä kaikki kentät!");
		} else {

		}*/