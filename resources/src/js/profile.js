$('#btnProfile').click(function (e) {
	e.preventDefault();
	updateProfile();
});

$('#bodyTable').on('click', '.btnGetProfile', function (e) {
	e.preventDefault();
	getForProfile();
});

$('#states').change(function (e) {
	e.preventDefault();
	getCities($(this).val());
});

function getForProfile(){

	let id = $("input[name=id]").val();
	let url = base_url('profile/'+id);

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

				getCities(htmlDecode(response.data.id_state));

				$("#name").val(htmlDecode(response.data.name));
				$("#lastName").val(htmlDecode(response.data.last_name));
				$("#country").val(htmlDecode(response.data.id_country));
				$("#states").val(htmlDecode(response.data.id_state));
				$("#documentType").val(htmlDecode(response.data.id_document_type));
				$("#ci").val(htmlDecode(response.data.document_number));
				$("#phone").val(htmlDecode(response.data.phone));
				$("#mobile").val(htmlDecode(response.data.mobile));
				$("#address").val(htmlDecode(response.data.address));

			} else {
				toast(
					"bg-info",
					response.message.title,
					response.message.message,
					1
				);
			}
		},
	});

}

function getCities(idState){

	let url = base_url("cities-search/"+idState)
	$.ajax({
		type: "GET",
		url: url,
		success: function (answer) {
			let response = JSON.parse(answer)
			$("#cities option:not(:first)").remove();
			if(response.message.type === 'success') {
				toast(
					"bg-success",
					response.message.title,
					response.message.message,
					1
				);

				let data = response.data;

				data.forEach(row => {
					var nuevaOpcion = $("<option>").val(row.id).text(row.name);
					$("#cities").append(nuevaOpcion);
				});

			}else{
				toast('bg-danger', response.message.title, response.message.message, 1);
				$("#cities option:not(:first)").remove();
			}
		}
	});
}

function updateProfile(){
	let id = $("input[name=id]").val();
	let url = base_url('profile-update/'+id);

	let name = $("#name").val();
	let lastName = $("#lastName").val();
	let country = $("#country").val();
	let state = $("#states").val();
	let city = $("#cities").val();
	let documentType = $("#documentType").val();
	let ci = $("#ci").val();
	let phone = $("#phone").val();
	let mobile = $("#mobile").val();
	let address = $("#address").val();

	let value = validate([
		{
			name: "name",
			type: "string",
			value: name,
			min: 6,
			max: 50,
			required: true,
		},

		{
			name: "lastName",
			type: "string",
			value: lastName,
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
			name: "cities",
			type: "string",
			value: city,
			min: 1,
			max: 255,
			required: true,
		},

		{
			name: "documentType",
			type: "string",
			value: documentType,
			min: 1,
			max: 255,
			required: true,
		},

		{
			name: "ci",
			type: "cedula",
			value: ci,
			min: 1,
			max: 10,
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
			required: false,
		},

		{
			name: "address",
			type: "string",
			value: address,
			min: 0,
			max: 500,
			required: false,
		},

	]);

	if (value) {
		const data = {
			name,
			lastName,
			country,
			state,
			city,
			documentType,
			ci,
			phone,
			mobile,
			address
		};

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

					$(".btn-model-close").trigger("click");
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



