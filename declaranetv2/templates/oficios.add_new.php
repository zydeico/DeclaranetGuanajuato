<?php
//include("headers.php");

?>
<script>
    $(function(){
       $('.btn').button(); 
    });
</script>
<style>
tr{
	margin-top:20px;
	}</style>
<div style="width:90%; margin-left:25px; margin-top:25px;" align="center">
        <div style="margin-top:10px;">
         <form action="ofic.php?action=<?=hideVar('save');?>" method="post" id="frm-user">
         <?php
		 if($context->editar == 1){
			 ?>
		   <input type="hidden" value="<?= $context->id; ?>" name="editar" id="editar" />
			 <?php
		 }else{
		 
		 ?>
        <input type="hidden" value="0" name="editar" id="editar" />
         <?php
	}
		 
		 ?>
        <table width="200" border="0">
  <tr>
    <td align="right">Dependencia: </td>
    <td><select name="dependencia" id="dependencia" class="large">
    <?php
	if($context->editar == 1){
	
	
	?>
    
    <option value="<?= $context->data_rowg[0]['ID_Dependencia']; ?>"><?= $context->data_dependencia_name[0]['Dependencia'] ?></option>
    
    <?php
	}
		foreach($context->data_dependencia as $d){
			if($context->data_rowg[0]['ID_Dependencia'] != $d['ID_Dependencia']){
		?>
      	<option value="<?= $d['ID_Dependencia']; ?>"><?= $d['Dependencia']; ?></option>
      <?php
			}
		}
	  ?>
    </select></td>
  </tr>
  <tr>
    <td align="right">Expediente:</td>
    <td>
   <input name="expediente" class="require" id="expediente" type="text" value="<?php
    if($context->editar == 1){
		echo $context->data_rowg[0]['Expediente'];
		 }?>" style="width:366px;"/>
   </td>
  </tr>
  <tr>
    <td align="right">Instrucción:</td>
    <td><textarea name="instrucciones" id="instrucciones" cols="" class="require" rows="" style=" height: 138px;
    width: 366px;"><?php
    if($context->editar == 1){
		echo $context->data_rowg[0]['Instruccion'];
		 }?></textarea></td>
  </tr>
  <tr>
    <td align="right">Responsable:</td>
    <td><select name="responsable" id="responsable" class="large">
    <?php
	
		
		
    if($context->editar == 1){
		
		 ?>
         <option value="<?= $context->d_namee[0]['ID_User']; ?>" selected="selected"><?= $context->d_namee[0]['Nombre']; ?></option>
         <?php
		
		 }
         
         
		foreach($context->data_users as $d){
		if($context->d_namee[0]['ID_User'] != $d['ID_User']){
		?>
      	<option value="<?= $d['ID_User']; ?>"><?= $d['Nombre']; ?></option>
      <?php
		}}
		
	  ?>
   
      
    </select></td>
  </tr>
  <?
  if($context->editar == 1){
  ?>
  <tr>
    <td align="right">Estatus:</td>
    <td><select name="estatus" id="estatus" class="large">
    <?php
	$arr[1]= 'Pendiente';
	  $arr[2]= 'En Tramite';
	  $arr[3]= 'Atendido';
	 if($context->editar == 1){
		 	
			?>
            
            <option value="<?= $context->d_est[0]['Estatusb']?>"><?= $context->d_est[0]['Estatus']?></option>
            <?php
	 }

	 for($i=1; $i<4; $i++){
		  if($i != $context->d_est[0]['Estatusb']){
		  ?>
            <option value="<?= $i; ?>"><?= $arr[$i]; ?></option>
          <?php
		  }
	 }
	  ?>  
    </select></td>
  </tr>
  <?php
  }else{
	  ?>
      <input type="hidden" value="1" name="estatus" id="estatus"/>
      <?php
	  }
  ?>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
    <td>&nbsp;</td>
    <td><div style="margin-left:77px;"><input name="Enviar" id="btnSaveUser" type="button" value="Guardar" class ="btn" /></div></td>
  </tr>
</table>
            </form>
        </div>
    </div>