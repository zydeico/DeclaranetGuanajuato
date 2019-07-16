// JavaScript Document
//socket = io.connect('//172.22.5.38:3700');
//socket = io.connect('//ec2-54-244-124-180.us-west-2.compute.amazonaws.com:3700');
//socket = io.connect('//declaranetv2.strc.guanajuato.gob.mx:3700');
socket = io.connect('//webchat.strc.guanajuato.gob.mx:3700');
 p_activo = "";
chats_tomados = new Array() 
 alert_ant = "";

window.onload = function() {
	html = "";
	socket.on('connect', function(){
		obtener_activos();
		
	  });
	  
	socket.on('message', function (data) {
		if(data.action) {
			
			
			
			if ($("#tr_alert_"+data.de).length > 0){
			  //yata
			}else{
			
			
			var html = '';
				if((data.action == 'usuario_nuevo') || (data.action == 'usuario_nuevo2' && data.para == nombre)){	
				//alert(estado_chat);
				if(estado_chat == 1){
				socket.emit('send', { message: "beeeee", action: "avemus_asesor", de: nombre, para: data.de });
				
						html +=	'<tr id="tr_alert_'+data.de+'">';
						html +=	'<td id="td_alert_'+data.de+'">';
        html +=	   ' <div id="alerta_nuevo_'+data.de+'" class="alert_nuevo" onclick="ver_chat_n('+"'"+data.de+"'"+')">'+data.de.substring(0,data.de.length-5)+'</div>';
        html +=	   	'<div id="chat_box_'+data.de+'" class="chat_box_n">';
       html +=	    ' <div id="minimizar" class="minimizar_conversacion" onclick="ocultar_chat_n('+"'"+data.de+"'"+')">Minimizar</div>';
       html +=	    ' <div id="terminar_converzacion" class="terminar_converzacion" onclick="terminar_chat_n('+"'"+data.de+"'"+')">Terminar</div>';
          html +=	  '<div class="contenedor_chat" id="conver_'+data.de+'"></div>';
        html +=	  '  <input name="" type="text" onkeyup="t_enviar('+"'"+data.de+"'"+', event);" style="width: 129px;" id="el_mensaje_'+data.de+'"/>';
       html +=	    ' <input name="enviar" type="button" value="enviar" style="width: 62px;" onclick="enviar_mensaje('+"'"+data.de+"'"+');"/>';
       html +=	   '  </div>';
       html +=	    ' </td>';
	   html +=	'</tr>';
							
							$("#pegar_elementos").append(html);
				}
			}
			}
				
				if(data.action == 'usuario_nuevof'){	
				if ($("#tr_alert_"+data.de).length > 0){
			  //yata
			}else{
				//alert(estado_chat);
					if(estado_chat == 1){
				socket.emit('send', { message: "beeeee", action: "avemus_asesorf", de: nombre, para: data.de });
				
						html +=	'<tr id="tr_alert_'+data.de+'">';
						html +=	'<td id="td_alert_'+data.de+'">';
        html +=	   ' <div id="alerta_nuevo_'+data.de+'" class="alert_nuevo" onclick="ver_chat_n('+"'"+data.de+"'"+')">'+data.de.substring(0,data.de.length-5)+'</div>';
        html +=	   	'<div id="chat_box_'+data.de+'" class="chat_box_n">';
       html +=	    ' <div id="minimizar" class="minimizar_conversacion" onclick="ocultar_chat_n('+"'"+data.de+"'"+')">Minimizar</div>';
       html +=	    ' <div id="terminar_converzacion" class="terminar_converzacion" onclick="terminar_chat_n('+"'"+data.de+"'"+')">Terminar</div>';
          html +=	  '<div class="contenedor_chat" id="conver_'+data.de+'"></div>';
        html +=	  '  <input name="" type="text" onkeyup="t_enviar('+"'"+data.de+"'"+', event);" style="width: 129px;" id="el_mensaje_'+data.de+'"/>';
       html +=	    ' <input name="enviar" type="button" value="enviar" style="width: 62px;" onclick="enviar_mensaje('+"'"+data.de+"'"+');"/>';
       html +=	   '  </div>';
       html +=	    ' </td>';
	   html +=	'</tr>';
							
							$("#pegar_elementos").append(html);
				}
				}
				}
				
				if(data.action == "usuario_tomado"){
					if(data.de != nombre){
							$("#td_alert_"+data.message).hide();
						}
						
					}
				if(data.action == "se_fue"){
					terminar_chat_n_local(data.de);
							//$("#td_alert_"+data.message).hide();
						
						
					}
				if(data.action == "mensaje"){
					if(data.para == nombre){
						
							$("#conver_"+data.de).append('<span class="nombre_chat">'+data.de.substring(0,data.de.length-5)+'</span>: <span class= "mensaje_chat">'+data.message+'</span><br />');
							
							if(p_activo != data.de){
								$("#alerta_nuevo_"+data.de).addClass('icono_chat');
							}
							
							$("#conver_"+data.de).animate({scrollTop:"5000px"});
						}
					}
		} else {
			//console.log("There is a problem:", data);
		}
	});	
	
}

