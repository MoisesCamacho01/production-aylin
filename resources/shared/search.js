$("input[name=searchGlobal]").keypress(function(e) {
	var code = (e.keyCode ? e.keyCode : e.which);
	if(code==13){
		if($(this).val() == '') {
			toast('bg-danger', "¿Qué buscas?", 'Tienes que escribir algo para buscarlo', 0, 'top-0 start-50 translate-middle-x')
		}else{
			if($(this).attr('url') == ''){
				if($(this).attr('urlSearch') == ''){
					toast('bg-info', "¿Error de búsqueda?", 'Creo que lo que buscas no existe', 0, 'top-0 start-50 translate-middle-x')
				}else{
					window.location.href = $(this).attr('urlSearch')+'?search='+$(this).val();
				}
			}
		}
	}
});

$('input[name=searchGlobal]').keyup(function (e) {
	let url = $(this).attr('url');
	if(url != '') paginator(1);
});

function searchGlobal(url, text='', start, limit){
	let search = text != '' ?  text : $('input[name=searchGlobal]').val();

	const data = {
		search,
		start,
		limit
	}

	$('#loader').removeClass('ocultar');
	$('#bodyTable').html('');

	$.ajax({
		type: "POST",
		url: url,
		data: data,
		success: function (answer) {
			let response = JSON.parse(answer)
			if(response.message.type === 'success') {
				$('#loader').addClass('ocultar');
				$('#bodyTable').html(response.data);
				cantidadPaginator($("input[name='pagePaginator']").val())
			}else{
				toast('bg-danger', response.message.title, response.message.message, 1);
			}
		}
	});
}
