var usuarioRecibeActual = null;
var totalTemp = null;
var totalInicial = null;

function onLoad(){
	submit = document.getElementById("submit");
	submit.disabled = true;
}

function ocultarForm(){
	if(!(document.getElementById("formConversacion").classList.contains("invisible"))){		
		document.getElementById("formConversacion").classList.add("invisible");
	}
}

function goBack(){
	window.history.back();
}

function goInicio(){
	window.location.href = "index.html";
}

function checkCoincidence(){
	pass = document.getElementById("pass");
	pass2 = document.getElementById("pass2");
	warning = document.getElementById("warning");

	if(pass.value.length > 0 || pass2.value.length > 0){
		if(pass.value == pass2.value){
			if(warning.classList.contains("font-red")){
				warning.classList.remove("font-red")
			}
			warning.classList.add("font-green");
			warning.innerHTML = "Las contraseñas coinciden";
			document.getElementById("submit").disabled = false;
		}else{
			if(warning.classList.contains("font-green")){
				warning.classList.remove("font-green")
			}
			warning.classList.add("font-red");
			warning.innerHTML = "Las contraseñas no coinciden";
			document.getElementById("submit").disabled = true;
		}
	}
}

function notificar(){
    if(!window.Notification){
        console.log('El navegador no acepta notificaciones.');
    }else{
        // Checkear si se tienen permisos------------
        if(Notification.permission === 'granted'){
            // show notification here
            console.log('Hay permiso para mostrar notificaciones');
        }else{
            // Pedir permiso a usuario------------
            Notification.requestPermission().then(function (p) {
                if(p === 'granted'){
                    // show notification here
                    console.log('Permiso para mostrar notificaciones.');
                }else{
                    console.log('El usuario no acepta notificaciones.');
                }
            }).catch(function (err) {
                console.error(err);
            });
        }
    }
}

function enviarMensaje(){
	var mensaje = document.getElementById("mensaje").value;
	var usuarioRecibe = document.getElementById("usuarioRecibe").value;
	const http = new XMLHttpRequest();
	const url = 'http://urlejemplo/php/enviar-mensaje.php';

	http.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			if(!this.response){
				alert("Verificá los datos ingresados!");
			}else{
				alert("Mensaje enviado!");
				window.location.href = "http://urlejemplo/home.php";
			}	
		}else{
			console.log(this.readyState +" "+ this.status);
		}
	}

	http.open("POST", url);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.send('mensaje='+mensaje+'&usuarioRecibe='+usuarioRecibe);
}

function enviarMensajeConversacion(){
	var mensaje = document.getElementById("mensajeConversacion").value;
	const http = new XMLHttpRequest();
	const url = 'http://urlejemplo/php/enviar-mensaje-conversacion.php';

	http.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			if(!this.response){
				alert("Verificá los datos ingresados!");
			}else{
				document.getElementById("conversacion").innerHTML = this.response;
				document.getElementById("mensajeConversacion").value = null;
				document.getElementById('finalConversacion').scrollIntoView();
				if(document.getElementById("formConversacion").classList.contains("invisible")){		
					document.getElementById("formConversacion").classList.remove("invisible");
				}
			}	
		}else{
			console.log(this.readyState +" "+ this.status);
		}
	}

	http.open("POST", url);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.send('mensaje='+mensaje+'&usuarioRecibe='+usuarioRecibeActual);
}

function mostrarConversaciones(){
	const http = new XMLHttpRequest();
	const url = 'http://urlejemplo/php/on-load.php';
	
	http.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById("conversaciones").innerHTML += this.response;
		}else{
			console.log(this.readyState+" "+this.status);
		}
	}
	http.open("GET", url);
	http.send();
}

