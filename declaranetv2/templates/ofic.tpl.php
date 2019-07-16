<? function Style($context){?>
<style type ="text/css">
   #btnNewUser {float: right; margin: 1px; }
   #users {margin: 10px auto; }
   #btnChange {margin: 5px auto; }
   #list-profile {width: 90%; height: 230px; overflow: auto; padding: 10px; border: 1px solid #C9CCE7; text-align: left; }
   #list-profile td {padding: 3px 5px; }
   .del-pro {cursor: pointer; }
</style>

<? } ?>

<? function Script($context){?>
<?php
		$permiso_para_agregar = 57;
		$add = "0";
		foreach($_SESSION['attrib_ac'] as $key=>$val){ 
		   if($val == $permiso_para_agregar){
			   $add = "1";
			}
		} 
	?>

<script type ="text/javascript">
    var grid;
    function Edit(id){
        doSexy('ofic.php?action=<?=hideVar('editar')?>&id=' + id, 550, 340, "Editar oficio");
    	}
		
		function Edit_user(id){
        doSexy('ofic.php?action=<?=hideVar('editar_user')?>&id=' + id, 400, 110, "Cambiar usuario");
    	}
	  
	   function Save(){
		  
        closeSexy();
        Loading();
        $.post('ofic.php?action=<?=hideVar('save')?>', $('#frm-user').serialize(), 		 	function(data){
           // $('.mask, .loading').remove();
               <?php
	if($add == 1){
		echo "Reload(grid, 'data/loadOffice.php?add=1');";
		}else{
			echo "Reload(grid, 'data/loadOffice.php');";
			}
	
	?>
        });
    }
	
	 $('#btnSaveUser').live('click', function(){
         if(Full($('#frm-user'))){
           Save();
         }
      });
	  
	   function Saveb(){
        closeSexy();
       // Loading();
        $.post('ofic.php?action=<?=hideVar('save_user')?>', $('#frm-userb').serialize(), function(data){
            $('.mask, .loading').remove();
            
               <?php
	if($add == 1){
		echo "Reload(grid, 'data/loadOffice.php?add=1');";
		}else{
			echo "Reload(grid, 'data/loadOffice.php');";
			}
	?>
        });
    }
	
	 $('#btnSaveUserb').live('click', function(){
         if(Full($('#frm-userb'))){
           Saveb();
         }
      });

	function Borrar(id_g){
        $.msgBox({title: 'Confirme', 
                  content: '¿Seguro de Borrar este oficio?', 
                  type: 'confirm', 
                  buttons: [{ value: "OK" }, { value: "Cancelar"}],
                  success: function (result) {
                    if (result == "OK") {
                        $.get('ofic.php?action=<?=hideVar('Borrar')?>&id='+id_g, 				  	function(data){
                            <?php
	if($add == 1){
		echo "Reload(grid, 'data/loadOffice.php?add=1');";
		}else{
			echo "Reload(grid, 'data/loadOffice.php');";
			}
	
	?>
                        });
                    }
                  }
            });
    } 
	  
	  
		
	$(function(){
       <?setGrid("grid", $context->params, true);?> 
	    
	<?php
	if($add == 1){
		echo "Reload(grid, 'data/loadOffice.php?add=1');";
		}else{
			echo "Reload(grid, 'data/loadOffice.php');";
			}
	
	?>
       
      
        $('#btnNewUser').click(function(){
                 doSexy('ofic.php?action=<?=hideVar('nuevo')?>', 550, 315, "Nuevo oficio");
        });
	  
	  
	
	
    });
     
</script>

<? } ?>

<?function Body($context){?>
<div class ="container">
    <div class ="section-title"><?=$context->title?> >_</div>
    <?php
		$permiso_para_agregar = 57;
		$add = "0";
		foreach($_SESSION['attrib_ac'] as $key=>$val){ 
		   if($val == $permiso_para_agregar){
			   $add = "1";
			}
		} 
	?>

    <?php
	 if($add == 1){?>
    <div><input type ="button" class ="btn" value ="Crear Oficio" id ="btnNewUser"></div>
    <br>
    <?php } ?>
    <div id ="users">
        <table width="100%"  cellpadding="0" cellspacing="0">		
            <tr>
                 <td id="pager"></td>
            </tr>
            <tr>
                 <td><div id="infopage" style =""></div></td>
            </tr>
            <tr>
                 <td><div id="grid" style ="height: 750px"></div></td>
            </tr>
            <tr>
                 <td class = "RowCount"></td>
            </tr>
        </table>
    </div>
</div>
<? } ?>