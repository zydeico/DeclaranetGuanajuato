<?function Style($context){?>
<style type ="text/css">
    #actions {margin: 20px auto; }
    #actions td {padding: 0px 5px;}
    #filter {width: 95%; background-color: #D5D6EB; font-size: 11pt;}
    #filter td {padding: 10px; }
</style>
<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    var grid;
    
    $(function(){
         
         <?setGrid("grid", $context->params, true);?>
         grid.attachEvent("onCheck", function(rId,cInd,state){
            var count = parseInt($('#counter').text());
            if(state) 
                count += 1;
            else
                count -= 1;
            $('#counter').text(count);
         });
         
         $('#btnFind').click(function(){
            Loading();
            Reload(grid, 'data/loadOmited.php?dec=' + $('#cmbDeclare').val() + '&dep=' + $('#cmbDepend').val());
         });
         
         $('#btnExport').click(function(){
//            var checked = grid.getCheckedRows(1);
//            if(checked.length > 0){  
//                checked = checked.split(",");
//                var all = grid.getAllRowIds(",");
//                all = all.split(",");
//                for(var i=0; i<all.length; i++){
//                    if(checked.indexOf(all[i]) < 0)
//                        grid.deleteRow(all[i]);
//                }
                grid.toExcel('js/dhtmlxGrid/grid-excel-php/generate.php');
//                grid.checkAll(true);
//            }else
//                $.msgBox({title: "Revise", content: "No ha seleccionado ningún elemento"});
         });
         
         $('.selection').click(function(){
            var action = $(this).attr('action');
            grid.checkAll(action);
            if(action == "true")
                $('#counter').text(Count(grid));
            else
                $('#counter').text("0");
         });
         
         $('#btnProced').click(function(){
             var checked = grid.getCheckedRows(1);
             if(checked.length > 0){  
                 checked = checked.split(",");
                 Loading();
                 $.post('procedure.php?action=<?=hideVar('new')?>&type=2&dec=' + $('#cmbDeclare').val(), {id: checked}, function(data){
                    $('.mask, .loading').remove();
                    if(data){
                        var json = $.parseJSON(data);
                        var error = "Ya existe procedimiento iniciado para " + json.length + " persona(s) de la selección. Realize una nueva búsqueda para verificar";
                        $.msgBox({title: "Error", content: error, type: "error"});
                    }else
                        $.msgBox({title: "OK", content: "Procedimientos iniciados correctamente", type: "info"});
                 });
             }else
                 $.msgBox({title: "Revise", content: "No ha seleccionado ningún elemento"});
         });
    });// END
    
    
</script>
<? } ?>

<?function Body($context){?>
<div class ="section-title"><?=$context->title?> >_</div>
<center>
    <form id ="filter">
        <table>
            <tr>
                <td>Declaración</td>
                <td>
                    <select id ="cmbDeclare">
                        <option value ="INICIAL">INICIAL</option>
                        <option value ="ANUAL">ANUAL</option>
                        <option value ="FINAL">FINAL</option>
                        <option value ="INTERESES">INTERESES</option>
                    </select>
                </td>
                <td>Dependencia</td>
                <td>
                    <select id ="cmbDepend" class ="large">
                        <?if(count($context->dep) > 1){?>
                        <option value ="">TODAS</option>
                        <?}?>
                        <?foreach($context->dep as $d){?>
                        <option value ="<?=$d['ID_Dependencia']?>"><?=$d['Dependencia']?></option>
                        <?}?>
                    </select>
                </td>
                <td>
                    <input type ="button" class ="btn" value ="Mostrar" id ="btnFind">
                </td>
            </tr>
        </table>
    </form>
    <table id ="actions">
        <tr>
            <td><span id ="counter">0</span> elementos seleccionados</td>
            <td><input type ="button" class ="btn selection" action ="true"  value ="Seleccionar todos" ></td>
            <td><input type ="button" class ="btn selection" action ="false"  value ="Deseleccionar todos" ></td>
            <td><input type ="button" class ="btn selection" value ="Exportar" id ="btnExport"></td>
            <?if($_SESSION['TP']=="GLOBAL"){?>
            <td><input type ="button" class ="btn" value ="Iniciar procedimiento" id ="btnProced"></td>
            <?}?>
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
             <td><div id="grid" style ="height: 700px"></div></td>
        </tr>
        <tr>
             <td class = "RowCount"></td>
        </tr>
    </table>
</center>

<? } ?>