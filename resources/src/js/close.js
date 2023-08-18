$(document).ready(function () {
	$("#btnCerrar").click(function (e) {
		e.preventDefault();

		$.ajax({
			url: base_url("singOut"),
			type: "GET",
			success: function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type == "success") {
					toast("bg-success", response.message.title, response.message.message, 1);
					setTimeout(() => {
						window.location.href = "";
					}, 600);
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
	});
});
