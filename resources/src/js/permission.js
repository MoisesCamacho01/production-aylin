$(".checkMenu").change(function (e) {
	e.preventDefault();
	if ($(this).is(":checked")) {
		permissionMenu($(this).val(), "insert");
	} else {
		permissionMenu($(this).val(), "delete");
	}
});

$(".checkSubMenu").change(function (e) {
	e.preventDefault();
	if ($(this).is(":checked")) {
		permissionSubMenu($(this).val(), "insert");
	} else {
		permissionSubMenu($(this).val(), "delete");
	}
});

$(".checkButton").change(function (e) {
	e.preventDefault();
	if ($(this).is(":checked")) {
		permissionButton($(this).val(), $(this).attr('submenu'), "insert");
	} else {
		permissionButton($(this).val(), $(this).attr('submenu'), "delete");
	}
});

function permissionMenu(id, tipo) {
	let param = $("input[name=idInstitution]").val();

	const data = {
		id,
		tipo,
	};

	let url = $("input[name=url]").val() + "permission/"+param+"/menu";
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
			} else {
				toast(
					"bg-danger",
					response.message.title,
					response.message.message,
					1
				);
			}
		},
		error: function (xhr, status, error) {
			toast("bg-danger", "Error en la solicitud AJAX", error, 1);
		},
	});
}

function permissionSubMenu(id, tipo) {
	let param = $("input[name=idInstitution]").val();

	const data = {
		id,
		tipo,
	};

	let url = $("input[name=url]").val() + "permission/"+param+"/submenu";
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
			} else {
				toast(
					"bg-danger",
					response.message.title,
					response.message.message,
					1
				);
			}
		},
		error: function (xhr, status, error) {
			toast("bg-danger", "Error en la solicitud AJAX", error, 1);
		},
	});
}

function permissionButton(id, submenu, tipo) {
	let param = $("input[name=idInstitution]").val();

	const data = {
		id,
		submenu,
		tipo,
	};

	let url = $("input[name=url]").val() + "permission/"+param+"/button";
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
			} else {
				toast(
					"bg-danger",
					response.message.title,
					response.message.message,
					1
				);
			}
		},
		error: function (xhr, status, error) {
			toast("bg-danger", "Error en la solicitud AJAX", error, 1);
		},
	});
}
