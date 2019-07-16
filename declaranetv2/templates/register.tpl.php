<?function Style($context){?>
<style type ="text/css">
   .method {width: 995; min-height: 100px; border: 1px solid #CACCE7; margin: 10px auto;}
   .title {background-color: #D1E5FF; padding: 5px 10px; text-align: left; }
   #btnNew {margin: 15px auto; }
   #functions {border: 1px solid #CACCE7; height: 200px; overflow: auto; padding: 5px 10px; margin: 5px auto; width: 70%; text-align: left; }
   #fracc {border: 1px solid #CACCE7; height: 40px; overflow: auto; margin: 5px auto; padding: 10px; width: 70%;}
   #serv-list {border: 1px solid #CACCE7; height: 200px; overflow: auto; margin: 5px auto; padding: 5px; width: 70%;}
   #tbl-serv {width: 99%; }
   .section {margin: 20px auto; color: #2D5FAB; width: 70%; font-weight: bold;}
   .list-title {color: #B42142; width: 70%; margin: 15px auto; font-weight: bold; }
   .quit-serv {cursor: pointer; }
   .label {color: #2D5FAB; font-size: 9pt; padding-right: 10px; }
   #add {cursor: pointer; }
   #auto-add {cursor: pointer; }
   #txtFunction {width: 520px; }
   #txtAutoFunction {width: 480px; }
   #tbl-functions td{font-size: 9pt; }
   .quit {cursor: pointer; }
   .auto-quit {cursor: pointer; }
   .actions {font-size: 9pt; }
   .component {border: 1px solid #CACCE7; padding: 10px; width: 90%; margin: 10px auto;}
   .separate {margin: 10px auto; }
   #btnUp {margin: 15px auto; }
   #dialog {overflow: auto; }
   .msg {color: #AE203A; margin: 10px;}
   .result {width: 99%; font-size: 10pt; margin: 5px auto; border-collapse: collapse;}
   .result th {background-color: #D1E5FF; padding: 5px; }
   .result td {padding: 3px 5px; font-style: oblique; }
   .center {text-align: center;}
   
</style>
<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    
    $(function(){
       $( "#tabs" ).tabs();
    
       $("#dialog").dialog({height: <?=($context->error?500:100)?>, width: 700, modal: true});
       
       $('#add').live('click', function(){
          if($('#txtFunction').val() != ""){
            var html = "<tr class = 'fn'>"
                     + "<td><img src = 'img/delete.png' class = 'quit' title = 'Quitar'></td>"
                     + "<td>" + $('#txtFunction').val()
                     + "<input type = 'hidden' name = 'fn[]' value = '" + $('#txtFunction').val() + "'>"
                     + "</td>"
                     + "</tr>";
            if($('.fn').length > 0){
                $('.fn:last').after(html);
            }else{
              $('#add').parents('tr').before(html);
            }
            $('#txtFunction').val('');
            $('#txtFunction').focus();
          }
       });
       
       $('#auto-add').live('click', function(){
          if($('#txtAutoFunction').val() != ""){
            var html = "<tr class = 'auto-fn'>"
                     + "<td><img src = 'img/delete.png' class = 'auto-quit' title = 'Quitar'></td>"
                     + "<td>" + $('#txtAutoFunction').val()
                     + "<input type = 'hidden' name = 'auto-fn[]' value = '" + $('#txtAutoFunction').val() + "'>"
                     + "</td>"
                     + "</tr>";
            if($('.auto-fn').length > 0){
                $('.auto-fn:last').after(html);
            }else{
              $('#auto-add').parents('tr').before(html);
            }
            $('#txtAutoFunction').val('');
            $('#txtAutoFunction').focus();
          }
       });
       
       $('.quit').live('click', function(){
           $(this).parents('tr').remove();
       });
       
       $('.auto-quit').live('click', function(){
           $(this).parents('tr').remove();
       });
        
       $('#btnAdd').click(function(){
           doSexy('register.php?action=<?=hideVar('add')?>', 700, $(window).height() - 100, "Agregar servidor público");
       });
       
       $('.quit-serv').live('click', function(){
          $(this).parents('tr').remove(); 
       });
       
       $('#btnContinue').live('click', function(){
          if(Full($('#register'))){
              var check = true;
              $('.serv').each(function(){
                  if($(this).find('b').text() == $('#txtRFC').val().toUpperCase())
                      check = false;
              });
              if(check){
                $.post('register.php?action=<?=hideVar('check')?>&dep=' + $('#cmbDepManual').val(), $('#register').serialize(), function(data){
                    if(data)
                        $.msgBox({title: "Revise", content: data});
                    else{
                        var elem = "<tr class = 'serv'>"
                                 + "<td width = '20'><img src = 'img/delete.png' class = 'quit-serv' title = 'Quitar'></td>"
                                 + "<td><b>" + $('#txtRFC').val().toUpperCase() + "</b> - " + $('#txtName').val() + " " + $('#txtPatern').val() + " " + $('#txtMatern').val() + " (" + $('#txtDate').val() + ")"
                                 + "<input type = 'hidden' name = 'rfc[]' value = '" + $('#txtRFC').val() + "'>"
                                 + "<input type = 'hidden' name = 'name[]' value = '" + $('#txtName').val() + "'>"
                                 + "<input type = 'hidden' name = 'patern[]' value = '" + $('#txtPatern').val() + "'>"
                                 + "<input type = 'hidden' name = 'matern[]' value = '" + $('#txtMatern').val() + "'>"
                                 + "<input type = 'hidden' name = 'date[]' value = '" + $('#txtDate').val() + "'>"
                                 + "<input type = 'hidden' name = 'percep[]' value = '" + $('#txtPercep').val() + "'>"
                                 + "<input type = 'hidden' name = 'mail[]' value = '" + $('#txtEmail').val() + "'>"
                                 + "<input type = 'hidden' name = 'pwd[]' value = '" + $('#txtPwd').val() + "'>"
                                 + "<input type = 'hidden' name = 'street[]' value = '" + $('#txtStreet').val() + "'>"
                                 + "<input type = 'hidden' name = 'num[]' value = '" + $('#txtNum').val() + "'>"
                                 + "<input type = 'hidden' name = 'col[]' value = '" + $('#txtCol').val() + "'>"
                                 + "<input type = 'hidden' name = 'CP[]' value = '" + $('#txtCP').val() + "'>"
                                 + "<input type = 'hidden' name = 'city[]' value = '" + $('#cmbCity').val() + "'>"
                                 + "<input type = 'hidden' name = 'tel[]' value = '" + $('#txtTel').val() + "'>"
                                 + "<input type = 'hidden' name = 'curp[]' value = '" + $('#txtCURP').val() + "'>"
                                 + "<input type = 'hidden' name = 'civil[]' value = '" + $('#cmbCivil').val() + "'>"
                                 + "</td>"
                                 + "</tr>";
                         $('#tbl-serv').append(elem);
                         doSexy('register.php?action=<?=hideVar('add')?>', 700, $(window).height() - 100, "Agregar servidor público");
                    }
                });
              }else
                $.msgBox({title: "Revise", content: "Ya agregó este RFC anteriormente"});
          } 
       });
       
       $('#btnRegister').live('click', function(){
          if(Full($('#manual'))){
              if($('.fn').length > 0){
                 if($('.chkFracc:checked').length > 0){
                    if($('.serv').length > 0){
                        Loading();
                        $.post('register.php?action=<?=hideVar('save')?>', $('#manual').serialize(), function(data){
                            $('.mask, .loading').remove();
                            if(data){
                                $.msgBox({title: "Error", content: data, type: "error"});
                            }else{
                                $.msgBox({title: "OK", content: "Datos guardados correctamente", type:"info"});
                                $('#manual').find('input:text').val('');
                                $('#manual').find('textarea').val('');
                                $('#manual').find('select').each(function(){
                                    $(this).find('option:first').attr('selected', 'selected');
                                });
                                $('.fn').remove();
                                $('.chkFracc').removeAttr('checked');
                                $('.serv').remove();
                            }                     
                        });
                    }else
                        $.msgBox({title: "Revise", content: "No se ha agregado ningún servidor aún"});
                  }else{
                      $.msgBox({title: "Revise", content: "Debe seleccionar al menos una fracción"});
                  }
              }else{
                  $.msgBox({title: "Revise", content: "Debe agregar al menos una función"});
              }
          }
       });
       
       $('#btnUp').click(function(){
            if($('#cmbDepAuto').val() != ""){
                if($('#cmbPos').val() != ""){
                    if($('.chkFracc:checked').length > 0){
                        if($('.auto-fn').length > 0){
                            if($('#txtFile').val() != ""){
                                Loading();
                                setTimeout(function(){$('#auto').submit();}, 1000);
                            }else
                                $.msgBox({title:"Revise", content: "No ha seleccionado la plantilla a cargar"});
                        }else
                            $.msgBox({title:"Revise", content: "Debe agregar al menos una función para todos los registros"});
                    }else
                        $.msgBox({title: "Revise", content: "Debe seleccionar al menos una fracción para todos los registros"});
                }else
                    $.msgBox({title: "Revise", content: "Debe seleccionar un cargo nominal para toda la plantills"});
            }else
                $.msgBox({title: "Revise", content: "Debe seleccionar una dependencia"});
       });
       
    });
</script>

<? } ?>

<?function Body($context){?>
<div class ="container">
    <div class ="section-title"><?=$context->title?> >_</div>
    <div id ="tabs">
        <ul>
            <?if(in_array(11, $context->allow)){?>
            <li><a href ="#auto">Automática</a></li>
            <?}?>
            <?if(in_array(10, $context->allow)){?>
            <li><a href ="#manual">Manual</a></li>
            <?}?>
        </ul>
        <?if(in_array(11, $context->allow)){?>
        <form id ="auto" action="register.php" method ="post" enctype = "multipart/form-data">
            <div class ="separate">1.- Descargue la plantilla</div>
            <div class ="component corner">
                <a href ="media/plantilla.xls"><img src ="img/excel-template.png" width ="50" height ="50" title ="Descargar" class ="tooltip"></a>
            </div>
            <div class ="separate">2.- Complete los Campos Obligatorios</div>
            <div class ="component corner">
                 <div id ="panel1">
                    <div class ="section">Dependencia</div>
                    <select id ="cmbDepAuto" name ="auto-dep">
                         <?if($_SESSION['TP'] == "GLOBAL"){?>
                         <option value ="">Seleccione...</option>
                         <?}?>
                         <?foreach($context->dep as $d){?>
                         <option value ="<?=$d['ID_Dependencia']?>" <?=($d['ID_Dependencia']==$context->autodep?"selected":"")?>><?=$d['Dependencia']?></option>
                         <?}?>
                    </select>
                    <div class ="section">Cargo Nominal</div>
                    <select id ="cmbPos" name ="auto-pos">
                        <option value ="">Seleccione...</option>
                        <?foreach($context->pos as $p){?>
                        <option value ="<?=$p['ID_Puesto']?>" <?=($p['ID_Puesto']==$context->autopos?"selected":"")?>><?=$p['Puesto']?></option>
                        <?}?>
                    </select>
                    <div class ="section">Fracciones del artículo 64</div>
                    <div id ="fracc" class ="corner">
                        <?foreach($context->fracc as $f){?>
                        <input type ="checkbox" class ="chkFracc" value ="<?=$f['ID_Fraccion']?>" name ="auto-fracc[]" <?=(in_array($f['ID_Fraccion'], $context->selection)?"checked":"")?>>
                        <span class ="label"><?=$f['Fraccion']?></span>
                        <? } ?>
                    </div>
                    <div class ="section">Funciones que encuadran por lo previsto por el art 64 de la LRASP</div>
                    <div id ="functions" class ="corner">
                        <table id ="tbl-functions">
                            <?foreach($context->functions as $f){?>
                            <tr class ="auto-fn">
                                <td><img src ="img/delete.png" class ="auto-quit" title ="Quitar"></td>
                                <td><?=$f?></td>
                                <input type ="hidden" name ="auto-fn[]" value ="<?=$f?>">
                            </tr>
                            <?}?>
                            <tr>
                                <td><img src ="img/check.png" class ="tooltip" id ="auto-add" title ="Agregar"></td>
                                <td><input type ="text" id ="txtAutoFunction"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class ="separate">3.- Cargue la plantilla</div>
            <div class ="component corner">
                <input type ="file" name ="template" id ="txtFile">
                <br>
                <input type ="button" class ="btn" value ="Subir" id ="btnUp">
            </div>
        </form>
        <?}?>
        
        <?if(in_array(10, $context->allow)){?>
        <form id ="manual">
            <div class ="section">Datos Generales</div>
            <table class ="data">
                 <tr>
                    <td>Dependencia</td>
                    <td>
                        <select class ="large" name ="dep" id ="cmbDepManual">
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
                    <td><textarea name ="funcional" cols ="42" rows ="3" class ="require"><?=$obj->Cargo_Funcional?></textarea></td>
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
                    <td><input type ="text" class ="numeric require" name ="level" value ="<?=$obj->Nivel?>" maxlength ="2"></td>
                </tr>
                <tr>
                    <td>Área de adscripción</td>
                    <td><input type ="text" class ="large require" name ="area" value ="<?=$obj->Area?>"></td>
                </tr>
            </table>
            <div class ="section">Datos del lugar de trabajo</div>
            <table class ="data">
                <tr>
                    <td>Teléfono</td>
                    <td><input type ="text" class ="large numeric require" name ="tel_work" value ="<?=$obj->Tel_Trabajo?>"></td>
                </tr>
                <tr>
                    <td>Calle</td>
                    <td><input type ="text" class ="large require" name ="calle_work" value ="<?=$obj->Calle_Trabajo?>"></td>
                </tr>
                <tr>
                    <td>Número</td>
                    <td><input type ="text" class ="large require" name ="num_work" value ="<?=$obj->Num_Trabajo?>"></td>
                </tr>
                <tr>
                    <td>Colonia</td>
                    <td><input type ="text" class ="large require" name ="col_work" value ="<?=$obj->Col_Trabajo?>"></td>
                </tr>
                <tr>
                    <td>C.P</td>
                    <td><input type ="text" class ="large numeric require" name ="CP_work" value ="<?=$obj->CP_Trabajo?>" maxlength ="5"></td>
                </tr>
                <tr>
                    <td>Ciudad y Estado</td>
                    <td><input type ="text" class ="large require" name ="city_work" value ="<?=$obj->Ciudad_Trabajo?>"></td>
                </tr>
            </table>
            <div class ="section">Funciones que encuadran por lo previsto por el art 64 de la LRASP</div>
            <div id ="functions" class ="corner">
                <table id ="tbl-functions">
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
            <table class ="list-title">
                <tr>
                    <td widht ="90%">Servidores Públicos a Registrar</td>
                    <td width ="10%"><input type ="button" class ="btn" value ="Agregar" id ="btnAdd"></td>
                </tr>
            </table>
            <div id ="serv-list" class ="corner">
                <table id ="tbl-serv">
                    
                </table>
            </div>
            <br>
            <input type ="button" class ="btn" value ="Registrar" id ="btnRegister" style ="width: 500px">
        </form>
        <?}?>
    </div>
</div>
<?if($context->msg){?>
<div id ="dialog">
    <center>
        <div class ="msg"><?=$context->msg?></div>
        <?if($context->error){?>
        <table class ="result">
            <thead>
            <th width ="80"># renglón</th>
            <th>Error</th>
            </thead>
            <?foreach($context->error as $k => $v){?>
            <tr>
                <td class ="center"><?=$k?></td>
                <td><?=$v?></td>
            </tr>
            <?}?>
        </table>
        <?}?>
    </center>
</div>
<?}?>

<? } ?>