var socket = io.connect('https://alarm-socketio.up.railway.app/', {
    'forceNew': true,
})
// var socket = io.connect('http://localhost:7000/', {
//     'forceNew': true,
// })

//https://alarm-socketio.onrender.com/

socket.on('message', function(data){
	if(data.code != ''){
		message(data)
	}
})

function message(data) {
	var arr = JSON.parse(JSON.stringify(data))
	console.log(arr);
	if(arr.Type != ""){
		toast(
			"bg-danger",
			"ALERTA: "+arr.Type,
			"USUARIO: "+arr.User+" \n MENSAJE: \n"+arr.message+" \n SECTOR: "+arr.nameSector,
			1
		);
	}
}

function enviar(id, user, type, sector, sectorName, msm){
	var msm = {
		 code:id,
		 User:user,
		 Type:type,
		 Sector:sector,
		 nameSector: sectorName,
		 message: msm,
	}
	socket.emit('new-message', msm);
	return false;
}
