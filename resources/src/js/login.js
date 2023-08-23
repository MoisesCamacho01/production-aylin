$(document).ready(function () {
	$('#btnIngresar').click(function (e) {
		e.preventDefault();

		let email = $('input[name="email"]').val();
		let password = $('input[name="password"]').val();
		let ip = $("#ip").val();

		let value = validate([
			{
				name: 'email',
				type: "string",
				campo: "email o usuario",
				value: email,
				min: 1,
				max: 150,
				required: true,
			},

			{
				name: 'password',
				type: "string",
				campo: "contraseña",
				value: password,
				min: 5,
				max: 18,
				required: true,
			 },

			 {
				name: "ip",
				type: "string",
				campo: "ip",
				value: ip,
				min: 1,
				max: 15,
				required: true,
			},
		])

		if(value){

			const data = {
				email,
				password,
				ip
			}

			$.ajax({
			  url: base_url('singIn'),
			  type: 'POST',
			  data: data,
			  success: function(answer) {
				let response = JSON.parse(answer);
				 if (response.message.type == 'success') {
				  toast('bg-success', response.message.title, response.message.message+" Verifica tus credenciales", 1);
				  setTimeout(() => {
					  window.location.href = 'dashboard';
				  }, 600);
			  } else {
				  toast('bg-danger', response.message.title, response.message.message, 1);
				 }
			  }
			})
		}else{
			toast('bg-danger', 'Acceso Incorrecto', 'Tus credenciales no son correctas', 1);
		}

	});

	function ipm(){
		$.getJSON("https://ipapi.co/json",function(data){
			$("#ip").val(data.ip)
		},"json");
	}

	ipm();



});
