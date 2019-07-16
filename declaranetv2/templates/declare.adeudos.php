<script>
    $(function(){
        $('.btn').button();
        DatePicker($('.date'), "<?=$_SESSION['DT']?>");
        <?if($context->data){?>
           $('.data').find('input:text, select, textarea').attr('disabled', 'disabled');
           $('#cmbMov').val("<?=$context->data->Tipo_Ad?>");
           $('#cmbTitular').val("<?=($context->data->Titular_Ad?$context->data->Titular_Ad:"0")?>");
           Change("<?=$context->data->Tipo_Ad?>");
           $('#addAdeudo').hide();
           <?if($context->data->Estatus == 3){?>
              $('#cmbMov').find('option[value!="<?=$context->data->Tipo_Ad?>"]').remove();
           <?}?>
        <?}?>
            
        $('#cmbMov').change(function(){
            Change($(this).val());
        });
        
        $('#addAdeudo').click(function(){
           if(Full($('.data'))){
                fakeLoad($(this).parent());
                $.post('declare.php?action=<?=hideVar('save')?>&target=adeudos', $('.data').serialize(), function(data){
                    ready();
                    if(data)
                        $.msgBox({title: "Error", content: data, type: "error"});
                    else{
                        $('#adeudos').remove();
                        Load('adeudos');
                        closeSexy();
                        Counter();
                    }
                });    
           }
           
        });
        
        function Change(val){
            switch(val){
                case "PARTICULAR":
                    $('.account').hide();
                    $('.account').find('input').val('');
                break;
                case "TARJETA":
                    $('.account').find('td:first').text("Número de tarjeta");
                    $('.account').show();
                    $('.terms').hide();
                    $('.terms').find('input').val('');
                    $('.acquire').hide();
                    $('.acquire').find('input').val('');
                break;
                default:
                    $('.account').find('td:first').text("Cuenta o Contrato");
                    $('.account').show();
                    $('.terms').show();
                    $('.acquire').show();
                break;
            }
        }   
        
        $('#cmbTitular').change(function(){
            if($(this).val() == "ADD")
                doSexy('declare.php?action=<?=hideVar('details')?>&target=dependientes', 700, 350, "Agregar dependiente");
        });
    });
</script>

<form class ="data">
    <center>
        <?if((in_array($context->data->Estatus, array(0)) && $context->data->ID_Adeudo) || $context->canmodify){?>
        <table class ="modify">
            <tr>
                <td>Modificar información</td>
                <td><input type ="checkbox" class ="unblock"></td>
            </tr>
        </table>
        <?}?>
        <div class ="title-manage"><?=($context->data?"Ver":"Agregar")?> adeudo</div>
        <input type ="hidden" name ="id" value ="<?=hideVar($context->data->ID_Adeudo)?>">
        <input type ="hidden" name ="trans" value ="<?=hideVar($context->data->ID_Trans)?>" id ="txtTrans">
        <table id ="">
            <tr>
                <td>Tipo</td>
                <td>
                    <select class ="large require" name ="type" id ="cmbMov">
                        <option value ="">Seleccione...</option>
                        <option value ="HIPOTECARIO">CRÉDITO HIPOTECARIO</option>
                        <option value ="INSTITUCION">CRÉDITO CON INSTITUCIONES</option>
                        <option value ="AUTOFINANCIAMIENTO">AUTOFINANCIAMIENTO</option>
                        <option value ="PARTICULAR">PRÉSTAMOS CON PARTICULARES</option>
                        <option value ="TARJETA">TARJETA DE CRÉDITO</option>
                    </select>
                </td>
            <tr>
                <td>Persona, institución o razón social</td>
                <td><input type ="text" class ="large require" name ="inst" value ="<?=showVar($context->data->Institucion_Ad)?>" <?=($context->data->Estatus == 3?"readonly":"")?>></td>
            </tr>
            <tr class ="account">
                <td>Cuenta o contrato</td>
                <td><input type ="text" class ="large require" name ="account" value ="<?=showVar($context->data->Cuenta_Ad)?>" <?=($context->data->Estatus == 3?"readonly":"")?>></td>
            </tr>
            <tr>
                <td>Titular</td>
                <td>
                    <select class ="large require" name ="titular" id ="cmbTitular">
                        <option value ="">Seleccione...</option>
                        <optgroup label ="Propio">
                            <option value ="0">DECLARANTE</option>
                        </optgroup>
                        <?if($context->data->Estatus != 3){?>
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
                        <?}?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Saldo $</td>
                <td><input type ="text" class ="require numeric money" name ="balance" value ="<?=number_format($context->data->Saldo, 2)?>"></td>
            </tr>
            <tr class ="terms">
                <td>Plazo (meses)</td>
                <td><input type ="text" class ="require numeric" name ="term" maxlength ="3" value ="<?=showVar($context->data->Plazo_Ad)?>"></td>
            </tr>
            <tr class ="terms">
                <td>Pago mensual $</td>
                <td><input type ="text" class ="require numeric money" name ="pay" value ="<?=showVar($context->data->Pago_Ad)?>"></td>
            </tr>
            <tr class ="acquire">
                <td>Fecha de adquisición</td>
                <td><input type ="text" class ="require date" name ="date" value ="<?=$context->data->Fecha_Mov?>" readonly></td>
            </tr>
            <tr>
                <td>Comentario (opcional)</td>
                <td><textarea name ="obs" cols ="37" rows ="3"><?=$context->data->Observaciones?></textarea></td>
            </tr>
        </table>
        <br>
        <div><input type ="button" class ="btn" id ="addAdeudo" value ="Aceptar"></div>
        
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