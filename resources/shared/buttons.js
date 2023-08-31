$("#bodyTable").on("click", ".btnInputHidden", function (e) {
	e.preventDefault();
	let id = $(this).attr("dataId");
	$("input[name=id]").val(id);
	borrarInputs();
});

$(".btn-success").click(function (e) {
	e.preventDefault();
	borrarInputs();
});

$("#bodyTable").on("click", ".btnGetForId", function (e) {
	e.preventDefault();
	getForId();
});

$("#btnCreate").click(async function (e){
	e.preventDefault();
	await create();
	if ($(".validate-text").text() == "") {
		paginator(1);
	}
});

$("#btnUpdate").click(async function (e) {
	e.preventDefault();
	await update();
	let urlSearch = $("input[name=searchGlobal]").attr("url");

	if (($(".validate-text").text() == "") && (urlSearch)) {
		paginator(1);
	}
});

$("#btnDelete").click(async function (e) {
	e.preventDefault();
	await deleted();
	paginator(1);
});

$("#btnSuspend").click(async function (e) {
	e.preventDefault();
	await suspend();
	paginator(1);
});

$("#btnActive").click(async function (e) {
	e.preventDefault();
	await active();
	paginator(1);
});

$("#backButton").click(function () {
	history.back();
});

$("#close-map").click(function (e) {
	e.preventDefault();
	$(".view-map").addClass("ocultar");
});

function imprSelec(nombre) {
	var ficha = document.getElementById(nombre);
	var ventimp = window.open(" ", "popimpr");
	ventimp.document.write(ficha.innerHTML);
	ventimp.document.close();
	ventimp.print();
	ventimp.close();
}

function borrarInputs() {
	$("input[type=text]:not(:disabled)").val("");
	$("input[type=password]:not(:disabled)").val("");
	$("input[type=number]:not(:disabled)").val("");
	$("input[type=email]:not(:disabled)").val("");
	$("input[type=date]:not(:disabled)").val("");
	$(".validate-text").html("");
}

function showViewMap() {
	$(".view-card").removeClass("ocultar");
}


