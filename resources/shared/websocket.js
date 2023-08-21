var socket = io.connect('https://alarm-socketio.up.railway.app/', {
    'forceNew': true,
})

//https://alarm-socketio.onrender.com/

socket.on('message', function(data){
	if(data.code != ''){
		message(data)
	}
})

function message(data) {
	var arr = JSON.parse(JSON.stringify(data))
	if(arr.idType != ""){
		toast(
			"bg-danger",
			"ALERTA: "+arr.idType,
			arr.idUser+":\n"+arr.message,
			1
		);
	}
}

function enviar(id, user, type, sector, msm){
	var msm = {
		 code:id,
		 User:user,
		 Type:type,
		 Sector:sector,
		 message: msm,
	}
	socket.emit('new-message', msm);
	return false;
}
