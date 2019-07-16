<script>
    $(function(){
       $('.btn').button(); 
    });
</script>

<?php
//include("headers.php");

 $d_est = $context->arr;
?>
  <div style=" margin-left: 50px;
    margin-top: 16px;">
     <form action="ofic.php?action=<?=hideVar('save_user');?>" method="post" id="frm-userb">
     <input type="hidden" value="<?= $context->v_id; ?>" name="id" id="id" />
    <select name="estatus" id="estatus" class="large">
    <option value="<?= $d_est[0]['Estatusb']?>"><?= $d_est[0]['Estatus']?></option>
      <?php
	  $arr[1]= 'Pendiente';
	  $arr[2]= 'En Tramite';
	  $arr[3]= 'Atendido';
	  for($i=1; $i<4; $i++){
		  if($i != $d_est[0]['Estatusb']){
		  ?>
            <option value="<?= $i; ?>"><?= $arr[$i]; ?></option>
          <?php
		  }}
	  ?>   
    </select>
    <br />
    <br />
    <div style="margin-left:105px;"><input name="Enviar" type="button" value="Guardar" class ="btn" id="btnSaveUserb"/></div>
    
    </form>
  </div>
