<?function Style($context){?>
<style>
.pregunta{
	width:100% !important;
	background: repeat-x scroll 50% 50% #F6F6F6;
    border: 1px solid #DDDDDD;
    color: #0073EA;
    font-weight: bold;
}
.bordeado{
	border:groove 1px #999;
	text-align:center;
	padding:5px 10px;
	
}
.tablota{

width:80%;
}
.tablotaError{
width:80%;
font-size:14pt;
color:#F00;
}
.tablota td{
		padding-top:4px;
	padding-bottom:4px;	
	
}
</style>
<?}?>
<?function Script($context){?>
<script>
    
    $(function(){
		 $('#btnSaveSurvey').live('click', function(){
			 //checaRadios()==0
			// if($("#formSurvey input[name='opt1']:radio").is(':checked')){
			
			if(checaRadios()==2 && Full($('#formSurvey'))){
				 
                                $.post('survey.php?action=<?=hideVar('saveSurvey')?>', $('#formSurvey').serialize(), function(data){
                                         if(data)
                                                $.msgBox({title: "Error", content: data, type: "error"});
                                         else{
                                                        $.msgBox({title: 'Correcto', 
                                                                  content: 'Encuesta guardada. Ahora será direccionado a su declaración de intereses.<br><b>Gracias</b>', 
                                                                  type: 'info', 
                                                                  buttons: [{ value: "OK" }],
                                                                  success: function (result) {
                                                                        if (result == "OK") {
                                                                                location.href='interest.php';
                                                                        }
                                                                  }
                                                        });

                                         }
                                });
				 
			 }//checaRadios
			 else{
                                $.msgBox({title: "Error", content: "Todas las preguntas son obligatorias", type: "error"});
                         }
		   });
		   function checaRadios(){
			   res=1;
			   $('.renglonRadio').each(function(){
					if($(this).find('input:radio:checked').length > 0 && res!=3)
						res= 2;
					else
						res= 3;
			   });
			   return res;
		   }
		  
       });
	   /* function checaRadios(){
		  
			var sAux="";
			var tipo;
			var frm = document.getElementById("formSurvey");
			for (i=0;i<frm.elements.length;i++){		
				tipo=frm.elements[i].type;
				alert(tipo);
			}
	   }*/
</script>
<?}?>

<? function Body($context){
	$reactivos = $context->reactivos;
$existeEncuesta = $context->existeEncuesta;
$declaracionValida = $context->declaracionValida;
?>
    <div class ="container">
        <div class ="section-title"><?=$context->title?> >_ </div>
        <h3>Favor de contestar la encuesta para obtener su acuse de declaración</h3>
        <?
        if($existeEncuesta){?>
				<center><table class="tablotaError">
                	<tr><td align="center">Esta encuesta ya ha sido contestada previamente.</td></tr> 
                </table></center>
		<? }elseif(count($declaracionValida)==0){
			
		?>
        		<center><table class="tablotaError">
                	<tr><td align="center">La encuesta solicitada no corresponde al usuario.</td></tr> 
                </table></center>
         <? }else{?>
            <form id="formSurvey" method="post">
            <table class="tablota" >
                <? $i=0;
                 foreach($reactivos as $reactivo){
                     $i++; 
                     $opciones=explode("|",$reactivo['Opciones']);
                     ?>
                    <tr>
                        <input type ="hidden" name ="reactivo[]" value ="<?=$reactivo['ID_Reactivo']?>">
                        <td align="left" class="pregunta">
                            <?=$i?>) <?=$reactivo['Reactivo']?>
                        </td>
                    </tr>
                    <tr>  
                        <td>                      
                            <table class="">
                                <?if($reactivo['Opciones']){?>
                                <tr class="renglonRadio">
                                     <?foreach($opciones as $opcion){?>
                                        <td nowrap class="bordeado corner"><?=$opcion?><input type="radio" value="<?=$opcion?>" class="require" name="opt<?=$reactivo['ID_Reactivo']?>" ></td>
                                     <?}?>
                                </tr>
                                <?}else{?>
                                <tr>
                                    <td><textarea cols ="100" rows = "3" name ="resp<?=$reactivo['ID_Reactivo']?>" class = "require"></textarea></td>   
                                </tr>
                                <?}?>
                            </table>
                        </td>
                    </tr>
    
                <? }?>
                    <tr>
                        <td  align="center">
                            <input type="hidden" name="i" id="i" value="<? echo (int) $_GET['id'];?>" />
                            <input type ="button" value ="Guardar" class ="btn" id ="btnSaveSurvey" >
                        </td>
                    </tr>            
            </table>
            </form>
        <? }?>
    </div>
<?}?>