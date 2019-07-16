<script>
    $(function(){
       $('.btn').button(); 
       
       $('#cmbQuestion').change(function(){
          switch($(this).val()){
              case "1":
                  $('.opt-plus, .opt-item').show();
                  break;
              case "2":
                  $('.opt-plus').hide();
                  $('.opt-item').hide().find('input').val('');
                  break;
          }
       });
       
       $('#cmbQuestion').trigger('change');
    });
</script>
    

<?$reactivo = $context->reactivosEdit;?> 
<form id ="frmReactivos">
    <input type="hidden" name="id"  id="id" value="<?=$reactivo->ID_Reactivo?>" >
    <center>
        <table id="preguntas">
            <tr>
                <td>Tipo de pregunta</td>
                <td>
                    <select class="" id ="cmbQuestion">
                        <option value ="1">Opción múltiple</option>
                        <option value ="2" <?=($reactivo && !$reactivo->Opciones?"selected":"")?>>Abierta</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Pregunta</td>
                <td><input type="text" class="large require" name="pregunta" id="pregunta" value="<?=$reactivo->Reactivo?>"></td>
            </tr>
            <tr class ="opt-plus">
                <td>Opciones</td>
                <td><div  onclick="agrega_campos()" style="cursor:pointer"><img width="20px" src="img/add.png" title="Agregar"/></div></td>
            </tr>              
        <? $opciones=explode("|",$reactivo->Opciones);
		$x=0;
			foreach($opciones as $opcion){
				$x++;
					?>
                        <tr id="<?=$x?>" class ="opt-item">
                            <td>
                            	Opcion <?=$x?>:</td><td><input type="text" class="require" name="opt[]" id="opt<?=$opcion?>" value="<?=$opcion?>"  />
                                <? if($x>1){?>
                                	<img src="img/delete.png" style="cursor:pointer" onclick="elimina_me('<?=$x?>')">
								<? }?>
                            </td>
                        </tr>                     
		<? }?>              
        </table>               
        
        <br />

        <input type="hidden" name="contadorTotal" id="contadorTotal" value="<?=$x?>" />
        <input type ="button" class ="btn" value ="Guardar" id ="btnSaveReactivos">
    </center>
</form>

