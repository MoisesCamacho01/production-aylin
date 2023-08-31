$('.select-alarm').select2({
	dropdownParent: $("#updateModal"),
	placeholder: 'Selecciona un Encargado',
	allowClear: true,
	dropdownCssClass: 'select-search',
	closeOnSelect: false,
	width: 'resolve'
});

var alarmCoord;

function initMap() {
	let coords = { lat: -0.9179301528102732, lng: -78.63297106182672 };
	let drawMap = "";
	let informationAlarms = [];


	$("#bodyTable").on("click", ".btnAlarmEdit", function (e) {
		e.preventDefault();
		$("input[id=NameSector]").val($(this).attr("sector"));
		$("input[id=sectorE]").val($(this).attr("sectorId"));
		$("input[name=idInstitution]").val($(this).attr("sectorId"));
		$(".btnInputHidden").trigger("click");
		$(".btnGetForId").trigger("click");
	});

	$("#bodyTable").on("click", ".btnSoundAlarm", function (e) {
		e.preventDefault();
		$("input[name=idSectorSound]").val($(this).attr("sectorId"));
		$("input[name=nameSectorSound]").val($(this).attr("sector"));
	});

	$("#states").change(async function (e) {
		e.preventDefault();
		drawMap = new google.maps.Map(document.getElementById("viewMap"), {
			center: coords,
			zoom: 9,
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

		var primerOption = $("#cities option:first-child").detach();
		$("#cities").empty().append(primerOption);
		await cities($(this).val());
		await myPolygon(drawMap, 'drawState/'+$(this).val(), 'cantidadProvincias', '#FF9E00');
		await myChildrenPolygon(drawMap, 'reports/cities/all-city-state/'+$(this).val(), 'cantidadCantones', '#FF3600');
		await AlarmPolygon(drawMap, 'reports/cities/all-alarm-state/'+$(this).val(), 'cantidadAlarmas', '#0046FF');
	});

	$("#cities").change(async function (e) {
		e.preventDefault();
		drawMap = new google.maps.Map(document.getElementById("viewMap"), {
			center: coords,
			zoom: 11,
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

		var primerOption = $("#parishes option:first-child").detach();
		$("#parishes").empty().append(primerOption);
		await parishes($(this).val());
		await myPolygon(drawMap, 'drawCity/'+$(this).val(), 'cantidadCantones', '#FF9E00');
		await myChildrenPolygon(drawMap, 'reports/parish/all-parish-city/'+$(this).val(), 'cantidadParroquias', '#FF3600');
		await AlarmPolygon(drawMap, 'reports/cities/all-alarm-city/'+$(this).val(), 'cantidadAlarmas', '#0046FF');
	});

	$("#parishes").change(async function (e) {
		e.preventDefault();
		drawMap = new google.maps.Map(document.getElementById("viewMap"), {
			center: coords,
			zoom: 12,
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
		var primerOption = $("#sectors option:first-child").detach();
		$("#sectors").empty().append(primerOption);
		sectors($(this).val());
		await myPolygon(drawMap, 'drawParish/'+$(this).val(), 'cantidadParroquias', '#FF9E00');
		await myChildrenPolygon(drawMap, 'reports/sectors/all-sectors-barrio/'+$(this).val(), 'cantidadBarrios', '#FF3600');
		await AlarmPolygon(drawMap, 'reports/parish/all-alarm-parish/'+$(this).val(), 'cantidadAlarmas', '#0046FF');
	});

	$("#sectors").change(async function (e) {
		e.preventDefault();
		drawMap = "";
		cantidadBarrios = 0;
		cantidadAlarmas = 0;
		drawMap = new google.maps.Map(document.getElementById("viewMap"), {
			center: coords,
			zoom: 14,
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
		await myPolygon(drawMap, 'drawSector/'+$(this).val(), 'cantidadBarrios', '#FF9E00');
		await AlarmPolygon(drawMap, 'reports/sector/all-alarm-sector/'+$(this).val(), 'cantidadAlarmas', '#0046FF');
	});

	$("#btnViewAll").click(function (e) {
		e.preventDefault();
		viewAll();
	});

	viewAll();
	function viewAll() {
		drawMap = new google.maps.Map(document.getElementById("viewMap"), {
			center: coords,
			zoom: 9,
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
		states(drawMap);
	}

	function states(drawMap) {
		let url = base_url("reports/states/all-state-country/C001");
		cantidadProvincias = 0;
		$.ajax({
			type: "GET",
			url: url,
			success: function (answer) {
				let response = JSON.parse(answer);

				if (response.message.type == "success") {
					toast(
						"bg-success",
						response.message.title || "Registro encontrado",
						response.message.message || "El registro fue encontrado",
						1
					);
					let data = response.data;
					data.forEach(async(row)=>{
						await myPolygon(drawMap, 'drawState/'+row.id_city, 'cantidadProvincias', '#FF9E00');
						await myChildrenPolygon(drawMap, 'reports/cities/all-city-state/'+row.id_city, 'cantidadCantones', '#FF3600');
						await AlarmPolygon(drawMap, 'reports/cities/all-alarm-state/'+row.id_city, 'cantidadAlarmas', '#0046FF');
					});
				}
			},
		});
	}

	function cities(idState) {
		let url = base_url("reports/cities/all-city-state/" + idState);
		cantidadCantones = 0;
		$.ajax({
			type: "GET",
			url: url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (
					response.message.type == "success" &&
					response.message.title != ""
				) {
					toast(
						"bg-success",
						response.message.title || "Registro encontrado",
						response.message.message || "El registro fue encontrado",
						1
					);
					let data = response.data;
					data.forEach((row) => {
						var nuevaOpcion = $("<option>").val(row.id_city).text(row.name);
						$("#cities").append(nuevaOpcion);
					});

				}
			},
		});
	}

	function parishes(idCity) {
		let url = base_url("reports/parish/all-parish-city/" + idCity);
		cantidadParroquias = 0;
		$.ajax({
			type: "GET",
			url: url,
			success: function (answer) {
				let response = JSON.parse(answer);

				if (
					response.message.type == "success" &&
					response.message.title != ""
				) {
					toast(
						"bg-success",
						""+response.message.title || "Registro encontrado",
						""+response.message.message || "El registro fue encontrado",
						1
					);
					let data = response.data;
					data.forEach((row) => {
						var nuevaOpcion = $("<option>").val(row.id_city).text(row.name);
						$("#parishes").append(nuevaOpcion);
					});
				}
			},
		});
	}

	function sectors(idParish) {
		let url = base_url("reports/sectors/all-sectors-barrio/" + idParish);
		cantidadBarrios = 0;
		$.ajax({
			type: "GET",
			url: url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (
					response.message.type == "success" &&
					response.message.title != ""
				) {
					toast(
						"bg-success",
						""+response.message.title || "Registro encontrado",
						""+response.message.message || "El registro fue encontrado",
						1
					);
					let data = response.data;
					data.forEach((row) => {
						var nuevaOpcion = $("<option>").val(row.id).text(row.name);
						$("#sectors").append(nuevaOpcion);
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

	//NUEVO CODIGO
	async function viewDrawFatherOnMap(drawMap, urlFather, color = '#000') {
		let url = base_url(urlFather);

		$(".loaderModal").removeClass("ocultar");
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
						if(row.estado_alarma != 'P3grDcY020230817zW8HaN190633'){
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
							<button type='button' data-bs-toggle='modal' sector='${row.sector}' sectorId='${row.id_sector}' data-bs-target='#updateModal' dataId='${row.id}' class='btnAlarmEdit btn btn-info'>Editar</button>
							<a class='btnInputHidden btnGetForId' dataId='${row.id}'></a>`;
							
						if (
							row.estado_alarma != '0iEh8DYd20230428y8L2u1175602'
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

	async function myPolygon(drawMap, urlContainer, contador, color = '#000') {
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
					$(".btn-model-close").trigger("click");
					$("#btnViewAll").trigger("click");
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

function getForId() {
	let id = $("input[name=id]").val();
	let idI = $("input[name=idInstitution").val();

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
					response.data.id,
					"view",
					"#1051D5",
					response.data.latitud * 1,
					response.data.longitud * 1
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

	// OBTENER LA UBICACION DEL MARCADOR
	function newAlarmCords(
		id,
		x,
		color,
		latitude = 0,
		longitude = 0,
		name = ""
	) {
		let url = $("input[name=urlMap]").val() + "drawAlarm/" + id;
		var coords = {
			lat: latitude != 0 ? latitude : -0.9179301528102732,
			lng: longitude != 0 ? longitude : -78.63297106182672,
		};
		var markerAlarm = "";
		var markerMap = "";
		var polygonMarker = "";

		let base_url = $("input[name=baseUrl]").val();
		let url2 = `${base_url}/src/img/logo.png`;

		// Crea un nuevo ícono personalizado
		let icon = {
			url: url2,
			scaledSize: new google.maps.Size(35, 40), // Tamaño del ícono (ajústalo según tus necesidades)
			origin: new google.maps.Point(0, 0), // Punto de origen del ícono
			anchor: new google.maps.Point(16, 32), // Punto de anclaje del ícono (ajústalo según el diseño del ícono)
		};

		markerMap = new google.maps.Map(
			document.getElementById("mapLocationAlarmE"),
			{
				zoom: 17,
				center: coords,
			}
		);

		if (x == "view") {
			$.ajax({
				type: "GET",
				url: url,
				success: function (answer) {
					let response = JSON.parse(answer);
					if (response.message.type == "success") {
						let coordenadas = response.data;
						let geo = JSON.parse(JSON.stringify(coordenadas));

						let cor = [];

						geo.forEach((row) => {
							cor.push({ lat: row.latitud * 1, lng: row.longitud * 1 });
						});

						polygonMarker = new google.maps.Polygon({
							path: cor,
							strokeColor: color,
							strokeOpacity: 0.8,
							strokeWeight: 2,
							fillColor: color,
							fillOpacity: 0.2,
						});

						polygonMarker.setMap(markerMap);
					}
				},
			});

			// Crea el marcador
			markerAlarm = new google.maps.Marker({
				position: coords,
				map: markerMap,
				title: name != "" ? name : "Mi marcador",
				draggable: true,
			});

			// Establece el nuevo ícono personalizado en el marcador
			markerAlarm.setIcon(icon);

			// Agrega el evento de arrastre al marcador
			google.maps.event.addListener(
				markerAlarm,
				"dragend",
				function (event) {
					// Verifica si la nueva posición del marcador está dentro del polígono
					if (
						!google.maps.geometry.poly.containsLocation(
							event.latLng,
							polygonMarker
						)
					) {
						// Si la nueva posición está fuera del polígono, impide que el marcador se mueva allí
						markerAlarm.setPosition(coords); // Devuelve el marcador a su posición original
					} else {
						$("#latitudeE").val(event.latLng.lat());
						$("#longitudeE").val(event.latLng.lng());
					}
				}
			);
		}
	}

	alarmsCoord = newAlarmCords;
}

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

$("#typeNot").change(function (e) {
	e.preventDefault();
	$("#typeNotVal").val($(this).find("option:selected").text());
});

$("#btnRefresh").click(function (e) {
	e.preventDefault();
	$("#btnViewAll").trigger("click");
});
