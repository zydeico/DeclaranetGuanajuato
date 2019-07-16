<?function Style($context){?>
<style type ="text/css">
    .accordion h3 {background: #beb5f1; padding: 15px;}
    .row-odd td {background: #e2e1e6;}
    .element td {padding: 5px 3px;}
    #tbl-serv {width: 99%; margin: 10px auto; }
    #tbl-serv td {padding: 5px; }
    #graph {width: 99%; margin: 15px auto; height: 300px;}
    #tbl-obs {width: 99%; margin: 10px auto; }
    #tbl-obs td {padding: 5px;}
    #btnClose {margin: 10px auto; width: 500px; background: #fa5473; padding: 10px;}
    .aditional {color: #072fe8; font-weight: bold; font-size: 10pt;}
    .adds-text {color: red;}
</style>
<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    $(function(){
        Chart(<?=$context->json?>);
        
        $('.valid').click(function(){
            var seg = $(this).parents('tr').find('.seg').val();
            var trans = $(this).parents('tr').find('.trans').val();
            var id = $(this).parents('tr').find('.id').val();
            var st = $(this).parents('tr').find('.option').val();
            var verif = $(this).parents('tr').find('.verif').val();
            var obs = $(this).parents('tr').find('.obs').val();
            var resp = <?=$context->resp?$context->resp:0?>;
            var self = $(this);
            var ok = true;
            if(st == "2" && !verif){
                ok = false;
                $.msgBox({title: "Revise", content: "Debe llenar el campo de verificación para declinar el registro"});
            }
            if(ok){
                fakeLoad($(this).parent());
                $.post('verify.php?action=<?=hideVar('save')?>', {seg: seg, trans: trans, id: id, st: st, verif: verif, obs: obs, resp: resp}, function(data){
                    ready();
                    if(data)
                        $.msgBox({title: "Error", content: data, type: "error"});
                    else{
                        $(self).val("Listo!");
                        setTimeout(function(){
                            $(self).val('Guardar');
                        }, 3000);
                    }
                });
            }
        });
        
        $('.saveadds').click(function(){
            var self = $(this);
            var obs = $(this).parents('tr').find('textarea').val();
            if(obs){
                fakeLoad($(this).parent());
                $.post('verify.php?action=<?=hideVar('adds')?>', {id: $(this).attr('id'), target: $(this).attr('action'), obs: obs}, function(data){
                    ready();
                    if(data)
                        $.msgBox({title: "Error", content: data, type: "error"});
                    else{
                        $(self).val("Listo!");
                        setTimeout(function(){
                            $(self).val('Guardar');
                        }, 3000);
                    }
                });
            }else{
                $.msgBox({title: "Revise", content: "Debe agregar la descripción del hallazgo primero"});
            }
        });
        
        $('#btnObs').click(function(){
            if($('#txtObs').val()){
                fakeLoad($(this).parent());
                $.post('verify.php?action=<?=hideVar('obs')?>', {ver: <?=$context->ver?>, obs: $('#txtObs').val()}, function(data){
                    ready();
                    if(data)
                        $.msgBox({title: "Error", content: data, type: "error"});
                    else{
                        var row = "<tr>"
                                + "<td>" + getDateTime() + "</td>"
                                + "<td><?=$_SESSION['NM']?></td>"
                                + "<td>" + $('#txtObs').val() + "</td>"
                                + "</tr>";
                        $('#tbl-obs').append(row);
                        $('#txtObs').val('');
                    }
                });
            }
        });
        
        $('#btnClose').click(function(){
            $.msgBox({title: 'Confirme', 
                content:'¿Seguro de cerrar este proceso de verificación?', 
                type: 'confirm', 
                buttons: [{ value: "OK" }, { value: "Cancelar"}],
                success: function (result) {
                  if (result == "OK") {
                       Loading();
                       location.href = "verify.php?action=<?=hideVar('close')?>&id=<?=$context->ver?>";
                  }
                }
            });
        });
    });
    
    function Chart(json){
        
           var data = [
             {dec: "INICIAL-2010", "income": 10000, "debit": 8000},   
             {dec: "ANUAL-2011", "income": 9000, "debit": 7000},   
             {dec: "FINAL-2012", "income": 8000, "debit": 5000}, 
           ];
           
            // SERIAL CHART
            var chart = new AmCharts.AmSerialChart();
            chart.dataProvider = json;
            chart.categoryField = "dec";
            chart.startDuration = 0.5;
            chart.balloon.color = "#000000";
            chart.addListener('dataUpdated', function(){
                removeLegend();
            });
            // AXES
            // category
            var categoryAxis = chart.categoryAxis;
            categoryAxis.fillAlpha = 1;
            categoryAxis.fillColor = "#FAFAFA";
            categoryAxis.gridAlpha = 0;
            categoryAxis.axisAlpha = 0;
            categoryAxis.gridPosition = "start";
            categoryAxis.position = "top";

            // value
            var valueAxis = new AmCharts.ValueAxis();
            valueAxis.title = "Cantidad $";
            valueAxis.dashLength = 5;
            valueAxis.axisAlpha = 0;
//            valueAxis.minimum = 0;
//            valueAxis.maximum = 10000000;
            valueAxis.integersOnly = true;
            valueAxis.gridCount = 10;
    //        valueAxis.reversed = true; // this line makes the value axis reversed
            chart.addValueAxis(valueAxis);

            // GRAPHS
            // Income graph						            		
            var graph = new AmCharts.AmGraph();
            graph.type = "smoothedLine";
            graph.title = "Ingresos";
            graph.valueField = "income";
            graph.balloonText = "Ingresos en [[category]]: $[[value]]";
            graph.lineAlpha = 1;
            graph.bullet = "round";
            graph.bulletSize = 10;
            graph.lineColor = "#08D36E";
            chart.addGraph(graph);

            // Debit graph
            var graph = new AmCharts.AmGraph();
            graph.type = "smoothedLine";
            graph.title = "Egresos";
            graph.valueField = "debit";
            graph.balloonText = "Egresos en [[category]]: $[[value]]";
            graph.bullet = "square";
            graph.bulletSize = 10;
            graph.lineColor = "#4BACF2";
            chart.addGraph(graph);
            
            var graph = new AmCharts.AmGraph();
            graph.type = "smoothedLine";
            graph.title = "Ingresos otros";
            graph.valueField = "income_else";
            graph.balloonText = "Ingresos dependientes en [[category]]: $[[value]]";
            graph.lineAlpha = 1;
            graph.hidden = true;
            graph.bullet = "triangleUp";
            graph.bulletSize = 10;
            graph.lineColor = "#F2EE1D";
            chart.addGraph(graph);
            
            var graph = new AmCharts.AmGraph();
            graph.type = "smoothedLine";
            graph.title = "Egresos otros";
            graph.valueField = "debit_else";
            graph.balloonText = "Egresos dependientes en [[category]]: $[[value]]";
            graph.lineAlpha = 1;
            graph.hidden = true;
            graph.bullet = "triangleDown";
            graph.bulletSize = 10;
            graph.lineColor = "#FC870A";
            chart.addGraph(graph);
            
            // CURSOR
            var chartCursor = new AmCharts.ChartCursor();
            chartCursor.cursorAlpha = 0;
            chartCursor.cursorPosition = "mouse";
            chartCursor.categoryBalloonDateFormat = "YYYY";
            chart.addChartCursor(chartCursor);

            // LEGEND
            var legend = new AmCharts.AmLegend();
            legend.markerType = "circle";
            chart.addLegend(legend);

            // WRITE
            chart.write("graph");
            removeLegend(); 
        
    }
</script>
<? } ?>

<?function Body($context){?>
<div class ="section-title"><?=$context->title?> >_</div>

<p><a href = "verify.php">< Regresar</a></p>

<div class ="accordion">
    <h3>Datos del servidor público</h3>
    <div>
        <table id ="tbl-serv">
            <tr>
                <td width = "20%"><b>Nombre</b></td>
                <td><?=$context->info->Servidor?></td>
            </tr>
            <tr>
                <td><b>Cargo</b></td>
                <td><?=$context->info->Cargo_Funcional?></td>
            </tr>
            <tr>
                <td><b>Dependencia</b></td>
                <td><?=$context->info->Dependencia?></td>
            </tr>
        </table>
    </div>
    <h3>Gráfica de Ingresos vs Egresos</h3>
    <div id ="graph"></div>
    <?$row = 1?>
    <?foreach($context->data as $k => $v){?>
        <?$found = ""?>
        <h3><?=$k?></h3>
        <div>
            <table class ="element">
                <thead>
                <th width ="250">Declarado</th>
                <th width ="200">Operación</th>
                <th>Verificación</th>
                <th>Observaciones</th>
                <th width ="150">Validación</th>
                </thead>
                <?if($v){?>
                    <?foreach($v as $x){?>
                        <?foreach($x as $e){?>
                            <tr class="<?=($row++%2==0?"row-odd":"row-even")?>">
                                <td>
                                    <?=InterpretElem($e, true);?>
                                </td>
                                <td>
                                    <?=InterpretTrans($e, reset(explode(" ", $e['Declared'])));?>
                                </td>
                                <td>
                                    <textarea class ="verif" cols ="25" rows ="10" <?=($context->resp!=$_SESSION['UI'] || $context->close?"disabled":"")?>><?=$e['Verificacion']?></textarea>
                                </td>
                                <td>
                                    <textarea class ="obs" cols ="25" rows ="10" <?=($context->resp!=$_SESSION['UI'] || $context->close?"disabled":"")?>><?=$e['ObsSeg']?></textarea>
                                </td>
                                <td class ="action">
                                    <input type ="hidden" class ="seg" value ="<?=$e['ID_Seg']?>">
                                    <input type ="hidden" class ="trans" value ="<?=$e['ID_Trans']?>">
                                    <input type ="hidden" class ="id" value ="<?=$context->ver?>">
                                    <div class ="data"><?=$e['Resp']?> (<?=$e['Fecha_Seg']?$e['Fecha_Seg']:"Sin validación"?>)</div>
                                    <select name ="valid" class ="option" <?=($context->resp!=$_SESSION['UI']?"disabled":"")?>>
                                        <option value ="0" >Pendiente</option>
                                        <option value ="1" <?=($e['StSeg']=="1"?"selected":"")?>>Validado</option>
                                        <option value ="2" <?=($e['StSeg']=="2"?"selected":"")?>>Declinado</option>
                                    </select> 
                                    <?if($context->resp==$_SESSION['UI'] && !$context->close){?>
                                    <p><input type ="button" class ="btn valid" value ="Guardar"></p>
                                    <?}?>
                                </td>
                            </tr>
                        <?}?>
                    <?}?>
                <?}?>
                <?foreach($context->obs as $o){
                   if($o['Tipo_Obs'] == $k){?>
                       <tr>
                            <td class ="aditional">Observaciones o hallazgos adicionales a la información declarada sobre este rubro</td>
                            <td colspan="3"><textarea cols="77" rows="4" class ="adds-text" placeholder="Opcional, sólo en su caso" disabled><?=$o['Fecha_Obs'] . ": " . $o['Observacion']?></textarea></td>
                            <td></td>
                        </tr>
                   <?}
                }?>
                <?if($context->resp==$_SESSION['UI'] && !$context->close){?>
                <tr>
                    <td class ="aditional">Observaciones o hallazgos adicionales a la información declarada sobre este rubro</td>
                    <td colspan="3"><textarea cols="77" rows="4" class ="adds-text" placeholder="Opcional, sólo en su caso"></textarea></td>
                    <td><p><input type ="button" class ="btn saveadds" value ="Guardar" id ="<?=$context->ver?>" action ="<?=$k?>"></p></td>
                </tr>
                <?}?>
            </table>
        </div>
    <?}?>
        
    <div>
        <h3>OBSERVACIONES GENERALES</h3>
        <table id ="tbl-obs">
            <thead>
            <th width = "15%">Fecha</th>
            <th width = "20%">Usuario</th>
            <th>Observación</th>
            </thead>
            <?foreach($context->obs as $o){?>
                <?if($o['Tipo_Obs'] == "GENERAL"){?>
                <tr>
                    <td><?=$o['Fecha_Obs']?></td>
                    <td><?=$o['Usuario']?></td>
                    <td><?=$o['Observacion']?></td>
                </tr>
                <?}?>
            <?}?>
        </table>
        <br>
        
        <?if($context->resp==$_SESSION['UI']){?>
        <div>
            <h4>Nueva observacion</h4>
            <br>
            <textarea id ="txtObs" cols="100" rows="3" name ="obs"></textarea>
            <p>
                <input type ="button" class ="btn" id ="btnObs" value="Guardar">
            </p>
        </div>
        <?}?>
    </div>
    <?if($context->resp == $_SESSION['UI'] && !$context->close){?>
    <p><input type ="button" class ="btn" value="Cerrar proceso de verificación" id ="btnClose"></p>
    <?}elseif($context->close){?>
    <h2>CERRADO (<?=$context->close?>)</h2>
    <?}?>
    
</div>
<? } ?>