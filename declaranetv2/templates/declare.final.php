<?$cont = 0;?>
<script>
    var check = new Array();
    $(function(){
        $('.btn').button();
        $('.corner').corner();
        $('.format').buttonset();
        
        $('#<?=$context->struct[$cont++]?>').show();
        for(var i=0; i<$('.title-final').length; i++)
            $('.title-final:eq(' + (i) + ')').append("<br><span class = 'count-final'>(Paso " + (i + 1) + "/" + $('.title-final').length + ")</span>"); 
        
        $('#cmbEstate').change(function(){
            $('#cmbCity').load('declare.php?action=<?=hideVar('cities')?>&id=' + $(this).val());
        });
        
        $('.check').click(function(){
            if($(this).is(':checked')){
                $(this).parent().find('span.ui-button-text').text(' SI ');
                $(this).parents('tr').find('.balance').val('0.00').attr('readonly', 'true');
            }else{
                $(this).parent().find('span.ui-button-text').text('NO');
                $(this).parents('tr').find('.balance').val('').removeAttr('readonly');
            }
        });
        
        $('.prev, .next').click(function(){
            var self = $(this).parents('.final').attr('id');
            var action = $(this).attr('action');
            
            var full = Full('#' + self);
            var index = check.indexOf(self);
            if(!full && index == -1)
               check.push(self);
            else if(full && index > -1)
               check.splice(index, 1);
            
            switch(action){
                case "cancel":
                    $('#panel-final').fadeOut(function(){
                        $('.mask').fadeOut(function(){
                            $(this).remove();
                        });
                    });
                break;
                case "send":
                    if(check.length > 0){
                        Navigate(check[0]);
                        Full('#' + check[0]);
                    }else if ($('#income').length > 0 && $('.inc').length <= 0){
                        $.msgBox({title: "Revise", content: "Debe agregar al menos un tipo de ingreso en el periodo"});
                    }else if($('#income').length > 0 && $("input[name='inc-type[]'][value=1]").length <= 0){
                        $.msgBox({title: "Revise", content: "Aún no declara su SUELDO total del periodo"});
                    }else{
                        $.post('declare.php?action=<?=hideVar('valid')?>', $('#declare').serialize(), function(data){
                           if(data)
                               $.msgBox({title: "Error", content: data, type: "error"});
                           else{
                               $('#panel-final').hide();
                               Loading();
                               $(document.body).append("<div class ='sending-now'>Espere mientras enviamos su información</div>");
                               $('.sending-now').css({
                                   'color': 'white',
                                   'font-size': '14pt',
                                   'position': 'absolute' , 
                                   'top': $('.loading').offset().top + 100,
                                   'left': $(document).width() / 2 - 180, 
                                   'z-index': 100001
                               });
                               $.post('declare.php?action=<?=hideVar('send')?>', $('#declare').serialize(), function(data){
                                   if(isNumeric(data))
                                       location.href = "survey.php?id=" + data;
                                   else{
                                       $('.mask, .loading, .sending-now').remove();
                                       $.msgBox({title: "Error", content: data, type: "error"});
                                   }
                               });
                           }
                        });
                    }
                break;
                default:
                   Navigate(action);
                break;
            }
                
        });
        
        function Navigate(id){
            $('.final').hide();
            $('#' + id).fadeIn();
        }
        
        $('.mov-inver').change(function(){
           var imp = $(this).parent().next().find('input');
           if($(this).val() == "11")
               $(imp).val('0.00');
           else
               $(imp).val('');
           $(imp).focus();
        });
        
        $('#cmbIncome').change(function(){
            $('.income').hide();
            $('.income').find('input, select').val('');
            switch($(this).val()){
                case "1":
                    $('#label-income').text("Sueldo de todo el periodo $");
                    $('.import').slideDown();
                break;
                case "2":
                    $('#label-income').text("Importe $");
                    $('.enterprise').slideDown();
                    $('.import').slideDown();
                break;
                case "3":
                    $('#label-income').text("Importe $");
                    $('.service').slideDown();
                    $('.import').slideDown();
                break;
                case "4":
                    $('#label-income').text("Importe $");
                    $('.rent').slideDown();
                    $('.import').slideDown();
                break;
                case "5":
                    $('#label-income').text("Importe $");
                    $('.other').slideDown();
                    $('.import').slideDown();
                break;
            }
        });
        
        $('#add-income').click(function(){
            if($('#cmbIncome').val()){
                if(Full($('#panel-add'))){
                    var html = "<div class = 'inc'>"
                             + "<table>"
                             + "<td><b>" + $('#cmbIncome').find('option:selected').text() + "</b><br>"
                             + "$" + $('#txtImport').val() + "<br>"
                             + "<span class = 'quitIncome pointer'>Eliminar<span></td></tr>"
                             + "</table>"
                             + "<input type = 'hidden' name = 'inc-type[]' value = '" + $('#cmbIncome').val() + "'>"
                             + "<input type = 'hidden' name = 'inc-razon[]' value = '" + $('#txtRazon').val() + "'>"
                             + "<input type = 'hidden' name = 'inc-service[]' value = '" + $('#txtService').val() + "'>"
                             + "<input type = 'hidden' name = 'inc-contra[]' value = '" + $('#txtContra').val() + "'>"
                             + "<input type = 'hidden' name = 'inc-inmueble[]' value = '" + $('#cmbInmueble').val() + "'>"
                             + "<input type = 'hidden' name = 'inc-concept[]' value = '" + $('#txtConcept').val() + "'>"
                             + "<input type = 'hidden' name = 'inc-import[]' value = '" + $('#txtImport').val() + "'>"
                             + "</div>";
                     $('#list-income').append(html);
                     $('.inc:last').effect('highlight', {color: '#4F77B8'}, 1000);
                     $('.income').hide();
                     $('#cmbIncome').val('');
                }
            }else
                $.msgBox({title: "Revise", content: "Debe seleccionar un tipo de ingreso"});
        });
        
        $('.quitIncome').live('click', function(){
            $(this).parents('.inc').remove();
        });
        
        $('#cancel-income').click(function(){
            $('.watch').removeClass('watch');
            $('.income').hide();
            $('#cmbIncome').val('');
        });
        
        $('#txtPensionCant').focusout(function(){
           if(parseFloat($(this).val()) > 0){
               $('#txtPensionText').addClass('require');
           }else{
               $('#txtPensionText').removeClass('require').val('');
           }
        });
    });
