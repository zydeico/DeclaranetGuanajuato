<script>
    $(function(){
        $('.btn').button();
        <?if($context->data){?>
           $('.data').find('input:text, select, textarea').attr('disabled', 'disabled');
           $('#cmbType').val("<?=$context->data->Tipo_Depend?>");
           $('#cmbOcupacion').val("<?=showVar($context->data->Ocupacion_Depend)?>");
           <?$exp = explode("-", $context->data->Nacimiento_Depend);?>
           $('#txtDay').val("<?=$exp[2]?>");
           $('#cmbMonth').val("<?=$exp[1]?>");
           $('#cmbYear').val("<?=$exp[0]?>");
           Change($('#cmbOcupacion').val());
           $('#addDepend').hide();
        <?}?>
            
        $('#cmbOcupacion').change(function(){
            Change($(this).val());
        });
    
        $('#addDepend').click(function(){
           if(Full($('.data'))){
                fakeLoad($(this).parent());
                $.post('declare.php?action=<?=hideVar('save')?>&target=dependientes', $('.data').serialize(), function(data){
                    ready();
                    if(data)
                        $.msgBox({title: "Error", content: data, type: "error"});
                    else{
                        $('#dependientes').remove();
                        Load('dependientes');
                        closeSexy();
                        Counter();
                    }
                });    
            }
           
        });
        
        function Change(val){
            if(val == "TRABAJA")
                $('.job').show();
            else
                $('.job').hide();
        }
    });
</script>

<form class ="data">
    <center>
        <?if(($context->data->Estatus == 0 && $context->data->ID_Depend) || $context->canmodify){?>
        <table class ="modify">
            <tr>
                <td>Modificar información</td>
                <td><input type ="checkbox" class ="unblock"></td>
            </tr>
        </table>
        <?}?>
        <div class ="title-manage"><?=($context->data?"Ver":"Agregar")?> cónyuge/dependiente</div>
        <input type ="hidden" name ="id" value ="<?=hideVar($context->data->ID_Depend)?>">
        <input type ="hidden" name ="trans" value ="<?=hideVar($context->data->ID_Trans)?>" id ="txtTrans">
        <table id ="tbl-depend">
            <tr>
                <td>Parentesco</td>
                <td>
                    <select name ="relation" class ="large require" id ="cmbType">
                        <option value ="">Seleccione...</option>
                        <option value ="CONYUGE">CÓNYUGE</option>
                        <option value ="HIJO">HIJO(A)</option>
                        <option value ="HERMANO">HERMANO(A)</option>
                        <option value ="PADRE">PADRE</option>
                        <option value ="MADRE">MADRE</option>
                        <option value ="OTRO">OTRO</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Nombre completo</td>
                <td><input type ="text" name ="name" class ="large require" value ="<?=showVar($context->data->Nombre_Depend)?>"></td>
            </tr>
            <tr>
                <td>RFC</td>
                <td><input type ="text" name ="RFC" class ="large require" value ="<?=showVar($context->data->RFC_Depend)?>" maxlength ="10"></td>
            </tr>
            <tr>
                <td>CURP</td>
                <td><input type="text" size="70" name="CURP" class="large require" value="<?=showVar($context->data->CURP_Depend)?>"  /></td>
            </tr> 
            <tr>
                <td>Domicilio</td>
                <td><input type ="text" name ="direc" class ="large require" value ="<?=showVar($context->data->Domicilio_Depend)?>"></td>
            </tr>
<!--            <tr>
                <td>Fecha de nacimiento</td>
                <td>
                    <table class ="small">
                        <tr>
                            <td>Día</td>
                            <td><input type ="text" class ="small numeric require" name ="day" maxlength ="2" style ="width: 30px" id ="txtDay"></td>
                            <td>Mes</td>
                            <td>
                                <select class ="require" name ="month" style ="width: 70px" id ="cmbMonth">
                                    <option value ="" selected>Seleccione...</option>
                                    <option value ="01">Enero</option>
                                    <option value ="02">Febrero</option>
                                    <option value ="03">Marzo</option>
                                    <option value ="04">Abril</option>
                                    <option value ="05">Mayo</option>
                                    <option value ="06">Junio</option>
                                    <option value ="07">Julio</option>
                                    <option value ="08">Agosto</option>
                                    <option value ="09">Septiembre</option>
                                    <option value ="10">Octubre</option>
                                    <option value ="11">Noviembre</option>
                                    <option value ="12">Diciembre</option>
                                </select>
                            </td>
                            <td>Año</td>
                            <td>
                                <select class ="require" name ="year" style ="width: 70px" id ="cmbYear">
                                    <option value ="">Seleccione...</option>
                                    <?for($i=Date('Y'); $i>=Date('Y') - 100; $i--){?>
                                    <option value ="<?=$i?>"><?=$i?></option>
                                    <?}?>
                                </select>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>-->
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
                <td><input type ="text" class ="require large" name ="place" value ="<?=showVar($context->data->Lugar_Trabajo)?>"></td>
            </tr>
            <tr class ="job" style ="display:none">
                <td>Domicilio de trabajo</td>
                <td><input type ="text" class ="require large" name ="address" value ="<?=showVar($context->data->Domicilio_Trabajo)?>"></td>
            </tr>
<!--            <tr>
                <td>Ingresos Anuales $</td>
                <td><input type ="text" class ="large numeric money require" name ="aport" value ="<?=number_format($context->data->Importe, 2)?>" id ="txtAport"></td>
            </tr>-->
            <tr>
                <td>Comentario (opcional)</td>
                <td><textarea name ="obs" cols ="37" rows ="3"><?=$context->data->Observaciones?></textarea></td>
            </tr>
        </table>
        <br>
        <div><input type ="button" class ="btn" id ="addDepend" value ="Aceptar"></div>
        
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


