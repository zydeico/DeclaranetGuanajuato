<script>
    $(function(){
        $('.btn').button();
        DatePicker($('.date'), "<?=$_SESSION['DT']?>");
        <?if($context->data){?>
           $('.data').find('input:text, select, textarea').attr('disabled', 'disabled');
           $('#cmbType').val("<?=$context->data->Tipo_Inv?>");
           $('#cmbTitular').val("<?=($context->data->Titular_Inv?$context->data->Titular_Inv:"0")?>");
           $('.info').show();
           Change($('#cmbType').val());
           $('#addInversion').hide();
           <?if($context->data->Estatus == 3){?>
              $('#cmbType').find('option[value!="<?=$context->data->Tipo_Inv?>"]').remove();
           <?}?>
        <?}?>
        
        $('#cmbType').change(function(){
            Change($(this).val());
        });
        
        $('#addInversion').click(function(){
           if(Full($('.data'))){
                fakeLoad($(this).parent());
                $.post('declare.php?action=<?=hideVar('save')?>&target=inversiones', $('.data').serialize(), function(data){
                    ready();
                    if(data)
                        $.msgBox({title: "Error", content: data, type: "error"});
                    else{
                        $('#inversiones').remove();
                        Load('inversiones');
                        closeSexy();
                        Counter();
                    }
                });    
           }
           
        });
        
        function Change(val){
            switch(val){
                case "BANCARIA":
                case "INSTITUCION":
                case "OTRO":
                    $('#label-subject').text("Banco/Institución");
                    $('.info').show();
                    $('.acquire').show();
                break;
                case "PRESTAMO":
                    $('#label-subject').text("Persona o denominación social");
                    $('.info').show();
                    $('.acquire').show();
                    $('#account').hide();
                break;
                case "NEGOCIO":
                    $('#label-subject').text("Nombre y giro del negocio");
                    $('.info').show();
                    $('.acquire').show();
                    $('#account').hide();
                break;
                case "AHORRO EN CASA":
                    $('.info').find('input').val('');
                    $('.info').hide();
                    $('.acquire').hide();
                    $('.acquire').find('input').val('');
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
        <?if((in_array($context->data->Estatus, array(0)) && $context->data->ID_Inversion) || $context->canmodify){?>
        <table class ="modify">
            <tr>
                <td>Modificar información</td>
                <td><input type ="checkbox" class ="unblock"></td>
            </tr>
        </table>
        <?}?>
        <div class ="title-manage"><?=($context->data?"Ver":"Agregar")?> inversión</div>
        <input type ="hidden" name ="id" value ="<?=hideVar($context->data->ID_Inversion)?>">
        <input type ="hidden" name ="trans" value ="<?=hideVar($context->data->ID_Trans)?>" id ="txtTrans">
        <table id ="">
            <tr>
                <td>Tipo</td>
                <td>
                    <select class ="large require" name ="type" id ="cmbType">
                        <option value ="">Seleccione...</option>
                        <option value ="AHORRO EN CASA">AHORRO EN CASA</option>
                        <option value ="BANCARIA">CUENTA BANCARIA O CAJA DE AHORRO</option>
                        <option value ="INSTITUCION">INVERSIÓN CON INSTITUCIONES</option>
                        <option value ="PRESTAMO">PRÉSTAMOS EFECTUADOS</option>
                        <option value ="NEGOCIO">NEGOCIO</option>
                        <option value ="OTRO">OTRO</option>
                    </select>
                </td>
            </tr>
            <tr class ="info" style ="display:none">
                <td id ="label-subject">Banco/Institución</td>
                <td><input type ="text" class ="large require" name ="inst" value ="<?=showVar($context->data->Institucion_Inv)?>" <?=($context->data->Estatus == 3?"readonly":"")?>></td> 
            </tr>
            <tr id ="account" class ="info" style ="display:none">
                <td>No. Cuenta</td>
                <td><input type ="text" class ="large require" name ="account" value ="<?=showVar($context->data->Cuenta_Inv)?>" <?=($context->data->Estatus == 3?"readonly":"")?>></td>
            </tr>
            <tr>
                <td>Saldo $</td>
                <td><input type ="text" class ="large require numeric money" name ="balance" value ="<?=number_format($context->data->Saldo, 2)?>"></td>
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
            <tr class ="acquire">
                <td>Fecha de adquisición</td>
                <td><input type ="text" class ="require date" name ="date" value="<?=$context->data->Fecha_Mov?>" readonly></td>
            </tr>
            <tr>
                <td>Comentario (opcional)</td>
                <td><textarea name ="obs" cols ="37" rows ="3"><?=$context->data->Observaciones?></textarea></td>
            </tr>
        </table>
        <br>
        <div><input type ="button" class ="btn" id ="addInversion" value ="Aceptar"></div>
        
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