function abrirConversacion(usuarioRecibe){
	let regexComillas = /\"/g;
	let regexEspacios = /\s+/g;
	let conversacionComillasSimples = document.getElementById("conversacion").innerHTML.replace(regexComillas,"\'");
	let conversacion = conversacionComillasSimples.replace(regexEspacios, '');
	const http = new XMLHttpRequest();
	const url = 'http://urlejemplo/php/abrir-conversacion.php';

	http.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			let respuesta = this.response.replace(regexEspacios, '');
			if(!(conversacion === respuesta)){
					console.log(conversacion +"//"+ respuesta);
					document.getElementById("conversacion").innerHTML = this.response;
					document.getElementById('finalConversacion').scrollIntoView();
				if(document.getElementById("formConversacion").classList.contains("invisible")){		
					document.getElementById("formConversacion").classList.remove("invisible");
				}
			}
		}else{
			console.log(this.readyState+" "+this.status);
		}
	}
	http.open("POST", url);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.send('usuarioRecibe='+usuarioRecibe);
	usuarioRecibeActual = usuarioRecibe;
}

function mostrarInformacion(){
	const http = new XMLHttpRequest();
	const url = 'http://urlejemplo/php/mostrar-informacion.php';

	http.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById("informacion").innerHTML = this.response;
		}else{
			console.log(this.readyState+" "+this.status);
		}
	}
	http.open("GET", url);
	http.send();	
}

function mostrarImagenPerfil(){
	const http = new XMLHttpRequest();
	const url = 'http://urlejemplo/php/mostrar-imagen-perfil.php';

	http.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById("imagenPerfil").innerHTML += this.response;
		}else{
			console.log(this.readyState+" "+this.status);
		}
	}
	http.open("GET", url);
	http.send();	
}

function almacenarUsuario(){
	document.getElementById("formTituloConversacion").submit();
}

function almacenarUsuarioBuscar($form){
	document.getElementById($form).submit();
}

function mostrarInfoUsuario(){
	const http = new XMLHttpRequest();
	const url = 'http://urlejemplo/php/mostrar-info-usuario.php';

	http.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById("informacion").innerHTML = this.response;
		}else{
			console.log(this.readyState+" "+this.status);
		}
	}
	http.open("GET", url);
	http.send();	
}

function mostrarImagenUsuario(){
	const http = new XMLHttpRequest();
	const url = 'http://urlejemplo/php/mostrar-imagen-usuario.php';

	http.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById("imagenPerfil").innerHTML += this.response;
		}else{
			console.log(this.readyState+" "+this.status);
		}
	}
	http.open("GET", url);
	http.send();	
}

function eliminarUsuarioAlmacenado(){
	document.getElementById("navForm").submit();
}

function buscarUsuarios(){
	var usuarioABuscar = document.getElementById("usuarioABuscar").value;
	const http = new XMLHttpRequest();
	const url = 'http://urlejemplo/php/buscar-usuarios.php';

	http.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById("imagenPerfil").innerHTML= "<p>Resultados de la búsqueda</p>";
			document.getElementById("informacion").innerHTML = this.response;
		}else{
			console.log(this.readyState+" "+this.status);
		}
	}
	http.open("POST", url);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.send('usuarioABuscar='+usuarioABuscar);	
}

function checkForUpdates(){
	if(usuarioRecibeActual != null){
		abrirConversacion(usuarioRecibeActual);
	}
	setTimeout(checkForUpdates,5000);
}

function checkearMensajeNuevo(){
	totalMensajes();
	if(totalTemp == null){
		totalTemp = totalInicial;
	}else if(totalTemp < totalInicial){
		var notify = new Notification('diestroChat',{
    		body: 'Tenés un nuevo mensaje!',
 		});
 		totalTemp = totalInicial;
	}
	setTimeout(checkearMensajeNuevo,5000);	
}

function totalMensajes(){
	const http = new XMLHttpRequest();
	const url = 'http://localhost/Diestro/post-curso/diestro-chat/php/total-mensajes.php';

	http.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){			 
			totalInicial = parseInt(this.response);
		}else{
			console.log(this.readyState+" "+this.status);
		}
	}
	http.open("GET", url);
	http.send();	
}