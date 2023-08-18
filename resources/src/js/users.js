getRegister();

function suspend() {
	let id = $("input[name=id]").val();

	const data = {
		id,
	};

	let url = $("input[name=url]").val() + "usuarios/suspend";
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		success: function (answer) {
			let response = JSON.parse(answer);
			if (response.message.type == "success") {
				toast(
					"bg-success",
					response.message.title,
					response.message.message,
					1
				);

			} else {
				toast(
					"bg-danger",
					response.message.title,
					response.message.message,
					1
				);
			}
		},
	});
}

function active() {
	let id = $("input[name=id]").val();

	const data = {
		id,
	};

	let url = $("input[name=url]").val() + "usuarios/active";
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		success: function (answer) {
			let response = JSON.parse(answer);
			if (response.message.type == "success") {
				toast(
					"bg-success",
					response.message.title,
					response.message.message,
					1
				);

			} else {
				toast(
					"bg-danger",
					response.message.title,
					response.message.message,
					1
				);
			}
		},
	});
}

function deleted() {
	let id = $("input[name=id]").val();

	const data = {
		id,
	};

	let url = $("input[name=url]").val() + "usuarios/delete";
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		success: function (answer) {
			let response = JSON.parse(answer);
			if (response.message.type == "success") {
				toast(
					"bg-success",
					response.message.title,
					response.message.message,
					1
				);

			} else {
				toast(
					"bg-danger",
					response.message.title,
					response.message.message,
					1
				);
			}
		},
	});
}

function update() {
	let id = $("input[name=id]").val();
	let username = $("#usernameE").val();
	let email = $("#emailE").val();
	let password = $("#passwordE").val();
	let userType = $("#userTypeE").val();

	let value = validate([
		{
			name: "username",
			type: "string",
			value: username,
			min: 6,
			max: 50,
			required: true,
		},

		{
			name: "email",
			type: "email",
			value: email,
			min: 1,
			max: 255,
			required: true,
		},

		{
			name: "userType",
			type: "string",
			value: userType,
			min: 1,
			max: 255,
			required: true,
		},
	]);

	if (value) {
		const data = {
			id,
			username,
			email,
			password,
			userType,
		};

		let url = $("input[name=url]").val() + "usuarios/update";
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type === "success") {
					toast(
						"bg-success",
						response.message.title,
						response.message.message,
						1
					);

					$(".btn-model-close").trigger("click");
				} else {
					toast(
						"bg-danger",
						response.message.title,
						response.message.message,
						1
					);
				}
			},
		});
	}
}

function create() {
	let username = $("#username").val();
	let email = $("#email").val();
	let password = $("#password").val();
	let userType = $("#userType").val();

	let value = validate([
		{
			name: "username",
			type: "string",
			value: username,
			min: 6,
			max: 50,
			required: true,
		},

		{
			name: "email",
			type: "email",
			value: email,
			min: 1,
			max: 255,
			required: true,
		},

		{
			name: "password",
			type: "string",
			value: password,
			min: 6,
			max: 18,
			required: true,
		},

		{
			name: "userType",
			type: "string",
			value: userType,
			min: 1,
			max: 255,
			required: true,
		},
	]);

	if (value) {
		const data = {
			username,
			email,
			password,
			userType,
		};

		let url = $("input[name=url]").val() + "usuarios/crear";
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			success: function (answer) {
				let response = JSON.parse(answer);
				if(response.message.type === "success"){
					toast(
						"bg-success",
						response.message.title,
						response.message.message,
						1
					);
					$("#username").val('');
					$("#password").val('');
					$("#email").val('');
					$(".btn-model-close").trigger("click");
					paginator(1);
				}else{
					toast(
						"bg-danger",
						response.message.title,
						response.message.message,
						1
					);
				}
			},
			error: function(xhr, status, error) {
				toast(
					"bg-danger",
					"Error en la solicitud AJAX",
					error,
					1
				);
			}
		});
	}
}

function getForId() {
	let id = $("input[name=id]").val();

	let url = $("input[name=url]").val() + "usuarios/" + id;
	$.ajax({
		type: "GET",
		url: url,
		success: function (answer) {
			let response = JSON.parse(answer);

			if (response.message.type === "success") {
				toast(
					"bg-success",
					response.message.title,
					response.message.message,
					1
				);

				$("#usernameE").val(htmlDecode(response.data.user_name));
				$("#emailE").val(htmlDecode(response.data.email));
				$("#userTypeE").val(htmlDecode(response.data.user_type));

			} else {
				toast(
					"bg-danger",
					response.message.title,
					response.message.message,
					1
				);

				$(".btn-close").click();
			}
		},
	});
}

function getRegister() {
	let urlSearch = $("input[name=searchGlobal]").attr("url");
	if (urlSearch != "") {
		paginator(1);
	}
}

