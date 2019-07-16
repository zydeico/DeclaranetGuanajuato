<?function Style($context){?>
<style type ="text/css">
   #filter td {padding: 10px 5px; font-size: 11pt; }
   #gauge {height: 350px; }
   #chart {height: 400px; }
   .miniloading {margin: 50px auto; text-align: center;}
   h3 {margin: 15px 0px; }
</style>
<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    var grid;
    
    $(function(){
       $('#accordion').accordion({heightStyle: 'content'});
       
       <?=setGrid("grid", $context->params, true);?>
       
       $('#btnFinder').click(function(){
            Gauge();
            Chart();
            Reload(grid, 'data/loadRepDec.php?dec=' + $('#cmbDec').val() + '&year=' + $('#cmbYear').val() + '&dep=' + $('#cmbDep').val());
       });
       
       $('#btnExport').click(function(){
          grid.toExcel('js/dhtmlxGrid/grid-excel-php/generate.php'); 
       });
        
    });// END
    
    function Gauge(){
        $('#gauge').html("<div class = 'miniloading'><img src = 'img/loadingmini.gif'></div>");
        $.get('repdec.php?action=<?=hideVar('gauge')?>&dec=' + $('#cmbDec').val() + '&year=' + $('#cmbYear').val() + '&dep=' + $('#cmbDep').val(), function(val){
            $('.mask, .loading').remove();
            // create angular gauge
            var chart = new AmCharts.AmAngularGauge();
//            chart.addTitle("Avance de declaración");

            // create axis
            var axis = new AmCharts.GaugeAxis();
            axis.startValue = 0;
            axis.axisThickness = 1;
            axis.endValue = 100;
            // color bands
            var band1 = new AmCharts.GaugeBand();
            band1.startValue = 0;
            band1.endValue = 50;
            band1.color = "#ea3838";
            band1.innerRadius = "95%";

            var band2 = new AmCharts.GaugeBand();
            band2.startValue = 50;
            band2.endValue = 80;
            band2.color = "#ffac29";
            band2.innerRadius = "95%";

            var band3 = new AmCharts.GaugeBand();
            band3.startValue = 80;
            band3.endValue = 100;
            band3.color = "#00CC00";
            band3.innerRadius = "95%";

            axis.bands = [band1, band2, band3];

            // bottom text
            axis.bottomTextYOffset = -20;
            axis.setBottomText("%");
            chart.addAxis(axis);

            // gauge arrow
            var arrow = new AmCharts.GaugeArrow();
            chart.addArrow(arrow);

            chart.write("gauge");
            arrow.setValue(val);
            axis.setBottomText(val + "%");
            removeLegend();
        });
    }
    
    function Chart(){
        $('#chart').html("<div class = 'miniloading'><img src = 'img/loadingmini.gif'></div>");
        $.getJSON('repdec.php?action=<?=hideVar('general')?>&dec=' + $('#cmbDec').val() + '&year=' + $('#cmbYear').val() + '&dep=' + $('#cmbDep').val(), function(json){
            var chart = new AmCharts.AmSerialChart();
            chart.pathToImages = "js/amcharts_3.1.1/amcharts/images/";
            chart.dataProvider = json;
            chart.categoryField = "date";

            // data updated event will be fired when chart is first displayed,
            // also when data will be updated. We'll use it to set some
            // initial zoom
    //        chart.addListener("dataUpdated", zoomChart);

            // AXES
            // Category
            var categoryAxis = chart.categoryAxis;
            categoryAxis.parseDates = true; // in order char to understand dates, we should set parseDates to true
            categoryAxis.minPeriod = "DD"; // as we have data with minute interval, we have to set "mm" here.			 
            categoryAxis.gridAlpha = 0.07;
            categoryAxis.axisColor = "#DADADA";

            // Value
            var valueAxis = new AmCharts.ValueAxis();
            valueAxis.gridAlpha = 0.07;
            valueAxis.title = "Declaraciones";
            chart.addValueAxis(valueAxis);

            // GRAPH
            var graph = new AmCharts.AmGraph();
            graph.type = "line"; // try to change it to "column"
            graph.title = "red line";
            graph.valueField = "value";
            graph.lineAlpha = 1;
            graph.lineColor = "#d1cf2a";
            graph.fillAlphas = 0.1; // setting fillAlphas to > 0 value makes it area graph
            chart.addGraph(graph);

            // CURSOR
            var chartCursor = new AmCharts.ChartCursor();
            chartCursor.cursorPosition = "mouse";
    //        chartCursor.categoryBalloonDateFormat = "JJ:NN, DD MMMM";
            chartCursor.categoryBalloonDateFormat = "YYYY-MM-DD";
            chart.addChartCursor(chartCursor);

            // SCROLLBAR
            var chartScrollbar = new AmCharts.ChartScrollbar();

            chart.addChartScrollbar(chartScrollbar);

            // WRITE
            chart.write("chart");
            removeLegend();
        });
    }
    
</script>
<? } ?>

<?function Body($context){?>
<div class ="section-title"><?=$context->title?> >_</div>
<div id ="filter">
    <table>
        <tr>
            <td>Declaración</td>
            <td>
                <select id ="cmbDec">
                    <option value ="INICIAL">INICIAL</option>
                    <option value ="ANUAL">ANUAL</option>
                    <option value ="FINAL">FINAL</option>
                    <option value ="INTERESES">INTERESES</option>
                </select>
            </td>
            <td>Dependencia</td>
            <td>
                <select id ="cmbDep" class ="large">
                    <?if($_SESSION['TP'] == "GLOBAL"){?>
                    <option value ="">TODAS</option>
                    <?}?>
                    <?foreach($context->dep as $d){?>
                    <option value ="<?=$d['ID_Dependencia']?>"><?=$d['Dependencia']?></option>
                    <?}?>
                </select>
            </td>
            <td>Año</td>
            <td>
                <select id ="cmbYear">
                    <?for($i=Date('Y'); $i>=$context->min; $i--){?>
                    <option value ="<?=$i?>"><?=$i?></option>
                    <?}?>
                </select>
            </td>
            <td><input type ="button" class ="btn" value ="Mostrar" id ="btnFinder"></td>
        </tr>
    </table>
</div>

<h3 align ="center">Avance de declaración</h3>
<div>
    <div id ="gauge"></div>
</div>
<h3>Gráfica general</h3>
<div id ="chart"></div>
<h3 align ="center">Lista completa</h3>
<div>
    <center>
        <p><input type ="button" class ="btn" value ="Exportar" id ="btnExport"></p>
        <table width="100%"  cellpadding="0" cellspacing="0">		
            <tr>
                 <td id="pager"></td>
            </tr>
            <tr>
                 <td><div id="infopage" style =""></div></td>
            </tr>
            <tr>
                 <td><div id="grid" style ="height: 600px"></div></td>
            </tr>
            <tr>
                 <td class = "RowCount"></td>
            </tr>
        </table>
    </center>
</div>


<? } ?>