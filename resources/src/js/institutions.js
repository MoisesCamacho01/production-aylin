getRegister();

function suspend() {
	let id = $("input[name=id]").val();

	const data = {
		id,
	};

	let url = $("input[name=url]").val() + "institutions/suspend";
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
			}
		},
	});
}

function active() {
	let id = $("input[name=id]").val();

	const data = {
		id,
	};

	let url = $("input[name=url]").val() + "institutions/active";
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
			}
		},
	});
}

function deleted() {
	let id = $("input[name=id]").val();

	const data = {
		id,
	};

	let url = $("input[name=url]").val() + "institutions/delete";
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
			}
		},
	});
}

function update() {
	let id = $("input[name=id]").val();
	let name = $("#nameE").val();
	let phone = $("#phoneE").val();
	let mobile = $("#mobileE").val();
	let country = $("#countryE").val();

	let value = validate([
		{
			name: "nameE",
			type: "string",
			value: states,
			min: 1,
			max: 300,
			required: true,
		},

		{
			name: "phoneE",
			type: "number",
			value: phone,
			min: 1,
			max: 9,
			required: true,
		},

		{
			name: "mobileE",
			type: "number",
			value: mobile,
			min: 1,
			max: 10,
			required: true,
		},

		{
			name: "countryE",
			type: "string",
			value: country,
			min: 1,
			max: 255,
			required: true,
		},
	])

	if(value){
		const data = {
			id,
			name,
			phone,
			mobile,
			country
		};

		let url = $("input[name=url]").val() + "institutions/update";
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
				}
			},
		});
	}

}

function create() {
	let name = $("#name").val();
	let phone = $("#phone").val();
	let mobile = $("#mobile").val();
	let country = $("#country").val();

	let value = validate([
		{
			name: "name",
			type: "string",
			value: states,
			min: 1,
			max: 300,
			required: true,
		},

		{
			name: "phone",
			type: "number",
			value: phone,
			min: 1,
			max: 9,
			required: true,
		},

		{
			name: "mobile",
			type: "number",
			value: mobile,
			min: 1,
			max: 10,
			required: true,
		},

		{
			name: "country",
			type: "string",
			value: country,
			min: 1,
			max: 255,
			required: true,
		},
	])

	if(value){
		const data = {
			name,
			phone,
			mobile,
			country
		};

		let url = $("input[name=url]").val() + "institutions/crear";
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
				}
			},
		});
	}

}

function getForId(){
	let id = $("input[name=id]").val();

	let url = $("input[name=url]").val() + "institutions/"+id;
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
				$('#phoneE').val(response.data.phone);
				$('#mobileE').val(response.data.mobile);
				$('#countryE').val(response.data.country);
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
		paginator(1);
	}
}
