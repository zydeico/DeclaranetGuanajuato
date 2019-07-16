<?function Style($context){?>
<style>
#mensajes{
	border: solid 1px #CCC;
	float:left;
	width:39%;
        overflow:auto;
        height: 90%;

}
#detalle{
	text-align:left;
	padding-top:8px;
	padding-bottom:8px;	
	font-size:12px;
	border: solid 1px #CCC;
	float:right;
	position:relative !important;
width:59%;
}
.gris{
	color:#CCC;
}
#tabs-1{
height:765px;
}
#tabs-2{
height:765px;
}
.titulomsg{	
	padding:8px;
	border: solid 1px #CCC;
	cursor:pointer;


}
.tittxt{
	font-size:14;
	font-weight:bold;
		cursor:pointer;
}
.titfecha{
	font-size:12px;
	font-weight:500;
		cursor:pointer;
}
.titulomsg:hover{
			background-color:#F8F8F8;
}
.sobre{
		background-color:#F00;
}
.cuerpo{
	
}
.noleido{
	
	background-color:#E1E1E1;
	
}
.leido{

}
</style>
<?}?>
<?function Script($context){?>
 <script>
 i=0;
 var grid;
    $(function(){	
        $('#divcheck').live('click', function(){
            Loading();
            if(i==0){
               document.getElementById('txtdiv').innerHTML='Mostrar notificaciones activas';
               Reload(grid, 'data/loadNotificaciones.php?t=1');			   
               i=1;
               return false;
            }else{
               document.getElementById('txtdiv').innerHTML='Mostrar notificaciones expiradas';
               Reload(grid, 'data/loadNotificaciones.php?t=2');				
               i=0;   
               return false;
            }
        });
		 
       <?if(in_array(59, $context->allow)){?>
            <?setGrid("grid", $context->params);?> 
            Reload(grid, 'data/loadNotificaciones.php?t=2');
       <?}?>
	   	  		   
        $( "#tabs" ).tabs({heightStyle: "content"}); 
        $( "#accordion" ).accordion({
                heightStyle: "content",
                collapsible:true,
                active:false
        });
        $('#btnSaveMsg').live('click', function(){
                 if(Full($('#frmMsg'))){
                           $.post('message.php?action=<?=hideVar('saveMsg')?>', $('#frmMsg').serialize(), function(data){
                           if(data!='1')
                                   $.msgBox({title: "Error", content: data, type: "error"});
                           else{
                                        $.msgBox({title: 'Correcto', 
                                                  content: 'Se ha enviado el mensaje', 
                                                  type: 'info', 
                                                  buttons: [{ value: "OK" }],
                                                  success: function (result) {
                                                        if (result == "OK") {
                                                                closeSexy();
                                                        }
                                                  }
                                        });						   
                           }
                        });
                 }
          });
          $('#btnSaveNtf').live('click', function(){
                 if(Full($('#frmMsg'))){
                        fakeLoad($(this).parent());
                        $.post('message.php?action=<?=hideVar('saveMsg')?>', $('#frmMsg').serialize(), function(data){
                           ready();
                           if(data!='1')
                                   $.msgBox({title: "Error", content: data, type: "error"});
                           else{
                                        $.msgBox({title: 'Correcto', 
                                                  content: 'Se ha enviado el mensaje', 
                                                  type: 'info', 
                                                  buttons: [{ value: "OK" }],
                                                  success: function (result) {
                                                        if (result == "OK") {
                                Reload(grid, 'data/loadNotificaciones.php');									
                                                                closeSexy();

                                                        }
                                                  }
                                        });						   
                           }
                        });
                 }
          });		  		
			
		
	});	
	function muestraMsg(id){
		document.getElementById('detalle').innerHTML=document.getElementById('h'+id).value;
		$.post('message.php?action=<?=hideVar('leido')?>&i='+id,function(data){
		if(data)
			$("#d"+id).attr('class', 'titulomsg leido');
		});		
		
	}
	function checaRFC(rfc){
		$.post('message.php?action=<?=hideVar('checaRFC')?>&rfc='+rfc,function(data){
			if(isNumeric(data)){
			    $('#txtServ').val(data);
                        }else{
                            $.msgBox({title: "Error", content: "El RFC no esta registrado", type: "error"});
                            document.getElementById('receptor').value='';				
			}
		});	
	}
	function addMsg(tipo,i){
		doSexy('message.php?action=<?=hideVar('addMsg')?>&tipo='+tipo+'&i='+i, 600, 300, "Nuevo mensaje");
	}		
    function Del(id){
        $.msgBox({title: 'Confirme', 
                  content: '¿Seguro de eliminar la notificacion?', 
                  type: 'confirm', 
                  buttons: [{ value: "OK" }, { value: "Cancelar"}],
                  success: function (result) {
                    if (result == "OK") {
                        $.get('message.php?action=<?=hideVar('del')?>&id=' + id, function(data){
                            if(data)
                                $.msgBox({title: "Error", content: data, type: "error"});
                            else{
                                Reload(grid, 'data/loadNotificaciones.php');
                            }
                        });
                    }
                  }
            });	
	}
		  
		  
</script>
<?}?>
<? function Body($context){
$allow=$context->allow;	
$mensajes=$context->mensajes;	
$notificaciones=$context->notificaciones;	

?>
<div class ="container">
    <div class ="section-title"><?=$context->title?> >_</div>
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Mensajes</a></li>
                <? if(in_array(59, $allow)){?>
                <li><a href="#tabs-2">Notificaciones</a></li>
                <?}?>                
            </ul>

                <div id="tabs-1">   
  					<? if(in_array(55, $allow)){//entra aqui si tiene persmiso de enviar mensaje?>              	         
                       <div align="left"> <input type="button" name="addMsg" id="addMsg" value="Enviar mensaje" class ="btn" onclick="addMsg(1,'')"  /></div>
                       <br />
                    <? }?>
                    <div id="mensajes"  >
                    <? if($mensajes){
							foreach($mensajes as $mensaje){
							?>
								<div align="left" id="d<?=$mensaje['ID_Mensaje']?>"  onclick="muestraMsg('<?=$mensaje['ID_Mensaje']?>')" class="titulomsg <?php if($mensaje['Leido']==0) echo "noleido"; else echo "leido";?>">
									<label class="tittxt"><?=$mensaje['Asunto']?></label><br />
									<label class="titfecha"><?=DateFormat($mensaje['Fecha_Creacion'],1);?></label>
                                    <input type="hidden" id="h<?=$mensaje['ID_Mensaje']?>" name="h<?=$mensaje['ID_Mensaje']?>" 
                                    value="<h3><strong>Remitente: </strong><?=$mensaje['nombre']?></h3>
                                    	   <h4><strong>Fecha: </strong><?=DateFormat($mensaje['Fecha_Creacion'],1);?></h4>
                                           <h3><strong>Asunto: </strong><?=$mensaje['Asunto']?></h3>
                                           <h3><strong>Mensaje: </strong></h3><p class='cuerpo'><?=$mensaje['Mensaje']?></p> 
                                           " />
                                </div>								
						<? }//foreach
						}else{?>
                    		<p>No hay mensajes en este momento</p>
                    <? 	}//else?>
                    </div>  
                    <div id="detalle">
                    	<p class="gris">Vista previa</p>
                    </div>
                </div>       
                <? if(in_array(59, $allow)){?>
                <div id="tabs-2"> 
                   <table><tr>
                    <td>
                   <div style="" align="left"> <input type="button" name="addMsg" id="addMsg" value="Enviar notificacion" class ="btn"  onclick="addMsg(2,'')"/></div>
                   </td>
                   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                   <td align="center">
                   <div  class ="btn" id="divcheck" ><label id="txtdiv">Mostrar notificaciones expiradas</label></div>	
                   </td></tr></table>
                   <br />
                    
                 <? /*   <div id="accordion">
						<? if($notificaciones){
                                foreach($notificaciones as $notificacion){
								
                                ?>
                                    <h3 align="left"><?=$notificacion['Asunto']?></h3>
                                    <div>
                                        <p align="justify"><?=$notificacion['Mensaje']?></p>
                                    </div>                                							
                            <? }//foreach
                            }else{?>
                                <p>No hay notificaciones en este momento</p>
                        <? 	}//else?>  
                    </div>  */?>
                    <table width="95%"  cellpadding="0" cellspacing="0">		
                        <tr>
                             <td id="pager"></td>
                        </tr>
                        <tr>
                             <td><div id="infopage" style =""></div></td>
                        </tr>
                        <tr>
                             <td><div id="grid" style ="height: 600px"></div></td>
                        </tr>
                        <tr>
                             <td class = "RowCount"></td>
                        </tr>
                    </table>                    
                </div> 
            <? }?>

      
        </div>         
</div>
<? }?>