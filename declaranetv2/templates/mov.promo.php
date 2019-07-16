<script>
    $(function(){
        $('.btn').button();
        DatePicker($('.date'), "<?=Date('Y-m-d')?>");
        $('.corner').corner();
       
    });
</script>

<form id ="promo">
    <center>
        <input type ="hidden" name ="id" value ="<?=$context->id?>">
        <table>
            <tr>
                <td>Servidor público</td>
                <td class ="label"><?=$context->data->Nombre?></td>
            </tr>
            <tr>
                <td>Cargo Nominal</td>
                <td>
                    <select name ="pos" class ="large">
                        <?foreach($context->pos as $p){?>
                        <option value ="<?=$p['ID_Puesto']?>" <?=($p['ID_Puesto']==$context->data->ID_Puesto?"selected":"")?> ><?=$p['Puesto']?></option>
                        <?}?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Cargo Funcional</td>
                <td><textarea name ="funcional" class ="require" cols ="37" rows ="4"><?=$context->data->Cargo_Funcional?></textarea></td>
            </tr>
            <tr>
                <td>Área de adscripción</td>
                <td><input type ="text" class ="require large" name ="area" value ="<?=$context->data->Area?>"></td>
            </tr>
            <tr>
                <td>Nivel tabular</td>
                <td><input type ="text" class ="numeric require large" name ="level" value ="<?=$context->data->Nivel?>"></td>
            </tr>
            <tr>
                <td>Fecha de término del cargo anterior </td>
                <td><input type ="text" class ="require date large" name ="date" readonly></td>
            </tr>
        </table> 
        <div class ="section">Funciones</div>
        <div id ="fn-iist" class ="corner">
            <table id ="fn-tbl">
                <?foreach($context->functions as $f){?>
                <tr class ="fn">
                    <td><img src ="img/delete.png" class ="quit" title ="Quitar"></td>
                    <td><?=$f['Funcion']?></td>
                    <input type ="hidden" name ="fn[]" value ="<?=$f['Funcion']?>">
                </tr>
                <?}?>
                <tr>
                    <td><img src ="img/check.png" id ="addFn" title ="Agregar" class ="tooltip"></td>
                    <td><input type ="text" class ="large" id ="txtFn"></td>
                </tr>
            </table>
        </div>
        <?$fracc = explode("|", $context->data->ART64);?>
        <div class ="section">Fracciones</div>
        <div id ="fracc" class ="corner">
            <?foreach($context->fracc as $f){?>
            <input type ="checkbox" name ="fracc[]" class ="chkfracc" value ="<?=$f['ID_Fraccion']?>" <?=(in_array($f['ID_Fraccion'], $fracc)?"checked":"")?>>
            <span class ="fracc-label"><?=$f['Fraccion']?></span>
            <?}?>
        </div>
        <table class ="actions">
            <tr>
                <td><input type ="button" class ="btn" value ="Aceptar" id ="btnPromo"></td>
            </tr>
        </table>
    </center>
</form>