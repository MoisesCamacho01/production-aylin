getRegister();

function suspend() {
	let id = $("input[name=id]").val();

	const data = {
		id,
	};

	let url = $("input[name=url]").val() + "cities/suspend";
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

function active() {
	let id = $("input[name=id]").val();

	const data = {
		id,
	};

	let url = $("input[name=url]").val() + "cities/active";
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

function deleted() {
	let id = $("input[name=id]").val();

	const data = {
		id,
	};

	let url = $("input[name=url]").val() + "cities/delete";
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

function update() {
	let id = $("input[name=id]").val();
	let name = $("#nameE").val();
	let states = $("#statesE").val();

	let value = validate([
		{
			name: "nameE",
			type: "text",
			value: name,
			min: 1,
			max: 50,
			required: true,
		},

		{
			name: "statesE",
			type: "string",
			value: states,
			min: 1,
			max: 50,
			required: true,
		},
	]);

	if(value){
		const data = {
			id,
			name,
			states,
		};

		let url = $("input[name=url]").val() + "cities/update";
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
	let states = $("#states").val();

	let value = validate([
		{
			name: "name",
			type: "text",
			value: name,
			min: 1,
			max: 50,
			required: true,
		},

		{
			name: "states",
			type: "string",
			value: states,
			min: 1,
			max: 50,
			required: true,
		},
	]);

	if(value){
		const data = {
			name,
			states,
		};

		let url = $("input[name=url]").val() + "cities/crear";
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
					$("#name").val('');
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

function getForId(){
	let id = $("input[name=id]").val();

	let url = $("input[name=url]").val() + "cities/"+id;
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

				$('#nameE').val(response.data.name);
				$('#statesE').val(response.data.state);
				$('#countriesE').val(response.data.country);
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

				$('.btn-close').click();
			}
		},
	});
}

function getRegister(){
	let urlSearch = $('input[name=searchGlobal]').attr('url');
	if(urlSearch!=''){
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
		$("input[name=idInstitution]").val($(this).attr('dataIdC'))
		viewAll();
	});

	// BUTTON SAVE DRAW
	$("#btnSaveDraw").click(function (e) {
		e.preventDefault();
		saveDraw();
	});

	$("#bodyTable").on("click", ".btnGetDraw", function (e) {
		e.preventDefault();
		$("input[name=idInstitution]").val($(this).attr('dataIdC'))
		viewAll("view");
	});

	function getDraw(type, drawMap) {
		let id = $("input[name=id").val();
		let url = $("input[name=url]").val() + "drawCity/" + id;
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
						mapaGenerate("draw", drawMap, response.data[0].color);
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

		let url = $("input[name=url]").val() + "drawCity";
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

	function noTocarPoligono() {
		let positionAnterior = "";

		markers.forEach(function (marker) {
			for (let i = 0; i < polygons.length; i++) {
				if (polygons[i] instanceof google.maps.Polygon) {
					var polygonCoords = polygons[i].getPath().getArray(); // Obtenemos las coordenadas del polígono no editable
					var tempPolygon = new google.maps.Polygon({
						paths: polygonCoords,
					}); // Creamos un polígono temporal
					if (
						google.maps.geometry.poly.containsLocation(
							marker.getPosition(),
							tempPolygon
						)
					) {
						// Si el marcador no está en el borde del polígono no editable, entonces está dentro
						toast(
							"bg-warning",
							"Dibujar Sector",
							"No se puede dibujar un sector encima de otro",
							1
						);
						positionAnterior = {
							lat: localStorage.getItem("lat") * 1,
							lng: localStorage.getItem("lng") * 1,
						};
						marker.setAnimation(null);
						marker.setPosition(positionAnterior);
						updatePath();
						return;
					}
				}
			}
		});
	}

	function addMarker(icon){
		// CLICK in map
		google.maps.event.addListener(drawMap, "click", function () {
			toast(
				"bg-warning",
				"Dibujar parroquia",
				"No se puede dibujar una parroquia fuera de su cantón",
				1
			);
		});

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

	function OnPositionPolygon(){
		var isIntersecting = false;

		for (let i = 0; i < polygons.length; i++) {
			let poligono = polygons[i];
			poligono.getPath().forEach(function(vertex) {
				if (google.maps.geometry.poly.containsLocation(vertex, polygon)) {
					isIntersecting = true;
				}
			});

			if(isIntersecting){
				break;
			}
		}

		if (isIntersecting) {
			toast(
				"bg-warning",
				"Dibujar Sector",
				"No se puede dibujar una parroquia encima de otro",
				1
			);
		}

		return isIntersecting;
	}

	function asignarManejadorClicDerecho() {

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
				// updatePath();
				// Verifica si la nueva posición del marcador está dentro del polígono
				if (!google.maps.geometry.poly.containsLocation(event.latLng, polygonMarker)) {
					// Si la nueva posición está fuera del polígono, impide que el marcador se mueva allí
					// Devuelve el marcador a su posición original
					let marcador = markers[localStorage.getItem('marker')*1];
					// Modificar la posición del último marcador
					marcador.setPosition(new google.maps.LatLng((localStorage.getItem("lat")*1), (localStorage.getItem("lng")*1)));
					updatePath();
					toast(
						"bg-warning",
						"Dibujar parroquia",
						"No se puede dibujar una fuera de su cantón",
						1
					);

				}

				if(OnPositionPolygon()){
					if (markers.length > 0) {
						// Obtener el último marcador del arreglo
						let marcador = markers[localStorage.getItem('marker')*1];
						// Modificar la posición del último marcador
						marcador.setPosition(new google.maps.LatLng((localStorage.getItem("lat")*1), (localStorage.getItem("lng")*1)));
						updatePath();

					}
				}

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
		noTocarPoligono();
		// console.log(`ot ${OnPositionPolygon()}`)
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
			"reports/cities/all-city-state/" +
			idI;

		drawMap = new google.maps.Map(
			document.getElementById(type == "view" ? "viewMap" : "map"),
			{
				zoom: 10,
				center: coords,
			}
		);
		$.ajax({
			type: "GET",
			url: url,
			success: function (answer) {
				let response = JSON.parse(answer);

				if (response.message.type == "success") {
					let sectors = response.data;
					sectors.forEach((row) => {
						if (row.id != id && type != "view") {
							getDrawOtherSectors(row.id, '#43443', row.name, drawMap);
						} else if (type == "view") {
							let idState = $("input[name=id").val();
							if(idState == row.id){
								getDraw(type, drawMap);
							}
						} else {
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

		viewFather(idI, drawMap);
	}

	function viewFather(id, drawMap){
		let url = base_url("drawState/"+id);

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
					var fontSize = Math.sqrt(polygonArea) / 700;

					let centroid = getPolygonCentroid(cor);

					// Crea un marcador en el centroide del polígono
					let labelMarker = new google.maps.Marker({
					  position: centroid,
					  map: drawMap,
					  label: {
						text: response.data[0].name,
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
		let url = $("input[name=url]").val() + "drawCity/" + id;
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

					let centroid = getPolygonCentroid(cor);

					// Crea un marcador en el centroide del polígono
					let labelMarker = new google.maps.Marker({
						position: centroid,
						map: drawMap,
						label: {
							text: name,
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
					polygons.push(polygon2);
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
}
