<?function Style($context){?>
<style>
.separado td{
	padding-top:10px;
	padding-bottom:10px;
}
.opt-item input {width: 200px;}
#frmReactivos table td {padding: 5px;}
</style>
<?}?>
<?function Script($context){?>
<? $parametrosScript = $context->parametros;?>
<script>

      var gridEncuesta;
	  var grid;
    
    $(function(){
		  		   
		  $( "#tabs" ).tabs();
                  DatePicker($('.date'));
		  <?setGrid("grid", $context->params);?> 
		  Reload(grid, 'data/loadFaqs.php');

 		   <?setGrid("gridReactivos", $context->reactivs);?> 
		   Reload(gridReactivos, 'data/loadReactivos.php');
  /*-----------------------------------------------*/
		  $('#btnNewPregEncuesta').click(function(){
			   doSexy('config.php?action=<?=hideVar('addPregunta')?>', 600, 300, "Nueva pregunta de encuesta");
		  });	  
		  /*-----------------------------------------------*/
		  $('#btnNewFaq').click(function(){
			   doSexy('config.php?action=<?=hideVar('addFaq')?>', 600, 280, "Nueva pregunta frecuente");
		  });
		  $('#btnSaveFaq').live('click', function(){
			 if(Full($('#frm-faq'))){
				if($('.change').is(':visible')){
					   $.post('config.php?action=<?=hideVar('validFaq')?>', $('#frm-faq').serialize(), function(data){
					   if(data)
						   $.msgBox({title: "Error", content: data, type: "error"});
					   else
						   SaveFaq();
					});
				}else
					SaveFaq();
			 }
		  });	
		function SaveFaq(){
			closeSexy();
			Loading();
			$.post('config.php?action=<?=hideVar('saveFaq')?>', $('#frm-faq').serialize(), function(data){
				$('.mask, .loading').remove();
				if(data)
					$.msgBox({title: 'Error', content: data, type: 'error'});
				else
					Reload(grid, 'data/loadFaqs.php');
			});
		}
		  
		  $('#btnAdd').live('click', function(){
			   $.get('config.php?action=<?=hideVar('addFaq')?>&id=' + $('#txtID').val() + '&pro=' + $('#cmbProfile').val(), function(data){
				   if(data)
					   $.msgBox({title: "Error", content: data, type: "error"});
				   else{
					   Reload(grid, 'data/loadFaqs.php');
					   doSexy('config.php?action=<?=hideVar('view')?>&id=' + $('#txtID').val(), 500, 300, "");
				   }
			   });
		  });	
		  /* $('#btnSaveParams').live('click', function(){
			  if(Full($('#form1'))){
				  $.post('config.php?action=<?=hideVar('saveParams')?>', $('#formParams').serialize(), function(data){
					  if(data!='')	
						$.msgBox({title: "Error", content: data, type: "error"});					
					  else
						$.msgBox({title: "Correcto", content: "Se han guardado los datos", type: "info"});
						//$.msgBox({title: "Correcto", content: "Se han guardado los datos", type: "info"});
				   });
			  }
		   });		*/
		   $('#btnSaveParams').live('click', function(){
			  if(Full($('#formParams'))){
					fakeLoad($(this).parent());
					var data = new FormData();
					var inputFileImage=new Array(); 
					var file=new Array(); 
					 <? foreach($parametrosScript as $parametroS){
						 if($parametroS['Tipo']!="text" && $parametroS['Tipo']!="date" && $parametroS['Tipo']!="password" && $parametroS['Tipo']!="textarea"){?>
							inputFileImage['<?=$parametroS['ID_Parametro'];?>'] = document.getElementById("Valor_<?=$parametroS['ID_Parametro'];?>");
							file[<?=$parametroS['ID_Parametro'];?>] = inputFileImage[<?=$parametroS['ID_Parametro'];?>].files[0];		
							data.append('val<?=$parametroS['ID_Parametro'];?>', file[<?=$parametroS['ID_Parametro'];?>]);	
			<?php /*		var extension;
							extension=document.getElementById('Valor_<?=$parametroS['ID_Parametro'];?>').value;
							alert(extension.substring(0,-3));

							document.getElementById('div_<?=$parametroS['ID_Parametro'];?>').innerHTML='1111';		
							*/ ?>
					 <?  }else{?>
							 data.append('val<?=$parametroS['ID_Parametro'];?>', $('#Valor_<?=$parametroS['ID_Parametro'];?>').val());
					 	 <? }
					  }?>
					$.ajax({
						url: 'config.php?action=<?=hideVar('saveParams')?>',
						type:'POST',
						contentType:false,
						data: data,
						processData:false,
						cache:false, 
						success: function(msg){
							ready();
							if(msg)
								$.msgBox({title: "Error", content: msg, type: "error"});
							else{
								$.msgBox({title: 'Correcto', 
									  content: 'Se han guardado los datos', 
									  type: 'info', 
									  buttons: [{ value: "OK" }],
									  success: function (result) {
										if (result == "OK") {
											location.reload();
										}
									  }
								});								
								//$.msgBox({title: "Correcto", content: "Se han guardado los datos", type: "info"});
								 //location.reload();
							}
						}
					});
	
				}
		   
		   });
		     
		  	  	  
	 });   
    function Edit(id){
        doSexy('config.php?action=<?=hideVar('addFaq')?>&id=' + id, 600, 300, "Editar pregunta frecuente");
    }
	/*---------------------------------------------------*/
	function EditEncuesta(id){
		doSexy('config.php?action=<?=hideVar('addPregunta')?>&id=' + id, 600, 300, "Editar pregunta de encuesta");
	}
    function DelEncuesta(id){
        $.msgBox({title: 'Confirme', 
                  content: '¿Seguro de eliminar este registro?', 
                  type: 'confirm', 
                  buttons: [{ value: "OK" }, { value: "Cancelar"}],
                  success: function (result) {
                    if (result == "OK") {
                        $.get('config.php?action=<?=hideVar('delPregunta')?>&id=' + id, function(data){
                            if(data)
                                $.msgBox({title: "Error", content: data, type: "error"});
                            else{
										
                                Reload(gridReactivos, 'data/loadReactivos.php');
								
                            }
                        });
                    }
                  }
            });
    }   			
       $('#btnSaveReactivos').live('click', function(){
          if(Full($('#frmReactivos'))){
	          $.post('config.php?action=<?=hideVar('saveReactivos')?>', $('#frmReactivos').serialize(), function(data){
				  if(data!='')	
				  	$.msgBox({title: "Error", content: data, type: "error"});					
				  else{
					$.msgBox({title: "Correcto", content: "Se han guardado los datos", type: "info"});
					closeSexy();
                                        Reload(gridReactivos, 'data/loadReactivos.php');
                                  }
			   });
          }
       });			
	/*---------------------------------------------------*/	
	
    function Del(id){
        $.msgBox({title: 'Confirme', 
                  content: '¿Seguro de eliminar este registro?', 
                  type: 'confirm', 
                  buttons: [{ value: "OK" }, { value: "Cancelar"}],
                  success: function (result) {
                    if (result == "OK") {
                        $.get('config.php?action=<?=hideVar('del')?>&id=' + id, function(data){
                            if(data)
                                $.msgBox({title: "Error", content: data, type: "error"});
                            else{
                                Reload(grid, 'data/loadFaqs.php');
                            }
                        });
                    }
                  }
            });
    }   	
    function  vistaPrevia(img){
           doSexy(img, 0, 0);
      }	 
//###############################################################3
var contador = 0;
function agrega_campos(){
	var contaT;
	contaT= parseInt(document.getElementById('contadorTotal').value)+1;
	document.getElementById('contadorTotal').value=contaT;
	$("#preguntas").append("<tr id='"+contador+"' class = 'opt-item'><td>Opcion "+contaT+":</td><td><input type='text' name='opt[]' id='opt'"+contaT+"  class=\"require\" /> <img src=\"img/delete.png\" style=\"cursor:pointer\" onclick='elimina_me("+contador+")'></td></tr>");
	contador++;
}

function elimina_me(elemento){
	document.getElementById('contadorTotal').value=parseInt(document.getElementById('contadorTotal').value)-1;
	$("#"+elemento).remove();
}



</script>
<?}?>
<? function Body($context){
$obj = $context->data;
$parametros = $context->parametros;
$reactivos = $context->reactivos;
?>
<div class ="container">
    <div class ="section-title"><?=$context->title?> >_ </div>
        <div id="tabs">
            <ul>
            <li><a href="#tabs-1">Parametros</a></li>
            <li><a href="#tabs-2">FAQS</a></li>
            <li><a href="#tabs-3">Encuesta</a></li>
            </ul>
            <script>
            function validaCampo(id, tipo){
				var extension;
				tipos=tipo.split(",");
				var seleccionada;
				seleccionada=document.getElementById(id).value.substr(-3);
//				console.log(tipos);
				//extension=extension.toLowerCase();
				var length = tipos.length,
				tipoElement = null;
				var error=1;
				for (var i = 0; i < length; i++) {
				  	tipoElement = tipos[i];
					if((tipoElement.toLowerCase()!=seleccionada) && error==1){
						error=1;
					}else{
						error=2;					
					}
				/*	if(tipoElement.toLowerCase()=='pdf'){
						if(extension.substr(-3)=='pdf'){
							//
						}else{
							 $.msgBox({title: "Error", content: "Solo se permite extension: PDF", type: "error"});
							 document.getElementById(id).value='';
						}
					}else if(tipo.toLowerCase()=='png' || tipo.toLowerCase()=='png'){
						if(extension.substr(-3)=='pdf' || extension.substr(-3)=='jpg' || extension.substr(-4)=='jpeg' || extension.substr(-3)=='png'){
							//
						}else{
							 $.msgBox({title: "Error", content: "Solo se permiten extensiones: PDF, JPG y PNG", type: "error"});
							 document.getElementById(id).value='';
						}					
					}*/
				}
				if(error==1){
					$.msgBox({title: "Error", content: "Solo se permiten extensiones: "+tipo, type: "error"});
					document.getElementById(id).value='';	
				}
			}
            </script>
        <div id="tabs-1">
            <form id="formParams" method="post" action="config.php" enctype="multipart/form-data"  class="avoid">
                <table class="separado">
                <? foreach($parametros as $parametro){?>
                    <tr>
                      <td  align="left"><?=$parametro['Nombre'];?>:</td>
                       
                            <?if($parametro['Tipo']=="text"){?>
                                <td ><input type="text" size="70" name="Valor_<?=$parametro['ID_Parametro'];?>" id="Valor_<?=$parametro['ID_Parametro'];?>" class="tooltip" title="<?=$parametro['ToolTip'];?>" value="<?=$parametro['Valor'];?>" /> </td>
                            <?}elseif($parametro['Tipo']=="date"){?>
                                <td ><input type="text" size="70" name="Valor_<?=$parametro['ID_Parametro'];?>" id="Valor_<?=$parametro['ID_Parametro'];?>" class="tooltip date" title="<?=$parametro['ToolTip'];?>" value="<?=$parametro['Valor'];?>" readonly /> </td>
                            <?}elseif($parametro['Tipo']=="password"){?>
                                <td ><input type="password" size="70" name="Valor_<?=$parametro['ID_Parametro'];?>" id="Valor_<?=$parametro['ID_Parametro'];?>" class="tooltip" title="<?=$parametro['ToolTip'];?>" value="<?=$parametro['Valor'];?>" /> </td>
                            <?}elseif($parametro['Tipo']=="textarea"){?>
                                <td ><textarea cols ="70" rows ="3" name="Valor_<?=$parametro['ID_Parametro'];?>" id="Valor_<?=$parametro['ID_Parametro'];?>" class="tooltip" title="<?=$parametro['ToolTip'];?>"><?=$parametro['Valor'];?></textarea> </td>
                            <?}else{?>                            	
                            	 <td ><input type="file" onchange="validaCampo('Valor_<?=$parametro['ID_Parametro'];?>','<?=$parametro['Tipo'];?>')"  name=""  id="Valor_<?=$parametro['ID_Parametro'];?>" class="tooltip" title="<?=$parametro['ToolTip'];?>"/>
                                <input type="hidden" name="Valor_<?=$parametro['ID_Parametro'];?>_requerido"  id="Valor_<?=$parametro['ID_Parametro'];?>_requerido" class="require" />
								<? if($parametro['Valor']!=''){
									if(strtolower(substr($parametro['Valor'],-4))=='.pdf'){?>
                                        	 <td><a id="pdf<?=$parametro['ID_Parametro'];?>" href="<?=$parametro['Valor'];?>" target="_blank"><img src="img/view.gif" class="tooltip" title="Ver archivo" /></a> </td>
                                    <? }else{//cierra el de pdf?>
                                			 <td ><? //=substr($parametro['Valor'],9)?><img src="img/view.gif" onclick="vistaPrevia('<?=$parametro['Valor'];?>');" id="imagen<?=$parametro['ID_Parametro'];?>" class="tooltip" title="Ver archivo" style="cursor:pointer" />   </td>                                  
                                    <? }?>
                                <? }?>
                            <? }?>
                        </td>
                    </tr>                                                     
                <? }?>
                    <tr>
                        <td colspan="2" align="center">
                           <input type="hidden" name="i" id="i" value="<?=$obj[0]['ID_Info']?>"  />
                           <input type ="button" value ="Guardar" class ="btn" id ="btnSaveParams" >
                        </td>
                    </tr>                  
                </table>
            </form>			
	
        </div>            
        <div id="tabs-2">
            <div>
            	<input type ="button" class ="btn" value ="Agregar pregunta" id ="btnNewFaq"></div>
            <br>
            <div id ="users">
                <table width="100%"  cellpadding="0" cellspacing="0">		
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
        </div>
        <div id="tabs-3">
            <div><input type ="button" class ="btn" value ="Agregar pregunta" id ="btnNewPregEncuesta"></div>
            <br>
            <div id ="encuesta">
                <table width="100%"  cellpadding="0" cellspacing="0">		
                    <tr>
                         <td id="pager"></td>
                    </tr>
                    <tr>
                         <td><div id="infopage" style =""></div></td>
                    </tr>
                    <tr>
                         <td><div id="gridReactivos" style ="height: 600px"></div></td>
                    </tr>
                    <tr>
                         <td class = "RowCount"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?}?>