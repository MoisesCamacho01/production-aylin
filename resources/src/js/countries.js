getRegister();

function suspend() {
	let id = $("input[name=id]").val();

	const data = {
		id,
	};

	let url = $("input[name=url]").val() + "countries/suspend";
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

	let url = $("input[name=url]").val() + "countries/active";
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

	let url = $("input[name=url]").val() + "countries/delete";
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

	let value = validate([
		{
			name: "name",
			type: "string",
			value: name,
			min:1,
			max:50,
			required:true
		}
	])

	if(value){
		const data = {
			id,
			name,
		};

		let url = $("input[name=url]").val() + "countries/update";
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

}

function create() {
	let name = $("#name").val();

	let value = validate([
		{
			name: "name",
			type: "string",
			value: name,
			min:1,
			max:50,
			required:true
		}
	])

	if(value){
		const data = {
			name,
		};

		let url = $("input[name=url]").val() + "countries/crear";
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
}

function getForId(){
	let id = $("input[name=id]").val();

	let url = $("input[name=url]").val() + "countries/"+id;
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

				$('#nameE').val(htmlDecode(response.data.name));

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
