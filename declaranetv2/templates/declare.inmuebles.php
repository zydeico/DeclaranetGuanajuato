<script>
    $(function(){
        $('.btn').button();
        DatePicker($('.date'), "<?=$_SESSION['DT']?>");
        <?if($context->data){?>
           $('.data').find('input:text, select, textarea').attr('disabled', 'disabled');
           $('#cmbType').val("<?=$context->data->Tipo_In?>");
           $('#cmbTitular').val("<?=($context->data->Titular_In?$context->data->Titular_In:"0")?>");
           $('#cmbMov').val("<?=$context->data->Tipo_Trans?>");
           $('#cmbForm').val("<?=$context->data->Forma_Trans?>");
           $('#cmbCredit').val("<?=$context->data->ID_Credito?>");
           if($('#cmbMov').val() == 1)
               $('.form').show();
           if($('#cmbForm').val() == "CREDITO")
               $('.credit').show();
           $('#addInmueble').hide();
        <?}?>
        
        $('#cmbMov').change(function(){
            if($(this).val() == 1)
                $('.form').show();
            else{
                $('.form').hide();
                $('.credit').hide('');
                $('#cmbForm').val('');
                $('#cmbCredit').val('');
            }
        });
        
        $('#cmbForm').change(function(){
           if($(this).val() == "CREDITO") 
               $('.credit').show();
           else
               $('.credit').hide();
        });
        
        $('#addInmueble').click(function(){
           if(Full($('.data'))){
                fakeLoad($(this).parent());
                $.post('declare.php?action=<?=hideVar('save')?>&target=inmuebles', $('.data').serialize(), function(data){
                    ready();
                    if(data)
                        $.msgBox({title: "Error", content: data, type: "error"});
                    else{
                        $('#inmuebles').remove();
                        Load('inmuebles');
                        closeSexy();
                        Counter();
                    }
                });    
           }
           
        });
        
        $('#cmbCredit').change(function(){
            if($(this).val() == "ADD")
                doSexy('declare.php?action=<?=hideVar('details')?>&target=adeudos', 700, 380, "Agregar adeudos");
        });
        
        $('#cmbTitular').change(function(){
            if($(this).val() == "ADD")
                doSexy('declare.php?action=<?=hideVar('details')?>&target=dependientes', 700, 350, "Agregar dependiente");
        });
    });
</script>

