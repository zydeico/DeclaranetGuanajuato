<?function Style($context){?>
<style type ="text/css">
   #filter {margin: 20px auto; }
   #filter table td {padding: 5px; }
</style>
<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    var grid;
    
    $(function(){
       <?setGrid("grid", $context->params, true);?>
       Grid();
               
       $('#cmbDep, #cmbStat').change(function(){
            Grid();
       });
       
       $('#btnExport').click(function(){
          grid.toExcel('js/dhtmlxGrid/grid-excel-php/generate.php'); 
       });
    });// END
    
    
    function Grid(){
        if($('#cmbDep').val()){
            Loading();
            Reload(grid, 'data/loadRepObl.php?dep=' + $('#cmbDep').val() + '&st=' + $('#cmbStat').val());
        }
    }
</script>
<? } ?>

<?function Body($context){?>
<div class ="section-title"><?=$context->title?> >_</div>
<div id ="filter">
    <table>
        <tr>
            <td>Dependencia</td>
            <td colspan ="2">
                <select id ="cmbDep">
                    <?if($_SESSION['TP'] == "GLOBAL"){?>
                    <option value ="">Seleccione...</option>
                    <option value ="ALL">TODAS</option>
                    <?}?>
                    <?foreach($context->dep as $d){?>
                    <option value ="<?=$d['ID_Dependencia']?>"><?=$d['Dependencia']?></option>
                    <?}?>
                </select>
            </td>
            <td>Estatus</td>
            <td>
                <select id ="cmbStat">
                    <option value ="1">ACTIVO</option>
                    <option value ="2">BAJA</option>
                </select>
            </td>
            <td>
                <input type ="button" class ="btn action" value ="Exportar" id ="btnExport">
            </td>
        </tr>
    </table>
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
             <td><div id="grid" style ="height: 750px"></div></td>
        </tr>
        <tr>
             <td class = "RowCount"></td>
        </tr>
    </table>
</center>
<? } ?>