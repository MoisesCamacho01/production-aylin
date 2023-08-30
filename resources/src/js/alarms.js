$('.select-alarm').select2({
	dropdownParent: $("#createModal"),
	placeholder: 'Selecciona un Encargado',
	allowClear: true,
	dropdownCssClass: 'select-search',
	closeOnSelect: false,
	width: 'resolve'
});

$('.select-alarmE').select2({
	dropdownParent: $("#updateModal"),
	placeholder: 'Selecciona un Encargado',
	allowClear: true,
	dropdownCssClass: 'select-search',
	closeOnSelect: false,
	width: 'resolve'
});

getRegister();
var alarmsCoord;
var alarmId;

function suspend() {
	let id = $("input[name=id]").val();

	const data = {
		id,
	};

	let url = $("input[name=url]").val() + "alarms/suspend";
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
				paginator(1);
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

	let url = $("input[name=url]").val() + "alarms/active";
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
				paginator(1);
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

	let url = $("input[name=url]").val() + "alarms/delete";
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
				paginator(1);
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
	let code = $("#codeE").val();
	let sector = $("#sectorE").val();
	let manager = $("#managerE").val();
	let latitude = $("#latitudeE").val();
	let longitude = $("#longitudeE").val();

	let value = validate([
		{
			name: "codeE",
			type: "string",
			campo: "código",
			value: code,
			min: 1,
			max: 50,
			required: true,
		},

		{
			name: "managerE",
			type: "string",
			campo: "encargado",
			value: manager,
			min: 1,
			max: 50,
			required: true,
		},

		{
			name: "sectorE",
			type: "string",
			campo: "sector",
			value: sector,
			min: 1,
			max: 50,
			required: true,
		},

		{
			name: "latitudeE",
			type: "string",
			campo: "latitud",
			value: latitude,
			min: 1,
			max: 22,
			required: true,
		},

		{
			name: "longitudeE",
			type: "string",
			campo: "longitud",
			value: longitude,
			min: 1,
			max: 22,
			required: true,
		},
	]);

	if (value) {
		const data = {
			id,
			code,
			sector,
			manager,
			latitude,
			longitude,
		};

		let url = $("input[name=url]").val() + "alarms/update";
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
					$(".btn-model-close").trigger("click");
					paginator(1);
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
	let code = $("#code").val();
	let manager = $("#manager").val();
	let sector = $("#sector").val();
	let latitude = $("#latitude").val();
	let longitude = $("#longitude").val();

	let value = validate([
		{
			name: "code",
			type: "string",
			campo: "codigo",
			value: code,
			min: 1,
			max: 50,
			required: true,
		},

		{
			name: "manager",
			type: "string",
			campo: "encargado",
			value: manager,
			min: 1,
			max: 50,
			required: true,
		},

		{
			name: "sector",
			type: "string",
			campo: "sector",
			value: sector,
			min: 1,
			max: 50,
			required: true,
		},

		{
			name: "latitude",
			type: "string",
			campo: "latitud",
			value: latitude,
			min: 1,
			max: 22,
			required: true,
		},

		{
			name: "longitude",
			type: "string",
			campo: "longitud",
			value: longitude,
			min: 1,
			max: 22,
			required: true,
		},
	]);

	if (value) {
		const data = {
			code,
			sector,
			manager,
			latitude,
			longitude,
		};

		let url = $("input[name=url]").val() + "alarms/crear";

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
					$("#code").val("");
					$("#manager").val("");
					$("#latitude").val("");
					$("#longitude").val("");
					$(".btn-model-close").trigger("click");
					paginator(1);
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

function getForId() {
	let id = $("input[name=id]").val();
	let idI = $("input[name=idInstitution").val();
	alarmId(idI, id);
}

function getRegister() {
	let urlSearch = $("input[name=searchGlobal]").attr("url");
	if (urlSearch != "") {
		paginator(1);
	}
}

async function initMap() {
	let path = [];
	let coords = { lat: -0.9179301528102732, lng: -78.63297106182672 };
	let drawMap = "";
	var polygonMarker = "";
	var myPolygon = "";
	var borrado = 0;

	$("#bodyTable").on("click", ".btnDrawMap", function (e) {
		e.preventDefault();
		drawingPolygon();
		// viewAll();
	});

	// BUTTON SAVE DRAW
	$("#btnSaveDraw").click(function (e) {
		e.preventDefault();
		saveDraw();
	});

	$("#bodyTable").on("click", ".btnGetDraw", function (e) {
		e.preventDefault();
		viewDrawOnMap();
	});

	//BUTTON NEW ALARM
	$("#btnNewAlarm").click(function (e) {
		e.preventDefault();
		newAlarmCords("", "new");
	});

	async function saveDraw() {
		path = [];
		if (borrado == 0) {
			await getPolygonCoords();
		}
		let id = $("input[name=id]").val();
		const data = {
			id,
			cords: JSON.stringify(path),
		};

		let url = $("input[name=url]").val() + "drawAlarm";
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

	// Función para calcular el centroide de un polígono
	function getPolygonCentroid(coords) {
		var bounds = new google.maps.LatLngBounds();
		coords.forEach(function (point) {
			bounds.extend(point);
		});

		return bounds.getCenter();
	}

	function getAlarmId(idI, id) {
		let url = $("input[name=url]").val() + "alarms/" + idI + "/" + id;
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

					$("#codeE").val(response.data.code);
					$("#managerE").val(response.data.id_alarm_manager);
					$("#latitudeE").val(response.data.latitud);
					$("#longitudeE").val(response.data.longitud);

					alarmsCoord(
						id,
						"view",
						"#251A1C",
						response.data.latitud * 1,
						response.data.longitud * 1,
						response.data.code
					);
				} else {
					toast(
						"bg-danger",
						response.message.title,
						response.message.message,
						1
					);

					$(".btn-close").click();
				}
			},
		});
	}

	async function newAlarmCords(
		id,
		x,
		color = "#1051D5",
		latitude = 0,
		longitude = 0
	) {

		var markerAlarm = "";
		let urlIcon = base_url("resources/src/img/logo.png");
		let map = x == "new" ? "mapLocationAlarm" : "mapLocationAlarmE";

		drawMap = new google.maps.Map(document.getElementById(map), {
			center: coords,
			zoom: 15,
			mapTypeControl: false,
			streetViewControl: false,
		});

		await viewDrawFatherOnMap(drawMap);
		await mySiblingsPolygon(id, drawMap);

		coords = getPolygonCentroid(path);

		if (latitude != 0 && longitude != 0) {
			coords = { lat: latitude*1, lng: longitude*1};
		}

		drawMap.setCenter(coords);

		// Crea un nuevo ícono personalizado
		let icon = {
			url: urlIcon,
			scaledSize: new google.maps.Size(35, 40), // Tamaño del ícono (ajústalo según tus necesidades)
			origin: new google.maps.Point(0, 0), // Punto de origen del ícono
			anchor: new google.maps.Point(16, 32), // Punto de anclaje del ícono (ajústalo según el diseño del ícono)
		};

		if (x == "new") {
			// Crea el marcador
			markerAlarm = new google.maps.Marker({
				position: coords,
				map: drawMap,
				title: "Mi marcador",
				draggable: true,
			});

			markerAlarm.setIcon(icon);

			// Agrega el evento de arrastre al marcador
			google.maps.event.addListener(
				markerAlarm,
				"dragend",
				function (event) {
					// Verifica si la nueva posición del marcador está dentro del polígono
					let cord = coords;
					if($("#lat").val() != ""){
						cord = new google.maps.LatLng({lat: $("#lat").val()*1, lng: $("#lng").val()*1})
					}

					if (
						!google.maps.geometry.poly.containsLocation(
							event.latLng,
							polygonMarker
						)
					) {
						// Si la nueva posición está fuera del polígono, impide que el marcador se mueva allí
						markerAlarm.setPosition(cord); // Devuelve el marcador a su posición original
						toast(
							"bg-warning",
							"Ubicar alarma",
							"No se puede ubicar la alarma fuera de su barrio",
							1
							);
					} else {
						$("#lat").val(event.latLng.lat());
						$("#lng").val(event.latLng.lng());
						$("#latitude").val(event.latLng.lat());
						$("#longitude").val(event.latLng.lng());
					}
				}
			);

		} else if (x == "view") {

			$("#lat").val('')
			let url = base_url("drawAlarm/" + id);
			await $.ajax({
				type: "GET",
				url,
				success: function (answer) {
					let response = JSON.parse(answer);
					if (response.message.type == "success" && response.data[0].geom != undefined) {
						let polygon = JSON.parse(response.data[0].geom);

						let centro = getCentro(polygon);

						getPolygon(polygon);
						polygonMarker = new google.maps.Polygon({
							path: path,
							strokeColor: response.data[0].color,
							strokeOpacity: 0.8,
							strokeWeight: 2,
							fillColor: response.data[0].color,
							fillOpacity: 0.2,
						});

						polygonMarker.setMap(drawMap);
						drawMap.setCenter(centro);
						let urlIcon = base_url("resources/src/img/logo-white.png");

						// Crea un nuevo ícono personalizado
						let icon = {
							url: urlIcon,
							scaledSize: new google.maps.Size(35, 40), // Tamaño del ícono (ajústalo según tus necesidades)
							origin: new google.maps.Point(0, 0), // Punto de origen del ícono
							anchor: new google.maps.Point(16, 32), // Punto de anclaje del ícono (ajústalo según el diseño del ícono)
						};

						let markerAlarm = "";

						let coords2 = {
							lat: response.data[0].lat_alarm * 1,
							lng: response.data[0].lng_alarm * 1,
						};

						// Crea el marcador
						markerAlarm = new google.maps.Marker({
							position: coords2,
							map: drawMap,
							title: response.data[0].code,
							draggable: false,
						});

						markerAlarm.setIcon(icon);

						toast(
							"bg-success",
							response.message.title,
							response.message.message,
							1
						);
					} else {
						if(response.data[0].lat_alarm != undefined) {
							toast(
								"bg-info",
								response.message.title,
								response.message.message + ", puedes dibujar uno.",
								1
							);
						}else{
							toast(
								"bg-danger",
								response.message.title,
								"Tenemos un problema, recargar la pagina por favor",
								1
							);
						}
					}

					if(response.data[0].lat_alarm != undefined) {
						let msm = (response.data[0].geom != undefined) ? "La alarma no puede ir fuera del rango de escucha" : "La alarma no puede ir fuera del barrio asignado";
						let urlIcon = base_url("resources/src/img/logo.png");

						// Crea un nuevo ícono personalizado
						let icon = {
							url: urlIcon,
							scaledSize: new google.maps.Size(35, 40), // Tamaño del ícono (ajústalo según tus necesidades)
							origin: new google.maps.Point(0, 0), // Punto de origen del ícono
							anchor: new google.maps.Point(16, 32), // Punto de anclaje del ícono (ajústalo según el diseño del ícono)
						};

						let markerAlarm = "";

						let coords2 = {
							lat: response.data[0].lat_alarm * 1,
							lng: response.data[0].lng_alarm * 1,
						};

						let centro = new google.maps.LatLng(coords2);
						drawMap.setCenter(centro);
						// Crea el marcador
						markerAlarm = new google.maps.Marker({
							position: coords2,
							map: drawMap,
							title: response.data[0].code,
							draggable: true,
						});

						markerAlarm.setIcon(icon);

						// Agrega el evento de arrastre al marcador
						google.maps.event.addListener(
							markerAlarm,
							"dragend",
							function (event) {
								let cord = coords;
								if($("#lat").val() != ""){
									cord = new google.maps.LatLng({lat: $("#lat").val()*1, lng: $("#lng").val()*1})
								}
								// Verifica si la nueva posición del marcador está dentro del polígono
								if (
									!google.maps.geometry.poly.containsLocation(
										event.latLng,
										polygonMarker
									)
								) {
									// Si la nueva posición está fuera del polígono, impide que el marcador se mueva allí
									markerAlarm.setPosition(cord); // Devuelve el marcador a su posición original
									toast(
										"bg-info",
										"Ubicar alarma",
										msm,
										1
									);
								} else {
									$("#lat").val(event.latLng.lat());
									$("#lng").val(event.latLng.lng());
									$("#latitudeE").val(event.latLng.lat());
									$("#longitudeE").val(event.latLng.lng());
								}
							}
						);
					}

					$(".loaderModal").addClass("ocultar");
					$("#map").removeClass("ocultar");
				},
			});
		}
	}

	alarmsCoord = newAlarmCords;
	alarmId = getAlarmId;

	//NUEVO CODIGO
	$(".btnMover").click(function (e) {
		e.preventDefault();
		myPolygon.setOptions({ draggable: true });
		$(this).addClass("disabled");
		$(".btnNoMover").removeClass("disabled");
	});

	$(".btnNoMover").click(function (e) {
		e.preventDefault();
		myPolygon.setOptions({ draggable: false });
		$(this).addClass("disabled");
		$(".btnMover").removeClass("disabled");
	});

	$(".btnBorrar").click(function (e) {
		e.preventDefault();
		myPolygon.setPaths([]);
		$(".btnMB").addClass("disabled");
		$(".btnNuevo").removeClass("disabled");
		borrado = 1;
	});

	$(".btnNuevo").click(function (e) {
		e.preventDefault();
		var defaultPolygon = [
			new google.maps.LatLng(-0.979835, -78.592705),
			new google.maps.LatLng(-0.896679, -78.710152),
			new google.maps.LatLng(-0.868363, -78.569822),
		];
		myPolygon.setPaths(defaultPolygon);
		$(this).addClass("disabled");
		$(".btnMB").removeClass("disabled");
		borrado = 0;
	});

	async function viewDrawOnMap() {
		let id = $("input[name=id").val();
		let url = base_url("drawAlarm/" + id);
		drawMap = new google.maps.Map(document.getElementById("viewMap"), {
			zoom: 15,
			center: coords,
			styles: [
				{
					featureType: "poi.park",
					elementType: "labels", // Aplicar estilo a las etiquetas de los parques
					stylers: [{ visibility: "off" }],
				},
			],
			mapTypeControl: false,
			streetViewControl: false,
		});

		await viewDrawFatherOnMap(drawMap);
		$(".loaderModal").removeClass("ocultar");
		$("#map").addClass("ocultar");

		await $.ajax({
			type: "GET",
			url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type == "success" && response.data[0].geom != undefined) {
					let polygon = JSON.parse(response.data[0].geom);
					let geoJSON = {
						type: "Feature",
						geometry: polygon,
					};
					let centro = getCentro(polygon);
					drawMap.data.addGeoJson(geoJSON);
					drawMap.data.setStyle({
						fillColor: "#FF0000",
						strokeWeight: 1,
						strokeOpacity: 1,
					});
					drawMap.setCenter(centro);
					let urlIcon = base_url("resources/src/img/logo-white.png");

					// Crea un nuevo ícono personalizado
					let icon = {
						url: urlIcon,
						scaledSize: new google.maps.Size(35, 40), // Tamaño del ícono (ajústalo según tus necesidades)
						origin: new google.maps.Point(0, 0), // Punto de origen del ícono
						anchor: new google.maps.Point(16, 32), // Punto de anclaje del ícono (ajústalo según el diseño del ícono)
					};

					let markerAlarm = "";

					let coords2 = {
						lat: response.data[0].lat_alarm * 1,
						lng: response.data[0].lng_alarm * 1,
					};

					// Crea el marcador
					markerAlarm = new google.maps.Marker({
						position: coords2,
						map: drawMap,
						title: response.data[0].code,
						draggable: false,
					});

					markerAlarm.setIcon(icon);

					toast(
						"bg-success",
						response.message.title,
						response.message.message,
						1
					);
				} else {
					if(response.data[0].lat_alarm != undefined) {
						toast(
							"bg-info",
							response.message.title,
							response.message.message + ", puedes dibujar uno.",
							1
						);
					}else{
						toast(
							"bg-danger",
							response.message.title,
							"Tenemos un problema, recargar la pagina por favor",
							1
						);
					}
				}

				if(response.data[0].lat_alarm != undefined) {
					let urlIcon = base_url("resources/src/img/logo.png");

					// Crea un nuevo ícono personalizado
					let icon = {
						url: urlIcon,
						scaledSize: new google.maps.Size(35, 40), // Tamaño del ícono (ajústalo según tus necesidades)
						origin: new google.maps.Point(0, 0), // Punto de origen del ícono
						anchor: new google.maps.Point(16, 32), // Punto de anclaje del ícono (ajústalo según el diseño del ícono)
					};

					let markerAlarm = "";

					let coords2 = {
						lat: response.data[0].lat_alarm * 1,
						lng: response.data[0].lng_alarm * 1,
					};

					let centro = new google.maps.LatLng(coords2);
					drawMap.setCenter(centro);
					// Crea el marcador
					markerAlarm = new google.maps.Marker({
						position: coords2,
						map: drawMap,
						title: response.data[0].code,
						draggable: false,
					});

					markerAlarm.setIcon(icon);
				}

				$(".loaderModal").addClass("ocultar");
				$("#map").removeClass("ocultar");
			},
		});
	}

	async function viewDrawFatherOnMap(drawMap) {
		let id = $("input[name=idInstitution").val();
		let url = base_url("drawSector/" + id);

		$(".loaderModal").removeClass("ocultar");
		$("#map").addClass("ocultar");

		await $.ajax({
			type: "GET",
			url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type == "success") {
					let polygon = JSON.parse(response.data[0].geom);

					getPolygon(polygon);
					polygonMarker = new google.maps.Polygon({
						path: path,
						strokeColor: response.data[0].color,
						strokeOpacity: 0.8,
						strokeWeight: 2,
						fillColor: response.data[0].color,
						fillOpacity: 0.2,
					});

					polygonMarker.setMap(drawMap);
				}

				$(".loaderModal").addClass("ocultar");
				$("#map").removeClass("ocultar");
			},
		});
	}

	async function drawingPolygon() {
		path = [];
		let id = $("input[name=id").val();
		let url = base_url("drawAlarm/" + id);
		drawMap = new google.maps.Map(document.getElementById("map"), {
			center: coords,
			zoom: 15,
			styles: [
				{
					featureType: "poi",
					elementType: "labels", // Aplicar estilo a las etiquetas de los parques
					stylers: [{ visibility: "off" }],
				},

				{
					featureType: "administrative", // Para ocultar el nombre de las ciudades
					elementType: "labels",
					stylers: [{ visibility: "off" }],
				},
				{
					featureType: "transit", // Paradas de autobús
					elementType: "labels",
					stylers: [{ visibility: "off" }], // Oculta las etiquetas de las paradas de autobús
				},
			],
			mapTypeControl: false,
			streetViewControl: false,
		});
		await viewDrawFatherOnMap(drawMap);
		await mySiblingsPolygon(id, drawMap);

		var defaultPolygon = [
			new google.maps.LatLng(-0.979835, -78.592705),
			new google.maps.LatLng(-0.896679, -78.710152),
			new google.maps.LatLng(-0.868363, -78.569822),
		];

		myPolygon = new google.maps.Polygon({
			draggable: false,
			editable: true,
			strokeColor: "#FF0000",
			strokeOpacity: 0.8,
			strokeWeight: 2,
			fillColor: "#FF0000",
			fillOpacity: 0.35,
		});

		$(".loaderModal").removeClass("ocultar");
		$("#map").addClass("ocultar");

		await $.ajax({
			type: "GET",
			url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type == "success" && response.data[0].geom != undefined) {
					let polygon = JSON.parse(response.data[0].geom);

					let centro = getCentro(polygon);
					drawMap.setCenter(centro);
					getPolygon(polygon);

					toast(
						"bg-success",
						response.message.title,
						response.message.message,
						1
					);
				} else {
					if(response.data[0].lat_alarm != undefined) {
						toast(
							"bg-info",
							response.message.title,
							response.message.message + ", puedes dibujar uno.",
							1
						);
					}else{
						toast(
							"bg-danger",
							response.message.title,
							"Tenemos un problema, recargar la pagina por favor",
							1
						);
					}
				}

				if(response.data[0].lat_alarm != undefined) {
					let urlIcon = base_url("resources/src/img/logo-white.png");

					// Crea un nuevo ícono personalizado
					let icon = {
						url: urlIcon,
						scaledSize: new google.maps.Size(35, 40), // Tamaño del ícono (ajústalo según tus necesidades)
						origin: new google.maps.Point(0, 0), // Punto de origen del ícono
						anchor: new google.maps.Point(16, 32), // Punto de anclaje del ícono (ajústalo según el diseño del ícono)
					};

					let markerAlarm = "";

					let coords2 = {
						lat: response.data[0].lat_alarm * 1,
						lng: response.data[0].lng_alarm * 1,
					};

					let centro = new google.maps.LatLng(coords2);
					path = [];
					drawMap.setCenter(centro);
					// path.push(centro);
					path.push({
						lat: centro.lat() + 0.001,
						lng: centro.lng() + 0.001,
					});
					path.push({
						lat: centro.lat() + 0.001,
						lng: centro.lng() - 0.001,
					});
					path.push({
						lat: centro.lat() - 0.001,
						lng: centro.lng() - 0.001,
					});
					path.push({
						lat: centro.lat() - 0.001,
						lng: centro.lng() + 0.001,
					});

					// Crea el marcador
					markerAlarm = new google.maps.Marker({
						position: coords2,
						map: drawMap,
						title: response.data[0].code,
						draggable: false,
					});

					markerAlarm.setIcon(icon);
				}
				$(".loaderModal").addClass("ocultar");
				$("#map").removeClass("ocultar");
			},
		});

		if (path.length > 0) {
			myPolygon.setPath(path);
		} else {
			myPolygon.setPath(defaultPolygon);
		}

		myPolygon.setMap(drawMap);

		google.maps.event.addListener(myPolygon, "rightclick", function (event) {
			var vertices = myPolygon.getPath();
			var clickedIndex = -1;

			for (var i = 0; i < vertices.getLength(); i++) {
				if (
					google.maps.geometry.spherical.computeDistanceBetween(
						event.latLng,
						vertices.getAt(i)
					) < 10
				) {
					clickedIndex = i;
					break;
				}
			}
			if (clickedIndex !== -1) {
				vertices.removeAt(clickedIndex); // Elimina el vértice
			}
		});
	}

	async function mySiblingsPolygon(id, drawMap) {
		let idI = $("input[name=idInstitution").val();
		let url = base_url("reports/alarms/all-of-sector/" + idI);
		await $.ajax({
			type: "GET",
			url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type == "success") {
					let data = response.data;
					data.forEach((row) => {
						if (id != row.id_city) {
							let polygon = JSON.parse(row.geom);
							let geoJSON = {
								type: "Feature",
								geometry: polygon,
							};
							drawMap.data.addGeoJson(geoJSON);
							drawMap.data.setStyle({
								fillColor: "purple",
								strokeWeight: 1,
							});

							let centro = getCentro(polygon);

							// Crea un marcador en el centroide del polígono
							let labelMarker = new google.maps.Marker({
								position: centro,
								map: drawMap,
								label: {
									text: row.name,
									color: "#251A1C",
									fontWeight: "bold",
									fontSize: "12px",
									labelOrigin: new google.maps.Point(0, -20),
								},
								icon: {
									url: "https://maps.google.com/mapfiles/transparent.png", // Imagen transparente para ocultar el marcador
									size: new google.maps.Size(1, 1), // Tamaño del icono del marcador (1x1 píxeles)
									anchor: new google.maps.Point(0, 0), // Punto de anclaje del icono del marcador
								},
							});
							labelMarker.setMap(drawMap);
						}
					});
				}
			},
		});
	}

	function getPolygonCoords() {
		path = [];
		var len = myPolygon.getPath().getLength();
		for (var i = 0; i < len; i++) {
			let lat = myPolygon.getPath().getAt(i).lat();
			let lng = myPolygon.getPath().getAt(i).lng();
			path.push({ lat: lat, lng: lng });
		}
	}

	function getCentro(polygon) {
		var coordinates = polygon.coordinates[0];
		var centroid = coordinates.reduce(
			function (acc, current) {
				return [acc[0] + current[0], acc[1] + current[1]];
			},
			[0, 0]
		);

		centroid = new google.maps.LatLng(
			centroid[1] / coordinates.length,
			centroid[0] / coordinates.length
		);
		return centroid;
	}

	function getPolygon(polygon) {
		path = [];
		let array = polygon.coordinates[0];
		array.forEach((row) => {
			path.push({ lat: row[1], lng: row[0] });
		});
	}
}
