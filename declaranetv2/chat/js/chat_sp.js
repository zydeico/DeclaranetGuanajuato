// JavaScript Document
	 de_server = "";
	 chat_viejo = 0;
//	 socket = io.connect('//172.22.5.38:3700');
//	 socket = io.connect('//ec2-54-244-124-180.us-west-2.compute.amazonaws.com:3700');
//        socket = io.connect('//declaranetv2.strc.guanajuato.gob.mx:3700');
socket = io.connect('//webchat.strc.guanajuato.gob.mx:3700');

window.onload = function() {
	 field = document.getElementById("to_read");
	 sendButton = document.getElementById("sub_button");
	 content = document.getElementById("to_apend");
	 avemus_b = 0;
	 hay_chat = 0;
	 nuevo = 0;
	 como_estoy = 0;
	socket.on('connect', function(){
		
	  });
	socket.on('message', function (data) {
		if(data.action) {
			var html = '';
				if(data.action == 'mensaje'){
						if(data.para == nombre){
							como_estoy = 2;
							//alert(como_estoy);
							nuevo = 0;
							de_server = data.de;	
							$("#to_read").removeAttr('disabled');						
							html = "";
							html += '<span class="nombre_chat">' + data.de.substring(0,data.de.length-5) +'</span>: <span class= "mensaje_chat">'+data.message+'</span><br />';
							
						}
				}
				if(data.action == 'obtener_activos'){
					//console.log("el _ que se conecto: ", data);
					//console.log(de_server+"dddddddddddd"+como_estoy);
					//alert(como_estoy);
					//alert(de_server+"aaaa"+hay_chat+"bbbb"+nuevo);
						if(como_estoy == 1){
							
							socket.emit('send', { message: "", action: "usuario_nuevo2", de: nombre, para: data.de });
						}
				}
				if(data.action == 'fin_conversacion'){
						if(data.para == nombre){
							//alert("finaliso");
							
							$("#to_read").attr("disabled", "disabled");
							//como_estoy = 0;
							//alert(como_estoy);
							hay_chat = 0;
							de_server == ''
							
							
							//.removeAttr('disabled');
							//$("#img_connect").show();
							//$("#img_connect").attr("src", base_dir_img+"reiniciar.png");
						}
				}
				if(data.action == 'tomaddo'){
						if(data.para == nombre){
							hay_chat = 1;
							como_estoy = 2
							//alert(como_estoy);
						}
				}
				
				if(data.action == 'avemus_asesor'){
					//if(avemus_b == 0){
						//avemus_b = 1;
						
						if(como_estoy == 1){
							//console.log("el _ que respondio que esta activo:", data);
							$("#to_apend").html('<span class= "mensaje_chat">Esperando a un asesor...</span><br />');
							}
						
						//}
					}
				if(data.action == 'avemus_asesorf'){
					//de_server = '';
					   //hay_chat = 0;
					   if(como_estoy == 1){
						//console.log("el _ que respondio que esta activo:", data);
						$("#to_apend").html('<span class= "mensaje_chat">Buscando un nuevo asesor...</span><br />');
					   }
					}

			$("#to_apend").append(html);
			$("#to_apend").animate({scrollTop:"5000px"});
			
		} else {
			//console.log("errrrroooorrrr:", data);
		}
	});
	sendButton.onclick = sendMessage = function() {
			var text = field.value;
			if(text.length > 0){
				socket.emit('send', { message: text, de: nombre, action: 'mensaje', para: de_server});
			field.value = "";
			$("#to_apend").append('<span class="nombre_chat">'+nombre.substring(0,nombre.length-5)+'</span>: <span class= "mensaje_chat">'+text+'</span><br />');
				}
			
			
	};
}

function lanzar_chat(){ 
	nuevo = 1;
	 como_estoy = 1;
	//alert(como_estoy);
	socket.emit('send', { message: "asdasd", de: nombre, action: 'se_fue', para: de_server});
	socket.emit('send', { message: "el usuario abandono la conversación", de: nombre, action: 'mensaje', para: de_server});
		$.ajax({
		  url: base_dir_path+'get_name.php',
		  cache: false
		}).done(function( html ) {
		 
			  nombre = html;
			 
			  if(chat_viejo == 0){
				  chat_viejo = 1;
				  }else{
					  de_server = '';
					   hay_chat = 0;
					  $("#to_apend").html('<span class= "mensaje_chat">Por el momento no hay asesores disponibles, por favor intente más tarde...</span><br />');  
					  nuevo = 1;
					  }
				
										
				socket.emit('send', { message: "", action: "usuario_nuevof", de: nombre, para: 'server' });
				$("#img_connect").attr("src", base_dir_img+"reiniciar.png");
  
	
			});
		
	//$("#img_connect").hide();
}
	
function abrir_chat(from){
	como_estoy = 1;
	//alert(como_estoy);
	lanzar_chat();
	$("#dialog_box").show();	
	 $( "#menu-extras" ).animate({
		height: "330px"
		}, 500, function() {
				
	});
	
}

$(document).ready(function() {
	$("#to_read").keyup(function(e) {
		if(e.keyCode == 13) {
			sendMessage();
		}
	});
});

window.onbeforeunload = function() {
      socket.emit('send', { message: "el usuario abandono la conversación", de: nombre, action: 'mensaje', para: de_server});
	  }
  
