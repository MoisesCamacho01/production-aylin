$('#forgotPassword').click(function (e) {
	e.preventDefault();
	let email = $('#email').val();
	let password = $('#password').val();
	let password2 = $('#password2').val();
	let token = $('#token').val();

	let value = validate([
		{
			name: 'email',
			type: "email",
			campo: "email",
			value: email,
			min: 1,
			max: 150,
			required: true,
		},

		{
			name: 'password',
			type: "string",
			campo: "contraseña 1",
			value: password,
			min: 6,
			max: 18,
			required: true,
		},

		{
			name: 'password2',
			type: "string",
			campo: "contraseña 2",
			value: password2,
			min: 6,
			max: 18,
			required: true,
		},

		{
			name: 'token',
			type: "string",
			campo: "código de seguridad",
			value: token,
			min: 6,
			max: 100,
			required: true,
		},
	]);

	if(value){

		if(password == password2){
			const data = {
				email,
				password,
				password2,
				token
			}

			$('#loader').removeClass('ocultar');

			$('#formEmail').removeClass('visible');
			$('#formEmail').addClass('ocultar');
			$('#errorEmail').removeClass('visible');
			$('#errorEmail').addClass('ocultar');

			$('#titleSend').addClass('ocultar');

			$.ajax({
				type: "POST",
				url: base_url('reset-password'),
				data: data,
				success: function (answer) {
					let response = JSON.parse(answer);
					if(response.message.type == 'success'){
						toast('bg-success', response.message.title, response.message.message+" Verifica tu correo", 1);

						$('#successEmail').removeClass('ocultar');
						$('#successEmail').addClass('visible');
						$('#titleSend').addClass('ocultar');
						$('#loader').addClass('ocultar');
					}else{
						toast('bg-danger', response.message.title, response.message.message+" verifica tu correo", 1);
						$('#titleSend').removeClass('ocultar');
						$('#formEmail').removeClass('ocultar');
						$('#formEmail').addClass('visible');
						$('#errorEmail').removeClass('ocultar');
						$('#errorEmail').addClass('visible');
						$('#successEmail').removeClass('visible');
						$('#successEmail').addClass('ocultar');
						$('#loader').addClass('ocultar');
					}
				}
			});
		}else{
			toast('bg-danger', 'Contraseña incorrecta', "La contraseña no coincide", 1);
		}
	}
});
