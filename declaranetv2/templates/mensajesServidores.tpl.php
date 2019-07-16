<?function Style($context){?>
<?}?>
<?function Script($context){?>
 <script>
    $(function(){	  		   
		$( "#accordion" ).accordion({
			collapsible:true,
			active:false
		});		  
	});	
		  
		  
</script>
<?}?>
<? function Body($context){
$allow=$context->allow;	
$notificaciones=$context->notificaciones;	
	?>
<div class ="container">
    <div class ="section-title"><?=$context->title?> >_</div>
       
    <div id="accordion">
    <? if($notificaciones){
            foreach($notificaciones as $notificacion){
            ?>
                <h3 align="left"><?=$notificacion['Asunto']?> (<?=DateFormat($notificacion['Fecha_Creacion'],1)?>)</h3>
                <div>
                    <p align="justify"><?=$notificacion['Mensaje']?></p>
                </div>
        <? }//foreach
        }else{?>
            <p>No hay mensajes sin leer en este momento</p>
    <? 	}//else?>
    </div>       

</div>
<? }?>