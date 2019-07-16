<script>
    $(function(){
        DatePicker($('.date'));
        $('.btn').button();
        
        $('#check').click(function(){
           $('#label').find('span').text(($('#check').is(':checked')?"SI":"NO"));
        });
        
        $('#btnSave').click(function(){
            if(Full('#proc-edit')){
                fakeLoad($(this).parent());
                $.post('procedure.php?action=<?=hideVar('save')?>', $('#proc-edit').serialize(), function(data){
                   ready();
                   if(data)
                       $.msgBox({title: "Error", content: data, type: "error"});
                   else{
                        closeSexy();
                        Loading();
                        Grid();
                   }
                });
            }
        });
    });
</script>
<form id ="proc-edit">
    <center>
        <input type ="hidden" name ="id" value ="<?=$context->data->ID_Proc?>">
        <table id ="tbl-edit">
            <tr>
                <td>PRA </td>
                <td><input type ="text" class ="require" name ="pra" value ="<?=$context->data->PRA?>"></td>
            </tr>
            <tr>
                <td>Fecha PRA </td>
                <td><input type ="text" class ="date require" name ="date" value ="<?=$context->data->Fecha_PRA?>"></td>
            </tr>
            <tr>
                <td>Bloqueado </td>
                <td><input type="checkbox" id="check"  class ="btn" name ="bloq" <?=($context->data->Bloqueado?"checked":"NO")?>><label for="check" id ="label"><?=($context->data->Bloqueado?"SI":"NO")?></label></td>
            </tr>
        </table>
        <br>
        <p><input type ="button" class ="btn" id ="btnSave" value ="Guardar"></p>
    </center>
</form>