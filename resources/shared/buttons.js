$('#bodyTable').on('click', '.btnInputHidden', function (e) {
	e.preventDefault();
	let id = $(this).attr('dataId');
	$("input[name=id]").val(id);
});

$('#bodyTable').on('click', '.btnGetForId', function (e) {
	e.preventDefault();
	getForId();
});

$("#btnCreate").click(function (e) {
	e.preventDefault();
	create();
	paginator(1);
});

$("#btnUpdate").click(function (e) {
	e.preventDefault()
	update();
	paginator(1);
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

function imprSelec(nombre) {
	var ficha = document.getElementById(nombre);
	var ventimp = window.open(' ', 'popimpr');
	ventimp.document.write( ficha.innerHTML );
	ventimp.document.close();
	ventimp.print( );
	ventimp.close();
 }
