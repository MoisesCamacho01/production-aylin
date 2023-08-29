async function paginator(pagina){
	if(pagina>=1){
		let cantidad = $('input[name="cantidadPaginator"]').val()
		let searchTxt = $('input[name="searchGlobal"]').val()
		let inicio = $('input[name="inicioPaginator"]').val()
		await searchGlobal($('input[name="searchGlobal"]').attr('url'), searchTxt, inicio, cantidad)
	}else{
		toast('bg-danger', "¿Error inesperado?", 'Ha ocurrido un problema recarga la pagina', 0, 'top-0 start-50 translate-middle-x');
	}
}

function cantidadPaginator(pagina) {

	let cantidad = $('input[name="cantidadRegistros"]').val()*1
	let cantidadPaginator = $('input[name="cantidadPaginator"]').val()*1
	let limitPages = $('input[name="pagesLimit"]').val()

	if(pagina == 1){
		$('.page-left').parent().addClass('disabled');
	}else{
		$('.page-left').parent().removeClass('disabled');
	}

	if((cantidadPaginator*pagina)>=cantidad){
		$('.page-right').parent().addClass('disabled');
	}else{
		$('.page-right').parent().removeClass('disabled');
	}

	let numPaginas = Math.ceil((cantidad)/cantidadPaginator)
	let quantityPage = (pagina*1) + (limitPages*1);
	if(quantityPage > numPaginas) quantityPage = numPaginas;

	if(cantidad>=0){
		var paginas = '';
		for (let i = pagina; i<=quantityPage; i++) {
			paginas += `<li class="page-item `
			if(i == pagina){
				paginas +='active'
			}
			paginas +=`">
				<a class="page-link btnPages" href="#">
					`+i+`
				</a>
			</li>`;


		}
		$(".btnPages").parent().remove();
		$("#buttonBack").after(paginas)
	}else{
		toast('bg-danger', "¿Error inesperado?", 'Ha ocurrido un problema recarga la pagina', 0, 'top-0 start-50 translate-middle-x');
	}
}

// ACTION PAGINATOR BUTTON
$("#paginasContainer").on("click",".btnPages", function(e){
	e.preventDefault()
	let pagina = $(this).text()*1
	let cantidad = $('input[name="cantidadPaginator"]').val()
	$("input[name='inicioPaginator']").val((pagina>1 ? ((pagina*cantidad)-cantidad)+1: 0))
	$("input[name='pagePaginator']").val(pagina)
	let paginaTxt = $("input[name='pagePaginator']").val()
	paginator(paginaTxt)
})

//PAGINA PARA ATRAS
$("#paginasContainer").on("click",".page-left", function(e){
	e.preventDefault()
	let pagina = $('input[name="pagePaginator"]').val()*1-1
	let cantidad = $('input[name="cantidadPaginator"]').val()
	let inicio = $("input[name='inicioPaginator']").val()*1-cantidad
	$("input[name='pagePaginator']").val(pagina)
	$("input[name='inicioPaginator']").val(inicio<=1 ? 0 : inicio)
	paginator(pagina)

})

//PAGINA PARA ADELANTE
$("#paginasContainer").on("click",".page-right", function(e){
	e.preventDefault()
	let pagina = $('input[name="pagePaginator"]').val()*1+1
	let cantidad = $('input[name="cantidadPaginator"]').val()
	$("input[name='pagePaginator']").val(pagina)
	$("input[name='inicioPaginator']").val(((pagina*cantidad)-cantidad))
	paginator(pagina)

})
