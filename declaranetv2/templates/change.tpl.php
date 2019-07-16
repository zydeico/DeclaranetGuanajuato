<?function Style($context){?>
<style>
.separado td{
	padding-top:10px;
	padding-bottom:10px;
}
#form1 {font-size: 12pt; margin: 10px 50px; }
</style>
<?}?>
<?function Script($context){?>
<script>
       $('#btnRegister').live('click', function(){
          if(Full($('#form1'))){
	          $.post('change.php?action=<?=hideVar('save')?>', $('#form1').serialize(), function(data){
				  if(data!='')	
				  	$.msgBox({title: "Error", content: data, type: "error"});					
				  else
					$.msgBox({title: "Correcto", content: "Se ha cambiado su contraseña correctamente", type: "info"});
					//$.msgBox({title: "Correcto", content: "Se han guardado los datos", type: "info"});
			   });
          }
       });
</script>
<?}?>
<?function Body($context){?>
<div class ="container">
    <div class ="section-title"><?=$context->title?> >_ </div>
	<form id="form1"  class="avoid">
            Las contraseñas deben ser de tipo ALFANUMÉRICAS (Números y Letras), además de tener una LONGITUD MÍNIMA de 8 caracteres
            <table class="separado">
                <tr>
                  <td colspan="2"  align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td  align="left">Contraseña anterior:</td>
                    <td><input type="password" size="32" name="anterior" id="anterior" class="require" value=""  autocomplete ="off"/></td>
                </tr>
                <tr>
                  <td align="left">Contraseña nueva:</td>
                  <td><input type="password" size="32" name="nueva" id="nueva" class="require" value=""  autocomplete ="off"/></td>
                </tr>
                <tr>
                  <td align="left">Repetir contraseña nueva:</td>
                  <td><input type="password" size="32" name="nueva2" id="nueva2" class="require" value=""  autocomplete ="off"/></td>
                </tr>                                                          
                <tr>
                  <td colspan="2" align="center">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                           <input type ="button" value ="Guardar" class ="btn" id ="btnRegister" >
                    </td>
                </tr>            
            </table>
        </form>
    </div>
<?}?>