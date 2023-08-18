getRegister();

function suspend() {
	let id = $("input[name=id]").val();

	const data = {
		id,
	};

	let url = $("input[name=url]").val() + "managers/suspend";
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

	let url = $("input[name=url]").val() + "managers/active";
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

	let url = $("input[name=url]").val() + "managers/delete";
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
	let name = $("#nameE").val();
	let last_name = $("#last_nameE").val();
	let phone = $("#phoneE").val();
	let mobile = $("#mobileE").val();

	let value = validate([
		{
			name: "nameE",
			type: "string",
			value: name,
			min: 1,
			max: 50,
			required: true,
		},

		{
			name: "last_nameE",
			type: "string",
			value: last_name,
			min: 1,
			max: 50,
			required: true,
		},

		{
			name: "phoneE",
			type: "number",
			value: phone,
			min: 0,
			max: 9,
			required: false,
		},

		{
			name: "mobileE",
			type: "number",
			value: mobile,
			min: 0,
			max: 10,
			required: true,
		},
	])

	if(value){
		const data = {
			id,
			name,
			last_name,
			phone,
			mobile,
		};

		let url = $("input[name=url]").val() + "managers/update";
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
	let name = $("#name").val();
	let last_name = $("#last_name").val();
	let phone = $("#phone").val();
	let mobile = $("#mobile").val();

	let value = validate([
		{
			name: "name",
			type: "string",
			value: name,
			min: 1,
			max: 50,
			required: true,
		},

		{
			name: "last_name",
			type: "string",
			value: last_name,
			min: 1,
			max: 50,
			required: true,
		},

		{
			name: "phone",
			type: "number",
			value: phone,
			min: 0,
			max: 9,
			required: false,
		},

		{
			name: "mobile",
			type: "number",
			value: mobile,
			min: 0,
			max: 10,
			required: true,
		},
	])

	if(value){
		const data = {
			name,
			last_name,
			phone,
			mobile,
		};

		let url = $("input[name=url]").val() + "managers/crear";
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

function getForId(){
	let id = $("input[name=id]").val();

	let url = $("input[name=url]").val() + "managers/"+id;
	$.ajax({
		type: "GET",
		url: url,
		success: function (answer) {
			let response = JSON.parse(answer);
			if (response.message.type == "success") {
				toast(
					"bg-success",
					response.message.title,
					response.message.message,
					1
				);

				$('#nameE').val(response.data.name);
				$('#last_nameE').val(response.data.last_name);
				$('#phoneE').val(response.data.phone);
				$('#mobileE').val(response.data.mobile);
				// setTimeout(() => {
				// 	window.location.href = 'dashboard';
				// }, 600);
			} else {
				toast(
					"bg-danger",
					response.message.title,
					response.message.message,
					1
				);

				$('.btn-close').click();
			}
		},
	});
}

function getRegister(){
	let urlSearch = $('input[name=searchGlobal]').attr('url');
	if(urlSearch!=''){
		paginator(1)
	}
}
