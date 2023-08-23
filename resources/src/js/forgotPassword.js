$('#forgotPassword').click(function (e) {
	e.preventDefault();
	let email = $('#email').val();

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
	]);

	if(value){

		const data = {
			email
		}
		$('#loader').removeClass('ocultar');

		$('#formEmail').removeClass('visible');
		$('#formEmail').addClass('ocultar');
		$('#errorEmail').removeClass('visible');
		$('#errorEmail').addClass('ocultar');

		$('#titleSend').addClass('ocultar');

		$.ajax({
			type: "POST",
			url: base_url('send-email'),
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
	}
});
