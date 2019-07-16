<script>
    $(function(){
       $('.btn').button(); 
       
       $('#cmbEstate').change(function(){
            $('#cmbCity').load('declare.php?action=<?=hideVar('cities')?>&id=' + $(this).val());
       });
    });
</script>
<form id ="data">
    <input type ="hidden" name ="id" value ="<?=$context->data->ID_Info?>">
    <input type ="hidden" name ="serv" value ="<?=$context->id?>">
    <center>
        <div class ="title-data">Datos del servidor público</div>
        <table>
            <tr>
                <td>Calle</td>
                <td><input type ="text" class ="large require" name ="street" value ="<?=$context->data->Calle?>"></td>
            </tr>
            <tr>
                <td>Número</td>
                <td><input type ="text" class ="large require" name ="num" value ="<?=$context->data->Numero?>"></td>
            </tr>
            <tr>
                <td>Colonia</td>
                <td><input type ="text" class ="large require" name ="col" value ="<?=$context->data->Colonia?>"></td>
            </tr>
            <tr>
                <td>Estado</td>
                <td>
                    <select class ="large require" name ="estate" id ="cmbEstate">
                        <?foreach($context->estate as $e){?>
                        <option value ="<?=$e['ID_Estado']?>" <?=($e['ID_Estado']==$context->data->ID_Estado?"selected":"")?>><?=$e['Estado']?></option>
                        <?}?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Municipio/Ciudad</td>
                <td>
                    <select class ="large require" name ="city" id ="cmbCity">
                        <?foreach($context->cities as $c){?>
                        <option value ="<?=$c['ID_Ciudad']?>" <?=($c['ID_Ciudad']==$context->data->ID_Ciudad?"selected":"")?>><?=$c['Ciudad']?></option>
                        <?}?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Identificación</td>
                <td>
                    <select name ="card" class ="large">
                        <option value ="Credencial de Elector" <?=($context->data->Identificacion=="Credencial de Elector"?"selected":"")?>>Credencial de Elector</option>
                        <option value ="Licencia de Conducir" <?=($context->data->Identificacion=="Licencia de Conducir"?"selected":"")?>>Licencia de Conducir</option>
                        <option value ="Pasaporte" <?=($context->data->Identificacion=="Pasaporte"?"selected":"")?>>Pasaporte</option>
                        <option value ="Cartilla Militar" <?=($context->data->Identificacion=="Cartilla Militar"?"selected":"")?>>Cartilla Militar</option>
                        <option value ="Gafete Oficial" <?=($context->data->Identificacion=="Gafete Oficial"?"selected":"")?>>Gafete Oficial</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Clave de identificación</td>
                <td><input type ="text" class ="large require" name ="key" value ="<?=$context->data->Clave?>"></td>
            </tr>
        </table>
        <br>
        <table class ="actions">
            <tr>
                <td><input type ="button" class ="btn" value ="Generar" id ="btnAgree"></td>
            </tr>
        </table>
    </center>
</form>