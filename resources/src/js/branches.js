getRegister();

function suspend() {
	let id = $("input[name=id]").val();

	const data = {
		id,
	};

	let url = $("input[name=url]").val() + "branches/suspend";
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

	let url = $("input[name=url]").val() + "branches/active";
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

	let url = $("input[name=url]").val() + "branches/delete";
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
	let address = $("#addressE").val();
	let phone = $("#phoneE").val();
	let mobile = $("#mobileE").val();
	let institution = $("#institutionsE").val();
	let country = $("#countryE").val();
	let state = $("#statesE").val();
   let city = $("#cityE").val();

	let value = validate([
		{
			name: "nameE",
			type: "string",
			campo: "nombre",
			value: name,
			min: 1,
			max:50,
			required: true
		},

		{
			name: "addressE",
			type: "string",
			campo: "dirección",
			value: address,
			min: 1,
			max: 500,
			required: true,
		},

		{
			name: "phoneE",
			type: "number",
			campo: "celular",
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
			name: "institutionsE",
			type: "string",
			value: institution,
			min: 1,
			max: 255,
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

		{
			name: "statesE",
			type: "string",
			value: state,
			min: 1,
			max: 255,
			required: true,
		},

		{
			name: "cityE",
			type: "string",
			value: city,
			min: 1,
			max: 255,
			required: true,
		}
	])

	if(value){
		const data = {
			id,
			name,
			address,
			phone,
			mobile,
			institution,
			country,
			state,
			city
		};

		let url = $("input[name=url]").val() + "branches/update";
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
	let address = $("#address").val();
	let phone = $("#phone").val();
	let mobile = $("#mobile").val();
	let institution = $("#institutions").val();
	let country = $("#countries").val();
	let state = $("#states").val();
	let city = $("#cities").val();

	let value = validate([
		{
			name: "name",
			type: "string",
			value: name,
			min: 1,
			max:50,
			required: true
		},

		{
			name: "address",
			type: "string",
			value: address,
			min: 1,
			max: 500,
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
			name: "institutions",
			type: "string",
			value: institution,
			min: 1,
			max: 255,
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

		{
			name: "states",
			type: "string",
			value: state,
			min: 1,
			max: 255,
			required: true,
		},

		{
			name: "city",
			type: "string",
			value: city,
			min: 1,
			max: 255,
			required: true,
		}
	])

	if(value){
		const data = {
			name,
			address,
			phone,
			mobile,
			institution,
			country,
			state,
			city
		};

		let url = $("input[name=url]").val() + "branches/crear";
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
	let idI = $("input[name=idInstitution").val();

	let url = $("input[name=url]").val() + "branches/"+idI+"/"+id;
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
				$('#addressE').val(response.data.address);
				$('#phoneE').val(response.data.phone);
				$('#mobileE').val(response.data.mobile);
				$('#countryE').val(response.data.country);
				$('#statesE').val(response.data.state);
				$('#cityE').val(response.data.city);
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
