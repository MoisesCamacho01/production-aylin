getRegister();
var alarmsCoord
var alarmId

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
			value: code,
			min: 1,
			max: 50,
			required: true,
		},

		{
			name: "manager",
			type: "string",
			value: manager,
			min: 1,
			max: 50,
			required: true,
		},

		{
			name: "sector",
			type: "string",
			value: sector,
			min: 1,
			max: 50,
			required: true,
		},

		{
			name: "latitude",
			type: "string",
			value: latitude,
			min: 1,
			max: 22,
			required: true,
		},

		{
			name: "longitude",
			type: "string",
			value: longitude,
			min: 1,
			max: 22,
			required: true,
		},
	])

	if(value){
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
					$("#code").val('');
					$("#manager").val('');
					$("#latitude").val('');
					$("#longitude").val('');
					$('.btn-model-close').trigger('click');
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

function initMap() {
	let path = [];
	let markers = []; // array para almacenar los marcadores
	let polygon = "";
	let coords = { lat: -0.9179301528102732, lng: -78.63297106182672 };
	let polygons = [];
	let drawMap = "";
	var polygonMarker = "";

	$("#bodyTable").on("click", ".btnDrawMap", function (e) {
		e.preventDefault();
		viewAll();
	});

	// BUTTON SAVE DRAW
	$("#btnSaveDraw").click(function (e) {
		e.preventDefault();
		saveDraw();
	});

	$("#bodyTable").on("click", ".btnGetDraw", function (e) {
		e.preventDefault();
		viewAll("view");
	});

	//BUTTON NEW ALARM
	$("#btnNewAlarm").click(function (e) {
		e.preventDefault();
		newAlarmCords('','new');
	});

	function getDraw(type, drawMap) {
		let id = $("input[name=id").val();
		let url = $("input[name=url]").val() + "drawAlarm/" + id;
		$.ajax({
			type: "GET",
			url: url,
			success: function (answer) {
				let response = JSON.parse(answer);
				if (
					response.message.type == "success" &&
					response.data[0].longitud != null
				) {
					toast(
						"bg-success",
						response.message.title,
						response.message.message,
						1
					);
					mapaGenerate(type, drawMap, response.data);
					centerMap(response.data);
				} else {
					if (type == "view") {
						mapaGenerate("no", drawMap);
					} else {
						toast(
							"bg-info",
							response.message.title,
							"No existe un mapa puedes dibujar uno",
							1
						);
						mapaGenerate("draw", drawMap, '#251A1C');
					}
				}
			},
		});
	}

	function saveDraw() {
		updatePath();
		let id = $("input[name=id]").val();
		let cords = $("input[name=cords]").val();
		const data = {
			id,
			cords,
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

	function mapaGenerate(type, drawMap, coordenadas = "") {
		let marker = "";
		let base_url = $("input[name=baseUrl]").val();
		let url = `${base_url}/src/img/logo.png`;

		// Crea un nuevo ícono personalizado
		let icon = {
			url: url,
			scaledSize: new google.maps.Size(35, 40), // Tamaño del ícono (ajústalo según tus necesidades)
			origin: new google.maps.Point(0, 0), // Punto de origen del ícono
			anchor: new google.maps.Point(16, 32), // Punto de anclaje del ícono (ajústalo según el diseño del ícono)
		};

		if (type == "draw") {
			path = [];
			markers = [];
			polygon = "";
			$("input[name=cords]").val("");

			marker = new google.maps.Marker({
				position: coords,
				map: drawMap,
				draggable: true,
			});

			// Establece el nuevo ícono personalizado en el marcador
			marker.setIcon(icon);

			path.push(marker.getPosition());

			marker.setMap(drawMap);
			markers.push(marker); // agregamos el primer marcador al array

			addMarker(icon); // add Marker with a click
			asignarManejadorClicDerecho();

			let color = typeof coordenadas === "string" ? coordenadas : "#FE1246";

			polygon = new google.maps.Polygon({
				path: path,
				strokeColor: color,
				strokeOpacity: 0.8,
				strokeWeight: 2,
				fillColor: color,
				fillOpacity: 0.16,
			});

			polygon.setMap(drawMap);
		} else if (type == "edit") {
			if (coordenadas != "") {
				path = [];
				markers = [];
				polygon = "";
				$("input[name=cords]").val("");

				let geo = JSON.parse(JSON.stringify(coordenadas));
				let color =
					typeof geo[0].color === "string" ? geo[0].color : "#FE1246";

				geo.forEach((row) => {
					marker = new google.maps.Marker({
						position: { lat: row.latitud * 1, lng: row.longitud * 1 },
						map: drawMap,
						draggable: true,
					});
					marker.setIcon(icon);
					path.push(marker.getPosition());
					marker.setMap(drawMap);
					markers.push(marker);

				});

				addMarker(icon); // add Marker with a click
				asignarManejadorClicDerecho();

				polygon = new google.maps.Polygon({
					path: path,
					strokeColor: color,
					strokeOpacity: 0.8,
					strokeWeight: 2,
					fillColor: color,
					fillOpacity: 0.2,
				});

				polygon.setMap(drawMap);

				// OnPositionPolygon()
			} else {
				toast(
					"bg-danger",
					"Solicitud no aceptada",
					"El mapa que has solicitado no se puede encontrar",
					1
				);
			}
		} else if (type == "view") {
			if (coordenadas != "") {
				path = [];
				markers = [];
				polygon = "";
				$("input[name=cords]").val("");

				let geo = JSON.parse(JSON.stringify(coordenadas));
				let color =
					typeof geo[0].color === "string" ? geo[0].color : "#FE1246";

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

				polygon.setMap(drawMap);
			} else {
				toast(
					"bg-danger",
					"Solicitud no aceptada",
					"El mapa que has solicitado no se puede encontrar",
					1
				);
			}
		} else {
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

	function addMarker(icon){

		// add new marker on map click
		google.maps.event.addListener(polygonMarker, "click", function (event) {
			let newMarker = new google.maps.Marker({
				position: event.latLng,
				map: drawMap,
				draggable: true,
			});
			newMarker.setIcon(icon);
			newMarker.setMap(drawMap);
			markers.push(newMarker); // agregamos el nuevo marcador al array
			updatePath();
			asignarManejadorClicDerecho();
		});
	}

	function asignarManejadorClicDerecho() {
		console.log("m = "+markers.length);
		markers.forEach(function (marker) {
			// inicial
			google.maps.event.addListener(marker, "mousedown", function () {
				var originalPosition;
				// Guardar la posición original del marcador antes de permitirle moverse
				originalPosition = marker.getPosition();
				localStorage.setItem("marker", markers.indexOf(this));
				localStorage.setItem("lat", originalPosition.lat());
				localStorage.setItem("lng", originalPosition.lng());
			});

			google.maps.event.addListener(marker, "rightclick", function () {
				// Eliminar el marcador
				marker.setMap(null);
				// Eliminar el marcador de la matriz de marcadores
				var index = markers.indexOf(marker);
				if (index !== -1) {
					markers.splice(index, 1);
				}
				updatePath();
			});

			google.maps.event.addListener(marker, "dragend", function (event) {
				updatePath();
			});
		});
	}

	function updatePath() {
		// asignarManejadorClicDerecho();
		// console.log(`up ${markers.length}`)
		path = markers.map(function (marker) {
			return marker.getPosition();
		});
		polygon.setPaths(path);
		// noTocarPoligono();
		setPath();
	}

	function setPath() {
		$("input[name=cords]").val(JSON.stringify(path));
	}

	// SECTORES
	function viewAll(type = "edit") {
		let id = $("input[name=id").val();
		let idI = $("input[name=idInstitution").val();
		let url =
			$("input[name=url]").val() +
			"reports/alarms/all-of-sector/" +
			idI;

		drawMap = new google.maps.Map(
			document.getElementById(type == "view" ? "viewMap" : "map"),
			{
				zoom: 16,
				center: coords,
			}
		);

		viewFather(idI, drawMap)
		$.ajax({
			type: "GET",
			url: url,
			success: function (answer) {
				let response = JSON.parse(answer);

				if (response.message.type == "success") {
					let sectors = response.data;
					let urlIcon = type != "view" ? base_url('resources/src/img/logo-white.png') : base_url('resources/src/img/logo.png');

					// Crea un nuevo ícono personalizado
					let icon = {
						url: urlIcon,
						scaledSize: new google.maps.Size(35, 40), // Tamaño del ícono (ajústalo según tus necesidades)
						origin: new google.maps.Point(0, 0), // Punto de origen del ícono
						anchor: new google.maps.Point(16, 32), // Punto de anclaje del ícono (ajústalo según el diseño del ícono)
					};

					let markerAlarm = "";

					sectors.forEach((row) => {
						let coords2= { lat: row.latitud*1, lng: row.longitud*1};

						if (row.id != id && type != "view") {
							getDrawOtherSectors(row.id, '#43443', row.code, drawMap);
						} else if (type == "view") {
							let idState = $("input[name=id").val();
							if(idState == row.id){
								getDraw(type, drawMap);
								// Crea el marcador
								markerAlarm = new google.maps.Marker({
									position: coords2,
									map: drawMap,
									title: row.code,
									draggable: false,
								});

								markerAlarm.setIcon(icon);
							}
						} else {
							// Crea el marcador
							markerAlarm = new google.maps.Marker({
								position: coords2,
								map: drawMap,
								title: row.code,
								draggable: false,
							});

							markerAlarm.setIcon(icon);
							getDraw(type, drawMap);
						}
					});
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

	function viewFather(id, drawMap){
		let url = base_url("drawSector/"+id);

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
						strokeColor: response.data[0].color,
						strokeOpacity: 0.8,
						strokeWeight: 2,
						fillColor: response.data[0].color,
						fillOpacity: 0.2,
					});

					polygonMarker.setMap(drawMap);

					var polygonArea = google.maps.geometry.spherical.computeArea(polygonMarker.getPath());
					var fontSize = Math.sqrt(polygonArea) / 20;

					let centroid = getPolygonCentroid(cor);

					// Crea un marcador en el centroide del polígono
					let labelMarker = new google.maps.Marker({
					  position: centroid,
					  map: drawMap,
					  label: {
						text: geo[0].name,
						color: "#251A1C",
						fontWeight: 'bold',
						fontSize: fontSize.toString()+"px",
						labelOrigin: new google.maps.Point(0, -20)
					  },
					  icon: {
						url: 'https://maps.google.com/mapfiles/transparent.png', // Imagen transparente para ocultar el marcador
						size: new google.maps.Size(1, 1), // Tamaño del icono del marcador (1x1 píxeles)
						anchor: new google.maps.Point(0, 0) // Punto de anclaje del icono del marcador
					 }
					});

					labelMarker.setMap(drawMap);
				}
			},
		});
	}

	// ver todos los sectores excepto el que estamos editando
	function getDrawOtherSectors(id, color, name, drawMap) {
		let url = $("input[name=url]").val() + "drawAlarm/" + id;
		$("input[name=cords]").val("");

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

					let polygon2 = new google.maps.Polygon({
						path: cor,
						strokeColor: color,
						strokeOpacity: 0.8,
						strokeWeight: 2,
						fillColor: color,
						fillOpacity: 0.2,
					});

					polygon2.setMap(drawMap);

					let polygonArea = google.maps.geometry.spherical.computeArea(polygon2.getPath());
					let fontSize = Math.sqrt(polygonArea) / 1.5;

					let centroid = getPolygonCentroid(cor);

					// Crea un marcador en el centroide del polígono
					let labelMarker = new google.maps.Marker({
						position: centroid,
						map: drawMap,
						label: {
							text: name,
							color: "#251A1C",
							fontWeight: "bold",
							fontSize: fontSize.toString()+"px",
							labelOrigin: new google.maps.Point(0, -20),
						},
						icon: {
							url: "https://maps.google.com/mapfiles/transparent.png", // Imagen transparente para ocultar el marcador
							size: new google.maps.Size(1, 1), // Tamaño del icono del marcador (1x1 píxeles)
							anchor: new google.maps.Point(0, 0), // Punto de anclaje del icono del marcador
						},
					});
					labelMarker.setMap(drawMap);
					// polygons.push(polygon2);
				}
			},
		});
	}

	// Función para calcular el centroide de un polígono
	function getPolygonCentroid(coords) {
		var bounds = new google.maps.LatLngBounds();
		coords.forEach(function(point) {
			bounds.extend(point);
		});

		return bounds.getCenter();
	}

	function getAlarmId(idI, id){
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

					alarmsCoord(id, 'view', '#251A1C', response.data.latitud*1, response.data.longitud*1, response.data.code);
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

	function centerMap(coords){
		let cor = [];
		coords.forEach((row) => {
			cor.push({ lat: row.latitud * 1, lng: row.longitud * 1 });
		});
		let centroid = getPolygonCentroid(cor);
		drawMap.setCenter(centroid);
	}

	function newAlarmCords(id, x, color = '#1051D5', latitude=0, longitude=0, name='', nameMap=''){
		let url =  base_url("drawAlarm/"+id);
		var coords = { lat: latitude != 0 ? latitude : -0.9179301528102732, lng: longitude != 0 ? longitude : -78.63297106182672 };
		var markerAlarm = "";
		let urlIcon = base_url('resources/src/img/logo.png');

		let idI = $("input[name=idInstitution").val();

		// Crea un nuevo ícono personalizado
		let icon = {
			url: urlIcon,
			scaledSize: new google.maps.Size(35, 40), // Tamaño del ícono (ajústalo según tus necesidades)
			origin: new google.maps.Point(0, 0), // Punto de origen del ícono
			anchor: new google.maps.Point(16, 32), // Punto de anclaje del ícono (ajústalo según el diseño del ícono)
		};

		if(x == 'new'){
			let mapa = (nameMap != 'map') ? "mapLocationAlarm" : 'map';

			drawMap = new google.maps.Map(document.getElementById(mapa), {
				zoom: 17,
				center: coords,
			});

			viewFather(idI, drawMap)
			// Crea el marcador
			markerAlarm = new google.maps.Marker({
				position: coords,
				map: drawMap,
				title: name != '' ? name : 'Mi marcador',
				draggable: true,
			});

			markerAlarm.setIcon(icon);

			google.maps.event.addListener(markerAlarm, 'dragend', function(event){
				$("#latitude").val(event.latLng.lat());
				$("#longitude").val(event.latLng.lng());
			})

			// Agrega el evento de arrastre al marcador
			google.maps.event.addListener(markerAlarm, 'dragend', function(event){
				// Verifica si la nueva posición del marcador está dentro del polígono
				if (!google.maps.geometry.poly.containsLocation(event.latLng, polygonMarker)) {
					// Si la nueva posición está fuera del polígono, impide que el marcador se mueva allí
					markerAlarm.setPosition(coords); // Devuelve el marcador a su posición original
					toast(
						"bg-warning",
						"Ubicar alarma",
						"No se puede ubicar la alarma fuera de su barrio",
						1
					);
				}else{
					$("#latitudeE").val(event.latLng.lat());
					$("#longitudeE").val(event.latLng.lng());
				}
			 });
		}else if(x == 'view'){

			let mapa = (nameMap != 'map') ? "mapLocationAlarmE" : 'map';
			drawMap = new google.maps.Map(document.getElementById(mapa), {
				zoom: 19,
				center: coords,
			});

			viewFather(idI, drawMap)
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

						polygonMarker.setMap(drawMap);
					}
				},
			});

			// Crea el marcador
			markerAlarm = new google.maps.Marker({
				position: coords,
				map: drawMap,
				title: name != '' ? name : 'Mi marcador',
				draggable: nameMap != 'map' ? true : false,
			});

			markerAlarm.setIcon(icon);

			// Agrega el evento de arrastre al marcador
			google.maps.event.addListener(markerAlarm, 'dragend', function(event){
				// Verifica si la nueva posición del marcador está dentro del polígono
				if (!google.maps.geometry.poly.containsLocation(event.latLng, polygonMarker)) {
					  // Si la nueva posición está fuera del polígono, impide que el marcador se mueva allí
					  markerAlarm.setPosition(coords); // Devuelve el marcador a su posición original
					  toast(
						"bg-info",
						"Ubicar alarma",
						"Para reubicar la alarma tienes que modificar el sonido antes",
						1
					);
				}else{
					$("#latitudeE").val(event.latLng.lat());
					$("#longitudeE").val(event.latLng.lng());
				}
			 });
		}
	}

	alarmsCoord = newAlarmCords;
	alarmId = getAlarmId;


}

