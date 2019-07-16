<?function Style($context){?>
<style type ="text/css">
    #filter {margin: 0px auto 10px auto;}
    #filter td {padding: 5px 5px; }
    .title-data {color: #6A88C2; font-weight: bold; margin: 20px auto; }
</style>
<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    var grid;
    $(function(){
        $('#radio').buttonset();
    
        <?setGrid("grid", $context->params, true);?>
        
        Load();
        
        $('#cmbDep').change(function(){
           Load();
        });
        
        $('.estatus').change(function(){
            if(grid.getColumnsNum() > 8)
                grid.setColumnHidden(8, $('.estatus:checked').attr('action'));
            Load();
        });
        
        $('#btnGenerate').click(function(){
           var str = grid.getCheckedRows(1);
           if(str){
               var cell = str.split(",");
               Remind(cell, $('.estatus:checked').val());
           }else
               $.msgBox({title: "Revise", content: "No ha seleccionado ningún elemento"});
        });
        
        $('#btnAgree').live('click', function(){
            if(Full($('#data'))){
                fakeLoad($(this).parent());
                $.post('reminder.php?action=<?=hideVar('agree')?>', $('#data').serialize(), function(data){
                    closeSexy();
                    location.href = "file.php?id=" + data;
                });
            }
        });
        
        $('#btnExport').click(function(){
            var active = $('#radio').find('.ui-state-active span').text();
            grid.toExcel('js/dhtmlxGrid/grid-excel-php/generate.php?title=' + active);
        });
        
        function Load(){
            if($('#cmbDep').val() != ""){
                Loading();
                var dep = ($('#cmbDep').val() == "TODAS"?"":$('#cmbDep').val());
                Reload(grid, "data/loadReminder.php?dep=" + dep + '&st=' + $('.estatus:checked').val());
            }
        }
        
        
    });// END
    
    function Remind(cell, type){
       Loading();
       $.post('reminder.php?action=<?=hideVar('remind')?>&type=' + type, {id: cell}, function(data){
          location.href = "file.php?id=" + data; 
          $('.mask, .loading').remove();
       });
    }
    
    function Agree(id){
        doSexy('reminder.php?action=<?=hideVar('data')?>&id=' + id, 700, 300, "Generar convenio");
    }
        
</script>
<? } ?>

<?function Body($context){?>
<div class ="section-title"><?=$context->title?> >_</div>
<table id ="filter">
    <tr>
        <td>
             <div id="radio">
                <input type="radio" id="radio1" class ="estatus" name="radio" action ="false" value ="Inicial" checked/><label for="radio1">Altas</label>
                <input type="radio" id="radio2" class ="estatus" name="radio" action ="true" value ="Final"/><label for="radio2">Bajas</label>
             </div>
        </td>
        <td>Dependencia</td>
        <td>
            <select id ="cmbDep" style ="width:400px">
                <?if($_SESSION['TP'] == "GLOBAL"){?>
                <option value ="">Seleccione...</option>
                <option value ="TODAS">TODAS</option>
                <?}?>
                <?foreach($context->dep as $d){?>
                <option value ="<?=$d['ID_Dependencia']?>"><?=$d['Dependencia']?></option>
                <?}?>
            </select>
        </td>
        <td>
            <input type ="button" id ="btnGenerate" class ="btn" value ="Generar recordatorios">
        </td>
        <td>
            <input type ="button" class ="btn" value ="Exportar" id ="btnExport">
        </td>
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
         <td><div id="grid" style ="height: 600px"></div></td>
    </tr>
    <tr>
         <td class = "RowCount"></td>
    </tr>
</table>
<? } ?>

