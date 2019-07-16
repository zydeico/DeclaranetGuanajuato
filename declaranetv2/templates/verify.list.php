
<script>
    var list;
    
    $(function(){
        $('.btn').button();
        Loading();
        <?setGrid("list", $context->params)?>
        Reload(list, 'data/loadVerify.php');
        
        $('#cmbYear').change(function(){
            Loading();
            Reload(list, 'data/loadVerify.php?year=' + $(this).val());
        });
        
        $('#btnList').click(function(){
           list.toExcel('js/dhtmlxGrid/grid-excel-php/generate.php'); 
        });
        
    }); // END
</script>
<table id ="year-panel">
    <tr>
        <td>Año: </td>
        <td>
            <select id ="cmbYear">
                <?for($i=Date('Y'); $i>=$context->min; $i--){?>
                <option value ="<?=$i?>"><?=$i?></option>
                <?}?>
            </select>
        </td>
        <td><input type ="button" class ="btn" value ="Exportar lista" id ="btnList"></td>
    </tr>
</table>
<table width="100%"  cellpadding="0" cellspacing="0">		
    <tr>
         <td id="pager"></td>
    </tr>
    <tr>
         <td><div id="infopage" style =""></div></td>
    </tr>
    <tr>
         <td><div id="list" style ="height: 800px"></div></td>
    </tr>
    <tr>
         <td class = "RowCount"></td>
    </tr>
</table>