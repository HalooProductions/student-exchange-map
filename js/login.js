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
			type: "POST",
			url: "login.php",
			data: "name"=+username+"&pwd"=+password+,
			success: function(html){
				if(html==true)
				{
					window.location="index.html"
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