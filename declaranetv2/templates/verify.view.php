<style type ="text/css">
    .dec th {padding: 10px 0px;}
    #personal td {padding: 5px 10px ; }
    #graph {height: 100%; width: 100%; }
    .movement th {padding: 10px; }
    .movement {width: 100%; border-collapse: collapse; }
    .movement td {border: 1px solid #C3C7C9; padding: 3px;}
    .positive {color: #57C910; }
    .negative {color: #F9365D; }
    .stuff {margin: 5px ; }
    .sell {padding: 0px 10px; color: #7892C7; }
    .legend-info {margin: 10px; font-weight: bold; font-size: 10pt; color: #4872B5; text-align: center; }
    #legend {width: 80%; padding: 5px; font-size: 10pt; color: #2D5FAB; background-color: #FFCF11; box-shadow: 5px 5px 5px #888888; text-align: center; margin: 5px auto 20px auto;}
    
</style>
<script type ="text/javascript">
    var json = null;
    
    $(function(){
        $('#view').tabs({
            heightStyle: 'fill', 
            activate : function(event, ui){
                if(ui.newTab.index() == 2){
                   if(!json){
                        $.getJSON('verify.php?action=<?=hideVar('json')?>&id=<?=$context->id?>', function(data){
                             json = data;
                             Chart(json);
                        });
                   }else
                        Chart(json);
                }
            }
        });
        $('.corner').corner();
        setTimeout(function(){
            $('#legend').slideUp();
        }, 5000);
        
        $('#info').accordion({heightStyle: "content"});
        $('#declare').accordion({heightStyle: "content"});
        $('#stuff').accordion({heightStyle: "content"});
        
        $('.amount').each(function(){
           var val = parseInt($(this).text());
           if(parseInt(val) < 0)
               $(this).addClass('negative');
           else
               $(this).addClass('positive');
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
<div id ="legend" class ="corner">Esta información es confidencial y tu acceso ha sido registrado por políticas de seguridad.</div>
<div id ="view">
    <ul>
        <li><a href ="#general">Generales</a></li>
        <li><a href ="#mov">Movimientos</a></li>
        <li><a href ="#chart">Gráfica</a></li>
        <li><a href ="#balance">Balanza</a></li>
        <li><a href ="#history">Historial</a></li>
    </ul>
    <div id ="general">
        <table id ="personal">
            <tr>
                <td><b>Nombre</b></td>
                <td><?=$context->general->Nombre?></td>
            </tr>
            <tr>
                <td><b>Dependencia</b></td>
                <td><?=$context->general->Dependencia?></td>
            </tr>
            <tr>
                <td><b>Cargo</b></td>
                <td><?=$context->general->Puesto?></td>
            </tr>
            <tr>
                <td><b>Correo oficial</b></td>
                <td><?=$context->general->Correo?></td>
            </tr>
            <tr>
                <td><b>Correo alternativo</b></td>
                <td><?=$context->general->Correo2?></td>
            </tr>
        </table>
        <div class ="legend-info">Datos declarados por el servidor público</div>
        <div id ="info">
            <?foreach($context->info as $k => $v){?>
            <h3><?=$k?></h3>
            <div>
                <table class ="info">
                    <tr>
                        <td><b>Calle</b> </td>
                        <td><?=$v['Calle']?></td>
                    </tr>
                    <tr>
                        <td><b>Número</b> </td>
                        <td><?=$v['Numero']?></td>
                    </tr>
                    <tr>
                        <td><b>Colonia</b> </td>
                        <td><?=$v['Colonia']?></td>
                    </tr>
                    <tr>
                        <td><b>Ciudad</b> </td>
                        <td><?=$v['Ciudad']?></td>
                    </tr>
                    <tr>
                        <td><b>Estado</b> </td>
                        <td><?=$v['Estado']?></td>
                    </tr>
                    <tr>
                        <td><b>C.P</b> </td>
                        <td><?=$v['CP']?></td>
                    </tr>
                    <tr>
                        <td><b>Teléfono</b> </td>
                        <td><?=$v['Telefono']?></td>
                    </tr>
                    <tr>
                        <td><b>Estado civil</b> </td>
                        <td><?=$v['Civil']?></td>
                    </tr>
                    <tr>
                        <td><b>CURP</b> </td>
                        <td><?=$v['CURP']?></td>
                    </tr>
                </table>
            </div>
            <?}?>
        </div>
    </div>
    <div id ="mov">
        <table class ="movement">
            <thead>
            <th>Fecha</th>
            <th>Movimiento</th>
            <th>Tipo</th>
            <!--<th>Documento</th>-->
            <th>Inicio</th>
            <th>Termino</th>
            <th>Dependencia</th>
            <th>Cargo</th>
            <th></th>
            </thead>
            <?foreach($context->mov as $m){?>
                    
                    <tr>
                        <td><?=$m['Fecha_Mov']?></td>
                        <td><?=$m['Movimiento']?></td>
                        <td><?=$m['Tipo_Reg']?></td>
                        <!--<td><a href = "file.php?id=<?=hideVar($m['Documento'])?>"><?=($m['Documento']?"Descargar":"")?></a></td>-->
                        <td><?=$m['Inicio']?></td>
                        <td><?=$m['Termino']?></td>
                        <td><?=$m['Dependencia']?></td>
                        <td><?=$m['Puesto']?></td>
                    </tr>
                
            <?}?>
        </table>
    </div>
    <div id ="chart">
        <div id ="graph"></div>
    </div>
    <div id ="balance">
        <div id ="declare">
            <?foreach($context->balance as $k => $v){?>
            <h3><?=$k?></h3>
            <div>
                <table class ="dec">
                    <thead>
                    <th width ="100"></th>
                    <th width ="120">DECLARANTE</th>
                    <th width ="120">CONYUGE</th>
                    <th width ="120">CORRESPONSABLES</th>
                    </thead>
                    <tr>
                        <td><b>Sueldos</b></td>
                        <td>$ <span class ="positive"><?=number_format($v[0]['sueldo'], 2)?></span></td>
                        <td>$ <span class ="positive"><?=number_format($v[0]['conyuge'], 2)?></span></td>
                        <td>$ <span class ="positive"><?=number_format($v[0]['depend'], 2)?></span></td>
                    </tr>
                    <tr>
                        <td><b>Honorarios</b></td>
                        <td>$ <span class ="positive"><?=number_format($v[0]['honorarios'], 2)?></span></td>
                        <td>$      - </td>
                        <td>$      - </td>
                    </tr>
                    <tr>
                        <td><b>Otros</b></td>
                        <td>$ <span class ="positive"><?=number_format($v[0]['otros'], 2)?></span></td>
                        <td>$      - </td>
                        <td>$      - </td>
                    </tr>
                </table>
                <table class ="dec">
                    <thead>
                    <th width ="100"></th>
                    <th width ="120"></th>
                    <th width ="120"></th>
                    <th width ="120"></th>
                    </thead>
                    <tr>
                        <td><b>Inmuebles</b></td>
                        <td>$ <span class ="amount"><?=number_format($v[0]['inmuebles'], 2)?></span></td>
                        <td>$ <span class ="amount"><?=number_format($v[0]['inmuebles_con'], 2)?></span></td>
                        <td>$ <span class ="amount"><?=number_format($v[0]['inmuebles_dep'], 2)?></span></td>
                    </tr>
                    <tr>
                        <td><b>Muebles</b></td>
                        <td>$ <span class ="amount"><?=number_format($v[0]['muebles'], 2)?></span></td>
                        <td>$ <span class ="amount"><?=number_format($v[0]['muebles_con'], 2)?></span></td>
                        <td>$ <span class ="amount"><?=number_format($v[0]['muebles_dep'], 2)?></span></td>
                    </tr>
                    <tr>
                        <td><b>Vehículos</b></td>
                        <td>$ <span class ="amount"><?=number_format($v[0]['vehiculos'], 2)?></span></td>
                        <td>$ <span class ="amount"><?=number_format($v[0]['vehiculos_con'], 2)?></span></td>
                        <td>$ <span class ="amount"><?=number_format($v[0]['vehiculos_dep'], 2)?></span></td>
                    </tr>
                </table>
                <table class ="dec">
                    <thead>
                    <th width ="100"></th>
                    <th width ="120"></th>
                    <th width ="120"></th>
                    <th width ="120"></th>
                    </thead>
                    <tr>
                        <td><b>Inversiones</b></td>
                        <td>$ <span class ="positive"><?=number_format($v[0]['inversiones'], 2)?></span></td>
                        <td>$ <span class ="positive"><?=number_format($v[0]['inversiones_con'], 2)?></span></td>
                        <td>$ <span class ="positive"><?=number_format($v[0]['inversiones_dep'], 2)?></span></td>
                    </tr>
                    <tr>
                        <td><b>Adeudos</b></td>
                        <td>$ <span class ="positive"><?=number_format($v[0]['adeudos'], 2)?></span></td>
                        <td>$ <span class ="positive"><?=number_format($v[0]['adeudos_con'], 2)?></span></td>
                        <td>$ <span class ="positive"><?=number_format($v[0]['adeudos_dep'], 2)?></span></td>
                    </tr>
                </table>
                <table class ="dec">
                    <thead>
                    <th width ="100"></th>
                    <th width ="120"></th>
                    <th width ="120"></th>
                    <th width ="120"></th>
                    </thead>
                    <tr>
                        <td><b>Depósito en inversiones</b></td>
                        <td>$ <span class ="negative">-<?=number_format($v[0]['depositos'], 2)?></span></td>
                        <td>$ <span class ="negative">-<?=number_format($v[0]['depositos_con'], 2)?></span></td>
                        <td>$ <span class ="negative">-<?=number_format($v[0]['depositos_dep'], 2)?></span></td>
                    </tr>
                    <tr>
                        <td><b>Pago adeudos</b></td>
                        <td>$ <span class ="negative">-<?=number_format($v[0]['pagos'], 2)?></span></td>
                        <td>$ <span class ="negative">-<?=number_format($v[0]['pagos_con'], 2)?></span></td>
                        <td>$ <span class ="negative">-<?=number_format($v[0]['pagos_dep'], 2)?></span></td>
                    </tr>
                    <tr>
                        <td><b>Pago de pensiones</b></td>
                        <td>$ <span class ="negative">-<?=number_format($v[0]['pensiones'], 2)?></span></td>
                        <td>$      - </td>
                        <td>$      - </td>
                    </tr>
                </table>
                <table class ="dec">
                    <thead>
                    <th width ="100"></th>
                    <th width ="120"></th>
                    <th width ="120"></th>
                    <th width ="120"></th>
                    </thead>
                    <?$balance = $v[0]['sueldo'] + $v[0]['honorarios'] + $v[0]['otros'] + $v[0]['inmuebles'] + $v[0]['muebles'] + $v[0]['vehiculos'] + $v[0]['inversiones'] + $v[0]['adeudos'] - $v[0]['pensiones'] - $v[0]['depositos'] - $v[0]['pagos'];?>
                    <?$balance_con = $v[0]['conyuge'] + $v[0]['inmuebles_con'] + $v[0]['muebles_con'] + $v[0]['vehiculos_con'] + $v[0]['inversiones_con'] + $v[0]['adeudos_con'] - $v[0]['depositos_con'] - $v[0]['pagos_con'];?>
                    <?$balance_dep = $v[0]['depend'] + $v[0]['inmuebles_dep'] + $v[0]['muebles_dep'] + $v[0]['vehiculos_dep'] + $v[0]['inversiones_dep'] + $v[0]['adeudos_dep'] - $v[0]['depositos_dep'] - $v[0]['pagos_dep'];?>
                    <tr>
                        <td><b>Balance</b></td>
                        <td>$ <span class ="amount"><?=number_format($balance, 2)?></span></td>
                        <td>$ <span class ="amount"><?=number_format($balance_con, 2)?></span></td>
                        <td>$ <span class ="amount"><?=number_format($balance_dep, 2)?></span></td>
                    </tr>
                </table>
            </div>
            <?}?>
        </div>
    </div>
    <div id ="history">
        <div id ="stuff">
            <?foreach($context->stuff as $k => $v){?>
            <h3><?=$k?></h3>
            <div>
                <?foreach($v as $stuff){?>
                    <?if($stuff['Estatus'] > 0){?>
                        <div class ="stuff">
                            <b><?=$stuff['Tipo']?>: </b> 
                            <?$exp = explode("|", $stuff['Descripcion']);?>
                            <?foreach($exp as $e){
                                echo showVar($e) . " ";
                            }?>
                            <?if($stuff['Estatus'] == 2){?>
                            <span class ="sell">(Vendido)</span>
                            <?}?>
                        </div>
                    <?}?>
                <?}?>
            </div>
            <?}?>
        </div>
    </div>
</div>

