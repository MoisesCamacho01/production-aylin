$('.select-alarm').select2({
	dropdownParent: $("#updateModal"),
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

var alarmCoordMap;

async function initMap() {
	let coords = { lat: -0.9179301528102732, lng: -78.63297106182672 };
	let drawMap = "";
	let informationAlarms = [];
	let path = [];

	// var polygonMarker = "";
	var DrawingPolygon = "";
	var borrado = 0;

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
		$("input[name=msm]").val("");
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
		$("input[name=msm]").val("");
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

		if($(this).val() === "All"){
			$("#states").trigger('change');
		}else{
			await parishes($(this).val());
			await myPolygon(drawMap, 'drawCity/'+$(this).val(), 'cantidadCantones', '#FF9E00');
			await myChildrenPolygon(drawMap, 'reports/parish/all-parish-city/'+$(this).val(), 'cantidadParroquias', '#FF3600');
			await AlarmPolygon(drawMap, 'reports/cities/all-alarm-city/'+$(this).val(), 'cantidadAlarmas', '#0046FF');
		}
	});

	$("#parishes").change(async function (e) {
		e.preventDefault();
		$("input[name=msm]").val("");
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
		if($(this).val() === "All"){
			$("#cities").trigger('change');
		}else{
			sectors($(this).val());
			await myPolygon(drawMap, 'drawParish/'+$(this).val(), 'cantidadParroquias', '#FF9E00');
			await myChildrenPolygon(drawMap, 'reports/sectors/all-sectors-barrio/'+$(this).val(), 'cantidadBarrios', '#FF3600');
			await AlarmPolygon(drawMap, 'reports/parish/all-alarm-parish/'+$(this).val(), 'cantidadAlarmas', '#0046FF');
		}
	});

	$("#sectors").change(async function (e) {
		e.preventDefault();
		$("input[name=msm]").val("");
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
		if($(this).val() === "All"){
			$("#parishes").trigger('change');
		}else{
			await myPolygon(drawMap, 'drawSector/'+$(this).val(), 'cantidadBarrios', '#FF9E00');
			await AlarmPolygon(drawMap, 'reports/sector/all-alarm-sector/'+$(this).val(), 'cantidadAlarmas', '#0046FF');
		}
	});

	$("#btnViewAll").click(function (e) {
		e.preventDefault();
		viewAll();
	});

	$("#searchCodeAlarm").keyup(async function (e) {
		e.preventDefault();
		$("input[name=msm]").val("");
		drawMap = new google.maps.Map(document.getElementById("viewMap"), {
			center: coords,
			zoom: 18,
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
		let code = $(this).val();
		console.log(code);
		let url = base_url('reports/alarm/get-alarm')
		const data = {
			search : code
		}
		await $.ajax({
			type: "POST",
			data,
			url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type == "success") {
					let data = response.data;
					// x = 1;
					data.forEach((row) => {
						// $("#"+contador).text(x);
						// x = x+1;
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
							fillColor: "#0385C6", // Color de relleno
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
							<button type='button' data-bs-toggle='modal' sector='${row.sector}' sectorId='${row.id_sector}' data-bs-target='#updateModal' dataId='${row.id}' class='btnAlarmEdit btn btn-info'>Editar</button>
							<a class='btnInputHidden btnGetForId' dataId='${row.id}'></a>`;

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
	});

	$("#searchManagerAlarm").keyup(async function (e) {
		e.preventDefault();
		$("input[name=msm]").val("");
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
		let code = $(this).val();
		console.log(code);
		let url = base_url('reports/manager/get-alarm')
		const data = {
			search : code
		}
		await $.ajax({
			type: "POST",
			data,
			url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type == "success") {
					let data = response.data;
					// x = 1;
					data.forEach((row) => {
						// $("#"+contador).text(x);
						// x = x+1;
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
							fillColor: "#0385C6", // Color de relleno
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
							<button type='button' data-bs-toggle='modal' sector='${row.sector}' sectorId='${row.id_sector}' data-bs-target='#updateModal' dataId='${row.id}' class='btnAlarmEdit btn btn-info'>Editar</button>
							<a class='btnInputHidden btnGetForId' dataId='${row.id}'></a>`;

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
	});

	viewAll();
	async function viewAll() {
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

		var type = getQueryVariable('type');
		var code = getQueryVariable('code');

		if (type !== null || code !== null) {
			if(type === 'state'){
				await cities(code);
				await myPolygon(drawMap, 'drawState/'+code, 'cantidadProvincias', '#FF9E00');
				await myChildrenPolygon(drawMap, 'reports/cities/all-city-state/'+code, 'cantidadCantones', '#FF3600');
				await AlarmPolygon(drawMap, 'reports/cities/all-alarm-state/'+code, 'cantidadAlarmas', '#0046FF');
			}else if(type === 'city'){
				await parishes(code);
				await myPolygon(drawMap, 'drawCity/'+code, 'cantidadCantones', '#FF9E00');
				await myChildrenPolygon(drawMap, 'reports/parish/all-parish-city/'+code, 'cantidadParroquias', '#FF3600');
				await AlarmPolygon(drawMap, 'reports/cities/all-alarm-city/'+code, 'cantidadAlarmas', '#0046FF');
			}else if(type === 'parish'){
				sectors(code);
				await myPolygon(drawMap, 'drawParish/'+code, 'cantidadParroquias', '#FF9E00');
				await myChildrenPolygon(drawMap, 'reports/sectors/all-sectors-barrio/'+code, 'cantidadBarrios', '#FF3600');
				await AlarmPolygon(drawMap, 'reports/parish/all-alarm-parish/'+code, 'cantidadAlarmas', '#0046FF');
			}else if(type === 'sector'){
				await myPolygon(drawMap, 'drawSector/'+code, 'cantidadBarrios', '#FF9E00');
				await AlarmPolygon(drawMap, 'reports/sector/all-alarm-sector/'+code, 'cantidadAlarmas', '#0046FF');
			}else{
				states(drawMap);
			}

		}else{
			states(drawMap);
		}
	}

	function states(drawMap) {
		let url = base_url("reports/states/all-state-country/C001");
		cantidadProvincias = 0;
		$.ajax({
			type: "GET",
			url: url,
			success: function (answer) {
				let response = JSON.parse(answer);
				let msm = $("input[name=msm]").val();
				if (response.message.type == "success") {
					let message = "";
					if(msm != ""){
						message = "Estado de alarma actualizado"
					}else{
						message = response.message.message || "El registro fue encontrado"
					}

					toast(
						"bg-success",
						response.message.title || "Registro encontrado",
						message,
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
					let nuevaOpcion = $("<option>").val('All').text('TRAER TODOS');
					$("#cities").append(nuevaOpcion);
					data.forEach((row) => {
						nuevaOpcion = $("<option>").val(row.id_city).text(row.name);
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
					let nuevaOpcion = $("<option>").val('All').text('TRAER TODOS');
					$("#parishes").append(nuevaOpcion);
					data.forEach((row) => {
						nuevaOpcion = $("<option>").val(row.id_city).text(row.name);
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
					let nuevaOpcion = $("<option>").val('All').text('TRAER TODOS');
					$("#sectors").append(nuevaOpcion);
					data.forEach((row) => {
						nuevaOpcion = $("<option>").val(row.id).text(row.name);
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
							<button type='button' data-bs-toggle='modal' sector='${row.sector}' sectorId='${row.id_sector}' data-bs-target='#updateModal' dataId='${row.id}' class='btnAlarmEdit btn btn-info'>Editar</button>
							<a class='btnInputHidden btnGetForId' dataId='${row.id}'></a>`;

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

	// Función para calcular el centroide de un polígono
	function getPolygonCentroid(coords) {
		var bounds = new google.maps.LatLngBounds();
		coords.forEach(function (point) {
			bounds.extend(point);
		});

		return bounds.getCenter();
	}

	function getPolygon(polygon) {
		path = [];
		let array = polygon.coordinates[0];
		array.forEach((row) => {
			path.push({ lat: row[1], lng: row[0] });
		});
	}

	// OBTENER LA UBICACION DEL MARCADOR
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
		await viewDrawFatherOnMap(drawMap, 'drawSector/'+sectorId, "#C60303");
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

	// Codigo editar area de escucha de las alarmas

	$("#editArea").click(function (e) {
		e.preventDefault();
		drawingPolygon();
	});

	// BUTTON SAVE DRAW
	$("#btnSaveDraw").click(function (e) {
		e.preventDefault();
		saveDraw();
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
					$(".btnGetForId").trigger("click");
				} else {
					toast(
						"bg-danger",
						response.message.title,
						response.message.message,
						1
					);
					$(".btnGetForId").trigger("click");
				}
			},
		});
	}

	async function drawingPolygon() {
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
		await viewDrawFatherOnMap(drawMap, 'drawSector/'+sectorId, "#C60303");
		await mySiblingsPolygon(id, drawMap);

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

	function getPolygonCoords() {
		path = [];
		var len = DrawingPolygon.getPath().getLength();
		for (var i = 0; i < len; i++) {
			let lat = DrawingPolygon.getPath().getAt(i).lat();
			let lng = DrawingPolygon.getPath().getAt(i).lng();
			path.push({ lat: lat, lng: lng });
		}
	}

	async function mySiblingsPolygon(id, drawMap) {
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

	alarmsCoordMap = newAlarmCords;
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

async function getForId() {
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
				alarmsCoordMap(
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

$("#typeNot").change(function (e) {
	e.preventDefault();
	$("#typeNotVal").val($(this).find("option:selected").text());
});

$("#btnRefresh").click(function (e) {
	e.preventDefault();
	$("#btnViewAll").trigger("click");
	$("input[name=msm]").val("alarmas");
});
