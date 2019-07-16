<span id ="profile-info">Permisos para: <?=$context->profile?></span>
<input type ="hidden" name="id"  value ="<?=$context->id?>">
<div class ="over">
    <table id ="list-permission">
        <?$temp = "";?>
        <?foreach($context->permission as $p){?>
            <?if($temp != $p['Grupo']){?>
                <?$temp = $p['Grupo'];?>
                <tr>
                    <td colspan ="2" class ="section"><?=$temp?></td>
                </tr>
            <?}?>
            <tr>
                <td><input type ="checkbox" name ="permission[]" class ="chkPermission" value ="<?=$p['ID_Permiso']?>" <?=(in_array($p['ID_Permiso'], $context->access)?"checked":"")?>></td>
                <td class ="legend"><?=$p['Permiso']?></td>
            </tr>
        <?}?>
    </table>
</div>
<input type ="button" class ="btn" value ="Guardar cambios" id ="btnSave">