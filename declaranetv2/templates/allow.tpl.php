<?function Style($context){?>
<style type ="text/css">
    #profiles {float: left;width: 40%; }
    .section {background-color: #D1E5FF; text-align: center; padding: 5px; font-weight: bold; }
    .over {overflow: auto; height: 550px; }
    #permission {font-size: 9pt; width: 50%; height: 600px; float: right; }
    #list-permission {width: 100%; }
    #profile-info {padding: 15px; font-size: 10pt; margin: 15px auto; }
    #btnSave {margin: 15px ; }
    #newProfile {font-size:  10pt; margin: 15px auto; }
</style>

<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    var grid;
    
    $(function(){
       <?setGrid("grid", $context->params);?> 
       grid.loadXML('data/loadProfile.php');
       
       $('#btnSave').live('click', function(){
          Loading();
          $.post('allow.php?action=<?=hideVar('save')?>', $('#permission').serialize(), function(data){
              $('.mask, .loading').remove();
              if(data)
                  $.msgBox({title: 'Error', content: data, type: 'error'});
          });
       });
       
       $('#newProfile').click(function(){
           doSexy('allow.php?action=<?=hideVar('profile')?>', 400, 150, "Nuevo perfil");
       });
        
       $('#btnSaveProfile').live('click', function(){
          closeSexy();
          $.post('allow.php?action=<?=hideVar('saveProfile')?>', $('#frm-profile').serialize(), function(data){
              if(data)
                  $.msgBox({title: 'Error', content: data, type: 'error'});
              else{
                  grid.clearAll();
                  grid.loadXML('data/loadProfile.php');
              }
          }) 
       });
      
    });
    
    function View(id){
        $('#permission').load('allow.php?action=<?=hideVar('load')?>&id=' + id, function(){
            $('.btn').button();
        });
    
    }
    
    function Edit(id){
        doSexy('allow.php?action=<?=hideVar('profile')?>&id=' + id, 400, 150, "Modificar perfil");
    }
    
    function Del(id){
        $.msgBox({
            title: "Confirme",
            content: "Seguro de eliminar este perfil?",
            type: "confirm",
            buttons: [{ value: "OK" }, { value: "Cancelar"}],
            success: function (result) {
                if (result == "OK") {
                    $.get('allow.php?action=<?=hideVar('del')?>&id=' + id, function(data){
                        if(data)
                            $.msgBox({title: 'Error', content: data, type: 'error'});
                        else{
                            grid.clearAll();
                            grid.loadXML('data/loadProfile.php');
                            $('#permission').empty();
                        }
                    });
                }
            }
        });
    }
</script>

<? } ?>

<?function Body($context){?>
<div class ="container">
    <div class ="section-title"><?=$context->title?> >_</div>
    <div id ="profiles">
        <table width="100%"  cellpadding="0" cellspacing="0">		
            <tr>
                 <td id="pager"></td>
            </tr>
            <tr>
                 <td><div id="infopage" style =""></div></td>
            </tr>
            <tr>
                 <td><div id="grid" style ="height: 300px"></div></td>
            </tr>
            <tr>
                 <td class = "RowCount"></td>
            </tr>
        </table>
        <input type ="button" class ="btn" value ="Crear perfil" id ="newProfile">
    </div>
    <form id ="permission">
        
    </form>
</div>
<? } ?>

