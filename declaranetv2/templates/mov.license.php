<script type ="text/javascript">
    
    $(function(){
       <?setGrid("gridlic", $context->params);?> 
       if($('#cmbDep').val() != ""){
            Loading();
            Reload(gridlic, 'data/loadLicense.php?dep=' + $('#cmbDep').val());
       }
       
       
    });
    
    function ViewLic(id){
        doSexy('mov.php?action=<?=hideVar('details')?>&tp=<?=hideVar('license')?>&id=' + id, 500, 300, "Detalles de licencia");
    }
</script>

<table width="100%"  cellpadding="0" cellspacing="0">		
    <tr>
         <td id="pager"></td>
    </tr>
    <tr>
         <td><div id="infopage" style =""></div></td>
    </tr>
    <tr>
         <td><div id="gridlic" style ="height: 600px"></div></td>
    </tr>
    <tr>
         <td class = "RowCount"></td>
    </tr>
</table>