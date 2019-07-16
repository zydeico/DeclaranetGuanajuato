<?function Style($context){?>
<style type ="text/css">
   #filter td {padding: 10px 5px; font-size: 11pt; }
   .graphic {height: 300px; }
   .comment-list {width: 99%; margin: 10px auto;}
   .comment-list td {padding: 8px 3px; border-bottom: 1px solid gray;}
</style>
<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    
    $(function(){
      
      $('#btnFinder').click(function(){
         Loading();
         $('#loader').load('repenc.php?action=<?=hideVar('load')?>&dec=' + $('#cmbDec').val() + '&dep=' + $('#cmbDep').val() + '&year=' + $('#cmbYear').val(), function(data){
            $('.mask, .loading').remove();
            $('.accordion').accordion({
               active: false, 
               collapsible: true, 
               activate: function(event, ui){
                    var json = $.parseJSON(ui.newPanel.find('.json').val());
                    if(json){
                        var id = ui.newPanel.find('.graphic').attr('id');
                        var chart = new AmCharts.AmPieChart();
                        chart.dataProvider = json;
                        chart.titleField = "Resp";
                        chart.valueField = "Value";
                        chart.outlineColor = "#FFFFFF";
                        chart.outlineAlpha = 0.8;
                        chart.outlineThickness = 2;
                        chart.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
                        // this makes the chart 3D
                        chart.depth3D = 15;
                        chart.angle = 30;
                        chart.radius = 150;

                        // WRITE
                        chart.write(id);
                        removeLegend();
                    }
               }
            });
         });
      });
        
    });// END
    
    
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
                    <option value ="">TODAS</option>
                    <option value ="INICIAL">INICIAL</option>
                    <option value ="ANUAL">ANUAL</option>
                    <option value ="FINAL">FINAL</option>
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
<div id ="loader">
    
</div>
<? } ?>