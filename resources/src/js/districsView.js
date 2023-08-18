$('#ciudad').change(function (e) {
	e.preventDefault();
	parroquias($(this).val());
});

$('#parroquia').change(function (e) {
	e.preventDefault();
	$("input[name=idC]").val($(this).val());
});

$("#btnIr").click(function (e) {
	e.preventDefault();
	$siteUrl = $("input[name=url]").val();
	$submenu = $("input[name=submenu]").val()
	$idC = $("input[name=idC]").val();
	if($idC != ""){
		window.location.href = $siteUrl+$submenu+"/districs/"+$idC;
	}else{
		toast('bg-danger', "Redireccionamiento", "selecciona una parroquia", 1);
	}
});

function parroquias(city) {
	let url = $("input[name=url]").val()+"parishes-search/"+city

	$.ajax({
		type: "GET",
		url: url,
		success: function (answer) {
			let response = JSON.parse(answer)
			$("#parroquia option:not(:first)").remove();
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
					$("#parroquia").append(nuevaOpcion);
				});

			}else{
				toast('bg-danger', response.message.title, response.message.message, 1);
				$("#parroquia option:not(:first)").remove();
				$("input[name=idC]").val('')
			}
		}
	});
}
