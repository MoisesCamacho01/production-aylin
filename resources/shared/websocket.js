var socket = io.connect('https://alarm-socketio.onrender.com/', {
    'forceNew': true,
})

//https://alarm-socketio.onrender.com/

socket.on('message', function(data){
	message(data)
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
