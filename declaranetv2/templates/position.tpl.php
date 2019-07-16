<?function Style($context){?>
<?}?>
<?function Script($context){?>
<? $puestos = $context->puestos;?>
<script>

	  var grid;		
	$(function(){		  		  
		<? setGrid("grid", $context->params, true);?> 
		Reload(grid, 'data/loadPositions.php');
		$('#btnNewPuesto').click(function(){
		   doSexy('position.php?action=<?=hideVar('addPuesto')?>', 600, 100, "Nuevo puesto");
		});		
		$('#btnSavePuesto').live('click', function(){
		  if(Full($('#frmPuesto'))){
			  $.post('position.php?action=<?=hideVar('savePuesto')?>', $('#frmPuesto').serialize(), function(data){
			  if(data!='')	
			  		$.msgBox({title: "Error", content: data, type: "error"});					
			  else
					$.msgBox({title: "Correcto", content: "Se han guardado los datos", type: "info"});
					closeSexy();
					Reload(grid, 'data/loadPositions.php');
			   });
		  }
		});					   
	});
		function EditPuesto(id){
        	doSexy('position.php?action=<?=hideVar('addPuesto')?>&id=' + id, 600, 100, "Editar puesto");
    	}	    
		function DelPuesto(id){
			$.msgBox({title: 'Confirme', 
					  content: '¿Seguro de eliminar este registro?', 
					  type: 'confirm', 
					  buttons: [{ value: "OK" }, { value: "Cancelar"}],
					  success: function (result) {
						if (result == "OK") {
							$.get('position.php?action=<?=hideVar('delPuesto')?>&id=' + id, function(data){
								if(data)
									$.msgBox({title: "Error", content: data, type: "error"});
								else{
											
									Reload(grid, 'data/loadReactivos.php');
									
								}
							});
						}
					  }
				});
		}		
	</script>
<?}?>
<? function Body($context){
?>
<div class ="container">
    <div class ="section-title"><?=$context->title?> >_ </div>	
    <div><input type ="button" class ="btn" value ="Agregar puesto" id ="btnNewPuesto"></div>
    <br>
    <div id ="pruestos">
        <table width="100%"  cellpadding="0" cellspacing="0">		
            <tr>
                 <td id="pager"></td>
            </tr>
            <tr>
                 <td><div id="infopage" style =""></div></td>
            </tr>
            <tr>
                 <td><div id="grid" style ="height: 760px"></div></td>
            </tr>
            <tr>
                 <td class = "RowCount"></td>
            </tr>
        </table>
    </div>
<? }?>
