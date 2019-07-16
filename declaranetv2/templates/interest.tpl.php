<?function Style($context){?>
<style type ="text/css">
   #main-title {color: #ED3B96; margin: 10px auto;}
   #title1 {background:  #2599CE;}
   #title2 {background:  #63598F;}
   #title3 {background:  #EF7625;}
   #title4 {background:  #5C8F3A;}
   #title5 {background:  #155789;}
   .input-flat {border: none; color: blue;}
   .tdatos{text-align: right;}
   .panel-title {width: 95%; padding: 15px; border: 1px solid black; color: white; font-size: 16pt; text-decoration: underline; margin-top: 20px;}
   .panel {width: 96%; padding: 10px; border: 1px solid black; min-height: 100px;}
   .tbl-data {width: 100%; font-size: 10pt;}
   .tbl-data td {padding: 5px;}
   .tbl-data th:not(:last-child) {background: black; color: white; padding: 5px; text-align: justify;}
   .field {color: #717272; font-style: oblique; font-size: 9pt;text-transform: uppercase; }
   .subtitle {font-size: 14pt; color: #2F60AC; background: #F0F0F0; padding: 5px; margin-bottom: 10px;}
   .help {cursor: pointer; margin-left: 10px;}
    img.tooltip title{text-align: justify;}
   .tbl-data  input, select  {width: 97%; padding: 3px; box-shadow: 1px 0px 3px #95bdf9; }
   .divider {margin-bottom: 50px; }
   /*.quit-item {margin: 8px 15px; cursor: pointer;}*/
   #btnSendInterest {margin: 20px auto; font-size: 16pt !important; background: #A5E4F7; border-radius: 10px;}
   .quit-item {cursor: pointer; margin-left: 3px;}
   #alert-dec {width: 96%; padding: 10px; text-align: center; margin: 10px auto; background: #F43A75; color: white; font-weight: bold; font-size: 12pt; display: none;}
   table.tbl-data th{text-align: center !important;}
   .goto {margin: 10px 20px;}
   #btnGoPrev {float: left;}
   #btnGoNext {float: right;}
   .down-dec {cursor: pointer;}
   #tbl-hist {width: 20%; margin: 0 auto;}
   .info-current {color: red; text-decoration: underline;}
   #exist-dec {width: 96%; margin: 20px auto; padding: 10px; font-size: 14pt; background: #964aed; color: white;}
</style>
<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    var index_dt = 1, sending = false;
    $(function(){
        $('.btn').button();
        $('#tabs').tabs({<?=(isset($_GET['history'])?"active:1":"")?>});
         DatePicker($('.date'));
        $('#accordion').accordion({heightStyle: 'fill'});
        
        $('.down-dec').click(function(){
            Loading();
            $.get('interest.php?action=<?=hideVar('generate')?>&id=' + $(this).attr('id'), function(data){
                $('.mask, .loading').remove();
                location.href = "file.php?id=" + data; 
            });
        });
        
        <?if($context->patrimonial){?>
        
        $('.btn-add').click(function(){
           var tbl = $(this).parents('div.divider').find('table');
//           console.log(tbl);
           var sample = $(tbl).find('tr:last');
//           console.log(sample);
           $(tbl).append($(sample).clone());
           $(tbl).find('tr:last').find('input, select').val('').removeClass('require watch hasDatepicker').attr('id', '');
           DatePicker($(tbl).find('tr:last').find('.date'));
        });
        
        $('.quit-item').live('click', function(){
            var self = $(this);
            $.msgBox({title: 'Confirme', 
                content: '¿Desea borrar este elemento?', 
                type: 'confirm', 
                buttons: [{ value: "OK" }, { value: "Cancelar"}],
                success: function (result) {
                    if (result == "OK") {
                        if($(self).parents('table').find('tr').length > 2){
                            $(self).parents('tr').remove();
                        }else{
                            $(self).parents('tr').find('input, select').val('').removeClass('require watch');
                        }
                    }
                }
            });
        });
        
        $('.tbl-data input, select').live('focusout', function(){
            var row = $(this).parents('tr');
            if ($(row).find('input[value!=""], select[value!=""]').length > 0){
                $(row).find('input, select').addClass('require');
                $(row).addClass('item');
            }else{
                $(row).find('input, select').removeClass('require');
                $(row).removeClass('item');
            }
        });
        
        $('#btnSendInterest').click(function(){
            if(Full($('#main-form'))){
                if($('.require').length > 0){
                    $.msgBox({title: 'Confirme', 
                        content: '¿Desea enviar su declaración de intereses ahora?', 
                        type: 'confirm', 
                        buttons: [{ value: "OK" }, { value: "Cancelar"}],
                        success: function (result) {
                            if (result == "OK") {
                                Send();x
                            }
                        }
                    });
                }else{
                     $.msgBox({title: 'Confirme', 
                        content: '¿Desea enviar su declaración de intereses VACÍA?', 
                        type: 'confirm', 
                        buttons: [{ value: "OK" }, { value: "Cancelar"}],
                        success: function (result) {
                            if (result == "OK") {
                                Send();
                            }
                        }
                    });
                }
           }else{
               $.scrollTo($('.watch:first').offset().top - 100, 800, {queue:true} );
           }
        });
        
        function Send(){
            if(!sending){
                Loading();
                sending = true;
                $.post('interest.php?action=<?=hideVar('save')?>', $('#main-form').serialize(), function(data){
                    sending = false;
                    $('.mask, .loading').remove();
                    if(data){
                        $.msgBox({title: "Error", content: data, type: "error"});
                    }else{
                        $.msgBox({title: 'Correcto', 
                             content: 'Declaración enviada', 
                             type: 'info', 
                             success: function (result) {
                                 location.href = "interest.php?history";
                             }
                         });
                    }
                });
            }
        }
        
        <?}else{?>
        
        $('.quit-item, .btn-add, #btnSendInterest').hide();
        $('#alert-dec').show();
        
        $('.goto').click(function(){
           doSexy('interest.php?consult&dec=' + $(this).attr('action'), ($(window).width() >= 1200 ? 1200 : $(window).width()), $(window).height()-100, "Declaración de intereses"); 
        });
        
        <?}?>
    });// END
    
</script>
<? } ?>

<?function Body($context){?>
<h1 id ="main-title">Declaración de intereses</h1>
<?if($context->consult && $context->dec){?>
<h3 class="info-current"><?=$context->hist[0]['Fecha_DecInt']?></h3>
<?}elseif($context->consult){?>
<h3 class="info-current">Aun no se ha presentado esta declaración</h3>
<?}?>
<div class ="navi-extra">
    <?if(!$context->consult){?>
    <a href ="home.php" id ="go-center">Volver al Centro de Declaraciones</a>
    <a href ="login.php?action=<?=hideVar('logout')?>" id ="go-out"> Salir</a>
    <?}else{?>
        <?if($context->prev){?>
        <input type ="button" class ="btn goto" value ="Anterior" id ="btnGoPrev" action ="<?=$context->prev?>">
        <?}?>
        <?if($context->prev){?>
        <input type ="button" class ="btn goto" value ="Siguiente" id ="btnGoNext" action ="<?=$context->next?>">
        <?}?>
    <?}?>
</div>

<div id="tabs">
    <ul>
      <li><a href="#dec-panel">Información</a></li>
      <?if(!$context->consult){?>
      <li><a href="#hist-panel">Historial</a></li>
      <?}?>
    </ul>
    <div id="dec-panel">
        
        <form id ="main-form">
            <div class ="panel-title" id ="title1">DATOS DEL DECLARANTE</div>
            <div class ="panel">
                <table class ="tbl-data">
                    <tr>
                        <td class='tdatos'><b>Nombre:</b></td>
                        <td class ="field"><?=$context->data->Nombre?></td>
                        <td class='tdatos'><b>Poder:</b></td>
                        <td class ="field"><?=$context->data->Poder?></td>
                        <td class='tdatos'><b>Estado civil:</b></td>
                        <td class ="field"><?=$context->data->Civil?></td>
                    </tr>
                    <tr>
                        <td class='tdatos'><b>Entidad federativa:</b></td>
                        <td class ="field"><?=$context->data->Estado?>
        <!--                    <select class ="large" name ="estate" id ="cmbEstate">
                                <?foreach($context->estate as $e){?>
                                <option value ="<?=$e['ID_Estado']?>" <?=($e['ID_Estado']==$context->data->ID_Estado?"selected":"")?>><?=$e['Estado']?></option>
                                <?}?>
                            </select>-->
                        </td>
                        <td class='tdatos'><b>Municipio o delegación:</b></td>
                        <td class ="field"><?=$context->data->Ciudad?>
        <!--                    <select class ="large" name ="city" id ="cmbCity">
                                <?foreach($context->city as $c){?>
                                <option value ="<?=$c['ID_Ciudad']?>" <?=($c['ID_Ciudad']==$context->data->ID_Ciudad?"selected":"")?>><?=$c['Ciudad']?></option>
                                <?}?>
                            </select>-->
                        </td>
                                        <td class='tdatos'></td>
                        <td class ="field"></td>
                    </tr>
                    <tr>
                        <td class='tdatos'><b>Entidad de gobierno o institución:</b></td>
                        <td class ="field"><?=$context->data->Dependencia?></td>
                        <td class='tdatos'><b>Cargo que desempeña:</b></td>
                        <td class ="field"><?=$context->data->Puesto?></td>
                    </tr>
                </table>
            </div>
            <div class ="panel-title" id = "title2">INTERESES ECONÓMICOS Y FINANCIEROS</div>
            <div class ="panel">
                <div class ="subtitle">Participación DEL DECLARANTE en direcciones y consejos de administración <img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="La participación en direcciones y/o consejos de administración se refiere a cargos o funciones que el declarante desempeña o ha desempeñado en los últimos cinco años o en órganos directivos o de gobierno en organizaciones con fines de lucro, es decir, empresas o sociedades mercantiles. El declarante puede o no recibir una remuneración por esta participación."></div>
                <div class ="divider">
                    <table class ="tbl-data">
                        <thead>
                        <th width ="25%">Nombre de la empresa</th>
                        <th width ="20%">Descripción de la actividad económica de la empresa</th>
                        <th width ="10%">Ciudad en la que está constituida la empresa</th>
                        <th width ="20%">Tipo de participación, cargo o función que desempeñó o desempeña el declarante en la empresa</th>
                        <th width ="10%">La participación es</th>
                        <th width ="13%">Si la participación es remunerada, indique el monto anual total de la remuneración (incluyendo impuestos)</th>
                        <th width="2%"></th>
                        </thead>
                        <?$rows = 0;?>
                        <?foreach($context->eco as $e){?>
                            <?if($e['Registro'] == "DECLARANTE" && $e['Tipo'] == "CONSEJOS"){?>
                            <?$rows++?>
                            <tr class ="record">
                                <td>
                                    <input type ="text" class ="require" name ="enterprise_eco[]" value ="<?=$e['RazonSocial']?>">
                                </td>
                                <td>
                                    <input type ="text" class ="require" name ="sector_eco[]" value ="<?=$e['SectorEco']?>">
                                </td>
                                <td>
                                    <input type ="text" class ="require" name ="pais_eco[]" value ="<?=$e['Pais']?>">
                                </td>
                                <td>
                                    <input type ="text" class ="require" name ="cargo_eco[]" value ="<?=$e['Cargo']?>">
                                </td>
                                <td>
                                    <select name ="part_eco[]" class ="require">
                                        <option value ="">Seleccione</option>
                                        <option value ="VOLUNTARIA" <?=($e['Participacion']=="VOLUNTARIA"?"selected":"")?>>VOLUNTARIA</option>
                                        <option value ="REMUNERADA" <?=($e['Participacion']=="REMUNERADA"?"selected":"")?>>REMUNERADA</option>
                                    </select>
                                </td>
                                <td>
                                    <input type ="text" class ="money numeric require" name ="monto_eco[]" value ="<?=number_format($e['MontoAnual'])?>">
                                </td>
                                <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                            </tr>
                            <?}?>
                        <?}?>
                        <?if(!$rows){?>
                        <tr class ="item">
                            <td>
                                <input type ="text" class ="" name ="enterprise_eco[]">
                            </td>
                            <td>
                                <input type ="text" class ="" name ="sector_eco[]">
                            </td>
                            <td>
                                <input type ="text" class ="" name ="pais_eco[]">
                            </td>
                            <td>
                                <input type ="text" class ="" name ="cargo_eco[]">
                            </td>
                            <td>
                                <select name ="part_eco[]">
                                    <option value ="">Seleccione</option>
                                    <option value ="VOLUNTARIA">VOLUNTARIA</option>
                                    <option value ="REMUNERADA">REMUNERADA</option>
                                </select>
                            </td>
                            <td>
                                <input type ="text" class ="money numeric" name ="monto_eco[]">
                            </td>
                            <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                        </tr>
                        <?}?>
                    </table>
                    <p><input type ="button" class="btn btn-add" value ="Agregar otro"></p>
                </div>

                <div class ="divider">
                    <div class ="subtitle">Participación en direcciones y consejos de administración DE FAMILIARES HASTA EN PRIMER GRADO Y DEPENDIENTES ECONÓMICOS.<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="La participación en direcciones y/o consejos de administración se refiere a cargos o funciones que al momento de la presentación de la declaración desempeña algún familiar en primer grado –cónyuge, hijos, padres, suegros, yernos, y nueras– y/o cualquier otro dependiente económico del declarante en órganos directivos o de gobierno de organizaciones con fines de lucro, es decir, empresas. Los individuos pueden o no recibir una remuneración por esta participación."></div>
                    <table class ="tbl-data">
                        <thead>
                            <th width ="10%">Parentesco</th>
                            <th width ="25%">Nombre de la empresa</th>
                            <th width ="20%">Descripción de la actividad económica de la empresa</th>
                            <th width ="10%">Ciudad en la que está constituida la empresa</th>
                            <th width ="20%">Tipo de participación, cargo o función que desempeñó o desempeña el declarante en la empresa</th>
                            <th width ="10%">La participación es</th>
                            <th width ="2%"></th>
                        </thead>
                         <?$rows = 0;?>
                         <?foreach($context->eco as $e){?>
                            <?if($e['Registro'] == "DEPEND" && $e['Tipo'] == "CONSEJOS"){?>
                            <?$rows++?>
                                <tr class ="record">
                                    <td>
                                        <input type ="text" name ="depend_parent_eco[]" class ="require" value ="<?=$e['DependEco']?>">
                                    </td>
                                    <td>
                                        <input type="text" name ="depend_enterprise_eco[]" class ="require" value ="<?=$e['enterprise_eco']?>">
                                    </td>
                                    <td>
                                        <input type="text" name ="depend_sector_eco[]" class ="require" value ="<?=$e['SectorEco']?>">
                                    </td>
                                    <td>
                                        <input type="text" name ="depend_pais_eco[]" class ="require" value ="<?=$e['Pais']?>">
                                    </td>
                                    <td>
                                        <input type="text" name ="depend_cargo_eco[]" class ="require" value ="<?=$e['Cargo']?>">
                                    </td>
                                    <td>
                                        <select name ="depend_part_eco[]" class ="require">
                                            <option value ="">Seleccione</option>
                                            <option value ="VOLUNTARIA" <?=($e['Participacion']=="VOLUNTARIA"?"selected":"")?>>VOLUNTARIA</option>
                                            <option value ="REMUNERADA" <?=($e['Participacion']=="REMUNERADA"?"selected":"")?>>REMUNERADA</option>
                                        </select>
                                    </td>
                                    <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                                </tr>
                            <?}?>
                         <?}?>
                        <?if(!$rows){?>
                        <tr class ="item">
                            <td>
                                <input type ="text" name ="depend_parent_eco[]">
                            </td>
                            <td>
                                <input type="text" name ="depend_enterprise_eco[]" >
                            </td>
                            <td>
                                <input type="text" name ="depend_sector_eco[]" >
                            </td>
                            <td>
                                <input type="text" name ="depend_pais_eco[]" >
                            </td>
                            <td>
                                <input type="text" name ="depend_cargo_eco[]" >
                            </td>
                            <td>
                                <select name ="depend_part_eco[]">
                                    <option value ="">Seleccione</option>
                                    <option value ="VOLUNTARIA" >>VOLUNTARIA</option>
                                    <option value ="REMUNERADA" >REMUNERADA</option>
                                </select>
                            </td>
                            <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                        </tr>
                        <?}?>
                    </table>
                    <p><input type ="button" class="btn btn-add" value ="Agregar otro"></p>
                </div>

                <div class ="divider">
                    <div class ="subtitle">Participación accionaria DEL DECLARANTE en sociedades con fines de lucro<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="La participación accionaria en sociedades se refiere a inversiones o títulos de valor (acciones) que el declarante posee en organizaciones con fines de lucro, es decir, empresas, al día de la presentación de la declaración"></div>
                    <table class ="tbl-data">
                        <thead>
                            <th width ="20%">Nombre de la empresa</th>
                            <th width ="20%">Descripción de la actividad económica de la empresa</th>
                            <th width ="10%">Ciudad en la que está constituida la empresa</th>
                            <th width ="15%">Antigüedad de la participación accionaria declarada (años)</th>
                            <th width ="15%">Porcentaje de la empresa que representan las acciones declaradas o número de acciones poseídas</th>
                            <th width ="18%">Las acciones declaradas representan una participación mayoritaria o de control.</th>
                            <th width ="2%"></th>
                        </thead>
                        <?$rows = 0;?>
                        <?foreach($context->eco as $e){?>
                            <?if($e['Registro'] == "DECLARANTE" && $e['Tipo'] == "SOCIEDADES"){?>
                            <?$rows++?>
                            <tr class ="record">
                                <td>
                                    <input type ="text" name ="enterprise_soc[]" class ="require" value ="<?=$e['RazonSocial']?>">
                                </td>
                                <td>
                                    <input type ="text" name ="sector_soc[]" class ="require" value ="<?=$e['SectorEco']?>">
                                </td>
                                <td>
                                    <input type ="text" name ="pais_soc[]" class ="require" value ="<?=$e['Pais']?>">
                                </td>
                                <td>
                                    <input type ="text" class ="numeric require" name ="antig_soc[]" value ="<?=$e['Antiguedad']?>">
                                </td>
                                <td>
                                    <input type ="text" class ="numeric require" name ="porcent_soc[]" value ="<?=$e['Porcentaje']?>">
                                </td>
                                <td>
                                    <select name ="mayor_soc[]" class ="require">
                                        <option value ="">Seleccione</option>
                                        <option value ="1" <?=($e['Mayoritario']=="1"?"selected":"")?>>SI</option>
                                        <option value ="0" <?=($e['Mayoritario']=="0"?"selected":"")?>>NO</option>
                                    </select>
                                </td>
                                <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                            </tr>
                            <?}?>
                        <?}?>
                        <?if(!$rows){?>
                        <tr class ="item">
                            <td>
                                <input type ="text" name ="enterprise_soc[]">
                            </td>
                            <td>
                                <input type ="text" name ="sector_soc[]">
                            </td>
                            <td>
                                <input type ="text" name ="pais_soc[]">
                            </td>
                            <td>
                                <input type ="text" class ="numeric" name ="antig_soc[]">
                            </td>
                            <td>
                                <input type ="text" class ="numeric" name ="porcent_soc[]">
                            </td>
                            <td>
                                <select name ="mayor_soc[]">
                                    <option value ="">Seleccione</option>
                                    <option value ="1">SI</option>
                                    <option value ="0">NO</option>
                                </select>
                            </td>
                            <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                        </tr>
                        <?}?>
                    </table>
                    <p><input type ="button" class="btn btn-add" value ="Agregar otro"></p>
                </div>

                <div class ="divider">
                    <div class ="subtitle">Participación accionaria DE FAMILIARES HASTA EN PRIMER GRADO Y DEPENDIENTES ECONÓMICOS  en sociedades con fines de lucro<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="La participación accionaria en sociedades se refiere a inversiones o títulos de valor (acciones) que los familiares en primer grado –cónyuge, hijos, padres, suegros, yernos, y nueras– y/o cualquier otro dependiente económico del declarante posee al momento de la declaración en organizaciones con fines de lucro, es decir, empresas."></div>
                    <table class ="tbl-data">
                        <thead>
                            <th width ="20%">Parentesco</th>
                            <th width ="20%">Nombre de la empresa</th>
                            <th width ="20%">Descripción de la actividad económica de la empresa</th>
                            <th width ="10%">Ciudad en la que está constituida la empresa</th>
                            <th width ="10%">Antigüedad de la participación accionaria declarada (años)</th>
                            <th width ="10%">Porcentaje de las empresa que representan las acciones declaradas o número de acciones poseídas</th>
                            <th width ="10%">Las acciones declaradas representan una particiapación mayoritara o de control</th>
                            <th width ="2%"></th>
                        </thead>
                        <?$rows = 0;?>
                        <?foreach($context->eco as $e){?>
                            <?if($e['Registro'] == "DEPEND" && $e['Tipo'] == "SOCIEDADES"){?>
                            <?$rows++?>
                            <tr class ="record">
                                <td>
                                    <input type ="text" name ="depend_parent_soc[]" class ="require" value ="<?=$e['DependEco']?>">
                                </td>
                                <td>
                                    <input type ="text" name ="depend_enterprise_soc[]" class ="require" value ="<?=$e['RazonSocial']?>">
                                </td>
                                <td>
                                    <input type ="text" name ="depend_sector_soc[]" class ="require" value ="<?=$e['SectorEco']?>">
                                </td>
                                <td>
                                    <input type ="text" name ="depend_pais_soc[]" class ="require" value ="<?=$e['Pais']?>">
                                </td>
                                <td>
                                    <input type ="text" class ="numeric" name ="depend_antig_soc[]" class ="require" value ="<?=$e['Antiguedad']?>">
                                </td>
                                <td>
                                    <input type="text" name ="depend_porcent_soc[]" class ="require" value ="<?=$e['Porcentaje']?>">
                                </td>
                                <td>
                                    <select name ="depend_mayor_soc[]" class ="require">
                                        <option value ="">Seleccione</option>
                                        <option value ="1" <?=($e['Mayoritario']=="1"?"selected":"")?>>SI</option>
                                        <option value ="0" <?=($e['Mayoritario']=="0"?"selected":"")?>>NO</option>
                                    </select>
                                </td>
                                <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                            </tr>
                            <?}?>
                        <?}?>
                        <?if(!$rows){?>
                        <tr class ="item">
                            <td>
                                <input type ="text" name ="depend_parent_soc[]" >
                            </td>
                            <td>
                                <input type ="text" name ="depend_enterprise_soc[]" >
                            </td>
                            <td>
                                <input type ="text" name ="depend_sector_soc[]" >
                            </td>
                            <td>
                                <input type ="text" name ="depend_pais_soc[]" >
                            </td>
                            <td>
                                <input type ="text" class ="numeric" name ="depend_antig_soc[]" >
                            </td>
                            <td>
                                <input type="text" name ="depend_porcent_soc[]" >
                            </td>
                            <td>
                                <select name ="depend_mayor_soc[]">
                                    <option value ="">Seleccione</option>
                                    <option value ="1" >SI</option>
                                    <option value ="0" >NO</option>
                                </select>
                            </td>
                            <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                        </tr>
                        <?}?>
                    </table>
                    <p><input type ="button" class="btn btn-add" value ="Agregar otro"></p>
                </div>

                <div class ="divider">
                    <div class ="subtitle">Otros intereses económicos o financieros del declarante, familiares hasta en primer grado y dependientes económicos<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="Se refiere a aquellos convenios, contratos, compromisos o acuerdos con un valor económico presente o futuro que en la opinión del declarante podrían ser percibidos o susceptibles de estar en un conflicto de interés y que no pueden ser incluidos en alguna de las secciones anteriores de la declaración."></div>
                    <table class ="tbl-data">
                        <thead>
                        <th width ="30%">Nombre o razón social de la entidad</th>
                        <th width ="30%">Titular(es) del interés declarado</th>
                        <th width ="38%">Descripción de las características y condiciones del interés económico o financiero</th>
                        <th width ="2%"></th>
                        </thead>
                        <?$rows = 0;?>
                        <?foreach($context->eco as $e){?>
                            <?if($e['Registro'] == "DECLARANTE" && $e['Tipo'] == "OTROS"){?>
                            <?$rows++?>
                            <tr class ="record">
                                <td>
                                    <input type ="text" name ="otros_enterprise_eco[]" class ="require" value ="<?=$e['RazonSocial']?>">
                                </td>
                                <td>
                                    <input type ="text" name ="otros_titular_eco[]" class ="require" value ="<?=$e['Titular']?>">
                                </td>
                                <td>
                                    <input type ="text" name ="otros_desc_eco[]" class ="require" value ="<?=$e['Actividad']?>">
                                </td>
                                <td><img class ="quit-item" src = "img/delete.png"  title ="Borrar elemento"></td>
                            </tr>
                            <?}?>
                        <?}?>
                        <?if(!$rows){?>
                        <tr class ="item">
                            <td>
                                <input type ="text" name ="otros_enterprise_eco[]">
                            </td>
                            <td>
                                <input type ="text" name ="otros_titular_eco[]">
                            </td>
                            <td>
                                <input type ="text" name ="otros_desc_eco[]">
                            </td>
                            <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                        </tr>
                        <?}?>
                    </table>
                    <p><input type ="button" class="btn btn-add" value ="Agregar otro"></p>
                </div>
            </div>

            <div class ="panel-title" id = "title3">ACTIVIDADES PROFESIONALES Y EMPRESARIALES</div>
            <div class ="panel">
                 <div class ="divider">
                    <div class ="subtitle">Posiciones y cargos desempeñados por EL DECLARANTE en entidades –privadas–  durante los últimos cinco años<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="Se refiere a aquellas posiciones, cargos o funciones remuneradas que el declarante ha desempeñado en los últimos 5 años o que aún desempeña ya sea en entidades privadas. Estas actividades pudieron haber sido desempeñados de forma permanente u ocasional."></div>
                    <table class ="tbl-data">
                        <thead>
                            <th width="20%">Razón social de la entidad –pública o privada– en la que desempeña o ha desempeñado la posición, cargo o función</th>
                            <th width="20%">Posición, cargo o función que desempeña o ha desempeñado en los últimos cinco años</th>
                            <th width="10%">Ciudad en la que está constituida la empresa</th>
                            <th width="15%">Fecha de inicio de la posición, cargo o función</th>
                            <th width="15%">Fecha de término de finalización del cargo o función</th>
                            <th width="18%">Remuneración anual neta recibida por el desempeño en la posición, cargo o función</th>
                            <th width ="2%"></th>
                        </thead>
                        <?$rows = 0;?>
                        <?foreach($context->prof as $p){?>
                            <?if($p['PersonaFisica'] == 0 && $p['Registro'] == "DECLARANTE"){?>
                            <?$rows++?>
                            <tr class ="record">
                                <td>
                                    <input type ="text" name ="enterprise_prof[]" class ="require" value ="<?=$p['RazonSocial']?>">
                                </td>
                                <td>
                                    <input type ="text" name ="cargo_prof[]" class ="require" value ="<?=$p['Cargo']?>">
                                </td>
                                <td>
                                    <input type ="text" name ="pais_prof[]" class ="require" value ="<?=$p['Pais']?>">
                                </td>
                                <td>
                                    <input type ="text" class ="date require" name ="start_prof[]" value ="<?=$p['FechaInicio']?>" readonly>
                                </td>
                                <td>
                                    <input type ="text" class ="date require" name ="end_prof[]" value ="<?=$p['FechaTermino']?>" readonly>
                                </td>
                                <td>
                                    <input type ="text" class ="numeric money require" name ="monto_prof[]" value ="<?=number_format($p['MontoAnual'])?>">
                                </td>
                                <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                            </tr>
                            <?}?>
                        <?}?>
                        <?if(!$rows){?>
                        <tr class ="item">
                            <td>
                                <input type ="text" name ="enterprise_prof[]">
                            </td>
                            <td>
                                <input type ="text" name ="cargo_prof[]">
                            </td>
                            <td>
                                <input type ="text" name ="pais_prof[]">
                            </td>
                            <td>
                                <input type ="text" class ="date" name ="start_prof[]" readonly>
                            </td>
                            <td>
                                <input type ="text" class ="date" name ="end_prof[]" readonly>
                            </td>
                            <td>
                                <input type ="text" class ="numeric money" name ="monto_prof[]">
                            </td>
                            <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                        </tr>
                        <?}?>
                    </table>
                    <p><input type ="button" class="btn btn-add" value ="Agregar otro"></p>
                 </div>

                <div class ="divider">
                    <div class ="subtitle">Actividades profesionales y/o empresariales desempeñadas COMO PERSONA FÍSICA por EL DECLARANTE en los últimos cinco años<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="Se refiere a aquellos servicios por actividades profesionales o empresariales remuneradas que el declarante ha desempeñado en los últimos 5 años o que aún desempeña como persona física. Estos servicios pudieron haber sido desempeñados de forma permanente u ocasional. Este tipo de actividades incluye consultorías, asesorias etc."></div>
                    <table class ="tbl-data">
                        <thead>
                            <th width ="20%">Actividad profesional o empresarial que desempeña o ha desempeñado en los últimos 5 años</th>
                            <th width ="20%">Nombre del cliente o empresa para la que se prestó el servicio</th>
                            <th width ="10%">Ciudad en la que esta constituida la empresa</th>
                            <th width ="14%">Fecha de inicio de la presentación del servicio</th>
                            <th width ="14%">Fecha de finalización de la prestación del servicio</th>
                            <th width ="10%">Contraprestación anual neta recibida por el servicio provisto</th>
                            <th width ="2%"></th>
                        </thead>
                        <?$rows = 0;?>
                        <?foreach($context->prof as $p){?>
                            <?if($p['PersonaFisica'] == 1 && $p['Registro'] == "DECLARANTE"){?>
                            <?$rows++?>
                            <tr class ="record">
                                <td>
                                    <input type="text" name ="fisic_activ_prof[]" class ="require" value ="<?=$p['Cargo']?>">
                                </td>
                                <td>
                                    <input type="text" name ="fisic_enterprise_prof[]" class ="require" value ="<?=$p['RazonSocial']?>">
                                </td>
                                <td>
                                    <input type="text" name ="fisic_pais_prof[]" class ="require" value ="<?=$p['Pais']?>">
                                </td>
                                <td>
                                    <input type="text" class ="date require" name ="fisic_start_prof[]"  value ="<?=$p['FechaInicio']?>" readonly>
                                </td>
                                <td>
                                    <input type="text" class ="date require" name ="fisic_end_prof[]" value ="<?=$p['FechaTermino']?>" readonly>
                                </td>
                                <td>
                                    <input type="text" class ="numeric money require" name ="fisic_monto_prof[]" value ="<?=number_format($p['MontoAnual'])?>">
                                </td>
                                <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                            </tr>
                            <?}?>
                        <?}?>
                        <?if(!$rows){?>
                        <tr class ="item">
                            <td>
                                <input type="text" name ="fisic_activ_prof[]">
                            </td>
                            <td>
                                <input type="text" name ="fisic_enterprise_prof[]">
                            </td>
                            <td>
                                <input type="text" name ="fisic_pais_prof[]">
                            </td>
                            <td>
                                <input type="text" class ="date" name ="fisic_start_prof[]" readonly>
                            </td>
                            <td>
                                <input type="text" class ="date" name ="fisic_end_prof[]" readonly>
                            </td>
                            <td>
                                <input type="text" class ="numeric money" name ="fisic_monto_prof[]">
                            </td>
                            <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                        </tr>
                        <?}?>
                    </table>
                    <p><input type ="button" class="btn btn-add" value ="Agregar otro"></p>
                </div>

                <div class ="divider">
                    <div class ="subtitle">Actividades profesionales/empresariales/comerciales, cargos y funciones DE FAMILIARES HASTA EN PRIMER GRADO Y DEPENDIENTES ECONÓMICOS<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="Se refiere a aquellas actividades profesionales, empresariales o comerciales, así como cargos y funciones remuneradas que desempeñan actualmente los familiares en primer grado –cónyuge, hijos, padres, suegros, yernos, y nueras– y/o cualquier otro dependiente económico del declarante."></div>
                    <table class ="tbl-data">
                        <thead>
                            <th width ="20%">Parentesco</th>
                            <th width ="20%">Actividad, cargo o función desempeñada</th>
                            <th width ="20%">Sector económico de la entidad donde se desempeña</th>
                            <th width ="20%">Tipo de actividad de la entidad</th>
                            <th width ="18%">Ciudad en la que está constituida la empresa</th>
                            <th width ="2%"></th>
                        </thead>
                        <?$rows = 0;?>
                        <?foreach($context->prof as $p){?>
                            <?if($p['Registro'] == "DEPEND"){?>
                            <?$rows++?>
                            <tr class ="record">
                                <td>
                                    <input type ="text" name ="fisic_depend_parent[]" class ="require" value ="<?=$p['DependProf']?>">
                                </td>
                                <td>
                                    <input type ="text" name ="fisic_depend_cargo[]" class ="require" value ="<?=$p['Cargo']?>">
                                </td>
                                <td>
                                    <input type ="text" name ="fisic_depend_sector[]" class ="require" value ="<?=$p['SectorEco']?>">
                                </td>
                                <td>
                                    <input type ="text" name ="fisic_depend_activ[]" class ="require" value ="<?=$p['Actividad']?>">
                                </td>
                                <td>
                                    <input type ="text" name ="fisic_depend_pais[]" class ="require" value ="<?=$p['Pais']?>">
                                </td>
                                <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                            </tr>
                            <?}?>
                        <?}?>
                        <?if(!$rows){?>
                        <tr class ="item">
                            <td>
                               <input type ="text" name ="fisic_depend_parent[]" >
                            </td>
                            <td>
                                <input type ="text" name ="fisic_depend_cargo[]">
                            </td>
                            <td>
                                <input type ="text" name ="fisic_depend_sector[]">
                            </td>
                            <td>
                                <input type ="text" name ="fisic_depend_activ[]">
                            </td>
                            <td>
                                <input type ="text" name ="fisic_depend_pais[]">
                            </td>
                            <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                        </tr>
                        <?}?>
                    </table>
                    <p><input type ="button" class="btn btn-add" value ="Agregar otro"></p>
                </div>
            </div>

            <div class ="panel-title" id = "title4">INTERESES DIVERSOS</div>
            <div class ="panel">
                <div class ="divider">
                    <div class ="subtitle">Posiciones y cargos honorarios DEL DECLARANTE<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="Se refiere a cualquier posición no remunerada o cargos honorarios –en instituciones públicas o privadas– en las que el declarante ha participado en los últimos 5 años. Algunos de estos cargos o posiciones pueden consistir en la participación en consejos consultivos, comités editoriales, entre otros."></div>
                    <table class ="tbl-data">
                        <thead>
                            <th width ="30%">Nombre de la empresa</th>
                            <th width ="30%">Posición o cargo honorario</th>
                            <th width ="20%">Año de inicio de su participación en la organización</th>
                            <th width ="18%">La participación se encuentra</th>
                            <th widtht ="2%"></th>
                        </thead>
                        <?$rows = 0;?>
                        <?foreach($context->div as $d){?>
                            <?if($d['Tipo'] == "HONORARIOS" && $d['Registro'] == "DECLARANTE"){?>
                            <?$rows++?>
                            <tr class ="record">
                                <td>
                                    <input type ="text" name ="div_hono_enterprise[]" class ="require" value ="<?=$d['RazonSocial']?>">
                                </td>
                                <td>
                                    <input type ="text" name ="div_hono_cargo[]" class ="require" value ="<?=$d['Cargo']?>">
                                </td>
                                <td>
                                    <input type ="text" class ="numeric require" name ="div_hono_anio[]" value ="<?=$d['Anio']?>">
                                </td>
                                <td>
                                    <select name ="div_hono_vigente[]" class ="require">
                                        <option value ="">Seleccione</option>
                                        <option value ="0" <?=($d['Vigente']=="0"?"selected":"")?>>CONCLUIDA</option>
                                        <option value ="1" <?=($d['Vigente']=="1"?"selected":"")?>>VIGENTE</option>
                                    </select>
                                </td>
                                <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                            </tr>
                            <?}?>
                        <?}?>
                        <?if(!$rows){?>
                        <tr class ="item">
                            <td>
                                <input type ="text" name ="div_hono_enterprise[]">
                            </td>
                            <td>
                                <input type ="text" name ="div_hono_cargo[]">
                            </td>
                            <td>
                                <input type ="text" class ="numeric" name ="div_hono_anio[]">
                            </td>
                            <td>
                                <select name ="div_hono_vigente[]">
                                    <option value ="">Seleccione</option>
                                    <option value ="0">CONCLUIDA</option>
                                    <option value ="1">VIGENTE</option>
                                </select>
                            </td>
                            <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                        </tr>
                        <?}?>
                    </table>
                    <p><input type ="button" class="btn btn-add" value ="Agregar otro"></p>
                </div>

                <div class ="divider">
                    <div class ="subtitle">Participación en consejos y actividades filantrópicas DEL DECLARANTE<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="Se refiere a la participación en organizaciones sin fines de lucro o que llevan a cabo actividades filantrópicas en la que el declarante ha participado en los últimos 5 años y que podrían ser percibidos o susceptibles de influenciar el desempeño del encargo o las decisiones públicas del declarante."></div>
                    <table class ="tbl-data">
                        <thead>
                            <th width ="30%">Organización o institución en la que participa</th>
                            <th width ="30%">Tipo de participación</th>
                            <th width ="20%">Año de inicio de su participación en la organización</th>
                            <th width ="18%">La participación se encuentra</th>
                            <th width ="2%"></th>
                        </thead>
                        <?$rows = 0;?>
                        <?foreach($context->div as $d){?>
                            <?if($d['Tipo'] == "FILANTROPICA" && $d['Registro'] == "DECLARANTE"){?>
                            <?$rows++?>
                            <tr class ="record">
                                <td>
                                    <input type ="text" name ="div_fila_enterprise[]" class ="require" value ="<?=$d['RazonSocial']?>">
                                </td>
                                <td>
                                    <select name ="div_fila_part[]" class ="require">
                                        <option value ="">Seleccione</option>
                                        <option value ="PATRONO" <?=($d['Participacion']=="PATRONO"?"selected":"")?>>PATRONO</option>
                                        <option value ="FUNDADOR" <?=($d['Participacion']=="FUNDADOR"?"selected":"")?>>FUNDADOR</option>
                                        <option value ="ASOCIADO" <?=($d['Participacion']=="ASOCIADO"?"selected":"")?>>ASOCIADO</option>
                                        <option value ="ASOCIADO FUNDADOR" <?=($d['Participacion']=="ASOCIADO FUNDADOR"?"selected":"")?>>ASOCIADO FUNDADOR</option>
                                        <option value ="CONSEJERO" <?=($d['Participacion']=="CONSEJERO"?"selected":"")?>>CONSEJERO</option>
                                        <option value ="COMISARIO" <?=($d['Participacion']=="COMISARIO"?"selected":"")?>>COMISARIO</option>
                                        <option value ="OTRA" <?=($d['Participacion']=="OTRA"?"selected":"")?>>OTRA</option>
                                    </select>
                                </td>
                                <td>
                                    <input type ="text" class ="numeric require" name ="div_fila_anio[]" value ="<?=$d['Anio']?>">
                                </td>
                                <td>
                                    <select name ="div_fila_vigente[]" class ="require">
                                        <option value ="">Seleccione</option>
                                        <option value ="0" <?=($d['Vigente']=="0"?"selected":"")?>>CONCLUIDA</option>
                                        <option value ="1" <?=($d['Vigente']=="1"?"selected":"")?>>VIGENTE</option>
                                    </select>
                                </td>
                                <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                            </tr>
                            <?}?>
                        <?}?>
                        <?if(!$rows){?>
                        <tr class ="item">
                            <td>
                                <input type ="text" name ="div_fila_enterprise[]">
                            </td>
                            <td>
                                <select name ="div_fila_part[]">
                                    <option value ="">Seleccione</option>
                                    <option value ="PATRONO">PATRONO</option>
                                    <option value ="FUNDADOR">FUNDADOR</option>
                                    <option value ="ASOCIADO">ASOCIADO</option>
                                    <option value ="ASOCIADO FUNDADOR">ASOCIADO FUNDADOR</option>
                                    <option value ="CONSEJERO">CONSEJERO</option>
                                    <option value ="COMISARIO">COMISARIO</option>
                                    <option value ="OTRA">OTRA</option>
                                </select>
                            </td>
                            <td>
                                <input type ="text" class ="numeric" name ="div_fila_anio[]">
                            </td>
                            <td>
                                <select name ="div_fila_vigente[]">
                                    <option value ="">Seleccione</option>
                                    <option value ="0">CONCLUIDA</option>
                                    <option value ="1">VIGENTE</option>
                                </select>
                            </td>
                            <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                        </tr>
                        <?}?>
                    </table>
                    <p><input type ="button" class="btn btn-add" value ="Agregar otro"></p>
                </div>

                <div class ="divider">
                    <div class ="subtitle">Participación en consejos y actividades filantrópicas DE FAMILIARES HASTA EN PRIMER GRADO Y DEPENDIENTES ECONÓMICOS<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="Se refiere a participaciones vigentes de familiares en primer grado –cónyuge, hijos, padres, suegros, yernos, y nueras– y/o dependientes económicos en organizaciones sin fines de lucro o que llevan a cabo actividades filantrópicas."></div>
                    <table class ="tbl-data">
                        <thead>
                            <th width ="30%">Parentesco</th>
                            <th width ="30%">Organización o institución en la que participa</th>
                            <th width ="20%">Tipo de participación</th>
                            <th width ="18%">Año de inicio de su participación en la organización</th>
                            <th width ="2%"></th>
                        </thead>
                        <?$rows = 0;?>
                        <?foreach($context->div as $d){?>
                            <?if($d['Tipo'] == "FILANTROPICA" && $d['Registro'] == "DEPEND"){?>
                            <?$rows++?>
                            <tr class ="record">
                                <td>
                                    <input type ="text" name ="div_fila_depend_parent[]" class ="require" value ="<?=$d['DependDiv']?>">
                                </td>
                                <td>
                                    <input type ="text" name ="div_fila_depend_enterprise[]" class ="require" value ="<?=$d['RazonSocial']?>">
                                </td>
                                <td>
                                    <select name ="div_fila_depend_part[]" class ="require">
                                        <option value ="">Seleccione</option>
                                        <option value ="PATRONO" <?=($d['Participacion']=="PATRONO"?"selected":"")?>>PATRONO</option>
                                        <option value ="FUNDADOR" <?=($d['Participacion']=="FUNDADOR"?"selected":"")?>>FUNDADOR</option>
                                        <option value ="ASOCIADO" <?=($d['Participacion']=="ASOCIADO"?"selected":"")?>>ASOCIADO</option>
                                        <option value ="ASOCIADO FUNDADOR" <?=($d['Participacion']=="ASOCIADO FUNDADOR"?"selected":"")?>>ASOCIADO FUNDADOR</option>
                                        <option value ="CONSEJERO" <?=($d['Participacion']=="CONSEJERO"?"selected":"")?>>CONSEJERO</option>
                                        <option value ="COMISARIO" <?=($d['Participacion']=="COMISARIO"?"selected":"")?>>COMISARIO</option>
                                        <option value ="OTRA" <?=($d['Participacion']=="OTRA"?"selected":"")?>>OTRA</option>
                                    </select>
                                </td>
                                <td>
                                    <input type ="text" class ="numeric require" name ="div_fila_depend_anio[]" value ="<?=$d['Anio']?>">
                                </td>
                                <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                            </tr>
                            <?}?>
                        <?}?>
                        <?if(!$rows){?>
                        <tr class ="item">
                            <td>
                                <input type ="text" name ="div_fila_depend_parent[]">
                            </td>
                            <td>
                                <input type ="text" name ="div_fila_depend_enterprise[]">
                            </td>
                            <td>
                                <select name ="div_fila_depend_part[]">
                                    <option value ="">Seleccione</option>
                                    <option value ="PATRONO">PATRONO</option>
                                    <option value ="FUNDADOR">FUNDADOR</option>
                                    <option value ="ASOCIADO">ASOCIADO</option>
                                    <option value ="ASOCIADO FUNDADOR">ASOCIADO FUNDADOR</option>
                                    <option value ="CONSEJERO">CONSEJERO</option>
                                    <option value ="COMISARIO">COMISARIO</option>
                                    <option value ="OTRA">OTRA</option>
                                </select>
                            </td>
                            <td>
                                <input type ="text" class ="numeric" name ="div_fila_depend_anio[]">
                            </td>
                            <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                        </tr>
                        <?}?>
                    </table>
                    <p><input type ="button" class="btn btn-add" value ="Agregar otro"></p>
                </div>

                <div class ="divider">
                    <div class ="subtitle">Patrocinios, cortesías y donativos<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="Se refiere a aquellos apoyos financieros o en especie que han sido entregados por un tercero al declarante o a su cónyuge, hijos o dependientes económicos en los últimos 12 meses. Estos apoyos pueden incluir el uso de aeronaves, vehículos, donativos en especie, usufructo de un bien inmueble, accesos a eventos o conciertos, cortesías en restaurantes u hoteles, entre otros."></div>
                    <table class ="tbl-data">
                        <thead>
                            <th width ="25%">Receptor de patrocinio</th>
                            <th width ="25%">Nombre o razón social de la entidad que realizó el patrocinio o donativo</th>
                            <th width ="25%">Descripción del propósito o finalidad del patrocinio</th>
                            <th width ="23%">Valor total o estimado del patrocinio o donativo</th>
                            <th width ="2%"></th>
                        </thead>
                        <tr class="item">
                            <td>
                                <select name ="div_cort_recep[]">
                                    <option value="">Seleccione</option>
                                    <option value="DECLARANTE">DECLARANTE</option>
                                    <option value="CONYUGE">CONYUGE</option>
                                    <option value="DEPENDIENTES">DEPENDIENTES</option>
                                </select>
                            </td>
                            <td>
                                <input type ="text" name ="div_cort_enterprise[]">
                            </td>
                            <td>
                                <input type ="text" name ="div_cort_desc[]">
                            </td>
                            <td>
                                <input type ="text" class ="numeric money" name ="div_cort_monto[]">
                            </td>
                            <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                        </tr>
                    </table>
                    <p><input type ="button" class="btn btn-add" value ="Agregar otro"></p>
                </div>

                <div class ="divider">
                    <div class ="subtitle">Donativos realizados por el declarante, cónyuge o dependientes económicos<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="Se refiere a aquellos apoyos financieros o materiales que el declarante, cónyuge o dependientes económicos han donado a entidades públicas o privadas, en los últimos cinco años."></div>
                    <table class ="tbl-data">
                        <thead>
                            <th width ="25%">Declarante o parentesco de la persona que ha emitido el donativo</th>
                            <th width ="25%">Nombre o razón social de la entidad que recibió el donativo</th>
                            <th width ="25%">Descripción del propósito o finalidad del patrocinio</th>
                            <th width ="10%">Año en el que se realizó el donativo</th>
                            <th width ="13%">Valor total o estimado del patrocinio o donativo</th>
                            <th width ="2%"></th>
                        </thead>
                        <tr clasS="item">
                            <td>
                                <select name ="div_don_emisor[]">
                                    <option value="">Seleccione</option>
                                    <option value="DECLARANTE">DECLARANTE</option>
                                    <option value="CONYUGE">CONYUGE</option>
                                    <option value="DEPENDIENTES">DEPENDIENTES</option>
                                </select>
                            </td>
                            <td>
                                <input type ="text" name ="div_don_enterprise[]">
                            </td>
                            <td>
                                <input type ="text" name ="div_don_desc[]">
                            </td>
                            <td>
                                <input type ="text" class ="numeric" name ="div_don_anio[]">
                            </td>
                            <td>
                                <input type ="text" class ="numeric money" name ="div_don_monto[]">
                            </td>
                            <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                        </tr>
                    </table>
                    <p><input type ="button" class="btn btn-add" value ="Agregar otro"></p>
                </div>
            </div>
            <div class ="panel-title" id = "title5">OTROS INTERESES</div>
            <div class ="panel">
                <div class="divider">
                    <table class ="tbl-data">
                        <thead>
                            <th>Descripción de las condiciones y características del interés</th>
                            <th width ="2%"></th>
                        </thead>
                        <tr class ="item">
                            <td>
                                <input type ="text" name ="otros[]">
                            </td>
                            <td><img class ="quit-item" src = "img/delete.png" title ="Borrar elemento"></td>
                        </tr>
                    </table>
                    <p><input type ="button" class="btn btn-add" value ="Agregar otro"></p>
                </div>
            </div>
            
            <?if($context->dec){?>
            <div id ="exist-dec">Ya ha enviado una declaración durante el año actual, pero puede enviar tantas como le sea necesario</div>
            <?}?>
            <input type ="button" class = "btn" id ="btnSendInterest" value ="Enviar <?=($context->dec?"otra":"")?> declaración">
            <div id ="alert-dec"><?=(!$context->patrimonial?"Debe completar previamente su declaración patrimonial":"")?></div>
            
        </form>
    </div>
    <?if(!$context->consult){?>
    <div id="hist-panel">
        <div id="accordion">
            <?if($context->hist){?>
            <?foreach($context->hist as $h){?>
            <h3>Fecha de la declaración: <?=$h['Fecha_DecInt']?></h3>
            <div>
                <table id = "tbl-hist">
                    <tr>
                        <td><h3>Generar acuse</h3></td>
                        <td width = "50"><img src = "img/pdf2.png" class ="down-dec" id ="<?=hideVar($h['ID_DecInt'])?>"></td>
                    </tr>
                </table>
            </div>
            <?}?>
            <?}else{?>
            <div class ="notfound-info">Por el momento no se encuentran declaraciones</div>
            <?}?>
        </div>
    </div>
    <?}?>
</div>

<?if(!$context->consult){?>
<div class ="navi-extra">
    <a href ="home.php" id ="go-center">Volver al Centro de Declaraciones</a>
    <a href ="login.php?action=<?=hideVar('logout')?>" id ="go-out"> Salir</a>
</div>
<?}?>
<? } ?>