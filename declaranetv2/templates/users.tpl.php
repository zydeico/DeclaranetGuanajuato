<?function Style($context){?>
<style type ="text/css">
   #btnNewUser {float: right; margin: 1px; }
   #users {margin: 10px auto; }
   #btnChange {margin: 5px auto; }
   #list-profile {width: 90%; height: 200px; overflow: auto; padding: 10px; border: 1px solid #C9CCE7; text-align: left; }
   #list-profile td {padding: 3px 5px; }
   .del-pro {cursor: pointer; }
</style>

<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    var grid;
    
    $(function(){
       <?setGrid("grid", $context->params);?> 
       Reload(grid, 'data/loadUsers.php');
      
      $('#btnNewUser').click(function(){
           doSexy('users.php?action=<?=hideVar('user')?>', 600, 300, "Nuevo usuario");
      });
      
      $('#btnSaveUser').live('click', function(){
         if(Full($('#frm-user'))){
            if($('.change').is(':visible')){
                $.post('users.php?action=<?=hideVar('valid')?>', $('#frm-user').serialize(), function(data){
                   if(data)
                       $.msgBox({title: "Error", content: data, type: "error"});
                   else
                       Save();
                });
            }else
                Save();
         }
      });
      
      $('#btnChange').live('click', function(){
           $(this).parents('tr').hide();
           $('.change').show();
      });
      
      $('#btnAdd').live('click', function(){
           $.get('users.php?action=<?=hideVar('add')?>&id=' + $('#txtID').val() + '&pro=' + $('#cmbProfile').val(), function(data){
               if(data)
                   $.msgBox({title: "Error", content: data, type: "error"});
               else{
                   Reload(grid, 'data/loadUsers.php');
                   doSexy('users.php?action=<?=hideVar('view')?>&id=' + $('#txtID').val(), 500, 300, "Perfiles de usuario");
               }
           });
      });
      
      $('.del-pro').live('click', function(){
           $.get('users.php?action=<?=hideVar('quit')?>&id=' + $(this).attr('id'), function(data){
               if(data)
                   $.msgBox({title: "Error", content: data, type: "error"});
               else{
                   Reload(grid, 'data/loadUsers.php');
                   doSexy('users.php?action=<?=hideVar('view')?>&id=' + $('#txtID').val(), 500, 300, "Perfiles de usuario");
               }
           });
      });
      
    });
    
    function Save(){
        fakeLoad($('#btnSaveUser').parent());
        $.post('users.php?action=<?=hideVar('save')?>', $('#frm-user').serialize(), function(data){
            ready();
            if(isNumeric(data)){
                Reload(grid, 'data/loadUsers.php');
                doSexy('users.php?action=<?=hideVar('view')?>&id=' + data, 500, 300, "Perfiles de usuario");
            }else
                $.msgBox({title: 'Error', content: data, type: 'error'});
                
        });
    }
    
    function Edit(id){
        doSexy('users.php?action=<?=hideVar('user')?>&id=' + id, 600, 300, "Editar usuario");
    }
    
    function Del(id){
        $.msgBox({title: 'Confirme', 
                  content: '¿Seguro de desactivar usuario?', 
                  type: 'confirm', 
                  buttons: [{ value: "OK" }, { value: "Cancelar"}],
                  success: function (result) {
                    if (result == "OK") {
                        $.get('users.php?action=<?=hideVar('del')?>&id=' + id, function(data){
                            if(data)
                                $.msgBox({title: "Error", content: data, type: "error"});
                            else{
                                Reload(grid, 'data/loadUsers.php');
                            }
                        });
                    }
                  }
            });
    }   
    
    function View(id){
        doSexy('users.php?action=<?=hideVar('view')?>&id=' + id, 500, 300, "Perfiles de usuario");
    }
</script>

<? } ?>

<?function Body($context){?>
<div class ="container">
    <div class ="section-title"><?=$context->title?> >_</div>
    <div><input type ="button" class ="btn" value ="Crear usuario" id ="btnNewUser"></div>
    <br>
    <div id ="users">
        <table width="100%"  cellpadding="0" cellspacing="0">		
            <tr>
                 <td id="pager"></td>
            </tr>
            <tr>
                 <td><div id="infopage" style =""></div></td>
            </tr>
            <tr>
                 <td><div id="grid" style ="height: 600px"></div></td>
            </tr>
            <tr>
                 <td class = "RowCount"></td>
            </tr>
        </table>
    </div>
</div>
<? } ?>