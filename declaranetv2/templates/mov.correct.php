<script type ="text/javascript">
    
    $(function(){
       Loading();
       <?setGrid("gridcorrect", $context->params);?> 
       Reload(gridcorrect, 'data/loadCorrect.php?pending=' + ($('#chkPending').is(':checked')?"1":"0"));
       
       $('#chkPending').click(function(){
            Loading();
            Reload(gridcorrect, 'data/loadCorrect.php?pending=' + ($('#chkPending').is(':checked')?"1":"0"));
       });
    });
    
    function Correct(id){
        doSexy('mov.php?action=<?=hideVar('details')?>&tp=<?=hideVar('correct')?>&id=' + id, 800, $(window).height() - 100, "Detalles de corrección");
    }
</script>
<div id ="panel-pending"><input type ="checkbox" id ="chkPending" checked> Mostrar sólo pendientes</div>
<table width="100%"  cellpadding="0" cellspacing="0">		
    <tr>
         <td id="pager"></td>
    </tr>
    <tr>
         <td><div id="infopage" style =""></div></td>
    </tr>
    <tr>
         <td><div id="gridcorrect" style ="height: 600px"></div></td>
    </tr>
    <tr>
         <td class = "RowCount"></td>
    </tr>
</table>