<?function Style($context){?>
<style>
.separado td{
	padding-top:4px;
}
</style>
<?}?>
<?function Script($context){?>
<script>
       $('#btnRegister').live('click', function(){
          if(Full($('#form1'))){
	          $.post('info.php?action=<?=hideVar('save')?>', $('#form1').serialize(), function(data){
				  if(data!='')	
				  	$.msgBox({title: "Error", content: data, type: "error"});					
				  else
					$.msgBox({title: "Correcto", content: "Se han guardado los datos", type: "info"});
					//$.msgBox({title: "Correcto", content: "Se han guardado los datos", type: "info"});
			   });
          }
       });
	  $(function(){
	   $('#Estado').change(function(){
           $('#Ciudad').load('info.php?action=<?=hideVar('cities')?>&ciud=' + $(this).val());
       });
	          });
</script>
<?}?>
<?function Body($context){?>
<?$obj = $context->data;
$mail = $context->email;
$estados = $context->estados;
$ID_Estado = $context->ID_Estado;
$ciudades= $context->ciudades;
?>
<div class ="container">
    <div class ="section-title"><?=$context->title?> >_ </div>
	<form id="form1">
        <table class="separado">
            <tr>
              <td colspan="2"  align="center">&nbsp;</td>
            </tr>
            <tr>
              <td  align="left">Calle:</td>
                <td><input type="text" size="70" name="Calle" id="Calle" class="require" value="<?=$obj[0]['Calle']?>" /></td>
            </tr>
            <tr>
              <td align="left">Número:</td>
              <td><input type="text" size="70" name="Numero" id="Numero" class="require" value="<?=$obj[0]['Numero']?>" /></td>
            </tr>
            <tr>
              <td align="left">Colonia:</td>
              <td><input type="text" size="70" name="Colonia" id="Colonia" class="require" value="<?=$obj[0]['Colonia']?>" /></td>
            </tr>
            <tr>
              <td align="left">C.P.:</td>
              <td><input type="text" size="70" name="CP" id="CP" class="require" value="<?=$obj[0]['CP']?>" /></td>
            </tr>
            <tr>
              <td align="left">Telefono:</td>
                <td><input type="text" size="32" maxlength="32" name="Telefono" id="Telefono" class="require"  value="<?=$obj[0]['Telefono']?>" /></td>
            </tr>
            <tr>
                <td  align="left">Estado:</td>
                <td>
                <select name="Estado" id="Estado">
                		<? foreach($estados as $estado){
							?>
                        <option value="<?=$estado['ID_Estado']?>" <? if($estado['ID_Estado']==$ID_Estado) echo "selected";?>><?=$estado['Estado']?></option>
                        <? }?>
                    </select>
                </td>
            </tr>
            <tr>
                <td  align="left">Ciudad:</td>
                <td><select name="Ciudad" id="Ciudad">
                <? foreach($ciudades as $ciudad){
							?>
                		<option value="<?=$ciudad['ID_Ciudad']?>" <? if($ciudad['ID_Ciudad']==$obj[0]['ID_Ciudad']) echo "selected";?>><?=$ciudad['Ciudad']?></option>
                         <? }?>
                    </select>                </td>
            </tr>            
            <tr>
              <td colspan="2"  align="left">&nbsp;</td>
            </tr>
            <tr>
                <td  align="left">Estado civil:</td>
                <td><select name="Civil" id="Civil">
                		<option value="Soltero" <? if ($obj[0]['Civil']=="Soltero") echo "selected";?>>Soltero</option>
                		<option value="Casado" <? if ($obj[0]['Civil']=="Casado") echo "selected";?>>Casado</option>    
                		<option value="Divorciado" <? if ($obj[0]['Civil']=="Divorciado") echo "selected";?>>Divorciado</option>                                          
                		<option value="Viudo" <? if ($obj[0]['Civil']=="Viudo") echo "selected";?>>Viudo</option>           
                		<option value="Otro" <? if ($obj[0]['Civil']=="Otro") echo "selected";?>>Otro</option>                                                                        
                    </select>
                
                </td>
            </tr>
            <tr>
                <td>Email principal:</td>
                <td><input type="text" size="70" name="email" id="email" class=""  value="<?=$mail[0]['Correo']?>" /></td>
            </tr>   
            <tr>
                <td>Email alternativo:</td>
                <td><input type="text" size="70" name="alter" id="alter" class=""  value="<?=$mail[0]['Correo2']?>" /></td>
            </tr>   
            <tr>
                <td align="left">CURP:</td>
                <td><input type="text" size="70" name="CURP" id="CURP" class="" value="<?=$obj[0]['CURP']?>"  /></td>
            </tr>                                                          
            <tr>
              <td colspan="2" align="center">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="hidden" name="i" id="i" value="<?=$obj[0]['ID_Info']?>"  />
 	               <input type ="button" value ="Guardar" class ="btn" id ="btnRegister" >
                </td>
            </tr>            
        </table>
    </form>
</div>
<?}?>

