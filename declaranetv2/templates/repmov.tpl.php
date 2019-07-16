<?function Style($context){?>
<style type ="text/css">
   #filter td {padding: 10px 5px; font-size: 11pt; }
   .action {margin: 15px; }
</style>
<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    var grid;
    
    $(function(){
       DatePicker($('.date'));
       <?setGrid("grid", $context->params, true);?>
               
       $('#btnFinder').click(function(){
          if(Full($('#filter'))){
            Loading();
            Reload(grid, 'data/loadRepMov.php?d1=' + $('#txtDate1').val() + '&d2=' + $('#txtDate2').val() + '&dep=' + $('#cmbDep').val() + '&mov=' + $('#cmbMov').val());
          }
       });
       
       $('#btnExport').click(function(){
          grid.toExcel('js/dhtmlxGrid/grid-excel-php/generate.php'); 
       });
    });// END
    
</script>
<? } ?>

<?function Body($context){?>
<div class ="section-title"><?=$context->title?> >_</div>
<div id ="filter">
    <table>
        <tr>
            <td>Periodo </td>
            <td>Desde: </td>
            <td><input type ="text" class ="date require" id ="txtDate1" readonly></td>
            <td> Hasta </td>
            <td><input type ="text" class ="date require" id ="txtDate2" readonly></td>
        </tr>
        <tr>
            <td>Dependencia</td>
            <td colspan ="2">
                <select id ="cmbDep" class ="large">
                    <?if($_SESSION['TP'] == "GLOBAL"){?>
                    <option value ="">TODAS</option>
                    <?}?>
                    <?foreach($context->dep as $d){?>
                    <option value ="<?=$d['ID_Dependencia']?>"><?=$d['Dependencia']?></option>
                    <?}?>
                </select>
            </td>
            <td>Movimiento</td>
            <td>
                <select id ="cmbMov">
                    <option value ="">TODOS</option>
                    <option value ="1">ALTA</option>
                    <option value ="2">BAJA</option>
                    <option value ="3">PROMOCIÓN</option>
                    <option value ="4">LICENCIA</option>
                </select>
            </td>
        </tr>
    </table>
    <p>
        <input type ="button" class ="btn action" value ="Mostrar" id ="btnFinder">
        <input type ="button" class ="btn action" value ="Exportar" id ="btnExport">
    </p>
    
</div>

<center>
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
<? } ?>