$(document).ready(function(e) {
     $("#t_nombre").html(nombre);
});
function ver_chat_n(p_name){
		//alert("chat_box_"+p_name);
		$("#alerta_nuevo_"+p_name).removeClass('icono_chat');
		$(".chat_box_n").hide();
		$("#chat_box_"+p_name).show();
		p_activo = p_name;
		$("#alerta_nuevo_"+alert_ant).removeClass('alert_activo');
		alert_ant = p_name;
		$("#alerta_nuevo_"+p_name).addClass('alert_tomado');
		$("#alerta_nuevo_"+p_name).addClass('alert_activo');
		$('#el_mensaje_'+p_name).focus();
		
		$("#conver_"+p_name).animate({scrollTop:"5000px"});
		
			if(chats_tomados[p_name] != 1){
				chats_tomados[p_name] = 1;
				chat_tomado(p_name);
			}
		} 
	function ocultar_chat_n(p_name){
		$("#chat_box_"+p_name).hide();
		$("#alerta_nuevo_"+p_name).removeClass('alert_activo');
		p_activo = "";
		} 
	function chat_tomado(p_name){
		socket.emit('send', { message: p_name, action: "usuario_tomado", de: nombre, para: 'server' });
		socket.emit('send', { message: "Bienvenido le atiende: "+nombre.substring(0,nombre.length-5)+", en que podemos ayudarle?", action: "mensaje", de: nombre, para: p_name });
		socket.emit('send', { message: "sdfghjk", action: "tomaddo", de: nombre, para: p_name });
	}
	
	function obtener_activos(){
		//if(no_nuevo == 0){
				socket.emit('send', { message: '', action: "obtener_activos", de: nombre, para: 'server' });
			//}
		
		//console.log("aaaa");
		
	}
	
	
	function enviar_mensaje(p_name){
		mensajef = $("#el_mensaje_"+p_name).val();
		if(mensajef.length > 0){
			$("#el_mensaje_"+p_name).val("");
		
		socket.emit('send', { message: mensajef, action: "mensaje", de: nombre, para: p_name });
		$("#conver_"+p_name).append('<span class="nombre_chat">'+nombre.substring(0,nombre.length-5)+'</span>: <span class= "mensaje_chat">'+mensajef+'</span><br />');
		}
		
		
	}
	
	function cambiar_status(estado){
		hay_chat = estado;
		estado_chat = 1;
            $.get("chat/chat.php?st=" + estado, function(){
               if(estado == 1){
                $("#conversacion_n").show();
				
				obtener_activos();
                    
                }else{
					estado_chat = 0;
					hay_chat = 0;
					$("#pegar_elementos").html("");
                    $("#conversacion_n").hide();
					 for(var ch in chats_tomados) {
						 if(chats_tomados[ch] == 1){
							 //alert(ch);
							 terminar_chat_n(ch);
							 }
					 }				
				} 
            }); 
        }
		
		function t_enviar(de, event){
			  var keyCode = ('which' in event) ? event.which : event.keyCode;
            if(keyCode == 13){
				enviar_mensaje(de);
				}
			}
			
			function terminar_chat_n(n_chat){
				chats_tomados[n_chat] = 2;
					socket.emit('send', { message: "Se ha terminado la conversación", action: "mensaje", de: nombre, para: n_chat });
					socket.emit('send', { message: "", action: "fin_conversacion", de: nombre, para: n_chat });
					$("#tr_alert_"+n_chat).hide();
					$("#conver_"+n_chat).attr("id", "trash");
					$("#el_mensaje_"+n_chat).attr("id", "trash");
					$("#chat_box_"+n_chat).attr("id", "trash");
					$("#tr_alert_"+n_chat).attr("id", "trash");
					$("#td_alert_"+n_chat).attr("id", "trash");
					$("#alerta_nuevo_"+n_chat).attr("id", "trash");
					
				}
				function terminar_chat_n_local(n_chat){
				chats_tomados[n_chat] = 2;
					//socket.emit('send', { message: "Se ha terminado la conversación", action: "mensaje", de: nombre, para: p_activo });
					//socket.emit('send', { message: "", action: "fin_conversacion", de: nombre, para: p_activo });
					$("#tr_alert_"+n_chat).hide();
					$("#conver_"+n_chat).attr("id", "trash");
					$("#el_mensaje_"+n_chat).attr("id", "trash");
					$("#chat_box_"+n_chat).attr("id", "trash");
					$("#tr_alert_"+n_chat).attr("id", "trash");
					$("#td_alert_"+n_chat).attr("id", "trash");
					$("#alerta_nuevo_"+n_chat).attr("id", "trash");
					
				}

