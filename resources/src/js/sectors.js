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

function initMap() {
	let path = [];
	let coords = { lat: -0.9179301528102732, lng: -78.63297106182672 };
	let drawMap = "";
	var myPolygon = '';
	var borrado = 0;

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
}