<form class ="data">
    <center>
        <?if(($context->data->Estatus == 0 && $context->data->ID_Inmueble) || $context->canmodify){?>
        <table class ="modify">
            <tr>
                <td>Modificar información</td>
                <td><input type ="checkbox" class ="unblock"></td>
            </tr>
        </table>
        <?}?>
        <div class ="title-manage"><?=($context->data?"Ver":"Agregar")?> inmueble</div>
        <input type ="hidden" name ="id" value ="<?=hideVar($context->data->ID_Inmueble)?>">
        <input type ="hidden" name ="trans" value ="<?=hideVar($context->data->ID_Trans)?>" id ="txtTrans">
        <table id ="tbl-inmueble">
            <tr>
                <td>Tipo</td>
                <td>
                    <select class ="large require" name ="type" id ="cmbType">
                        <option value ="">Seleccione...</option>
                        <option value ="CASA">CASA HABITACIÓN</option>
                        <option value ="TERRENO">TERRENO</option>
                        <option value ="DEPARTAMENTO">DEPARTAMENTO</option>
                        <option value ="LOCAL">LOCAL COMERCIAL</option>
                        <option value ="OTRO">OTRO</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Superficie</td>
                <td><ul class="m2">
                        <li>Terreno <input type ="text" class ="numeric require tm2" name ="tm2" value ="<?=showVar($context->data->TerrenoM2)?>"> m2</li>
                        <li>Construcción <input type ="text" class ="numeric require" name ="cm2" value ="<?=showVar($context->data->ConstruccionM2)?>"> m2</li>
                    </ul>
                    
                </td>
            </tr>   
            <tr>
                <td>Calle</td>
                <td><input type ="text" class ="large require" name ="street" value ="<?=showVar($context->data->Calle_In)?>"></td>
            </tr>
            <tr>
                <td>Número</td>
                <td><input type ="text" class ="large require" name ="num" value ="<?=showVar($context->data->Numero_In)?>"></td>
            </tr>
            <tr>
                <td>Colonia</td>
                <td><input type ="text" class ="large require" name ="col" value ="<?=showVar($context->data->Colonia_In)?>"></td>
            </tr>
            <tr>
                <td>C.P.</td>
                <td><input type ="text" class ="large numeric require" name ="CP" value ="<?=showVar($context->data->CP_In)?>" maxlength ="5"></td>
            </tr>
            <tr>
                <td>Ciudad y estado</td>
                <td><input type ="text" class ="large require" name ="city" value ="<?=showVar($context->data->Ciudad_In)?>"></td>
            </tr>
            <tr>
                <td>Titular</td>
                <td>
                    <select class ="large require" name ="titular" id ="cmbTitular">
                        <option value ="">Seleccione...</option>
                        <optgroup label ="Propio">
                            <option value ="0">DECLARANTE</option>
                        </optgroup>
                        <?if($context->depend){?>
                        <optgroup label ="Mis dependientes">
                            <?foreach($context->depend as $d){?>
                            <option value ="<?=$d['ID_Depend']?>"><?=showVar($d['Nombre_Depend'])?></option>
                            <?}?>
                        </optgroup>
                        <?}?>
                        <optgroup label ="Otro">
                            <option value ="ADD">AGREGAR DEPENDIENTE</option>
                        </optgroup>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Valor $</td>
                <td><input type ="text" class ="large require numeric money" name ="value" value ="<?=number_format($context->data->Importe, 2)?>"></td>
            </tr>
            <?if($_SESSION['DEC'] != "INICIAL"){?>
            <tr>
                <td>Fecha de adquisición</td>
                <td><input type ="text" class ="require date" name ="date" value ="<?=$context->data->Fecha_Mov?>" readonly></td>
            </tr>
            <tr>
                <td>Tipo de adquisición</td>
                <td>
                    <select class ="large require" name ="mov" id ="cmbMov">
                        <option value ="">Seleccione...</option>
                        <option value ="1">COMPRA</option>
                        <option value ="3">DONACIÓN</option>
                        <option value ="15">CESIÓN</option>
                        <option value ="16">HERENCIA</option>
                        <option value ="17">PERMUTA</option>
                        <option value ="18">RIFA</option>
                        <option value ="19">TRANSPASO</option>
                    </select>
                </td>
            </tr>
            <tr class ="form" style ="display:none">
                <td>Forma de adquisición</td>
                <td>
                    <select class ="large require" name ="form" id ="cmbForm">
                        <option value ="">Seleccione...</option>
                        <option value ="CONTADO">CONTADO</option>
                        <option value ="CREDITO">CRÉDITO</option>
                    </select>
                </td>
            </tr>
            <tr class ="credit" style ="display:none">
                <td>Crédito usado</td>
                <td>
                   <select class ="large require" name ="credit" id ="cmbCredit">
                       <option value ="">Seleccione...</option> 
                        <?if($context->credit){?>
                            <?foreach($context->credit as $c){?>
                            <option value ="<?=$c['ID']?>"><?=$c['Tipo_Ad']?>: <?=showVar($c['Institucion_Ad'])?> - <?=showVar($c['Cuenta_Ad'])?></option>
                            <?}?>
                        <?}?>
                        <option value ="ADD">AGREGAR ADEUDO</option>
                    </select>
                </td>
            </tr>
            <?}?>
            <tr>
                <td>Comentario (opcional)</td>
                <td><textarea name ="obs" cols ="37" rows ="3"><?=$context->data->Observaciones?></textarea></td>
            </tr>
        </table>
        <br>
        <div><input type ="button" class ="btn" id ="addInmueble" value ="Aceptar"></div>
        
        <?if($context->data->Aclaracion){?>
            <div class ="title-coment">Aclaración/Comentario: </div>
            <div class ="coment"><?=$context->data->Aclaracion?></div>
        <?}elseif($context->data->Estatus == "0"){?>
            <input type ="button" class ="btn addcoment" value ="Agregar aclaración" >
        <?}elseif(!$context->data){?>
            <div class ="info-advertise">Para enviar aclaraciones adicionales por favor guarde su información primero y vuelva a abrir sus datos</div>
        <?}?>
            
    </center>
</form>