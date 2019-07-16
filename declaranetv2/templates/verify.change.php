<script>
    $(function(){
        $('.btn').button();
        
        $('#btnAsign').click(function(){
           if(Full($('#change'))){
                fakeLoad($(this).parent());
                $.post('verify.php?action=<?=hideVar('change')?>', $('#change').serialize(), function(data){
                    ready();
                    if(data)
                        $.msgBox({title: "Error", content: data, type: "error"});
                    else{
                        Reload(list, 'data/loadVerify.php?year=' + $('#cmbYear').val());
                        closeSexy();
                    }
               });
           }
        });
    });
    
</script>

<form id ="change"> 
    <center>
        <input type ="hidden" name ="id" value ="<?=$context->id?>">
        <table class ="change">
            <tr>
                <td>Usuario responsable</td>
            </tr>
            <tr>
                <td>
                    <select name ="user" class ="large require">
                        <?if(!$context->resp){?>
                        <option value ="">Seleccione...</option>
                        <?}?>
                        <?foreach($context->users as $u){?>
                        <option value ="<?=$u['ID_User']?>" <?=($context->resp==$u['ID_User']?"selected":"")?>><?=$u['Nombre']?></option>
                        <?}?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><input type ="button" class ="btn" value ="Asignar" id ="btnAsign"></td>
            </tr>
        </table>
        
    </center>
</form>