</script>

<form id ="declare">
    <center>
        <div id ="laboral" class ="final">
            <div clasS ="title-final corner">Revise sus datos laborales actuales </div>
            <table class ="income-tbl">
                <tr>
                    <td>Dependencia</td>
                    <td><span class = "readonly"><?=$context->lab->Dependencia?></span></td>
                </tr>
                <tr>
                    <td>Cargo Nominal</td>
                    <td><span class = "readonly"><?=$context->lab->Puesto?></span></td>
                </tr>
                <tr>
                    <td>Fecha de toma de posesión</td>
                    <td><span class = "readonly"><?=$context->lab->Fecha_Inicio?></span></td>
                </tr>
                <tr>
                    <td>Área de adscripción</td>
                    <td><input type ="text" class ="large require" value ="<?=$context->lab->Area?>" name ="area" ></td>
                </tr>
                <tr>
                    <td>Nivel Tabular</td>
                    <td><input type ="text" class ="large require numeric" value ="<?=$context->lab->Nivel?>" name ="level" maxlength ="2"></td>
                </tr>
                <tr>
                    <td>Sueldo Mensual</td>
                    <td><input type ="text" class ="large require money" value ="<?=$context->lab->Per_Mensual?>" name ="percep" ></td>
                </tr>
                <tr>
                    <td>Teléfono de trabajo</td>
                    <td><input type ="text" class ="large require" value ="<?=$context->lab->Tel_Trabajo?>" name ="phonework"></td>
                </tr>
                <tr>
                    <td>Calle de trabajo</td>
                    <td><input type ="text" class ="large require" value ="<?=$context->lab->Calle_Trabajo?>" name ="streetwork"></td>
                </tr>
                <tr>
                    <td>Número de trabajo</td>
                    <td><input type ="text" class ="large require" value ="<?=$context->lab->Num_Trabajo?>" name ="numwork"></td>
                </tr>
                <tr>
                    <td>Colonia de trabajo</td>
                    <td><input type ="text" class ="large require" value ="<?=$context->lab->Col_Trabajo?>" name ="colwork"></td>
                </tr>
                <tr>
                    <td>C.P. de trabajo</td>
                    <td><input type ="text" class ="large require numeric" value ="<?=$context->lab->CP_Trabajo?>" name ="cpwork" maxlength ="5"></td>
                </tr>
                <tr>
                    <td>Ciudad de trabajo</td>
                    <td><input type ="text" class ="large require" value ="<?=$context->lab->Ciudad_Trabajo?>" name ="citywork"></td>
                </tr>
            </table>
            <br>
            <div class ="navigate">
                <input type ="button" class ="btn prev" action ="cancel" value ="(X) Regresar" >
                <input type ="button" class ="btn next" action ="<?=($context->struct[$cont]?$context->struct[$cont]:"send")?>" value ="<?=($context->struct[$cont++]?"Siguiente >":"Terminar y Enviar")?>" >
            </div>
        </div>
        <div id ="personal" class ="final">
            <div clasS ="title-final corner">Actualize su información personal en caso de ser necesario </div>
            <table class ="income-tbl">
                <tr>
                    <td>Calle</td>
                    <td><input type ="text" class ="large require" name ="street" value ="<?=$context->per->Calle?>"></td>
                </tr>
                <tr>
                    <td>Número</td>
                    <td><input type ="text" class ="require" name ="num" value ="<?=$context->per->Numero?>" maxlength ="6"></td>
                </tr>
                <tr>
                    <td>Colonia</td>
                    <td><input type ="text" class ="large require" name ="col" value ="<?=$context->per->Colonia?>"></td>
                </tr>
                <tr>
                    <td>C.P.</td>
                    <td><input type ="text" class ="require numeric" name ="CP" value ="<?=$context->per->CP?>" maxlength ="5"></td>
                </tr>
                <tr>
                    <td>Estado</td>
                    <td>
                        <select class ="large require" name ="estate" id ="cmbEstate">
                            <?foreach($context->estate as $e){?>
                            <option value ="<?=$e['ID_Estado']?>" <?=($e['ID_Estado']==$context->per->ID_Estado?"selected":"")?>><?=$e['Estado']?></option>
                            <?}?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Municipio/Ciudad</td>
                    <td>
                        <select class ="large require" name ="city" id ="cmbCity">
                            <?foreach($context->city as $c){?>
                            <option value ="<?=$c['ID_Ciudad']?>" <?=($c['ID_Ciudad']==$context->per->ID_Ciudad?"selected":"")?>><?=$c['Ciudad']?></option>
                            <?}?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Teléfono Particular</td>
                    <td><input type ="text" class ="large require numeric" name ="phone" value ="<?=$context->per->Telefono?>"></td>
                </tr>
                <tr>
                    <td>Estado Civil</td>
                    <td>
                        <select name ="civil" class ="large require">
                            <option value="Soltero" <?=($context->per->Civil=="Soltero"?"selected":"")?>>Soltero</option>
                            <option value="Casado" <?=($context->per->Civil=="Casado"?"selected":"")?>>Casado</option>    
                            <option value="Divorciado" <?=($context->per->Civil=="Divorciado"?"selected":"")?>>Divorciado</option>                                          
                            <option value="Viudo" <?=($context->per->Civil=="Viudo"?"selected":"")?>>Viudo</option>           
                            <option value="Otro" <?=($context->per->Civil=="Otro"?"selected":"")?>>Otro</option>       
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>CURP</td>
                    <td><input type ="text" class ="large require" name ="curp" value ="<?=$context->per->CURP?>"></td>
                </tr>
            </table>
            <div class ="navigate">
                <input type ="button" class ="btn prev" action ="<?=$context->struct[$cont-2]?>" value ="< Anterior" >
                <input type ="button" class ="btn next" action ="<?=($context->struct[$cont]?$context->struct[$cont]:"send")?>" value ="<?=($context->struct[$cont++]?"Siguiente >":"Terminar y Enviar")?>" >
            </div>
        </div>
        <?if(in_array("sell", $context->struct)){?>
        <div id ="sell" class ="final">
            <div clasS ="title-final corner">
                Capture la cantidad recibida para cada venta realizada <br>
                en su último periodo de contratación ó el año anterior
            </div>
            <div class ="overflow">
                <table class ="income-tbl">
                    <?foreach($context->sell as $s){?>
                    <?$info = explode("|", $s['Info']);?>
                    <tr>
                        <input type ="hidden" name ="id-sell[]" value ="<?=$s['ID']?>">
                        <input type ="hidden" name ="type-sell[]" value ="<?=$info[0]?>">
                        <td>
                            <?for($i=0; $i<count($info); $i++){
                                if($i==0)
                                    echo "<b>" . $info[0] . ":</b> ";
                                else
                                    echo showVar($info[$i]) . " ";
                            }?>
                        </td>
                        <td> $ <input type ="text" class ="require numeric money" name ="sell[]"></td>
                        <td class ="finish">Último pago?</td>
                        <td>
                            <div class ="format">
                                <input type ="checkbox" class ="check" name ="finish-sell-<?=$info[0]?>[]" value ="<?=$s['ID']?>" id ="sell-<?=$info[0]?>-<?=$s['ID']?>"><label for ="sell-<?=$info[0]?>-<?=$s['ID']?>">NO</label>
                            </div>
                        </td>
                    </tr>
                    <?}?>
                </table>
            </div>
            <div class ="navigate">
                <input type ="button" class ="btn prev" action ="<?=$context->struct[$cont-2]?>" value ="< Anterior" >
                <input type ="button" class ="btn next" action ="<?=($context->struct[$cont]?$context->struct[$cont]:"send")?>" value ="<?=($context->struct[$cont++]?"Siguiente >":"Terminar y Enviar")?>" >
            </div>
        </div>
        <?}?>
        <?if(in_array("debt", $context->struct)){?>
        <div id ="debt" class ="final">
            <div clasS ="title-final corner">
                Capture la cantidad pagada para acada adeudo <br>
                en su último periodo de contratación ó el año anterior
            </div>
            <div class ="overflow">
                <table class ="income-tbl">
                    <thead>
                    <th width ="330">Adeudo</th>
                    <th>Cantidad pagada</th>
                    <th>Liquidado?</th>
                    <th>Saldo Final</th>
                    </thead>
                    <?foreach($context->debt as $d){?>
                    <?$info = explode("|", $d['Info']);?>
                    <tr>
                        <input type ="hidden" name ="id-debt[]" value ="<?=$d['ID']?>">
                        <td>
                            <?for($i=0; $i<count($info); $i++){
                                 if($i==0)
                                    echo "<b>" . showVar($info[0]) . ":</b> ";
                                 else
                                    echo showVar($info[$i]) . " ";
                            }?>
                        </td>
                        <td>$ <input type ="text" class ="require numeric money" name ="imp-debt[]" style ="width: 100px"></td>
                        <td>
                            <div class ="format">
                                <input type ="checkbox" class ="check" name ="finish-debt[]" value ="<?=$d['ID']?>" id ="debt-<?=$d['ID']?>"><label for ="debt-<?=$d['ID']?>">NO</label>
                            </div>
                        </td>
                        <td>$ <input type ="text" class ="require numeric money balance" name ="debt[]" style ="width: 100px"></td>
                    </tr>
                    <?}?>
                </table>
            </div>
            <div class ="navigate">
                <input type ="button" class ="btn prev" action ="<?=$context->struct[$cont-2]?>" value ="< Anterior" >
                <input type ="button" class ="btn next" action ="<?=($context->struct[$cont]?$context->struct[$cont]:"send")?>" value ="<?=($context->struct[$cont++]?"Siguiente >":"Terminar y Enviar")?>" >
            </div>
        </div>
        <?}?>
        <?if(in_array("inversment", $context->struct)){?>
        <div id ="inversment" class ="final">
            <div clasS ="title-final corner">
                Capture el saldo y movimientos para cada inversión<br>
                en su último periodo de contratación ó el año anterior
            </div>
            <div class ="overflow">
                <table class ="income-tbl">
                    <thead>
                    <th>Inversión</th>
                    <th width ="130">Total de depósitos</th>
                    <th width ="130">Total de retiros</th>
                    <th width ="130">Saldo Final</th>
                    </thead>
                    <?foreach($context->inver as $in){?>
                        <?$info = explode("|", $in['Info']);?>
                        <tr>
                            <input type ="hidden" name ="id-inver[]" value ="<?=$in['ID']?>">
                            <td width ="300">
                                <?for($i=0; $i<count($info); $i++){
                                     if($i==0)
                                        echo "<b>" . ($info[0]) . "</b>: ";
                                     else
                                        echo showVar($info[$i]) . " ";
                                }?>
                            </td>
                            <td>$ <input type ="text" class ="require numeric money" name ="dep-inver[]" value ="0.00" style ="width: 100px"></td>
                            <td>$ <input type ="text" class ="require numeric money" name ="ret-inver[]" value ="0.00" style ="width: 100px"></td>
                            <td>$ <input type ="text" class ="require numeric money" name ="inver[]" style ="width: 100px"></td>
                        </tr>
                    <?}?>
                </table>
            </div>
            <div class ="navigate">
                <input type ="button" class ="btn prev" action ="<?=$context->struct[$cont-2]?>" value ="< Anterior" >
                <input type ="button" class ="btn next" action ="<?=($context->struct[$cont]?$context->struct[$cont]:"send")?>" value ="<?=($context->struct[$cont++]?"Siguiente >":"Terminar y Enviar")?>" >
            </div>
        </div>
        <?}?>
        <?if(in_array("depend", $context->struct)){?>
        <div id ="depend" class ="final">
            <div clasS ="title-final corner">
                Capture los ingresos anuales de sus dependientes/corresponsables <br>
                en su último periodo de contratación ó el año anterior
            </div>
            <div class ="overflow">
                <table class ="income-tbl">
                    <thead>
                    <th width ="300">Nombre del dependiente</th>
                    <th>Ingresos</th>
                    </thead>
                    <?foreach($context->depend as $de){?>
                    <tr>
                        <input type ="hidden" name ="id-depend[]" value ="<?=$de['ID']?>">
                        <td><?=showVar($de['Nombre_Depend'])?></td>
                        <td>$ <input type ="text" class ="numeric money require" name ="depend[]" value ="0.00"></td>
                    </tr>
                    <?}?>
                </table>
            </div>
            <div class ="navigate">
                <input type ="button" class ="btn prev" action ="<?=$context->struct[$cont-2]?>" value ="< Anterior" >
                <input type ="button" class ="btn next" action ="<?=($context->struct[$cont]?$context->struct[$cont]:"send")?>" value ="<?=($context->struct[$cont++]?"Siguiente >":"Terminar y Enviar")?>" >
            </div>
        </div>
        <?}?>
        <?if(in_array("pension", $context->struct)){?>
        <div id ="pension" class ="final">
            <div clasS ="title-final corner"> 
                Si usted otorga Pensión Alimenticia, en éste espacio registre la cantidad total que haya 
                pagado a sus beneficiarios durante los meses laborados en el año
            </div>
            <div>
                <p>
                    <b>Cantidad total pagada $</b>
                    <br><br>
                    <input type ="text" class ="numeric money" id ="txtPensionCant" name ="pension-cant">
                </p>
                <p>
                    <b>Nombre(s) de los beneficiarios</b>
                    <br> <br>
                    <textarea name ="pension-text" cols="50" rows="5" id ="txtPensionText"></textarea>
                </p>
                
                <div class ="omit-step">Si esta opción no le aplica, pase a la siguiente ventana</div>
               
            </div>
            <div class ="navigate">
                <input type ="button" class ="btn prev" action ="<?=$context->struct[$cont-2]?>" value ="< Anterior" >
                <input type ="button" class ="btn next" action ="<?=($context->struct[$cont]?$context->struct[$cont]:"send")?>" value ="<?=($context->struct[$cont++]?"Siguiente >":"Terminar y Enviar")?>" >
            </div>
        </div>
        <?}?>
        <?if(in_array("income", $context->struct)){?>
        <div id ="income" class ="final">
            <div clasS ="title-final corner"> 
                Capture todos los tipos de ingresos obtenidos<br>
                en su último periodo de contratación ó el año anterior
            </div>
            <div id ="panel-list">
                <div id ="legend-income">Ingresos declarados:</div>
                <div id ="list-income" class ="corner">
                    
                </div>
            </div>
            <div id ="panel-add">
                <table class ="income-tbl">
                    <tr>
                        <td>Tipo de ingreso</td>
                        <td>
                            <select id ="cmbIncome">
                                <option value ="" >Seleccione...</option>
                                <option value ="1">SUELDO</option>
                                <option value ="2">ACTIVIDAD EMPRESARIAL</option>
                                <option value ="3">SERVICIOS PROFESIONALES</option>
                                <option value ="4">ARRENDAMIENTO O INMUEBLE</option>
                                <option value ="5">OTROS</option>
                            </select>
                        </td>
                    </tr>
                    <tr class ="income enterprise">
                        <td>RFC o Razón Social</td>
                        <td><input type ="text" class ="require" id ="txtRazon"></td>
                    </tr>
                    <tr class ="income service">
                        <td>Tipo de servicio</td>
                        <td><input type ="text" class ="require" id ="txtService"></td>
                    </tr>
                    <tr class ="income service">
                        <td>Nombre del contratista</td>
                        <td><input type ="text" class ="require" id ="txtContra"></td>
                    </tr>
                    <tr class ="income rent">
                        <td>Inmueble</td>
                        <td>
                            <select class ="require" id ="cmbInmueble">
                                <?if($context->in){?>
                                <option value ="">Seleccione un inmueble</option>
                                <?foreach($context->in as $i){?>
                                <?$info = explode("|", $i['Info']);?>
                                <option value ="<?=$i['ID']?>">
                                <?foreach($info as $inf){
                                   echo showVar($inf) . " ";
                                }?>
                                </option>
                                <?}?>
                                <?}else{?>
                                <option value ="">No tiene inmuebles declarados</option>
                                <?}?>
                            </select>
                        </td>
                    </tr>
                    <tr class ="income other">
                        <td>Concepto del ingreso</td>
                        <td><input type ="text" class ="require" id ="txtConcept"></td>
                    </tr>
                    <tr class ="income import">
                        <td id ="label-income"></td>
                        <td><input type ="text" class ="require numeric money" id ="txtImport"></td>
                    </tr>
                </table>
                <br>
                <table>
                    <tr>
                        <td><input type e="button" class ="btn" value ="Agregar ingreso" id ="add-income"></td>
                        <td><input type e="button" class ="btn" value ="Cancelar" id ="cancel-income"></td>
                    </tr>
                </table>
            </div>
            <div class ="navigate">
                <input type ="button" class ="btn prev" action ="<?=$context->struct[$cont-2]?>" value ="< Anterior" >
                <input type ="button" class ="btn next" action ="<?=($context->struct[$cont]?$context->struct[$cont]:"send")?>" value ="<?=($context->struct[$cont++]?"Siguiente >":"Terminar y Enviar")?>" >
            </div>
        </div>
        <?}?>
    </center>
</form>