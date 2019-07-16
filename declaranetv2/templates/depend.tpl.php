<?function Style($context){?>
<?}?>
<?function Script($context){?>
<? $puestos = $context->puestos;?>
<script>

	  var grid;		
	$(function(){		  		  
		<? setGrid("grid", $context->params, true);?> 
		Reload(grid, 'data/loadDepend.php');
		$('#btnNewDependencia').click(function(){
		   doSexy('depend.php?action=<?=hideVar('addDependencia')?>', 600, 100, "Nueva dependencia");
		});		
		$('#btnSaveDependencia').live('click', function(){
		  if(Full($('#frmDependencia'))){
			  $.post('depend.php?action=<?=hideVar('saveDependencia')?>', $('#frmDependencia').serialize(), function(data){
			  if(data!='')	
			  		$.msgBox({title: "Error", content: data, type: "error"});					
			  else
					$.msgBox({title: "Correcto", content: "Se han guardado los datos", type: "info"});
					closeSexy();
					Reload(grid, 'data/loadDepend.php');
			   });
		  }
		});					   
	});
		function EditDependencia(id){
        	doSexy('depend.php?action=<?=hideVar('addDependencia')?>&id=' + id, 600, 100, "Editar dependencia");
    	}	    
		function DelDependencia(id){
			$.msgBox({title: 'Confirme', 
					  content: '¿Seguro de eliminar este registro?', 
					  type: 'confirm', 
					  buttons: [{ value: "OK" }, { value: "Cancelar"}],
					  success: function (result) {
						if (result == "OK") {
							$.get('depend.php?action=<?=hideVar('delDependencia')?>&id=' + id, function(data){
								if(data)
									$.msgBox({title: "Error", content: data, type: "error"});
								else{
											
									Reload(grid, 'data/loadDepend.php');
									
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
    <div><input type ="button" class ="btn" value ="Agregar dependencia" id ="btnNewDependencia"></div>
    <br>
    <div id ="dependencias">
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
