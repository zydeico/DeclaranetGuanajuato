<script>
    $(function(){
       $('.btn').button();
       $('.corner').corner();
       DatePicker($('.date'), "<?=$_SESSION['DT']?>");
       $('#cmbOcupacion').val("<?=showVar($context->data->Ocupacion_Depend)?>");
       ChangeOcup();
       
       $('#cmbForm').change(function(){
          switch($(this).val()){
              case "CONTADO":
                  $('.credit').hide();
                  $('.credit').find('input, select').val('');
              break;
              case "CREDITO":
                  $('.credit').show();
              break;
          }
       });
       
       $('#btnManage').click(function(){
            if(Full($('#manage'))){
                fakeLoad($(this).parent());
                $.post('declare.php?action=<?=hideVar('manage')?>', $('#manage').serialize(), function(data){
                    ready();
                    if(data)
                        $.msgBox({title: "Error", content: data, type: "error"});
                    else{
                        $('#<?=$context->target?>').remove();
                        Load("<?=$context->target?>");
                        closeSexy();
                        Counter();
                    }
                });
            }
       });
       
       $('#cmbOcupacion').change(function(){
            ChangeOcup();
       });
       
       function ChangeOcup(){
            if($('#cmbOcupacion').val() == "TRABAJA")
                $('.job').show();
            else
                $('.job').hide();
        }
    });
</script>

<form id ="manage">
    <center>
        <div class ="label-manage">Ingrese los datos solicitados</div>
        <input type ="hidden" name ="id" value ="<?=($context->id)?>">
        <input type ="hidden" name ="target" value ="<?=$context->target?>">
        <input type ="hidden" name ="opt" value ="<?=$context->opt?>">
        <table class ="manage corner">
        <?if($context->opt == 2){?>
            <tr>
                <td>Fecha de venta</td>
                <td><input type ="text" class ="date require" name ="date" readonly></td>
            </tr> 
            <tr>
                <td>Importe de venta $</td>
                <td><input type ="text" class ="require numeric money" name ="value"></td>
            </tr>
            <tr>
                <td>Tipo de venta</td>
                <td>
                    <select name ="form" class ="large require" id ="cmbForm">
                        <option value ="">Seleccione...</option>
                        <option value ="CONTADO">CONTADO</option>
                        <option value ="CREDITO">CREDITO</option>
                    </select>
                </td>
            </tr>
            <tr class ="credit" style ="display:none">
                <td>Plazo</td>
                <td>
                    <input type ="text" class ="require numeric" name ="term" style ="width:50px"> 
                    <select class ="require" name ="period" style ="width: 100px">
                        <option value ="">Seleccione</option>
                        <option value ="MES(ES)">MES(ES)</option>
                        <option value ="AÑO(S)">AÑO(S)</option>
                    </select>       
                </td>
            </tr>
        <?}elseif($context->opt == 4){?>
            <tr>
                <td>Fecha de donación</td>
                <td><input type ="text" class ="require date" name ="date" readonly></td>
            </tr>
            <tr>
                <td>Nombre del beneficiario</td>
                <td><input type ="text" class ="require large" name ="benefit"></td>
            </tr>
            <tr>
                <td>Parentesco</td>
                <td><input type ="text" class ="require large" name ="relation"></td>
            </tr>
        <?}elseif($context->opt == 5){?>
            <tr>
                <td>Fecha de pérdida</td>
                <td><input type ="text" class ="require date" name ="date" readonly></td>
            </tr>
            <tr>
                <td>Describa el motivo de la pérdida</td>
                <td><textarea class ="require" cols ="40" rows ="5" name ="motive"></textarea></td>
            </tr>
        <?}elseif($context->opt == 6){?>
            <tr>
                <td>Fecha de separación</td>
                <td><input type ="text" class ="date require" name ="date" readonly></td>
            </tr> 
        <?}elseif($context->opt == 7){?>
            <tr>
                <td>Fecha de liquidación</td>
                <td><input type ="text" class ="date require" name ="date" readonly></td>
            </tr> 
            <tr>
                <td>Monto del pago final $</td>
                <td><input type ="text" class ="require numeric money" name ="value"></td>
            </tr>
        <?}elseif($context->opt == 8){?>
            <tr>
                <td>Fecha de término</td>
                <td><input type ="text" class ="date require" name ="date" readonly></td>
            </tr> 
            <tr>
                <td>Saldo final de la inversión $</td>
                <td><input type ="text" class ="require numeric money" name ="value"></td>
            </tr>
        <?}elseif($context->opt == 9){?>
            <tr>
                <td>Fecha de cancelación</td>
                <td><input type ="text" class ="require date" name ="date" readonly></td>
            </tr>
            <tr>
                <td>Describa el motivo de la cancelación</td>
                <td><textarea class ="require" cols ="40" rows ="5" name ="motive"></textarea></td>
            </tr>
        <?}elseif($context->opt == 12){?>
            <tr>
                <td>Domicilio</td>
                <td><input type ="text" name ="direc" class ="large require" value ="<?=showVar($context->data->Domicilio_Depend)?>"></td>
            </tr>
            <tr>
                <td>Ocupación</td>
                <td>
                    <select name ="ocupacion" class ="large require" id ="cmbOcupacion">
                        <option value ="">Seleccione...</option>
                        <option value ="TRABAJA">TRABAJA</option>
                        <option value ="ESTUDIANTE">ESTUDIANTE</option>
                        <option value ="HOGAR">HOGAR</option>
                        <option value ="OTRO">OTRO</option>
                    </select>
                </td>
            </tr>
            <tr class ="job" style ="display:none">
                <td>Lugar de trabajo</td>
                <td><input type ="text" class ="require large" name ="job_place" value ="<?=showVar($context->data->Lugar_Trabajo)?>"></td>
            </tr>
            <tr class ="job" style ="display:none">
                <td>Domicilio de trabajo</td>
                <td><input type ="text" class ="require large" name ="job_address" value ="<?=showVar($context->data->Domicilio_Trabajo)?>"></td>
            </tr>
        <?}?>
        </table>
        <br>
        <div><input type ="button" class ="btn" value ="Aceptar" id ="btnManage"></div>
    </center>
</form>