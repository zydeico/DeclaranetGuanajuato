<style>
.separado td{
	padding-top:4px;
}
</style>
<script>
    $(function(){
       $('.btn').button(); 
	   DatePicker($('#fechade'));
    });
	function cambiar(elem){
		
		if(elem.value=='DEPENDENCIA'){document.getElementById('rdep').style.display=''; document.getElementById('rdestino').style.display='none';}
		else if(elem.value=='UNICO'){document.getElementById('rdep').style.display='none'; document.getElementById('rdestino').style.display='';}  
		else{ document.getElementById('rdep').style.display='none'; document.getElementById('rdestino').style.display='none';}		
	}function cambia(val){
		
		if(val=='DEPENDENCIA'){document.getElementById('rdep').style.display=''; document.getElementById('rdestino').style.display='none';}
		else if(val=='UNICO'){document.getElementById('rdep').style.display='none'; document.getElementById('rdestino').style.display='';}  
		else{ document.getElementById('rdep').style.display='none'; document.getElementById('rdestino').style.display='none';}		
	}
</script>
    

<?
$obj = $context->data;
$tipo=$context->tipo;
$perfiles=$context->perfiles;
$usuarios=$context->usuarios;	
$dependencias=$context->dependencias;
$RFC=$context->RFC;

?> 
<form id ="frmMsg" class="avoid">
	<? if ($tipo==1){?>
    <center>
        <table  class="separado">
                <td>Tipo</td>            
                <td>
                	<select name="tipo" id="tipo" class ="large" onChange="if(this.value==1){document.getElementById('rperfil').style.display='none'; document.getElementById('rdestino').style.display='';} else{ document.getElementById('rperfil').style.display=''; document.getElementById('rdestino').style.display='none';}">               
                    	<option value="1">Individual</option>
                    	<option value="2">Por perfil</option>                        
                    </select>
              </td>
              <tr id="rperfil" style="display:none">
              	<td>Perfil</td>
              	<td>
                	<select name="perfil" id="perfil" class ="large">
                <? foreach($perfiles as $perfil){
							?>
                		<option value="<?=$perfil['ID_Perfil']?>"><?=$perfil['Perfil']?></option>
                         <? }?>
                    </select>
                </td>
              </tr>
              <tr id="rdestino">
                <td>Destinatario</td>
                <td>
                	<select name="receptor" id="receptor" class ="large">
						<? foreach($usuarios as $usuario){
							?>
                		<option value="<?=$usuario['ID_User']?>"><?=$usuario['Nombre']?> <?=$usuario['Paterno']?></option>
                         <? }?>
                    </select>                
                </td>
              </tr>     
              <tr id="">
                <td>Asunto</td>
                <td><input type ="text" class ="large require" name ="asunto" value =""></td>
              </tr>  
              <tr id="rdestino">
                <td>Mensaje</td>
                <td><textarea name="mensaje"  class="large require" rows="8"></textarea></td>
              </tr>                                                    
            </tr>         
        </table>
        <br>
        <input type="hidden" name="t" value="1" />        
        <input type ="button" class ="btn" value ="Guardar" id ="btnSaveMsg">
    </center>
    <? }else if($tipo==2){?>
    <center>
        <table  class="separado">
                <td>Tipo</td>            
                <td>
                	<select name="tipo" id="tipo" onChange="cambiar(this)">               
                    	<option value="GLOBAL">Global</option>
                    	<option value="DEPENDENCIA">Por dependencia</option>  
                    	<option value="UNICO">Unico</option>                                                
                    </select>
              </td>
              <tr id="rdep" style="display:none">
              	<td>Dependencia</td>
              	<td>
                	<select name="dependencia" id="dependencia">
                <? foreach($dependencias as $dependencia){
							?>
                		<option value="<?=$dependencia['ID_Dependencia']?>" <? if($obj[0]['ID_Receptor']==$dependencia['ID_Dependencia']) echo "SELECTED";?>><?=$dependencia['Dependencia']?></option>
                         <? }?>
                    </select>
                </td>
              </tr>
              <tr id="rdestino" style="display:none">
                <td>Destinatario(RFC)</td>
                <td>
                	<input type="text" onblur="checaRFC(this.value)" name="receptor" class="require" id="receptor" value="<?=$RFC?>" />            
                </td>
              </tr>     
              <tr id="">
                <td>Asunto</td>
                <td><input type ="text" class ="large require" name ="asunto" value ="<?=$obj[0]['Asunto']?>"></td>
              </tr>  
              <tr id="rdestino">
                <td>Mensaje</td>
                <td><textarea name="mensaje"  class="large require" rows="6"><?=$obj[0]['Mensaje']?></textarea></td>
              </tr>                                                    
              <tr id="">
                <td>Fecha de expiración</td>
                <td><input type="text" name="fechade" id='fechade' value="<?=$obj[0]['Fecha_Expiracion']?>"  class="require"/></td>
              </tr>  
            </tr>         
        </table>
        <br>

        <input type="hidden" name="t" value="2" />
        <input type="hidden" name="s" id ="txtServ"/>
        <input type="hidden" name="i" value="<?=$obj[0]['ID_Mensaje']?>" />  
        <input type="hidden" name="e" value="<?=$obj[0]['ID_Emisor']?>" />                  
        <div><input type ="button" class ="btn" value ="Guardar" id ="btnSaveNtf"></div>
    </center>   
    <script>
    <?

	if($obj[0]['Alcance']=='GLOBAL')$sel=0;
	if($obj[0]['Alcance']=='DEPENDENCIA')$sel=1;
	if($obj[0]['Alcance']=='UNICO')$sel=2;	
	

	if($sel!=''){	
	?>
			cambia('<?=$obj[0]['Alcance']?>');
			document.getElementById('tipo').selectedIndex=<?=$sel?>;
	<? }?>
    </script>
    <? }?>
</form>