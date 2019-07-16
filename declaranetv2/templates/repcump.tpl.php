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
               
       $('#btnFinder').click(function(){
            Loading();
            Reload(grid, 'data/loadRepCump.php?dep=' + $('#cmbDep').val() + '&dec=' + $('#cmbDec').val() + '&year=' + $('#cmbYear').val());
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
            <td>Año</td>
            <td>
                <select id ="cmbYear">
                    <?for($y=Date('Y'); $y>=$context->min; $y--){?>
                    <option value ="<?=$y?>"><?=$y?></option>
                    <?}?>
                </select>
            </td>
            <td>
                <input type ="button" class ="btn action" value ="Mostrar" id ="btnFinder">
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
<!--        <tr>
             <td class = "RowCount"></td>
        </tr>-->
    </table>
</center>
<? } ?>