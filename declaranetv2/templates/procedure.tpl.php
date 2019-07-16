<?function Style($context){?>
<style type ="text/css">
   #filter {margin: 20px auto; }
   #filter td {padding: 0px 5px;}
   #tbl-edit td {padding: 5px; }
   #info-agend {background: #D3D3D3;}
   #info-agend td {padding: 10px;} 
</style>
<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    var grid;
    
    $(function(){
         Loading();
         <?setGrid("grid", $context->params, true);?>
         Grid();
         
         $('#btnFilter').click(function(){
             var rfc = $('#txtRFC').val();
             var dep = $('#cmbDep').val();
             var year = $('#cmbYear').val();
             Loading();
             Grid();
         });
         
         $('#btnExport').click(function(){
            grid.toExcel('js/dhtmlxGrid/grid-excel-php/generate.php');  
         });
    });// END
    
    function Grid(){
        Reload(grid, 'data/loadProcedure.php?year=' + $('#cmbYear').val() + '&dep=' + $('#cmbDep').val() + '&pra=' + ($('#chkPRA').is(':checked')?"1":"0"));
    }
    
    function Edit(id){
        doSexy('procedure.php?action=<?=hideVar("edit")?>&id=' + id, 400, 200, 'Detalles de procedimiento');
    }
    
    function Del(id){
         $.msgBox({title: 'Confirme', 
                content: '¿Seguro de eliminar este procedimiento?', 
                type: 'confirm', 
                buttons: [{ value: "OK" }, { value: "Cancelar"}],
                success: function (result) {
                    if (result == "OK") {
                          Loading();
                          $.get('procedure.php?action=<?=hideVar('del')?>&id=' + id, function(data){
                              if(data)
                                  $.msgBox({title: "Error", content: data, type: "error"});
                              else
                                  Grid();
                          });
                    }
                }
          });
    }
    
    function Generate(id, tp){
        Loading();
        $.get('procedure.php?action=<?=hideVar('generate')?>&id=' + id + '&type=' + tp, function(data){
            $('.mask, .loading').remove();
            location.href = "file.php?id=" + data;
        });
    }
    
</script>
<? } ?>

<?function Body($context){?>
<div class ="section-title"><?=$context->title?> >_</div>
<div id ="info-agend">
    <table>
        <tr>
            <td>Último proceso automático: </td>
            <td><b><?=($context->agend?$context->agend->Fecha_Agenda:"NUNCA")?></b></td>
            <td>Procedimientos creados INICIALES: </td>
            <td><b><?=($context->agend?$context->agend->INICIAL:"0")?></b></td>
            <td>ANUALES: </td>
            <td><b><?=($context->agend?$context->agend->ANUAL:"0")?></b></td>
            <td>FINALES: </td>
            <td><b><?=($context->agend?$context->agend->FINAL:"0")?></b></td>
        </tr>
    </table>
</div>
<div id ="filter">
    <table>
        <tr>
            <td>Dependencia</td>
            <td>
                <select id ="cmbDep" class ="large">
                    <option value ="">TODAS</option>
                    <?foreach($context->dep as $d){?>
                    <option value ="<?=$d['ID_Dependencia']?>"><?=$d['Dependencia']?></option>
                    <?}?>
                </select>
            </td>
            <td>Año</td>
            <td>
                <select id ="cmbYear">
                    <option value ="">TODOS</option>
                    <?for($i=Date('Y'); $i>=$context->year; $i--){?>
                    <option value ="<?=$i?>" <?=(Date('Y')==$i?"selected":"")?>><?=$i?></option>
                    <?}?>
                </select>
            </td>
            <td>
                <label for="chkPRA">Sólo con PRA capturado</label>
                <input type ="checkbox" id ="chkPRA">
            </td>
            <td><input type ="button" class ="btn" value ="Filtrar" id ="btnFilter"></td>
            <td><input type ="button" class ="btn" value ="Exportar" id ="btnExport"></td>
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
             <td><div id="grid" style ="height: 700px"></div></td>
        </tr>
        <tr>
             <td class = "RowCount"></td>
        </tr>
    </table>
</center>

<? } ?>