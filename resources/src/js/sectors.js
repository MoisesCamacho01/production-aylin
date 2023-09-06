$('.select-alarm').select2({
	dropdownParent: $("#updateModalA"),
	placeholder: 'Selecciona un Encargado',
	allowClear: true,
	dropdownCssClass: 'select-search',
	closeOnSelect: false,
	width: 'resolve',
	language: {
		noResults: function () {
		  return 'No se encontraron resultados'; // Cambia este texto por el que desees
		}
	 }
});

getRegister();

function suspend() {
	let id = $("input[name=id]").val();

	const data = {
		id,
	};

	let url = $("input[name=url]").val() + "districs/suspend";
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
				// setTimeout(() => {
				// 	window.location.href = 'dashboard';
				// }, 600);
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

	let url = $("input[name=url]").val() + "districs/active";
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
				// setTimeout(() => {
				// 	window.location.href = 'dashboard';
				// }, 600);
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

	let url = $("input[name=url]").val() + "districs/delete";
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
				// setTimeout(() => {
				// 	window.location.href = 'dashboard';
				// }, 600);
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
	let name = $("#nameE").val();
	let distric = $("#districE").val();
	let color = $("#colorE").val();

	let value = validate([
		{
			name: "nameE",
			type: "string",
			campo: "nombre",
			value: name,
			min: 1,
			max: 191,
			required: true,
		},

		{
			name: "districE",
			type: "string",
			campo: "Parroquia",
			value: distric,
			min: 1,
			max: 255,
			required: true,
		},

		{
			name: "colorE",
			type: "string",
			campo: "color",
			value: color,
			min: 1,
			max: 20,
			required: true,
		},
	]);

	if (value) {
		const data = {
			id,
			name,
			distric: distric,
			color: color,
		};

		let url = $("input[name=url]").val() + "districs/update";
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
	let name = $("#name").val();
	let distric = $("#distric").val();
	let color = $("#color").val();

	let value = validate([
		{
			name: "name",
			type: "string",
			value: name,
			campo: "nombre",
			min: 1,
			max: 191,
			required: true,
		},

		{
			name: "distric",
			type: "string",
			campo: "parroquia",
			value: distric,
			min: 1,
			max: 255,
			required: true,
		},

		{
			name: "color",
			type: "string",
			campo: "color",
			value: color,
			min: 1,
			max: 20,
			required: true,
		},
	]);

	if (value) {
		const data = {
			name,
			distric,
			color,
		};

		let url = $("input[name=url]").val() + "districs/crear";
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
					$("#name").val("");
					$(".btn-model-close").trigger("click");

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

	let url = $("input[name=url]").val() + "districs/" + idI + "/" + id;
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
				$("#nameE").val(response.data.name);
				$("#colorE").val(response.data.color);

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
	var borrado = 0;
	var myPolygon = '';
	var DrawingPolygon = "";
	let informationAlarms = [];

	$("#bodyTable").on("click", ".btnDrawMap", function (e) {
		e.preventDefault();
		drawingPolygon();
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


	async function saveDraw() {
		path=[];
		if(borrado==0){
			await getPolygonCoords();
		}
		let id = $("input[name=id]").val();
		const data = {
			id,
			cords: JSON.stringify(path),
		};

		let url = $("input[name=url]").val() + "drawSector";
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

	// NUEVO CODIGO
	$(".btnMover").click(function (e) {
		e.preventDefault();
		myPolygon.setOptions({draggable: true});
		$(this).addClass('disabled');
		$(".btnNoMover").removeClass('disabled');
	});

	$(".btnNoMover").click(function (e) {
		e.preventDefault();
		myPolygon.setOptions({draggable: false});
		$(this).addClass('disabled');
		$(".btnMover").removeClass('disabled');
	});

	$(".btnBorrar").click(function (e) {
		e.preventDefault();
		myPolygon.setPaths([]);
		$('.btnMB').addClass('disabled');
		$(".btnNuevo").removeClass('disabled');
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
		$(this).addClass('disabled');
		$(".btnMB").removeClass('disabled');
		borrado = 0;
	});

	async function viewDrawOnMap() {

		let id = $("input[name=id").val();
		let url = base_url("drawSector/" + id);

		drawMap = new google.maps.Map(document.getElementById("viewMap"), {
			zoom: 13,
			center: coords,
			styles: [
				{
					featureType: "poi.park",
					elementType: "labels", // Aplicar estilo a las etiquetas de los parques
					stylers: [{ visibility: "off" }],
				},
			],
			mapTypeControl: false,
			streetViewControl: false
		});
		$('.loaderModal').removeClass('ocultar');
		$("#map").addClass("ocultar");

		await $.ajax({
			type: "GET",
			url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type == "success") {
					let polygon = JSON.parse(response.data[0].geom);
					let geoJSON = {
						type: "Feature",
						geometry: polygon,
					};
					let centro = getCentro(polygon);
					drawMap.data.addGeoJson(geoJSON);
					drawMap.data.setStyle({
						fillColor: "blue",
						strokeWeight: 1,
					});
					drawMap.setCenter(centro);
					toast(
						"bg-success",
						response.message.title,
						response.message.message,
						1
					);
				}else{
					toast(
						"bg-info",
						response.message.title,
						response.message.message,
						1
					);
				}

				$(".loaderModal").addClass("ocultar");
				$("#map").removeClass("ocultar");
			},
		});
	}

	async function viewDrawFatherOnMap(drawMap) {

		let id = $("input[name=idInstitution").val();
		let url = base_url("drawParish/" + id);

		$('.loaderModal').removeClass('ocultar');
		$("#map").addClass("ocultar");

		await $.ajax({
			type: "GET",
			url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type == "success") {
					let polygon = JSON.parse(response.data[0].geom);
					let centro = getCentro(polygon);
					drawMap.setCenter(centro);

					let lat = polygon.coordinates[0][0][1]
					let lng = polygon.coordinates[0][0][0]
					path.push({lat: (lat*1)+0.0300, lng: (lng*1)+0.0900});
					path.push({lat: (lat*1)+0.0300, lng: (lng*1)+0.1100});
					path.push({lat: (lat*1)+0.0400, lng: (lng*1)+0.100});

					let geoJSON = {
						type: "Feature",
						geometry: polygon,
					};

					// Define el estilo personalizado para el GeoJSON
					var geoJsonStyle = {
						strokeColor: "#000", // Color del contorno
						strokeOpacity: 0.8,
						strokeWeight: 2,
						fillColor: "#FFE043",   // Color de relleno
						fillOpacity: 0.35
					};

					// Crea una nueva capa GeoJSON con el estilo personalizado
					var geoJsonLayer = new google.maps.Data();
					geoJsonLayer.addGeoJson(geoJSON);

					// Aplica el estilo personalizado al GeoJSON
					geoJsonLayer.setStyle(geoJsonStyle);

					// Agrega la capa GeoJSON al mapa
					geoJsonLayer.setMap(drawMap);
				}

				$(".loaderModal").addClass("ocultar");
				$("#map").removeClass("ocultar");
			},
		});
	}

	async function drawingPolygon() {
		path = [];
		let id = $("input[name=id").val();
		let url = base_url("drawParish/" + id);
		drawMap = new google.maps.Map(document.getElementById("map"), {
			center: coords,
			zoom: 12,
			styles: [
				{
					featureType: "poi",
					elementType: "labels", // Aplicar estilo a las etiquetas de los parques
					stylers: [{ visibility: "off" }],
				},

				 {
					featureType: 'administrative', // Para ocultar el nombre de las ciudades
					elementType: 'labels',
					stylers: [{ visibility: 'off' }]
				 },
				 {
					featureType: 'transit', // Paradas de autobús
					elementType: 'labels',
					stylers: [{ visibility: 'off' }] // Oculta las etiquetas de las paradas de autobús
				 }
			],
			mapTypeControl: false,
			streetViewControl: false
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

		$('.loaderModal').removeClass('ocultar');
		$("#map").addClass("ocultar");

		await $.ajax({
			type: "GET",
			url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type == "success") {
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
				}else{
					toast(
						"bg-info",
						response.message.title,
						response.message.message+", puedes dibujar uno.",
						1
					);
				}
				$(".loaderModal").addClass("ocultar");
				$("#map").removeClass("ocultar");
			},
		});

		if(path.length > 0) {
			myPolygon.setPath(path);
		}else{
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
		let url = base_url("reports/sectors/all-sectors-barrio/"+idI);
		await $.ajax({
			type: "GET",
			url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if(response.message.type == "success"){
					let data = response.data;
					data.forEach(row => {
						if(id != row.id_city){
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
			}
		});
	}

	function getPolygonCoords() {
		path = [];
		var len = myPolygon.getPath().getLength();
		for(var i = 0; i < len; i++){
			let lat = myPolygon.getPath().getAt(i).lat();
			let lng = myPolygon.getPath().getAt(i).lng();
			path.push({lat: lat, lng: lng});
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

	function getPolygon(polygon){
		path = [];
		let array = polygon.coordinates[0];
		array.forEach(row => {
			path.push({lat: row[1], lng: row[0]});
		});
	}

	// ==================================

	// CODIGO DEL MODAL DE MAPAS

	function ipm() {
		$.getJSON(
			"https://ipapi.co/json",
			function (data) {
				$("#ip").val(data.ip);
			},
			"json"
		);
	}

	ipm();

	$(".btnViewMap").click(async function (e) {
		e.preventDefault();
		$("input[name=msm]").val("");
		let zoom = $(this).attr('zoom')*1;
		console.log("dsa")
		drawMap = new google.maps.Map(document.getElementById("viewMapAlarm"), {
			center: coords,
			zoom: zoom,
			styles: [
				{
					featureType: "administrative", // Para ocultar el nombre de las ciudades
					elementType: "labels",
					stylers: [{ visibility: "off" }],
				},
			],
			mapTypeControl: false,
			streetViewControl: false,
		});

		let idI = $("input[name=idInstitution").val();
		let ruta1 = $("input[name=ruta1").val();
		let ruta2 = $("input[name=ruta2").val();
		let ruta3 = $("input[name=ruta3").val();
		let url1 = ruta1+"/"+idI
		let url2 = ruta2+"/"+idI
		let url3 = ruta3+"/"+idI

		await myPolygonA(drawMap, url1, 'cantidadProvincias', '#FF9E00');
		if(ruta2 != ""){
			await myChildrenPolygon(drawMap, url2, 'cantidadCantones', '#FF3600');
		}
		await AlarmPolygon(drawMap, url3, 'cantidadAlarmas', '#0046FF');
	});

	async function myChildrenPolygon(drawMap, urlContainer, contador, color = '#000') {
		// let url = base_url("reports/cities/all-city-state/"+idI);
		let url = base_url(urlContainer);
		await $.ajax({
			type: "GET",
			url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type == "success") {
					let data = response.data;
					x = 1;
					data.forEach((row) => {
						$("#"+contador).text(x);
						x = x+1;
						let polygon = JSON.parse(row.geom);
						let geoJSON = {
							type: "Feature",
							geometry: polygon,
						};
						// Define el estilo personalizado para el GeoJSON
						var geoJsonStyle = {
							strokeColor: "#000", // Color del contorno
							strokeOpacity: 0.8,
							strokeWeight: 2,
							fillColor: color, // Color de relleno
							fillOpacity: 0.35,
						};

						// Crea una nueva capa GeoJSON con el estilo personalizado
						var geoJsonLayer = new google.maps.Data();
						geoJsonLayer.addGeoJson(geoJSON);

						// Aplica el estilo personalizado al GeoJSON
						geoJsonLayer.setStyle(geoJsonStyle);

						// Agrega la capa GeoJSON al mapa
						geoJsonLayer.setMap(drawMap);

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
					});
				}
			},
		});
	}

	async function AlarmPolygon(drawMap, urlContainer, contador, color = '#000') {
		// let url = base_url("reports/cities/all-city-state/"+idI);
		let url = base_url(urlContainer);
		await $.ajax({
			type: "GET",
			url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type == "success") {
					let data = response.data;
					x = 1;
					data.forEach((row) => {
						$("#"+contador).text(x);
						x = x+1;
						let polygon = JSON.parse(row.geom);
						let geoJSON = {
							type: "Feature",
							geometry: polygon,
						};
						// Define el estilo personalizado para el GeoJSON
						var geoJsonStyle = {
							strokeColor: "#000", // Color del contorno
							strokeOpacity: 0.8,
							strokeWeight: 2,
							fillColor: color, // Color de relleno
							fillOpacity: 0.35,
						};

						// Crea una nueva capa GeoJSON con el estilo personalizado
						var geoJsonLayer = new google.maps.Data();
						geoJsonLayer.addGeoJson(geoJSON);

						// Aplica el estilo personalizado al GeoJSON
						geoJsonLayer.setStyle(geoJsonStyle);

						// Agrega la capa GeoJSON al mapa
						geoJsonLayer.setMap(drawMap);

						let centro = getCentro(polygon);
						// Crea un marcador en el centroide del polígono
						let labelMarker = new google.maps.Marker({
							position: centro,
							map: drawMap,
							label: {
								text: row.code,
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

						let urlIcon = base_url("resources/src/img/logo.png");

						if(row.estado_alarma != 'P3grDcY020230817zW8HaN190633' && row.estado_alarma !== null){
							urlIcon = base_url("resources/src/img/logo-white.png");
						}
						// Crea un nuevo ícono personalizado
						let icon = {
							url: urlIcon,
							scaledSize: new google.maps.Size(35, 40), // Tamaño del ícono (ajústalo según tus necesidades)
							origin: new google.maps.Point(0, 0), // Punto de origen del ícono
							anchor: new google.maps.Point(16, 32), // Punto de anclaje del ícono (ajústalo según el diseño del ícono)
						};

						let markerAlarm = new google.maps.Marker({
							position: { lat: row.lat_alarm * 1, lng: row.lng_alarm * 1 },
							map: drawMap,
							title: row.code,
							draggable: false,
						});

						markerAlarm.setIcon(icon);
						let disabled = "";
						if (
							row.a_alarm == "ac03" ||
							row.a_alarm == "ac04" ||
							row.a_sector == "ac03" ||
							row.a_sector == "ac04" ||
							row.a_parish == "ac03" ||
							row.a_parish == "ac04" ||
							row.a_city == "ac03" ||
							row.a_city == "ac04"
						) {
							disabled = "disabled";
						}

						information = `
							<button type='button' data-bs-toggle='modal' sector='${row.sector}' sectorId='${row.id_sector}' data-bs-target='#updateModalA' dataId='${row.id}' class='btnAlarmEdit btn btn-info'>Editar</button>`;
						if (
							row.estado_alarma != 'P3grDcY020230817zW8HaN190633' && row.estado_alarma !== null
						) {
							information += `
								<button type='button' data-bs-toggle='modal' data-bs-target='#stopSoundAlarmModel' sectorId='${row.id_sector}' class='btn btn-success btnSoundAlarm ${disabled}'>Parar</button>
							`;
						} else {
							information += `
								<button type='button' data-bs-toggle='modal' data-bs-target='#soundAlarmModel' sector='${row.sector}' sectorId='${row.id_sector}' class='btn btn-success btnSoundAlarm ${disabled}'>Activar</button>
							`;
						}

						information += `

							<h5 class='mt-2'>Información de la alarma</h5>
							<p>
								<b>Código:</b> ${row.code}<br>
								<b>Barrio:</b> ${row.sector}<br>
								<b>Parroquia:</b> ${row.parish}<br>
								<b>Cantón:</b> ${row.canton}<br>
							</p>
							<h5>Datos del encargado</h5>
							<p>
								<b>Nombre:</b> ${row.name_manager}<br>
								<b>Teléfono:</b> ${row.phone}<br>
								<b>Celular:</b> ${row.mobile}<br>
							</p>
						`;

						var panelInformation = new google.maps.InfoWindow({
							content: information,
							pixelOffset: new google.maps.Size(0, -10),
						});

						// Establece el nuevo ícono personalizado en el marcador

						informationAlarms.push(panelInformation);

						markerAlarm.addListener("click", async function () {
							await closeAllInfoWindows();
							$("#sound").val(row.id_sector);
							panelInformation.open(drawMap, markerAlarm);
						});

					});
				}
			},
		});
	}

	async function myPolygonA(drawMap, urlContainer, contador, color = '#000') {
		// let url = base_url("reports/cities/all-city-state/"+idI);
		let url = base_url(urlContainer);
		await $.ajax({
			type: "GET",
			url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type == "success") {
					let data = response.data;
					x = 1;
					data.forEach((row) => {
						$("#"+contador).text(x);
						x = x+1;
						let polygon = JSON.parse(row.geom);
						let geoJSON = {
							type: "Feature",
							geometry: polygon,
						};
						// Define el estilo personalizado para el GeoJSON
						var geoJsonStyle = {
							strokeColor: "#000", // Color del contorno
							strokeOpacity: 0.8,
							strokeWeight: 2,
							fillColor: color, // Color de relleno
							fillOpacity: 0.35,
						};

						// Crea una nueva capa GeoJSON con el estilo personalizado
						var geoJsonLayer = new google.maps.Data();
						geoJsonLayer.addGeoJson(geoJSON);

						// Aplica el estilo personalizado al GeoJSON
						geoJsonLayer.setStyle(geoJsonStyle);

						// Agrega la capa GeoJSON al mapa
						geoJsonLayer.setMap(drawMap);

						let centro = getCentro(polygon);
						// Crea un marcador en el centroide del polígono
						drawMap.setCenter(centro);
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
					});
				}
			},
		});
	}

	function closeAllInfoWindows() {
		// Cierra todos los InfoWindows
		for (var i = 0; i < informationAlarms.length; i++) {
			informationAlarms[i].close();
		}
	}

	$(".modal-body").on("click", ".btnAlarmEdit", async function (e) {
		e.preventDefault();

		$("input[id=NameSector]").val($(this).attr("sector"));
		$("input[id=sectorE]").val($(this).attr("sectorId"));
		$("input[name=idInstitution]").val($(this).attr("sectorId"));
		$("input[name=id]").val($(this).attr("dataId"));
		await getForIdAlarm();
		// $(".btnGetForId").trigger("click");
	});

	$(".modal-body").on("click", ".btnSoundAlarm", function (e) {
		e.preventDefault();
		$("input[name=idSectorSound]").val($(this).attr("sectorId"));
		$("input[name=nameSectorSound]").val($(this).attr("sector"));
	});

	async function getForIdAlarm() {
		let id = $("input[name=id]").val();
		let idI = $("input[name=idInstitution").val();

		let url = $("input[name=url]").val() + "alarms/" + idI + "/" + id;

		await $.ajax({
			type: "GET",
			url: url,
			success: function (answer) {
				let response = JSON.parse(answer);

				if (response.message.type == "success") {
					toast(
						"bg-success",
						response.message.title || "Alarma Encontrada",
						response.message.message || "Alarma encontrada con éxito",
						1
					);

					$("#codeE").val(response.data.code);
					$("#managerE").val(response.data.id_alarm_manager);
					$("#latitudeE").val(response.data.latitud);
					$("#longitudeE").val(response.data.longitud);
					newAlarmCords(
						response.data.id,
						"view",
						"#1051D5",
						response.data.latitud * 1,
						response.data.longitud * 1
					);
				} else {
					toast(
						"bg-danger",
						response.message.title || "Alarma encontrada",
						response.message.message || "Ocurrió un problema",
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
		let map = "mapLocationAlarmE";

		drawMap = new google.maps.Map(document.getElementById(map), {
			center: coords,
			zoom: 17,
			mapTypeControl: false,
			streetViewControl: false,
		});
		let sectorId = $("input[id=sectorE]").val();
		await viewDrawFatherOnMapA(drawMap, 'drawSector/'+sectorId, "#C60303");
		coords = getPolygonCentroid(path);

		if (latitude != 0 && longitude != 0) {
			coords = { lat: latitude*1, lng: longitude*1};
		}

		drawMap.setCenter(coords);

		if (x == "view") {
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
							strokeColor: color,
							strokeOpacity: 0.8,
							strokeWeight: 2,
							fillColor: color,
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

					} else {
						if(response.data[0].lat_alarm != undefined) {
							toast(
								"bg-info",
								""+response.message.title,
								""+response.message.message,
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

	function getPolygonCentroid(coords) {
		var bounds = new google.maps.LatLngBounds();
		coords.forEach(function (point) {
			bounds.extend(point);
		});

		return bounds.getCenter();
	}

	$("#btnUpdateAlarm").click(function (e) {
		e.preventDefault();
		updateAlarm();
	});

	function updateAlarm() {
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
				campo: "codigo",
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

	// Codigo editar area de escucha de las alarmas

	$("#editArea").click(function (e) {
		e.preventDefault();
		drawingPolygonAlarm();
	});

	// BUTTON SAVE DRAW
	$("#btnSaveDrawA").click(function (e) {
		e.preventDefault();
		saveDrawA();
	});

	async function saveDrawA() {
		path = [];
		if (borrado == 0) {
			await getPolygonCoordsA();
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
			success: async function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type == "success") {
					toast(
						"bg-success",
						response.message.title,
						response.message.message,
						1
					);
					await getForIdAlarm()
				} else {
					toast(
						"bg-danger",
						response.message.title,
						response.message.message,
						1
					);
					await getForIdAlarm()
				}
			},
		});
	}
	async function drawingPolygonAlarm() {
		path = [];
		let id = $("input[name=id").val();
		let url = base_url("drawAlarm/" + id);
		drawMap = new google.maps.Map(document.getElementById("mapArea"), {
			center: coords,
			zoom: 17,
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
		let sectorId = $("input[id=sectorE]").val();
		await viewDrawFatherOnMapA(drawMap, 'drawSector/'+sectorId, "#C60303");
		await mySiblingsPolygonA(id, drawMap);

		var defaultPolygon = [
			new google.maps.LatLng(-0.979835, -78.592705),
			new google.maps.LatLng(-0.896679, -78.710152),
			new google.maps.LatLng(-0.868363, -78.569822),
		];

		DrawingPolygon = new google.maps.Polygon({
			draggable: false,
			editable: true,
			strokeColor: "#FF0000",
			strokeOpacity: 0.8,
			strokeWeight: 2,
			fillColor: "#FF0000",
			fillOpacity: 0.35,
		});

		$(".loaderModal").removeClass("ocultar");
		$("#mapArea").addClass("ocultar");

		await $.ajax({
			type: "GET",
			url,
			success: function (answer) {
				let response = JSON.parse(answer);
				console.log(response);
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
					drawMap.setCenter(centro);
					if(response.data[0].geom === undefined){
						path = [];
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
					}

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
				$("#mapArea").removeClass("ocultar");
			},
		});

		if (path.length > 0) {
			DrawingPolygon.setPath(path);
		} else {
			DrawingPolygon.setPath(defaultPolygon);
		}

		DrawingPolygon.setMap(drawMap);

		google.maps.event.addListener(DrawingPolygon, "rightclick", function (event) {
			var vertices = DrawingPolygon.getPath();
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

	function getPolygonCoordsA() {
		path = [];
		var len = DrawingPolygon.getPath().getLength();
		for (var i = 0; i < len; i++) {
			let lat = DrawingPolygon.getPath().getAt(i).lat();
			let lng = DrawingPolygon.getPath().getAt(i).lng();
			path.push({ lat: lat, lng: lng });
		}
	}

	async function viewDrawFatherOnMapA(drawMap, urlFather, color = '#000') {
		let url = base_url(urlFather);

		await $.ajax({
			type: "GET",
			url,
			success: function (answer) {
				let response = JSON.parse(answer);

				if (response.message.type == "success") {
					let polygon = JSON.parse(response.data[0].geom);
					let geoJSON = {
						type: "Feature",
						geometry: polygon,
					};

					// Define el estilo personalizado para el GeoJSON
					var geoJsonStyle = {
						strokeColor: "#000", // Color del contorno
						strokeOpacity: 0.8,
						strokeWeight: 2,
						fillColor: color, // Color de relleno
						fillOpacity: 0.35,
					};

					// Crea una nueva capa GeoJSON con el estilo personalizado
					var geoJsonLayer = new google.maps.Data();
					geoJsonLayer.addGeoJson(geoJSON);

					// Aplica el estilo personalizado al GeoJSON
					geoJsonLayer.setStyle(geoJsonStyle);

					// Agrega la capa GeoJSON al mapa
					geoJsonLayer.setMap(drawMap);

					let centro = getCentro(polygon);
					// Crea un marcador en el centroide del polígono
					let labelMarker = new google.maps.Marker({
						position: centro,
						map: drawMap,
						label: {
							text: response.data[0].name,
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

				$(".loaderModal").addClass("ocultar");
				$("#map").removeClass("ocultar");
			},
		});
	}

	async function mySiblingsPolygonA(id, drawMap) {
		let idI = $("input[id=sectorE]").val();
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

	$("#typeNot").change(function (e) {
		e.preventDefault();
		$("#typeNotVal").val($(this).find("option:selected").text());
	});

	$("#btnActiveAlarm").click(function (e) {
		e.preventDefault();
		if ("geolocation" in navigator) {
			let sector = $("#sound").val();
			let sectorName = $("#soundName").val();
			let typeNot = $("#typeNot").val();
			let why = $("#why").val();
			let lat = "";
			let lng = "";

			navigator.geolocation.getCurrentPosition(function (position) {
				lat = position.coords.latitude;
				lng = position.coords.longitude;

				let ip = $("#ip").val();

				let value = validate([
					{
						name: "sound",
						type: "string",
						campo: "sonido",
						value: sector,
						min: 1,
						max: 255,
						required: true,
					},
					{
						name: "typeNot",
						type: "string",
						campo: "tipo de notificación",
						value: typeNot,
						min: 1,
						max: 255,
						required: true,
					},
					{
						name: "why",
						type: "string",
						campo: "motivo",
						value: why,
						min: 1,
						max: 2000,
						required: true,
					},
					{
						name: "ip",
						type: "string",
						campo: "ip",
						value: ip,
						min: 1,
						max: 15,
						required: true,
					},
				]);

				if (value) {
					const data = {
						sector,
						typeNot,
						ip,
						why,
						lat,
						lng,
					};

					let url = $("input[name=url]").val() + "activeAlarm";
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
								$("#sound").attr("active", "true");
								$(".btn-model-close").trigger("click");
								codeUser = $("input[name=codeUser]").val();
								user = $("#userName").val();
								let typed = $("#typeNotVal").val();
								// $("#sound").attr("active", "true")
								enviar(codeUser, user, typed, sector, sectorName, why);
								$("input[name=msm]").val("alarmas");
								$("#btnViewAll").trigger("click");
							} else {
								toast(
									"bg-danger",
									response.message.title,
									response.message.message,
									1
								);
								$("#sound").attr("active", "false");
							}
						},
					});
				}
			});
		} else {
			toast(
				"bg-danger",
				"GEOLOCALIZACION",
				"La geolocalización no esta disponible en este navegador",
				1
			);
		}
	});

	$("#btnStopAlarm").click(function (e) {
		e.preventDefault();
		if ("geolocation" in navigator) {
			let sector = $("#sound").val();
			let sectorName = $("#soundName").val();
			let typeNot = 'P3grDcY020230817zW8HaN190633';
			let why = $("#why2").val();
			let lat = "";
			let lng = "";

			navigator.geolocation.getCurrentPosition(function (position) {
				lat = position.coords.latitude;
				lng = position.coords.longitude;

				let ip = $("#ip").val();

				let value = validate([
					{
						name: "sound2",
						type: "string",
						campo: "sonido",
						value: sector,
						min: 1,
						max: 255,
						required: true,
					},
					{
						name: "typeNot2",
						type: "string",
						campo: "tipo de notificación",
						value: typeNot,
						min: 1,
						max: 255,
						required: true,
					},
					{
						name: "why2",
						type: "string",
						campo: "motivo",
						value: why,
						min: 1,
						max: 2000,
						required: true,
					},
					{
						name: "ip2",
						type: "string",
						campo: "ip",
						value: ip,
						min: 1,
						max: 15,
						required: true,
					},
				]);

				if (value) {
					const data = {
						sector,
						typeNot,
						ip,
						why,
						lat,
						lng,
					};

					let url = $("input[name=url]").val() + "activeAlarm";
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
								$("#sound").attr("active", "true");
								$(".btn-model-close").trigger("click");
								codeUser = $("input[name=codeUser]").val();
								user = $("#userName").val();
								let typed = $("#typeNotVal").val();
								enviar(codeUser, user, typed, sector, sectorName, why);
								$("input[name=msm]").val("alarmas");
								$("#btnViewAll").trigger("click");

							} else {
								toast(
									"bg-danger",
									response.message.title,
									response.message.message,
									1
								);
								$("#sound").attr("active", "false");
							}
						},
					});
				}
			});
		} else {
			toast(
				"bg-danger",
				"GEOLOCALIZACION",
				"La geolocalización no esta disponible en este navegador",
				1
			);
		}
	});
}
