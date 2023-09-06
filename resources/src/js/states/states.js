
getRegister();

async function suspend() {
	let id = $("input[name=id]").val();

	const data = {
		id,
	};

	let url = $("input[name=url]").val() + "states/suspend";
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

async function active() {
	let id = $("input[name=id]").val();
	const data = {
		id,
	};

	let url = $("input[name=url]").val() + "states/active";

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

async function deleted() {
	let id = $("input[name=id]").val();

	const data = {
		id,
	};

	let url = $("input[name=url]").val() + "states/delete";
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

async function update() {
	let id = $("input[name=id]").val();
	let name = $("#nameE").val();
	let country = $("#countryE").val();

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
			name: "countryE",
			type: "string",
			value: country,
			min: 1,
			max: 255,
			required: true,
		},
	]);

	if (value) {
		const data = {
			id,
			name,
			country,
		};

		let url = $("input[name=url]").val() + "states/update";
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

async function create() {
	let name = $("#name").val();
	let country = $("#country").val();

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
			name: "country",
			type: "string",
			value: country,
			min: 1,
			max: 255,
			required: true,
		},
	]);

	if (value) {
		const data = {
			name,
			country,
		};

		let url = $("input[name=url]").val() + "states/crear";
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
					$(".btn-close").trigger("click");
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

async function getForId() {
	let id = $("input[name=id]").val();

	let url = $("input[name=url]").val() + "states/" + id;
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
				$("#countryE").val(response.data.id_countries);
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

				$(".btn-close").click();
			}
		},
	});
}

async function getRegister() {
	let urlSearch = $("input[name=searchGlobal]").attr("url");
	if (urlSearch != "") {
		paginator(1);
	}
}

async function initMap() {
	let path = [];
	let coords = { lat: -0.9179301528102732, lng: -78.63297106182672 };
	let drawMap = "";
	var myPolygon = '';

	$("#bodyTable").on("click", ".btnDrawMap", function (e) {
		e.preventDefault();
		$("input[name=idInstitution]").val($(this).attr("dataIdC"));
		drawingPolygon();
	});

	// BUTTON SAVE DRAW
	$("#btnSaveDraw").click(function (e) {
		e.preventDefault();
		saveDraw();
	});

	$("#bodyTable").on("click", ".btnGetDraw", function (e) {
		e.preventDefault();
		$("input[name=idInstitution]").val($(this).attr("dataIdC"));
		viewDrawOnMap();
	});

	async function saveDraw() {
		await getPolygonCoords();
		let id = $("input[name=id]").val();
		const data = {
			id,
			cords: JSON.stringify(path),
		};

		let url = $("input[name=url]").val() + "drawState";
		await $.ajax({
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

	async function viewDrawOnMap() {
		let id = $("input[name=id").val();
		let url = base_url("drawState/" + id);
		drawMap = new google.maps.Map(document.getElementById("viewMap"), {
			zoom: 9,
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
						"bg-success",
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

	async function drawingPolygon() {
		path = [];
		let id = $("input[name=id").val();
		let url = base_url("drawState/" + id);
		drawMap = new google.maps.Map(document.getElementById("map"), {
			center: coords,
			zoom: 9,
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

		var defaultPolygon = [
			new google.maps.LatLng(-1.043717, -78.991608),
			new google.maps.LatLng(-0.936924, -78.556261),
			new google.maps.LatLng(-0.686314, -78.796489),
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
					console.log(polygon)
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

		// console.log(path.length);

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
