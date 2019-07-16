<script>
    $(function(){
       $('.btn').button();
       DatePicker($('.date'), "<?=Date('Y-m-d')?>");
       
       $('#cmbEstate').change(function(){
            $('#cmbCity').load('declare.php?action=<?=hideVar('cities')?>&id=' + $(this).val());
       });
    });
</script>
<form id ="register">
    <center>
    <div class ="section">Datos del Servidor</div>
    <table class ="data">
        <tr>
            <td>RFC</td>
            <td><input type ="text" class ="large require clear" name ="RFC" value ="<?=$obj->RFC?>" id ="txtRFC" maxlength ="10"></td>
        </tr>
        <tr>
            <td>Nombre(s)</td>
            <td><input type ="text" class ="large require clear" name ="name" value ="<?=$obj->Nombre?>" id ="txtName"></td>
        </tr>
         <tr>
            <td>Ap. Paterno</td>
            <td><input type ="text" class ="large require clear" name ="paterno" value ="<?=$obj->Paterno?>" id ="txtPatern"></td>
        </tr>
        <tr>
            <td>Ap. Materno</td>
            <td><input type ="text" class ="large require clear" name ="materno" value ="<?=$obj->Materno?>" id ="txtMatern"></td>
        </tr>
        <tr>
            <td>Toma de posesión</td>
            <td><input type ="text" class ="date require" name ="date" value ="<?=$obj->Fecha_Inicio?>" readonly id ="txtDate"></td>
        </tr>
    </table>
    <div class ="section">Datos adicionales</div>
    <table class ="data">
        <tr>
            <td>Percepción mensual $</td>
            <td><input type ="text" class ="numeric money" name ="percep" value ="<?=$obj->Per_Mensual?>" id ="txtPercep"></td>
        </tr>
        <tr>
            <td>Correo electrónico</td>
            <td><input type ="text" class ="large clear" name ="mail" value ="<?=$obj->Correo?>" id ="txtEmail"></td>
        </tr>
        <tr>
            <td>Calle</td>
            <td><input type ="text" class ="large clear" name ="street" id ="txtStreet"></td>
        </tr>
        <tr>
            <td>Número</td>
            <td><input type ="text" class ="large clear" name ="num" id ="txtNum"></td>
        </tr>
        <tr>
            <td>Colonia</td>
            <td><input type ="text" class ="large clear" name ="col" id ="txtCol"></td>
        </tr>
        <tr>
            <td>C.P.</td>
            <td><input type ="text" class ="large numeric clear" name ="CP" id ="txtCP" maxlength ="5"></td>
        </tr>
        <tr>
            <td>Estado</td>
            <td>
                <select class ="large" name ="estate" id ="cmbEstate">
                    <option value ="">Seleccione...</option>
                    <?foreach($context->estate as $e){?>
                    <option value ="<?=$e['ID_Estado']?>" <?=($e['ID_Estado']==$context->per->ID_Estado?"selected":"")?>><?=$e['Estado']?></option>
                    <?}?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Municipio/Ciudad</td>
            <td>
                <select class ="large" name ="city" id ="cmbCity">
                    <option value ="">Seleccione...</option>
                    <?foreach($context->city as $c){?>
                    <option value ="<?=$c['ID_Ciudad']?>" <?=($c['ID_Ciudad']==$context->per->ID_Ciudad?"selected":"")?>><?=$c['Ciudad']?></option>
                    <?}?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Teléfono</td>
            <td><input type ="text" class ="large clear" name ="tel" id ="txtTel"></td>
        </tr>
        <tr>
            <td>CURP</td>
            <td><input type ="text" class ="large clear" name ="curp" id ="txtCURP"></td>
        </tr>
        <tr>
            <td>Estado Civil</td>
            <td>
                <select name ="civil" class ="large clear" id ="cmbCivil">
                    <option value ="">Seleccione</option>
                    <option value ="SOLTERO">SOLTERO</option>
                    <option value ="CASADO">CASADO</option>
                    <option value ="DIVORCIADO">DIVORCIADO</option>
                    <option value ="VIUDO">VIUDO</option>
                    <option value ="OTRO">OTRO</option>
                </select>
            </td>
        </tr>
    </table>
    <br>
    <input type ="button" class ="btn" value ="Continuar" id ="btnContinue">
    </center>
</form>