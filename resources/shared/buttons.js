$('#bodyTable').on('click', '.btnInputHidden', function (e) {
	e.preventDefault();
	let id = $(this).attr('dataId');
	$("input[name=id]").val(id);
	borrarInputs();
});

$(".btn-success").click(function (e) {
	e.preventDefault();
	borrarInputs();
});

$('#bodyTable').on('click', '.btnGetForId', function (e) {
	e.preventDefault();
	getForId();
});

$("#btnCreate").click(function (e) {
	e.preventDefault();
	create();
	if($(".validate-text").text() == ''){
		paginator(1);
	}
});

$("#btnUpdate").click(function (e) {
	e.preventDefault()
	update();
	if($(".validate-text").text() == ''){
		paginator(1);
	}
});

$("#btnDelete").click(function (e) {
	e.preventDefault();
	deleted();
	paginator(1);
});

$("#btnSuspend").click(function (e) {
	e.preventDefault();
	suspend();
	paginator(1);
});

$("#btnActive").click(function (e) {
	e.preventDefault();
	active();
	paginator(1);
});

$('#backButton').click(function() {
	history.back();
});

function imprSelec(nombre) {
	var ficha = document.getElementById(nombre);
	var ventimp = window.open(' ', 'popimpr');
	ventimp.document.write( ficha.innerHTML );
	ventimp.document.close();
	ventimp.print( );
	ventimp.close();
 }

 function borrarInputs(){
	$("input[type=text]:not(:disabled)").val('')
	$("input[type=password]:not(:disabled)").val('')
	$("input[type=number]:not(:disabled)").val('')
	$("input[type=email]:not(:disabled)").val('')
	$("input[type=date]:not(:disabled)").val('')
	$(".validate-text").html('')
 }
