<style type ="text/css">
       #main-title {color: #ED3B96; margin: 10px auto;}
   #title1 {background:  #2599CE;}
   #title2 {background:  #63598F;}
   #title3 {background:  #EF7625;}
   #title4 {background:  #5C8F3A;}
   #title5 {background:  #155789;}
   
   .tdatos{text-align: right;}
   .panel-title {width: 95%; padding: 15px; border: 1px solid black; color: white; font-size: 16pt; text-decoration: underline; margin-top: 20px;}
   .panel {width: 96%; padding: 10px; border: 1px solid black; min-height: 100px;}
   .tbl-data {width: 100%; font-size: 10pt;}
   .tbl-data td {padding: 5px;}
   .tbl-data th {background: black; color: white; padding: 5px; text-align: justify;}
   .field {color: #717272; font-style: oblique; font-size: 9pt;text-transform: uppercase; }
   .subtitle {font-size: 14pt; color: #2F60AC; background: #F0F0F0; padding: 5px; margin-bottom: 10px;}
   .help {cursor: pointer; margin-left: 10px;}
    img.tooltip title{text-align: justify;}
   .tbl-data  input, select  {width: 97%; padding: 3px; box-shadow: 1px 0px 3px #95bdf9; }
   .divider {margin-bottom: 50px; }
   /*.quit-item {margin: 8px 15px; cursor: pointer;}*/
   #btnSendInterest {margin: 20px auto; font-size: 16pt !important; background: #A5E4F7; border-radius: 10px;}
   .quit-item {cursor: pointer; margin-left: 3px;}
   #alert-dec {width: 96%; padding: 10px; text-align: center; margin: 10px auto; background: #F43A75; color: white; font-weight: bold; font-size: 12pt;}
   table.tbl-data th{text-align: center !important;}
</style>
<script>
   <script type ="text/javascript">
    var index_dt = 1;
    $(function(){
        
        
        $('.navi').click(function(){
           doSexy('interest.php?action=<?=hideVar('show')?>&id=' + $(this).attr('id') + '&ver=<?=$context->ver?>', 1000, $(window).height() - 100, "Verificación"); 
        });
        

    });// END
    
    
</script>


<h1 id ="main-title">Declaración de intereses para funcionarios y personas de interés público</h1>
    <?if($context->next){?>
    <img id ="<?=$context->next?>" src ="img/next.png" class ="navi next" width ="40" height ="40" title ="Siguiente">
    <?}?>
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
                </td>
                <td class='tdatos'><b>Municipio o delegación:</b></td>
                <td class ="field"><?=$context->data->Ciudad?>
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
                <th width ="27%">Nombre de la empresa</th>
                <th width ="20%">Sector económico de la empresa</th>
                <th width ="10%">País en el que está constituida la empresa</th>
                <th width ="20%">Tipo de participación, cargo o función que desempeñó o desempeña el declarante en la empresa</th>
                <th width ="10%">La participación es</th>
                <th width ="13%">Si la participación es remunerada, indique el monto anual total de la remuneración (incluyendo impuestos)</th>
                </thead>
                <?$rows = 0;?>
                <?foreach($context->eco as $e){?>
                    <?if($e['Registro'] == "DECLARANTE" && $e['Tipo'] == "CONSEJOS"){?>
                    <?$rows++?>
                    <tr class ="record">
                        <td>
                            <?=$e['RazonSocial']?>
                        </td>
                        <td>
                            <?=$e['SectorEco']?>
                        </td>
                        <td>
                            <?=$e['Pais']?>
                        </td>
                        <td>
                            <?=$e['Cargo']?>
                        </td>
                        <td>
                           <?=$e['Participacion']?>
                        </td>
                        <td style="text-align: right;">
                            <?=number_format($e['MontoAnual'],2)?>
                        </td>
                    </tr>
                    <?}?>
                <?}?>

            </table>
            
        </div>
        
        <div class ="divider">
            <div class ="subtitle">Participación en direcciones y consejos de administración DE FAMILIARES HASTA EN PRIMER GRADO Y DEPENDIENTES ECONÓMICOS.<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="La participación en direcciones y/o consejos de administración se refiere a cargos o funciones que al momento de la presentación de la declaración desempeña algún familiar en primer grado –cónyuge, hijos, padres, suegros, yernos, y nueras– y/o cualquier otro dependiente económico del declarante en órganos directivos o de gobierno de organizaciones con fines de lucro, es decir, empresas. Los individuos pueden o no recibir una remuneración por esta participación."></div>
            <table class ="tbl-data">
                <thead>
                    <th width ="10%">Parentesco</th>
                    <th width ="22%">Sector económico de la empresa</th>
                    <th width ="20%">Descripción de la actividad económica de la empresa</th>
                    <th width ="10%">País en el que está constituida la empresa</th>
                    <th width ="20%">Tipo de participación, cargo o función que desempeñó o desempeña el declarante en la empresa</th>
                    <th width ="8%">Fecha desde la que desempeña el cargo o función</th>
                    <th width ="10%">La participación es</th>
                </thead>
                 <?$rows = 0;?>
                 <?foreach($context->eco as $e){?>
                    <?if($e['Registro'] == "DEPEND" && $e['Tipo'] == "CONSEJOS"){?>
                    <?$rows++?>
                        <tr class ="record">
                            <td>                     
                                    <?foreach($context->depend as $d){?>
                                        <?=($e['ID_Depend']==$d['ID_Depend']?showVar($d['Nombre_Depend']):"")?>
                                    <?}?>
                            </td>
                            <td>
                                <?=$e['SectorEco']?>
                            </td>
                            <td>
                               <?=$e['Actividad']?>
                            </td>
                            <td>
                                <?=$e['Pais']?>
                            </td>
                            <td>
                                <?=$e['Cargo']?>
                            </td>
                            <td>
                                <?=$e['FechaInicio']?>
                            </td>
                            <td>
                                <?=$e['Participacion']?>
                            </td>
                        </tr>
                    <?}?>
                 <?}?>
            </table>
        </div>
        
        <div class ="divider">
            <div class ="subtitle">Participación accionaria DEL DECLARANTE en sociedades con fines de lucro<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="La participación accionaria en sociedades se refiere a inversiones o títulos de valor (acciones) que el declarante posee en organizaciones con fines de lucro, es decir, empresas, al día de la presentación de la declaración"></div>
            <table class ="tbl-data">
                <thead>
                    <th width ="22%">Nombre de la empresa</th>
                    <th width ="20%">Sector económico de la empresa</th>
                    <th width ="10%">País en el que está constituida la empresa</th>
                    <th width ="15%">Antigüedad de la participación accionaria declarada (años)</th>
                    <th width ="15%">Porcentaje de la empresa que representan las acciones declaradas o número de acciones poseídas</th>
                    <th width ="18%">Las acciones declaradas representan una participación mayoritaria o de control.</th>
                </thead>
                <?$rows = 0;?>
                <?foreach($context->eco as $e){?>
                    <?if($e['Registro'] == "DECLARANTE" && $e['Tipo'] == "SOCIEDADES"){?>
                    <?$rows++?>
                    <tr class ="record">
                        <td>
                            <?=$e['RazonSocial']?>
                        </td>
                        <td>
                           <?=$e['SectorEco']?>
                        </td>
                        <td>
                           <?=$e['Pais']?>
                        </td>
                        <td>
                            <?=$e['Antiguedad']?>
                        </td>
                        <td>
                            <?=$e['Porcentaje']?>
                        </td>
                        <td style="text-align: center;">
                            <?=($e['Mayoritario']==1?"SI":"NO")?>
                        </td>
                    </tr>
                    <?}?>
                <?}?>
            </table>
        </div>
        
        <div class ="divider">
            <div class ="subtitle">Participación accionaria DE FAMILIARES HASTA EN PRIMER GRADO Y DEPENDIENTES ECONÓMICOS  en sociedades con fines de lucro<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="La participación accionaria en sociedades se refiere a inversiones o títulos de valor (acciones) que los familiares en primer grado –cónyuge, hijos, padres, suegros, yernos, y nueras– y/o cualquier otro dependiente económico del declarante posee al momento de la declaración en organizaciones con fines de lucro, es decir, empresas."></div>
            <table class ="tbl-data">
                <thead>
                    <th width ="20%">Parentesco</th>
                    <th width ="20%">Sector económico de la empresa</th>
                    <th width ="32%">Descripción de la actividad económica de la empresa</th>
                    <th width ="10%">País en el que está constituida la empresa</th>
                    <th width ="18%">Las acciones declaradas representan una participación mayoritaria o de control.</th>
                </thead>
                <?$rows = 0;?>
                <?foreach($context->eco as $e){?>
                    <?if($e['Registro'] == "DEPEND" && $e['Tipo'] == "SOCIEDADES"){?>
                    <?$rows++?>
                    <tr class ="record">
                        <td>
                                <?foreach($context->depend as $d){?>
                                <?=($e['ID_Depend']==$d['ID_Depend']?showVar($d['Nombre_Depend']):"")?>
                                <?}?>
                        </td>
                        <td>
                            <?=$e['SectorEco']?>
                        </td>
                        <td>
                           <?=$e['Actividad']?>
                        </td>
                        <td>
                            <?=$e['Pais']?>
                        </td>
                        <td style="text-align: center;">
                             <?=($e['Mayoritario']==1?"SI":"NO")?>
                        </td>
                    </tr>
                    <?}?>
                <?}?>
            </table>

        </div>
        
        <div class ="divider">
            <div class ="subtitle">Otros intereses económicos o financieros del declarante, familiares hasta en primer grado y dependientes económicos<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="Se refiere a aquellos convenios, contratos, compromisos o acuerdos con un valor económico presente o futuro que en la opinión del declarante podrían ser percibidos o susceptibles de estar en un conflicto de interés y que no pueden ser incluidos en alguna de las secciones anteriores de la declaración."></div>
            <table class ="tbl-data">
                <thead>
                <th width ="30%">Nombre o razón social de la entidad</th>
                <th width ="30%">Titular(es) del interés declarado</th>
                <th width ="40%">Descripción de las características y condiciones del interés económico o financiero</th>
                </thead>
                <?$rows = 0;?>
                <?foreach($context->eco as $e){?>
                    <?if($e['Registro'] == "DECLARANTE" && $e['Tipo'] == "OTROS"){?>
                    <?$rows++?>
                    <tr class ="record">
                        <td>
                            <?=$e['RazonSocial']?>
                        </td>
                        <td>
                            <?=$e['Titular']?>
                        </td>
                        <td>
                            <?=$e['Actividad']?>
                        </td>
                    </tr>
                    <?}?>
                <?}?>
            </table>
        </div>
    </div>
    
    <div class ="panel-title" id = "title3">ACTIVIDADES PROFESIONALES Y EMPRESARIALES</div>
    <div class ="panel">
         <div class ="divider">
            <div class ="subtitle">Posiciones y cargos desempeñados por EL DECLARANTE en entidades –públicas o privadas–  durante los últimos cinco años<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="Se refiere a aquellas posiciones, cargos o funciones remuneradas que el declarante ha desempeñado en los últimos 5 años o que aún desempeña ya sea en entidades públicas o privadas. Estas actividades pudieron haber sido desempeñados de forma permanente u ocasional."></div>
            <table class ="tbl-data">
                <thead>
                    <th width="20%">Razón social de la entidad –pública o privada– en la que desempeña o ha desempeñó la posición, cargo o función</th>
                    <th width="20%">Posición, cargo o función que desempeña o ha desempeñado en los últimos cinco años</th>
                    <th width="10%">País en el que está constituida la entidad</th>
                    <th width="15%">Fecha de inicio de la posición, cargo o función</th>
                    <th width="15%">Fecha de término de finalización del cargo o función</th>
                    <th width="20%">Remuneración anual neta recibida por el desempeño en la posición, cargo o función</th>
                </thead>
                <?$rows = 0;?>
                <?foreach($context->prof as $p){?>
                    <?if($p['PersonaFisica'] == 0 && $p['Registro'] == "DECLARANTE"){?>
                    <?$rows++?>
                    <tr class ="record">
                        <td>
                            <?=$p['RazonSocial']?>
                        </td>
                        <td>
                            <?=$p['Cargo']?>
                        </td>
                        <td>
                            <?=$p['Pais']?>
                        </td>
                        <td>
                            <?=$p['FechaInicio']?>
                        </td>
                        <td>
                            <?=$p['FechaTermino']?>
                        </td>
                        <td style="text-align: right;">
                            <?=number_format($p['MontoAnual'])?>
                        </td>
                    </tr>
                    <?}?>
                <?}?>
            </table>
            
         </div>
        
        <div class ="divider">
            <div class ="subtitle">Actividades profesionales y/o empresariales desempeñadas COMO PERSONA FÍSICA por EL DECLARANTE en los últimos cinco años<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="Se refiere a aquellos servicios por actividades profesionales o empresariales remuneradas que el declarante ha desempeñado en los últimos 5 años o que aún desempeña como persona física. Estos servicios pudieron haber sido desempeñados de forma permanente u ocasional. Este tipo de actividades incluye consultorías, asesorias etc."></div>
            <table class ="tbl-data">
                <thead>
                    <th width ="22%">Actividad profesional o empresarial que desempeña o ha desempeñado en los últimos 5 años</th>
                    <th width ="20%">Nombre del cliente o empresa para la que se prestó el servicio</th>
                    <th width ="10%">País en el que se desarrolló la actividad profesional o empresarial</th>
                    <th width ="14%">Fecha de inicio de la presentación del servicio</th>
                    <th width ="14%">Fecha de finalización de la prestación del servicio</th>
                    <th width ="10%">Contraprestación anual neta recibida por el servicio provisto</th>
                </thead>
                <?$rows = 0;?>
                <?foreach($context->prof as $p){?>
                    <?if($p['PersonaFisica'] == 1 && $p['Registro'] == "DECLARANTE"){?>
                    <?$rows++?>
                    <tr class ="record">
                        <td>
                            <?=$p['Cargo']?>
                        </td>
                        <td>
                            <?=$p['RazonSocial']?>
                        </td>
                        <td>
                            <?=$p['Pais']?>
                        </td>
                        <td>
                            <?=$p['FechaInicio']?>
                        </td>
                        <td>
                            <?=$p['FechaTermino']?>
                        </td>
                        <td style="text-align: right;">
                            <?=number_format($p['MontoAnual'])?>
                        </td>
                    </tr>
                    <?}?>
                <?}?>
            </table>
           
        </div>
        
        <div class ="divider">
            <div class ="subtitle">Actividades profesionales/empresariales/comerciales, cargos y funciones DE FAMILIARES HASTA EN PRIMER GRADO Y DEPENDIENTES ECONÓMICOS<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="Se refiere a aquellas actividades profesionales, empresariales o comerciales, así como cargos y funciones remuneradas que desempeñan actualmente los familiares en primer grado –cónyuge, hijos, padres, suegros, yernos, y nueras– y/o cualquier otro dependiente económico del declarante."></div>
            <table class ="tbl-data">
                <thead>
                    <th width ="20%">Parestesco</th>
                    <th width ="20%">Actividad, cargo o función desempeñada</th>
                    <th width ="20%">Sector económico de la entidad donde se desempeña</th>
                    <th width ="20%">Tipo de actividad de la entidad</th>
                    <th width ="20%">País en el que está constituida la entidad o en el que desempeña la actividad</th>
                </thead>
                <?$rows = 0;?>
                <?foreach($context->prof as $p){?>
                    <?if($p['Registro'] == "DEPEND"){?>
                    <?$rows++?>
                    <tr class ="record">
                        <td>
                                <?foreach($context->depend as $d){?>
                                <?=($p['ID_Depend']==$d['ID_Depend']?showVar($d['Nombre_Depend']):"")?>
                                <?}?>
                        </td>
                        <td>
                            <?=$p['Cargo']?>
                        </td>
                        <td>
                            <?=$p['SectorEco']?>
                        </td>
                        <td>
                            <?=$p['Actividad']?>
                        </td>
                        <td style="text-align: center;">
                            <?=$p['Pais']?>
                        </td>
                    </tr>
                    <?}?>
                <?}?>
            </table>
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
                    <th width ="20%">La participación se encuentra</th>
                </thead>
                <?$rows = 0;?>
                <?foreach($context->div as $d){?>
                    <?if($d['Tipo'] == "HONORARIOS" && $d['Registro'] == "DECLARANTE"){?>
                    <?$rows++?>
                    <tr class ="record">
                        <td>
                            <?=$d['RazonSocial']?>
                        </td>
                        <td>
                            <?=$d['Cargo']?>
                        </td>
                        <td>
                           <?=$d['Anio']?>
                        </td>
                        <td>
                            <?=($d['Vigente']==1?"VIGENTE":"CONCLUIDA")?>
                        </td>
                    </tr>
                    <?}?>
                <?}?>
            </table>
        </div>
        
        <div class ="divider">
            <div class ="subtitle">Participación en consejos y actividades filantrópicas DEL DECLARANTE<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="Se refiere a la participación en organizaciones sin fines de lucro o que llevan a cabo actividades filantrópicas en la que el declarante ha participado en los últimos 5 años y que podrían ser percibidos o susceptibles de influenciar el desempeño del encargo o las decisiones públicas del declarante."></div>
            <table class ="tbl-data">
                <thead>
                    <th width ="30%">Organización o institución en la que participa</th>
                    <th width ="30%">Tipo de participación</th>
                    <th width ="20%">Año de inicio de su participación en la organización</th>
                    <th width ="20%">La participación se encuentra</th>

                </thead>
                <?$rows = 0;?>
                <?foreach($context->div as $d){?>
                    <?if($d['Tipo'] == "FILANTROPICA" && $d['Registro'] == "DECLARANTE"){?>
                    <?$rows++?>
                    <tr class ="record">
                        <td>
                            <?=$d['RazonSocial']?>
                        </td>
                        <td>
                            <?=$d['Participacion']?>
                        </td>
                        <td>
                            <?=$d['Anio']?>
                        </td>
                        <td>
                            <?=($d['Vigente']==1?"VIGENTE":"CONCLUIDA")?>
                        </td>
                    </tr>
                    <?}?>
                <?}?>
            </table>
        </div>
        
        <div class ="divider">
            <div class ="subtitle">Participación en consejos y actividades filantrópicas DE FAMILIARES HASTA EN PRIMER GRADO Y DEPENDIENTES ECONÓMICOS<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="Se refiere a participaciones vigentes de familiares en primer grado –cónyuge, hijos, padres, suegros, yernos, y nueras– y/o dependientes económicos en organizaciones sin fines de lucro o que llevan a cabo actividades filantrópicas."></div>
            <table class ="tbl-data">
                <thead>
                    <th width ="30%">Parestesco</th>
                    <th width ="30%">Organización o institución en la que participa</th>
                    <th width ="20%">Tipo de participación</th>
                    <th width ="20%">Año de inicio de su participación en la organización</th>
                </thead>
                <?$rows = 0;?>
                <?foreach($context->div as $d){?>
                    <?if($d['Tipo'] == "FILANTROPICA" && $d['Registro'] == "DEPEND"){?>
                    <?$rows++?>
                    <tr class ="record">
                        <td>
                                <?foreach($context->depend as $dep){?>
                                 <?=($d['ID_Depend']==$dep['ID_Depend']?showVar($dep['Nombre_Depend']):"")?>
                                <?}?>
                        </td>
                        <td>
                            <?=$d['RazonSocial']?>
                        </td>
                        <td>
                                <?=($d['Participacion']=="PATRONO"?"PATRONO":"")?>
                                <?=($d['Participacion']=="FUNDADOR"?"FUNDADOR":"")?>
                                <?=($d['Participacion']=="ASOCIADO"?"ASOCIADO":"")?>
                                <?=($d['Participacion']=="ASOCIADO FUNDADOR"?"ASOCIADO FUNDADOR":"")?>
                                <?=($d['Participacion']=="CONSEJERO"?"CONSEJERO":"")?>
                                <?=($d['Participacion']=="COMISARIO"?"COMISARIO":"")?>
                                <?=($d['Participacion']=="OTRA"?"OTRA":"")?>
                        </td>
                        <td>
                            <?=$d['Anio']?>
                        </td>
                    </tr>
                    <?}?>
                <?}?>
            </table>
        </div>
        
        <div class ="divider">
            <div class ="subtitle">Viajes financiados por terceros<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="Se refiere a aquellos viajes –incluidos viajes al extranjero– recibidos por el declarante, cónyuge, hijos o dependientes económicos– que fueron financiados por un tercero. No se deben incluir aquellos financiados con recursos propios del declarante y sus familiares o con recursos públicos. Se reportan aquellos viajes realizados en los últimos 12 meses."></div>
            <table class ="tbl-data">
                <thead>
                    <th width ="20%">Nombre de la entidad privada que financió el viaje</th>
                    <th width ="20%">Personas que realizaron el viaje</th>
                    <th width ="10%">Fecha en que se realizó el viaje</th>
                    <th width ="15%">País al que se realizó el viaje</th>
                    <th width ="20%">Descripción del propósito del viaje</th>
                    <th width ="15%">Valor total o estimado total del viaje</th>
                </thead>
                <?$rows = 0;?>
                <?foreach($context->div as $d){?>
                <?if($d['Tipo'] == "VIAJE"){?>
                    <tr class ="record">
                        <td><?=$d['RazonSocial']?></td>
                        <td><?=$d['Receptor']?></td>
                        <td><?=$d['Fecha']?></td>
                        <td><?=$d['Pais']?></td>
                        <td><?=$d['Descripcion']?></td>
                        <td style="text-align: right;"><?=number_format($d['ValorTotal'])?></td>
                    </tr>
                <?}?>
                <?}?>
            </table>
        </div>
        
        <div class ="divider">
            <div class ="subtitle">Patrocinios, cortesías y donativos<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="Se refiere a aquellos apoyos financieros o en especie que han sido entregados por un tercero al declarante o a su cónyuge, hijos o dependientes económicos en los últimos 12 meses. Estos apoyos pueden incluir el uso de aeronaves, vehículos, donativos en especie, usufructo de un bien inmueble, accesos a eventos o conciertos, cortesías en restaurantes u hoteles, entre otros."></div>
            <table class ="tbl-data">
                <thead>
                    <th width ="25%">Receptor de patrocinio</th>
                    <th width ="25%">Nombre o razón social de la entidad que realizó el patrocinio o donativo</th>
                    <th width ="25%">Descripción del propósito o finalidad del patrocinio</th>
                    <th width ="25%">Valor total o estimado del patrocinio o donativo</th>
                </thead>
                <?foreach($context->div as $d){?>
                <?if($d['Tipo'] == "PATROCINIO"){?>
                    <tr class ="record">
                        <td><?=$d['Receptor']?></td>
                        <td><?=$d['RazonSocial']?></td>
                        <td><?=$d['Descripcion']?></td>
                        <td style="text-align: right;"><?=number_format($d['ValorTotal'])?></td>
                    </tr>
                <?}?>
                <?}?>
            </table>
        </div>
        
        <div class ="divider">
            <div class ="subtitle">Donativos realizados por el declarante, cónyuge o dependientes económicos<img src ="img/question2.png" width ="20" height ="20" class ="help tooltip" title ="Se refiere a aquellos apoyos financieros o materiales que el declarante, cónyuge o dependientes económicos han donado a entidades públicas o privadas, en los últimos cinco años."></div>
            <table class ="tbl-data">
                <thead>
                    <th width ="25%">Declarante o parentesco de la persona que ha emitido el donativo</th>
                    <th width ="25%">Nombre o razón social de la entidad que recibió el donativo</th>
                    <th width ="25%">Descripción del propósito o finalidad del patrocinio</th>
                    <th width ="10%">Año en el que se realizó el donativo</th>
                    <th width ="15%">Valor total o estimado del patrocinio o donativo</th>
                </thead>
                <?foreach($context->div as $d){?>
                <?if($d['Tipo'] == "DONATIVO"){?>
                    <tr class ="record">
                        <td><?=$d['Emisor']?></td>
                        <td><?=$d['RazonSocial']?></td>
                        <td><?=$d['Descripcion']?></td>
                        <td><?=$d['Anio']?></td>
                        <td style="text-align: right;"><?=number_format($d['ValorTotal'])?></td>
                    </tr>
                <?}?>
                <?}?>
            </table>
        </div>
    </div>
    <div class ="panel-title" id = "title5">OTROS INTERESES</div>
    <div class ="panel">
        <div class="divider">
            <table class ="tbl-data">
                <thead>
                    <th>Descripción de las condiciones y características del interés</th>
                </thead>
                <tr class ="item">
                    <td>
                        <?=$context->otros?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</form>
