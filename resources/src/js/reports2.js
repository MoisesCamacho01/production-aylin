var alarmCoord;

function initMap(){
	let path = [];
	let markers = []; // array para almacenar los marcadores
	let polygon = "";
	let coords = { lat: -0.9179301528102732, lng: -78.63297106182672 };
	let polygons = [];
	let drawMap = "";
	let informationAlarms = [];
	var polygonMarker = "";

	$('#bodyTable').on('click', '.btnAlarmEdit', function (e) {
		e.preventDefault();
		$('input[id=NameSector]').val($(this).attr('sector'));
		$('input[id=sectorE]').val($(this).attr('sectorId'));
		$('input[name=idInstitution]').val($(this).attr('sectorId'));
		$('.btnInputHidden').trigger('click');
		$('.btnGetForId').trigger('click');
	});

	$('#bodyTable').on('click', '.btnSoundAlarm', function (e) {
		e.preventDefault();
		$('input[name=idSectorSound]').val($(this).attr('sectorId'));
	});

	$('#states').change(function (e) {
		e.preventDefault();
		cities($(this).val());
		drawMap = new google.maps.Map(
			document.getElementById("viewMap"),
			{
				zoom: 8,
				center: coords,
			}
		);
		viewState($(this).val());
	});

	$('#cities').change(function (e) {
		e.preventDefault();
		parishes($(this).val());
		drawMap = new google.maps.Map(
			document.getElementById("viewMap"),
			{
				zoom: 8,
				center: coords,
			}
		);
		viewState($("#states").val())
		viewCity($(this).val())
	});

	$('#parishes').change(function (e) {
		e.preventDefault();
		drawMap = new google.maps.Map(
			document.getElementById("viewMap"),
			{
				zoom: 8,
				center: coords,
			}
		);
		sectors($(this).val());
		viewState($("#states").val())
		viewCity($("#cities").val())
		viewParish($(this).val())
	});

	$('#sectors').change(function (e) {
		e.preventDefault();
		drawMap = new google.maps.Map(
			document.getElementById("viewMap"),
			{
				zoom: 8,
				center: coords,
			}
		);
		viewState($("#states").val())
		viewCity($("#cities").val())
		viewParish($("#parishes").val())
		viewSector($(this).val())
		viewAllAlarm($(this).val())
	});

	$("#btnViewAll").click(function (e) {
		e.preventDefault();
		viewAll()
	});

	viewAll();
	function viewAll(){
		drawMap = new google.maps.Map(
			document.getElementById("viewMap"),
			{
				zoom: 8,
				center: coords,
			}
		);
		viewState('12');
		viewCity('I5rznkBh202308165AmHL7180130');
		viewParish('4UnRPr9F20230816OCVQ8O191745');
		viewSector('0cGPmBKO20230816Yi7C0R194022');
		viewAllAlarm('0cGPmBKO20230816Yi7C0R194022');
	}
	function cities(idState){
		let url = base_url("reports/cities/all-city-state/"+idState);
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
					let data = response.data;

					data.forEach(row => {
						var nuevaOpcion = $("<option>").val(row.id).text(row.name);
						$("#cities").append(nuevaOpcion);
					});
				} else {
					toast(
						"bg-danger",
						response.message.title,
						response.message.message,
						1
					);

					$('.btn-close').click();
				}
			},
		});
	}

	function parishes(idCity){
		let url = base_url("reports/parish/all-parish-city/"+idCity);
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
					let data = response.data;

					data.forEach(row => {
						var nuevaOpcion = $("<option>").val(row.id).text(row.name);
						$("#parishes").append(nuevaOpcion);
					});
				} else {
					toast(
						"bg-danger",
						response.message.title,
						response.message.message,
						1
					);

					$('.btn-close').click();
				}
			},
		});
	}

	function sectors(idParish){
		let url = base_url("reports/sectors/all-sectors-barrio/"+idParish);
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
					let data = response.data;

					data.forEach(row => {
						var nuevaOpcion = $("<option>").val(row.id).text(row.name);
						$("#sectors").append(nuevaOpcion);
					});
				} else {
					toast(
						"bg-danger",
						response.message.title,
						response.message.message,
						1
					);

					$('.btn-close').click();
				}
			},
		});
	}

	function viewState(idState){
		let url = base_url("drawState/"+idState);

		$.ajax({
			type: "GET",
			url: url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type == "success") {

					mapaGenerate('states', drawMap, '#B22222', response.data);

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

	function viewCity(idState){
		let url = base_url("drawCity/"+idState);

		$.ajax({
			type: "GET",
			url: url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type == "success") {

					mapaGenerate('cities', drawMap, '#FF7F50', response.data);

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

	function viewParish(idState){
		let url = base_url("drawParish/"+idState);

		$.ajax({
			type: "GET",
			url: url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type == "success") {

					mapaGenerate('cities', drawMap, '#8C4966', response.data);

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

	function viewSector(idState){
		let url = base_url("drawSector/"+idState);

		$.ajax({
			type: "GET",
			url: url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (response.message.type == "success") {

					mapaGenerate('sectors', drawMap, response.data[0].color, response.data);

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

	function viewAllAlarm(idParish) {
		let url = base_url("reports/alarms/all-of-sector/"+idParish);
		$.ajax({
			type: "GET",
			url: url,
			success: function (answer) {
				let response = JSON.parse(answer);

				if (response.message.type == "success") {
					let sectors = response.data;
					let urlIcon = base_url('resources/src/img/logo.png');

					// Crea un nuevo ícono personalizado
					let icon = {
						url: urlIcon,
						scaledSize: new google.maps.Size(35, 40), // Tamaño del ícono (ajústalo según tus necesidades)
						origin: new google.maps.Point(0, 0), // Punto de origen del ícono
						anchor: new google.maps.Point(16, 32), // Punto de anclaje del ícono (ajústalo según el diseño del ícono)
					};

					sectors.forEach(row => {
						let markerAlarm = new google.maps.Marker({
							position: {lat: row.latitud*1, lng: row.longitud*1},
							map: drawMap,
							title: row.code,
							draggable: true,
						});

						markerAlarm.setIcon(icon);

						viewAlarm(row.id)
					});

					if(sectors.length > 0){
						markerInformation(sectors)
					}

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

	function viewAlarm(id) {
		let url = base_url("drawAlarm/"+id);
		$.ajax({
			type: "GET",
			url: url,
			success: function (answer) {
				let response = JSON.parse(answer);

				if (response.message.type == "success") {
					mapaGenerate('alarm', drawMap, '#024A86', response.data);
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

	function mapaGenerate(type, drawMap, color, coordenadas = "") {
		let base_url = $("input[name=baseUrl]").val();
		let url = `${base_url}/src/img/logo.png`;
		// Crea un nuevo ícono personalizado
		let icon = {
			url: url,
			scaledSize: new google.maps.Size(35, 40), // Tamaño del ícono (ajústalo según tus necesidades)
			origin: new google.maps.Point(0, 0), // Punto de origen del ícono
			anchor: new google.maps.Point(16, 32), // Punto de anclaje del ícono (ajústalo según el diseño del ícono)
		};

		if (type == "states") {
			if (coordenadas != "") {
				path = [];
				markers = [];
				polygon = "";

				let geo = JSON.parse(JSON.stringify(coordenadas));
				let cor = [];

				geo.forEach((row) => {
					cor.push({ lat: row.latitud * 1, lng: row.longitud * 1 });
				});

				polygon = new google.maps.Polygon({
					path: cor,
					strokeColor: color,
					strokeOpacity: 0.8,
					strokeWeight: 2,
					fillColor: color,
					fillOpacity: 0.2,
				});

				let centroid = getPolygonCentroid(cor);

				// Crea un marcador en el centroide del polígono
				let labelMarker = new google.maps.Marker({
					position: centroid,
					map: drawMap,
					label: {
						text: geo[0].name,
						color: "#251A1C",
						fontWeight: "bold",
						fontSize: "24px",
						labelOrigin: new google.maps.Point(0, -20),
					},
					icon: {
						url: "https://maps.google.com/mapfiles/transparent.png", // Imagen transparente para ocultar el marcador
						size: new google.maps.Size(1, 1), // Tamaño del icono del marcador (1x1 píxeles)
						anchor: new google.maps.Point(0, 0), // Punto de anclaje del icono del marcador
					},
				});
				labelMarker.setMap(drawMap);

				polygon.setMap(drawMap);
			} else {
				toast(
					"bg-danger",
					"Solicitud no aceptada",
					"El mapa que has solicitado no se puede encontrar",
					1
				);
			}
		} else if(type == 'cities'){
			if (coordenadas != "") {
				path = [];
				markers = [];
				polygon = "";

				let geo = JSON.parse(JSON.stringify(coordenadas));
				let cor = [];

				geo.forEach((row) => {
					cor.push({ lat: row.latitud * 1, lng: row.longitud * 1 });
				});

				polygon = new google.maps.Polygon({
					path: cor,
					strokeColor: color,
					strokeOpacity: 0.8,
					strokeWeight: 2,
					fillColor: color,
					fillOpacity: 0.2,
				});

				let centroid = getPolygonCentroid(cor);

				// Crea un marcador en el centroide del polígono
				let labelMarker = new google.maps.Marker({
					position: centroid,
					map: drawMap,
					label: {
						text: geo[0].name,
						color: "#251A1C",
						fontWeight: "bold",
						fontSize: "24px",
						labelOrigin: new google.maps.Point(0, -20),
					},
					icon: {
						url: "https://maps.google.com/mapfiles/transparent.png", // Imagen transparente para ocultar el marcador
						size: new google.maps.Size(1, 1), // Tamaño del icono del marcador (1x1 píxeles)
						anchor: new google.maps.Point(0, 0), // Punto de anclaje del icono del marcador
					},
				});
				labelMarker.setMap(drawMap);

				polygon.setMap(drawMap);
			} else {
				toast(
					"bg-danger",
					"Solicitud no aceptada",
					"El mapa que has solicitado no se puede encontrar",
					1
				);
			}
		} else if(type == 'parishes'){
			if (coordenadas != "") {
				path = [];
				markers = [];
				polygon = "";

				let geo = JSON.parse(JSON.stringify(coordenadas));
				let cor = [];

				geo.forEach((row) => {
					cor.push({ lat: row.latitud * 1, lng: row.longitud * 1 });
				});

				polygon = new google.maps.Polygon({
					path: cor,
					strokeColor: color,
					strokeOpacity: 0.8,
					strokeWeight: 2,
					fillColor: color,
					fillOpacity: 0.2,
				});

				let centroid = getPolygonCentroid(cor);

				// Crea un marcador en el centroide del polígono
				let labelMarker = new google.maps.Marker({
					position: centroid,
					map: drawMap,
					label: {
						text: geo[0].name,
						color: "#251A1C",
						fontWeight: "bold",
						fontSize: "24px",
						labelOrigin: new google.maps.Point(0, -20),
					},
					icon: {
						url: "https://maps.google.com/mapfiles/transparent.png", // Imagen transparente para ocultar el marcador
						size: new google.maps.Size(1, 1), // Tamaño del icono del marcador (1x1 píxeles)
						anchor: new google.maps.Point(0, 0), // Punto de anclaje del icono del marcador
					},
				});
				labelMarker.setMap(drawMap);

				polygon.setMap(drawMap);
			} else {
				toast(
					"bg-danger",
					"Solicitud no aceptada",
					"El mapa que has solicitado no se puede encontrar",
					1
				);
			}
		} else if(type == 'sectors'){
			if (coordenadas != "") {
				path = [];
				markers = [];
				polygon = "";

				let geo = JSON.parse(JSON.stringify(coordenadas));
				let cor = [];

				geo.forEach((row) => {
					cor.push({ lat: row.latitud * 1, lng: row.longitud * 1 });
				});

				polygon = new google.maps.Polygon({
					path: cor,
					strokeColor: color,
					strokeOpacity: 0.8,
					strokeWeight: 2,
					fillColor: color,
					fillOpacity: 0.2,
				});

				let centroid = getPolygonCentroid(cor);

				// Crea un marcador en el centroide del polígono
				let labelMarker = new google.maps.Marker({
					position: centroid,
					map: drawMap,
					label: {
						text: geo[0].name,
						color: "#251A1C",
						fontWeight: "bold",
						fontSize: "24px",
						labelOrigin: new google.maps.Point(0, -20),
					},
					icon: {
						url: "https://maps.google.com/mapfiles/transparent.png", // Imagen transparente para ocultar el marcador
						size: new google.maps.Size(1, 1), // Tamaño del icono del marcador (1x1 píxeles)
						anchor: new google.maps.Point(0, 0), // Punto de anclaje del icono del marcador
					},
				});
				labelMarker.setMap(drawMap);

				polygon.setMap(drawMap);
			} else {
				toast(
					"bg-danger",
					"Solicitud no aceptada",
					"El mapa que has solicitado no se puede encontrar",
					1
				);
			}
		} else if(type == 'alarm'){
			if (coordenadas != "") {
				path = [];
				markers = [];
				polygon = "";

				let geo = JSON.parse(JSON.stringify(coordenadas));
				let cor = [];

				geo.forEach((row) => {
					cor.push({ lat: row.latitud * 1, lng: row.longitud * 1 });
				});

				polygon = new google.maps.Polygon({
					path: cor,
					strokeColor: color,
					strokeOpacity: 0.8,
					strokeWeight: 2,
					fillColor: color,
					fillOpacity: 0.2,
				});

				let centroid = getPolygonCentroid(cor);

				// Crea un marcador en el centroide del polígono
				let labelMarker = new google.maps.Marker({
					position: centroid,
					map: drawMap,
					label: {
						text: geo[0].code,
						color: "#251A1C",
						fontWeight: "bold",
						fontSize: "24px",
						labelOrigin: new google.maps.Point(0, -20),
					},
					icon: {
						url: "https://maps.google.com/mapfiles/transparent.png", // Imagen transparente para ocultar el marcador
						size: new google.maps.Size(1, 1), // Tamaño del icono del marcador (1x1 píxeles)
						anchor: new google.maps.Point(0, 0), // Punto de anclaje del icono del marcador
					},
				});
				labelMarker.setMap(drawMap);

				polygon.setMap(drawMap);
			} else {
				toast(
					"bg-danger",
					"Solicitud no aceptada",
					"El mapa que has solicitado no se puede encontrar",
					1
				);
			}
		}else {
			toast(
				"bg-danger",
				"Solicitud no aceptada",
				"El mapa que has solicitado no se puede encontrar",
				1
			);

			path = [];
			markers = [];
			polygon = "";

			$("input[name=cords]").val("");

			drawMap = new google.maps.Map(document.getElementById("map"), {
				zoom: 17,
				center: coords,
			});
		}
	}

	// Función para mostrar la información del markador
	function markerInformation(data = []){
		let dataMarker = JSON.parse(JSON.stringify(data))
		let information = "";
		let base_url = $("input[name=baseUrl]").val();
		let url = `${base_url}/src/img/logo.png`;

		// Crea un nuevo ícono personalizado
		let icon = {
			url: url,
			scaledSize: new google.maps.Size(35, 40), // Tamaño del ícono (ajústalo según tus necesidades)
			origin: new google.maps.Point(0, 0), // Punto de origen del ícono
			anchor: new google.maps.Point(16, 32), // Punto de anclaje del ícono (ajústalo según el diseño del ícono)
		};

		dataMarker.forEach((row) => {
			information = `
				<h3>Información de la alarma</h3>
				<p><b>Código: ${row.code}</b></p>
				<p><b>Sector: ${row.sector}</b></p>

				<button type='button' data-bs-toggle='modal' sector='${row.sector}' sectorId='${row.id_sector}' data-bs-target='#updateModal' dataId='${row.id}' class='btnAlarmEdit btn btn-info'>Editar</button>
				<a class='btnInputHidden btnGetForId' dataId='${row.id}'></a>`
			if($("#sound").attr('active') == "true" && $("#sound").val() == row.id_sector){
				information +=`
					<button type='button' data-bs-toggle='modal' data-bs-target='#stopSoundAlarmModel' sectorId='${row.id_sector}' class='btn btn-success btnSoundAlarm'>Parar</button>
				`;
			}else{
				information +=`
					<button type='button' data-bs-toggle='modal' data-bs-target='#soundAlarmModel' sectorId='${row.id_sector}' class='btn btn-danger btnSoundAlarm'>Sonar</button>
				`;
			}

			var marker2 = new google.maps.Marker({
				position: { lat: row.latitud * 1, lng: row.longitud * 1 },
				map: drawMap,
				draggable:false,
				title: row.code,
			});
			var panelInformation = new google.maps.InfoWindow({
				content: information,
				pixelOffset: new google.maps.Size(0, -10)
			})
			// Establece el nuevo ícono personalizado en el marcador
			marker2.setIcon(icon);

			marker2.setMap(drawMap);
			markers.push(marker2);
			informationAlarms.push(panelInformation);

			marker2.addListener('click', function () {
				closeAllInfoWindows();
				panelInformation.open(drawMap, marker2);
			});

		})
	}

	function closeAllInfoWindows() {
      // Cierra todos los InfoWindows
      for (var i = 0; i < informationAlarms.length; i++) {
        informationAlarms[i].close();
      }
    }

	// Función para calcular el centroide de un polígono
	function getPolygonCentroid(coords) {
		var bounds = new google.maps.LatLngBounds();
		coords.forEach(function(point) {
			bounds.extend(point);
		});

		return bounds.getCenter();
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
			value: code,
			min: 1,
			max: 50,
			required: true,
		},

		{
			name: "managerE",
			type: "string",
			value: manager,
			min: 1,
			max: 50,
			required: true,
		},

		{
			name: "sectorE",
			type: "string",
			value: sector,
			min: 1,
			max: 50,
			required: true,
		},

		{
			name: "latitudeE",
			type: "string",
			value: latitude,
			min: 1,
			max: 22,
			required: true,
		},

		{
			name: "longitudeE",
			type: "string",
			value: longitude,
			min: 1,
			max: 22,
			required: true,
		},
	])

	if(value){
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
					$('.btn-model-close').trigger('click');
					$('#btnViewAll').trigger('click');
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

function ipm(){
	$.getJSON("https://ipapi.co/json",function(data){
		$("#ip").val(data.ip)
   },"json");
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
				alarmsCoord(response.data.id, 'view', "#1051D5", response.data.latitud*1, response.data.longitud*1);

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
	function newAlarmCords(id, x, color, latitude=0, longitude=0, name=''){
		let url = $("input[name=urlMap]").val() + "drawAlarm/" + id;
		var coords = { lat: latitude != 0 ? latitude : -0.9179301528102732, lng: longitude != 0 ? longitude : -78.63297106182672 };
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

		markerMap = new google.maps.Map(document.getElementById("mapLocationAlarmE"), {
			zoom: 17,
			center: coords,
		});

		if(x == 'view'){
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
				title: name != '' ? name : 'Mi marcador',
				draggable: true,
			});

			// Establece el nuevo ícono personalizado en el marcador
			markerAlarm.setIcon(icon);

			// Agrega el evento de arrastre al marcador
			google.maps.event.addListener(markerAlarm, 'dragend', function(event){
				// Verifica si la nueva posición del marcador está dentro del polígono
				if (!google.maps.geometry.poly.containsLocation(event.latLng, polygonMarker)) {
					  // Si la nueva posición está fuera del polígono, impide que el marcador se mueva allí
					  markerAlarm.setPosition(coords); // Devuelve el marcador a su posición original
				}else{
					$("#latitudeE").val(event.latLng.lat());
					$("#longitudeE").val(event.latLng.lng());
				}
			 });
		}
	}

	alarmsCoord = newAlarmCords;
}

$("#btnActiveAlarm").click(function (e) {
	e.preventDefault();
	if("geolocation" in navigator){
		let sector = $("#sound").val();
		let typeNot = $("#typeNot").val();
		let why = $("#why").val();
		let lat = '';
		let lng = '';

		navigator.geolocation.getCurrentPosition(function(position){
			lat = position.coords.latitude;
			lng = position.coords.longitude;

			let ip = $("#ip").val();

			let value = validate([
				{
					name: "sound",
					type: "string",
					value: sector,
					min: 1,
					max: 255,
					required: true,
				},
				{
					name: "typeNot",
					type: "string",
					value: typeNot,
					min: 1,
					max: 255,
					required: true,
				},
				{
					name: "why",
					type: "string",
					value: why,
					min: 1,
					max: 2000,
					required: true,
				},
				{
					name: "ip",
					type: "string",
					value: ip,
					min: 1,
					max: 15,
					required: true,
				},
			])

			if(value){
				const data = {
					sector,
					typeNot,
					ip,
					why,
					lat,
					lng
				}

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
							$('.btn-model-close').trigger('click');
							codeUser = $("input[name=codeUser]").val();
							user = $("input[name=nameUser]").val();
							enviar(codeUser, user, typeNot, why);
						} else {
							toast(
								"bg-danger",
								response.message.title,
								response.message.message,
								1
							);
							$("#sound").attr("active", "false");
						}
					}
				});
			}
		});

	}else{
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
	let sector = $("#sound").val();

	let value = validate([
		{
			name: "sound",
			type: "string",
			value: sector,
			min: 1,
			max: 255,
			required: true,
		},
	])

	if(value){
		const data = [
			sector
		]

		let url = $("input[name=url]").val() + "stopAlarm";
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
					$("#sound").attr("active", "false");
				} else {
					toast(
						"bg-danger",
						response.message.title,
						response.message.message,
						1
					);
					$("#sound").attr("active", "false");
				}
			}
		});
	}
});


