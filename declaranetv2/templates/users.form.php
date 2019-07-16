<script>
    $(function(){
       $('.btn').button(); 
    });
</script>
    

<?$obj = $context->data;?> 
<form id ="frm-user">
    <input type ="hidden" name ="id" value ="<?=$obj->ID_User?>">
    <center>
        <table>
            <tr>
                <td>Nombre</td>
                <td><input type ="text" class ="large require" name ="name" value ="<?=$obj->Nombre?>"></td>
            </tr>
            <tr>
                <td>Ap. Paterno</td>
                <td><input type ="text" class ="large require" name ="paterno" value ="<?=$obj->Paterno?>"></td>
            </tr>
            <tr>
                <td>Ap. Materno</td>
                <td><input type ="text" class ="large require" name ="materno" value ="<?=$obj->Materno?>"></td>
            </tr>
            <tr>
                <td>Correo</td>
                <td><input type ="text" class ="large require" name ="mail" value ="<?=$obj->User?>"></td>
            </tr>
            <tr class ="<?=($obj?"":"hidden")?>">
                <td>Contraseña</td>
                <td><input type ="button" class ="btn" value ="Cambiar clave" id ="btnChange"></td>
            </tr>
            <tr class ="change <?=($obj?"hidden":"")?>">
                <td>Contraseña</td>
                <td><input type ="password" class ="large require" name ="pwd" id ="txtPwd"></td>
            </tr>
            <tr class ="change <?=($obj?"hidden":"")?>">
                <td>Confirme</td>
                <td><input type ="password" class ="large require" name ="confirm" id ="txtConfirm"></td>
            </tr>
            <tr>
                <td>Tipo</td>
                <td>
                    <select name ="type" class ="large">
                        <option value ="REST" <?=($obj->Tipo=="REST"?"selected":"")?>>RESTRINGIDO</option>
                        <option value ="GLOBAL" <?=($obj->Tipo=="GLOBAL"?"selected":"")?>>GLOBAL</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Dependencia</td>
                <td>
                    <select name ="dep" class ="large require">
                        <?foreach($context->dep as $d){?>
                        <option value ="<?=$d['ID_Dependencia']?>" <?=($d['ID_Dependencia']==$obj->ID_Dependencia?"selected":"")?>><?=$d['Dependencia']?></option>
                        <?}?>
                    </select>
                </td>
            </tr>
        </table>
        <br>
        <div><input type ="button" class ="btn" value ="Guardar" id ="btnSaveUser"></div>
    </center>
</form>