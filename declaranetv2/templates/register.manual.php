
<script>
    
    $(function(){
       $('.btn').button();
       DatePicker($('.date'), "<?=Date('Y-m-d')?>");
       $('.corner').corner();
      
    });
</script>
<?$obj = $context->data;?>
<form id ="register">
    <center>
        <input type ="hidden" name ="id" value ="<?=$obj->ID_Serv?>">
        <table class ="data">
            <tr>
                <td>RFC</td>
                <td><input type ="text" class ="large require clear" name ="RFC" value ="<?=$obj->RFC?>"></td>
            </tr>
            <tr>
                <td>Nombre(s)</td>
                <td><input type ="text" class ="large require clear" name ="name" value ="<?=$obj->Nombre?>"</td>
            </tr>
             <tr>
                <td>Ap. Paterno</td>
                <td><input type ="text" class ="large require clear" name ="paterno" value ="<?=$obj->Paterno?>"></td>
            </tr>
            <tr>
                <td>Ap. Materno</td>
                <td><input type ="text" class ="large require clear" name ="materno" value ="<?=$obj->Materno?>"></td>
            </tr>
             <tr>
                <td>Dependencia</td>
                <td>
                    <select class ="large" name ="dep">
                        <?foreach($context->dep as $d){?>
                        <option value ="<?=$d['ID_Dependencia']?>" <?=($d['ID_Dependencia']==$obj->ID_Dependencia?"selected":"")?>><?=$d['Dependencia']?></option>
                        <?}?>
                    </select>
                </td>
            </tr>
             <tr>
                <td>Cargo Nominal</td>
                <td>
                    <select class ="large" name ="pos">
                        <?foreach($context->pos as $p){?>
                        <option value ="<?=$p['ID_Puesto']?>" <?=($p['ID_Puesto']==$obj->ID_Puesto?"selected":"")?>><?=$p['Puesto']?></option>
                        <?}?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Cargo Funcional</td>
                <td><textarea name ="funcional" cols ="35" rows ="3" class ="require"><?=$obj->Cargo_Funcional?></textarea></td>
            </tr>
            <tr>
                <td>Contratación</td>
                <td>
                    <select class ="large" name ="contra">
                        <option value ="BASE" <?=($obj->Contratacion=="BASE"?"selected":"")?>>BASE</option>
                        <option value ="HONORARIOS" <?=($obj->Contratacion=="HONORARIOS"?"selected":"")?>>HONORARIOS</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Art del AG 172</td>
                <td>
                    <select class ="large" name ="art">
                        <option value ="NO" <?=($obj->AG172=="NO"?"selected":"")?>>NO</option>
                        <option value ="SI" <?=($obj->AG172=="SI"?"selected":"")?>>SI</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Nivel tabular</td>
                <td><input type ="text" class ="numeric require" name ="level" value ="<?=$obj->Nivel?>"></td>
            </tr>
            <tr>
                <td>Área de adscripción</td>
                <td><input type ="text" class ="large require" name ="area" value ="<?=$obj->Area?>"></td>
            </tr>
            <tr>
                <td>Calle de lugar de trabajo</td>
                <td><input type ="text" class ="require large" name ="street_job" value ="<?=$obj->Calle_Trabajo?>"></td>
            </tr>
            <tr>
                <td>Número del lugar de trabajo</td>
                <td><input type ="text" class ="require" name ="num_job" value ="<?=$obj->Num_Trabajo?>"></td>
            </tr>
            <tr>
                <td>Colonia del lugar de trabajo</td>
                <td><input type ="text" class ="require large" name ="col_job" value ="<?=$obj->Col_Trabajo?>"></td>
            </tr>
            <tr>
                <td>C.P. del lugar de trabajo</td>
                <td><input type ="text" class ="require" name ="CP_job" value ="<?=$obj->CP_Trabajo?>" maxlength ="5"></td>
            </tr>
            <tr>
                <td>Ciudad y Estado del lugar de trabajo</td>
                <td><input type ="text" class ="require large" name ="city_job" value ="<?=$obj->Ciudad_Trabajo?>"></td>
            </tr>
            <tr>
                <td>Teléfono de trabajo</td>
                <td><input type ="text" class ="large numeric require" name ="phone" value ="<?=$obj->Tel_Trabajo?>"></td>
            </tr>
            <tr>
                <td>Percepción mensual $</td>
                <td><input type ="text" class ="numeric money" name ="percep" value ="<?=$obj->Per_Mensual?>"></td>
            </tr>
            <tr>
                <td>Toma de posesión</td>
                <td><input type ="text" class ="date require" name ="date" value ="<?=$obj->Fecha_Inicio?>" readonly></td>
            </tr>
        </table>
        <?if(!$obj){?>
        <div class ="section">Funciones</div>
        <div id ="functions" class ="corner">
            <table id ="tbl-functions">
                <?foreach($context->functions as $f){?>
                <tr class ="fn">
                    <td><img src ="img/delete.png" class ="quit" title ="Quitar"></td>
                    <td><?=$f['Funcion']?></td>
                    <input type ="hidden" name ="fn[]" value ="<?=$f['Funcion']?>">
                </tr>
                <?}?>
                <tr>
                    <td><img src ="img/check.png" class ="tooltip" id ="add" title ="Agregar"></td>
                    <td><input type ="text" id ="txtFunction"></td>
                </tr>
            </table>
        </div>
        <div class ="section">Fracciones del artículo 64</div>
        <div id ="fracc" class ="corner">
            <?foreach($context->fracc as $f){?>
            <input type ="checkbox" class ="chkFracc" value ="<?=$f['ID_Fraccion']?>" name ="fracc[]" <?=(in_array($f['ID_Fraccion'], $context->selection)?"checked":"")?>>
            <span class ="label"><?=$f['Fraccion']?></span>
            <? } ?>
        </div>
        <div class ="section">Datos adicionales</div>
        <table class ="data">
            <tr>
                <td>Correo electrónico</td>
                <td><input type ="text" class ="large clear" name ="mail" value ="<?=$obj->Correo?>"></td>
            </tr>
            <tr>
                <td>Contraseña de acceso</td>
                <td><input type ="password" class ="large clear" name ="pwd" value ="<?=$obj->Password?>"></td>
            </tr>
            <tr>
                <td>Calle</td>
                <td><input type ="text" class ="large clear" name ="street" ></td>
            </tr>
            <tr>
                <td>Número</td>
                <td><input type ="text" class ="large clear" name ="num" ></td>
            </tr>
            <tr>
                <td>Colonia</td>
                <td><input type ="text" class ="large clear" name ="col" ></td>
            </tr>
            <tr>
                <td>C.P.</td>
                <td><input type ="text" class ="large numeric clear" name ="CP" maxlength ="1"></td>
            </tr>
            <tr>
                <td>Ciudad y Estado</td>
                <td><input type ="text" class ="large clear" name ="city" ></td>
            </tr>
            <tr>
                <td>Teléfono</td>
                <td><input type ="text" class ="large clear" name ="tel" ></td>
            </tr>
            <tr>
                <td>CURP</td>
                <td><input type ="text" class ="large clear" name ="curp" ></td>
            </tr>
            <tr>
                <td>Estado Civil</td>
                <td>
                    <select name ="civil" class ="large clear">
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
        <?}else{?>
        <br>
        <div class ="section">Resumen de la corrección</div>
        <br>
        <textarea name ="desc" cols ="60" rows ="3" class ="require"></textarea>
        <br>
        <?}?>
        <br>
        <table class ="actions">
            <tr>
                <?if(!$obj){?>
                <td><input type ="checkbox" id ="chkKeep">Conservar datos</td>
                <?}?>
                <td>
                    <input type ="button" value ="<?=($obj?"Corregir":"Registrar")?>" class ="btn" id ="btnRegister">
                </td>
            </tr>
        </table>
    </center>
</form>