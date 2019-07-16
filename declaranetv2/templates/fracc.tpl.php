<?function Style($context){?>
<?}?>
<?function Script($context){?>
<? $puestos = $context->puestos;?>
<script>

	  var grid;		
	$(function(){		  		  
		<? setGrid("grid", $context->params, true);?> 
		Reload(grid, 'data/loadFracc.php');
		$('#btnNewFraccion').click(function(){
		   doSexy('fracc.php?action=<?=hideVar('addFraccion')?>', 600, 300, "Nueva fracción");
		});		
		$('#btnSaveFraccion').live('click', function(){
		  if(Full($('#frmFraccion'))){
			  $.post('fracc.php?action=<?=hideVar('saveFraccion')?>', $('#frmFraccion').serialize(), function(data){
			  if(data!='')	
			  		$.msgBox({title: "Error", content: data, type: "error"});					
			  else
					$.msgBox({title: "Correcto", content: "Se han guardado los datos", type: "info"});
					closeSexy();
					Reload(grid, 'data/loadFracc.php');
			   });
		  }
		});					   
	});
		function EditFraccion(id){
        	doSexy('fracc.php?action=<?=hideVar('addFraccion')?>&id=' + id, 600, 300, "Editar fracción");
    	}	    
		function DelFraccion(id){
			$.msgBox({title: 'Confirme', 
					  content: '¿Seguro de eliminar este registro?', 
					  type: 'confirm', 
					  buttons: [{ value: "OK" }, { value: "Cancelar"}],
					  success: function (result) {
						if (result == "OK") {
							$.get('fracc.php?action=<?=hideVar('delFraccion')?>&id=' + id, function(data){
								if(data)
									$.msgBox({title: "Error", content: data, type: "error"});
								else{
											
									Reload(grid, 'data/loadFracc.php');
									
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
    <div><input type ="button" class ="btn" value ="Agregar fracción" id ="btnNewFraccion"></div>
    <br>
    <div id ="fracciones">
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
