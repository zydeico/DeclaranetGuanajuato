<?php
		//echo $_SESSION['CHAT'];
		if($_SESSION['CHAT'] == 1){
			
				$e_chat = 1;
			
			}else{
				$e_chat = 0;
				}
		
		
		?>
        <script>
        estado_chat = <?= $e_chat; ?>
		</script>
<?php
session_start();

if(isset($_GET['st']))
    $_SESSION['CHAT'] = $_GET['st'];

$base_dir_img = "chat/images/";
$base_dir_path = "chat/";
?>
<script>
	var base_dir_img = '<?= $base_dir_img; ?>';
	var base_dir_path = '<?= $base_dir_path; ?>';
	
	var no_nuevo = 0;
</script>
<script src="<?= $base_dir_path; ?>js/socket.io.js" type="text/javascript"></script>
<?php

if($_SESSION['CHAT'] == 1){
	$hay_chat = 1;
	}else{
		$hay_chat = 0;
		}
?>
<script>
        var hay_chat = <?= $hay_chat; ?>;
</script>
        
<?php
//if($_SESSION['CU'] == 1){
if($_SESSION['PRO'] == "#SP"){?>
<script type ="text/javascript">
var nombre = '<?= substr($_SESSION[NM], 0,strpos($_SESSION[NM], ' '))."_".rand(1000, 9999); ?>';
</script>
<link href="<?= $base_dir_path; ?>css/chat_sp.css" rel="stylesheet" type="text/css" />
<script src="<?= $base_dir_path; ?>js/chat_sp.js" type="text/javascript"></script>

    <div id="contenedor_chat" align="center">
    	<img src="<?= $base_dir_img; ?>conectar.png" width="164" height="49" onclick="abrir_chat('<?= $_SESSION[NM]; ?>');" id="img_connect">
      	<br />
      	<div id="dialog_box">
        	<div id="to_apend" align="left">Por el momento no hay asesores disponibles, por favor intente más tarde...<br />
            </div>
            <input name="" type="text" id="to_read" disabled="disabled"/>
          	<input type="button" id="sub_button" value="enviar"/>
        </div>
    </div>  
                                    
<?php
//}elseif($_SESSION['CU'] == 2){
	
}elseif(in_array(44, $_SESSION['PM'])){ // Asesor?>

<script type ="text/javascript">
var nombre = '<?= substr($_SESSION[NM], 0,strpos($_SESSION[NM], ' '))."_"; ?>';
window.onbeforeunload = function() {
	n_data = $("#pegar_elementos").html();
	jQuery.ajax({
        url: base_dir_path+'store.php',
        type: 'POST',
		async: false,
        data: {
            content: n_data
        }
    });
      //socket.emit('send', { message: "el usuario abandono la conversación", de: nombre, action: 'mensaje', para: de_server});
  }
</script>

<link href="<?= $base_dir_path; ?>css/chat_asesor.css" rel="stylesheet" type="text/css" />
<script src="<?= $base_dir_path; ?>js/chat_asesor.js" type="text/javascript"></script>
<div id="contenedor_chat" align="center">
<div id ="chat-legend">Estado de conexión en chat</div>
<div id ="switch-chat"></div>
<!--<select name="" id="cambiar_status" onchange="cambiar_status(this.value); ">
                <option value="1" <?=($_SESSION['CHAT']?"selected":"")?>>Conectado</option>
                <option value="0" <?=($_SESSION['CHAT']?"":"selected")?>>Desconectado</option>
            </select>-->
            <br />
            <div id="conversacion_n">
        <table width="" border="0" id="pegar_elementos">
        
		<?php
		
		
		if(isset($_SESSION['content']) and ($_SESSION['CHAT'] == 1)){
				echo $_SESSION['content'];
				
				?>
                <script>
                no_nuevo = 1;
                </script>
                <?php
			}
		?>
        
          <tr>
            <td id="td_alert" id="td_n0" style="display:none;">
            <div id="alerta_nuevo_12" style="width:130px; background-color:#F00;" onclick="ver_chat_n('12')">patttttor</div>
           	<div id="chat_box_12" class="chat_box_n">
            <div style="cursor:pointer;" onclick="ocultar_chat_n('12')"><img src="<?= $base_dir_img; ?>minimizar.png" width="36" height="36" /></div>
            <div style="cursor:pointer;">terminar conversacion</div>
            <textarea name="" cols="10" rows="" style="height: 268px;
    width: 195px; overflow:scroll; overflow-x: hidden;"></textarea>
            <input name="" type="text" style="width: 111px;"/>
            <input name="enviar" type="button" value="enviar" style="width: 62px;"/>
            </div>
            </td>
          </tr>
        </table>
        </div>
</div>


<?php } ?> 