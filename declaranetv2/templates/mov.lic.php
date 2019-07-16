<script>
    $(function(){
       $('.btn').button();
       DatePicker($('.date'), null);
    });
</script>

<form id ="license">
    <input type ="hidden" value ="<?=$context->id?>" name ="id">
    <input type ="hidden" value ="<?=$context->data->ID_Mov?>" name ="mov">
    <center>
        <div class ="section">Rango de licencia</div>
        <table>
            <tr>
                <td>Inicio:</td>
                <td><input type ="text" class ="date require" name="start" value ="<?=$context->data->Inicio?>" readonly></td>
                <td>Fin:</td>
                <td><input type ="text" class ="date" name="end" value ="<?=$context->data->Termino?>" readonly></td>
            </tr>
            <tr>
                <td>Tipo</td>
                <td colspan ="3">
                    <select name ="type" class ="large">
                        <option value ="MEDICA" <?=($context->data->Tipo_Reg=="MEDICA"?"selected":"")?>>MÉDICA</option>
                        <option value ="TRABAJO" <?=($context->data->Tipo_Reg=="TRABAJO"?"selected":"")?>>TRABAJO</option>
                    </select>
                </td>
            </tr>
        </table>
        <div class ="section">Observaciones:</div>
        <textarea name ="obs" cols ="50" rows ="3"><?=$context->data->Motivo?></textarea>
        <div class ="section"><input type ="button" class ="btn" value ="Aceptar" id ="btnLicense"></div>
    </center>
</form>