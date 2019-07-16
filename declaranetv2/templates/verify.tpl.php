<?function Style($context){?>
<style type ="text/css">
    .filter-title {background-color: #C7CAE5; font-style: oblique; padding: 5px;  font-weight: bold; }
    .section {background-color: #DDDDDD; padding: 5px; }
    .field {color: #2A5DAA;}
    #filter {overflow: auto; }
    #reset {float: right;}
    #finder {margin: 5px 0px; background-color: #DDDDDD; padding: 10px; }
    #actions {margin: 20px auto; font-size: 9pt; font-weight:  bold; color: #416EB3; }
    #actions td {padding: 5px 15px;} 
    #year-panel {margin: 10px auto; font-size: 9pt; font-weight: bold;}
    #year-panel td {padding: 0px 10px; }
    .change td {padding: 10px; font-size: 10pt; text-align: center; }
    .title-result {color: #3969B0; margin: 20px; font-size: 12pt;}
    .tbl-result td {padding: 5px 10px;}
    .result {font-weight: bold;}
    .date {width: 100px; }
   #tbl-rep {margin: 10px auto; }
  #tbl-rep td {padding: 5px 10px;} 
</style>
<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    var grid, grid_report;
    
    $(function(){
         $( "#tabs" ).tabs({
            beforeLoad: function( event, ui ) {
                ui.jqXHR.error(function() {
                    ui.panel.html("Ocurrió un problema cargando esta sección. Por favor intente de nuevo");
                });
            }
         });
         
         <?if(in_array(51, $context->allow)){?>
            <?setGrid("grid", $context->params1, true);?>
            grid.attachEvent("onCheck", function(rId,cInd,state){
               var count = parseInt($('#counter').text());
               if(state) 
                   count += 1;
               else
                   count -= 1;
               $('#counter').text(count);
            });
         <?}?>
             
         <?if(in_array(64, $context->allow)){?>
            <?setGrid("grid_report", $context->params2, true);?>
                
            $('#btnDoReport').click(function(){
                Loading();
                Reload(grid_report, 'data/loadRepVerif.php?year=' + $('#cmbYearRep').val() + '&rfc=' + $('#txtRFCRep').val());
            });
            
            $('#btnExportReport').click(function(){
               grid_report.toExcel('js/dhtmlxGrid/grid-excel-php/generate.php'); 
            });
         <?}?>
             
         DatePicker($('.date'));
         
         $('#btnSearch').click(function(){
            if($('.estatus:checked').length > 0){
                Loading();
                grid.clearAll();
                $.post('data/loadSearch.php', $('#filter').serialize(), function(xml){
                    grid.loadXMLString(xml, function(){
                        $('.mask, .loading').remove();
                        $('#counter').text(Count(grid));
                    });
                });
            }else
                $.msgBox({title: "Revise", content: "Debe seleccionar un tipo de Estatus por lo menos"});
         });    
         
         $('#btnExport').click(function(){
            var checked = grid.getCheckedRows(1);
            if(checked.length > 0){  
                checked = checked.split(",");
                var all = grid.getAllRowIds(",");
                all = all.split(",");
                for(var i=0; i<all.length; i++){
                    if(checked.indexOf(all[i]) < 0)
                        grid.deleteRow(all[i]);
                }
                grid.toExcel('js/dhtmlxGrid/grid-excel-php/generate.php');
                grid.checkAll(true);
            }else
                $.msgBox({title: "Revise", content: "No ha seleccionado ningún elemento"});
         });
         
         $('.selection').click(function(){
            var action = $(this).attr('action');
            grid.checkAll(action);
            if(action == "true")
                $('#counter').text(Count(grid));
            else
                $('#counter').text("0");
         });
         
         $('#btnSend').click(function(){
             var checked = grid.getCheckedRows(1);
             if(checked.length > 0){  
                 Loading();
                 checked = checked.split(",");
                 $.post('verify.php?action=<?=hideVar('send')?>', {ids : checked}, function(data){
                    $('.mask, .loading').remove();
                    if(data)
                        $.msgBox({title: "Error", content: data, type: "error"});
                    else{
                        for(var i=0; i<checked.length; i++){
                            grid.setCellExcellType(checked[i],1,'ro');
                            grid.cells(checked[i], 1).setValue('');
                        }
                        $.msgBox({title: "OK", content: "Registros enviados correctamente", type: "info"});
                    }
                 });
             }else
                 $.msgBox({title: "Revise", content: "No ha seleccionado ningún elemento"});
         });
        
    });// END
    
    function View(id){
        doSexy('verify.php?action=<?=hideVar('view')?>&id=' + id, 900, 520, "Consulta general de servidor público");
    }
    
    function Del(id){
        $.msgBox({title: 'Confirme', 
            content:'¿Seguro de eliminar esta registro de verificación?', 
            type: 'confirm', 
            buttons: [{ value: "OK" }, { value: "Cancelar"}],
            success: function (result) {
              if (result == "OK") {
                  $.get('verify.php?action=<?=hideVar('del')?>&id=' + id, function(data){
                      if(data)
                          $.msgBox({title: "Error", content: data, type: "error"});
                      else{
                          Loading();
                          Reload(list, 'data/loadVerify.php?year=' + $('#cmbYear').val());
                      }
                  });
              }
            }
        });
    }
    
    function Change(id){
        doSexy('verify.php?action=<?=hideVar('change')?>&id=' + id, 500, 150, "Asignación de usuario");
    }
    
    function Verify(ver, serv){
        location.href = "verify.php?action=<?=hideVar('worksheet')?>&id=" + serv + '&ver=' + ver;
//        Loading();
//        $.get('verify.php?action=<?=hideVar('verify')?>&id=' + serv + '&ver=' + ver, function(data){
//            $('.mask, .loading').remove();
//            if(isNumeric(data))
//               doSexy('verify.php?action=<?=hideVar('show')?>&id=' + data + '&ver=' + ver, 1000, $(window).height() - 100, "Verificación");
//           else
//               $.msgBox({title: "Error", content: data, type: "error"});
//        });
    }
    
    function Closed(id){
        doSexy('verify.php?action=<?=hideVar('proced')?>&id=' + id, 600, 300, "Resultado de verificación");
    }
</script>
<? } ?>

<?function Body($context){?>
<div class ="section-title"><?=$context->title?> >_</div>
<div id ="tabs">
    <ul>
        <?if(in_array(51, $context->allow)){?>
        <li><a href ="#search">Buscador</a></li>
        <?}?>
        <li><a href ="verify.php?action=<?=hideVar('list')?>">Lista actual</a></li>
        <?if(in_array(64, $context->allow)){?>
        <li><a href ="#report">Reporte</a></li>
        <?}?>
    </ul>
    <?if(in_array(51, $context->allow)){?>
    <div id ="search">
        <center>
            <form id ="filter">
                <table>
                    <tr>
                        <td class ="section">
                            <div class ="filter-title">General</div>
                            <table>
                                <tr>
                                    <td class ="field">Balanza negativa</td>
                                    <td><input type ="checkbox" name ="balance" value ="1" checked></td>
                                </tr>
                                <tr>
                                    <td class ="field">RFC</td>
                                    <td><input type ="text" name ="rfc" class =""></td>
                                </tr>
                                <tr>
                                    <td class ="field">Nombre o Apellídos</td>
                                    <td><input type ="text" name ="name" class =""></td>
                                </tr>
                            </table>
                        </td>
                        <td class ="section">
                            <div class ="filter-title">Laboral</div>
                            <table>
                                <tr>
                                    <td class ="field">Dependencia</td>
                                    <td>
                                        <select name ="dep" class ="large">
                                            <option value ="">Seleccione</option>
                                            <?foreach($context->dep as $d){?>
                                            <option value ="<?=$d['ID_Dependencia']?>"><?=$d['Dependencia']?></option>
                                            <?}?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class ="field">Cargo (Nominal)</td>
                                    <td>
                                        <select name ="pos" class ="large">
                                            <option value ="">Seleccione</option>
                                            <?foreach($context->pos as $p){?>
                                            <option value ="<?=$p['ID_Puesto']?>"><?=$p['Puesto']?></option>
                                            <?}?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class ="field">&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class ="section">
                            <div class ="filter-title">Fechas</div>
                            <table>
                                <tr>
                                    <td class ="field">Toma de posesión</td>
                                    <td>Entre:</td>
                                    <td><input type ="text" name ="begin1" class ="date" readonly></td>
                                    <td> y </td>
                                    <td><input type ="text" name ="begin2" class ="date" readonly></td>
                                </tr>
                                <tr>
                                    <td class ="field">Fecha de baja</td>
                                    <td>Entre:</td>
                                    <td><input type ="text" name ="begin1" class ="date" readonly></td>
                                    <td> y </td>
                                    <td><input type ="text" name ="begin2" class ="date" readonly></td>
                                </tr>
                            </table>
                        </td>
                        <td class ="section">
                            <div class ="filter-title">Estatus</div>
                            <table>
                                <tr>
                                    <td>Activo</td>
                                    <td><input type ="checkbox" name ="estatus[]" value ="1" class ="estatus" checked></td>
                                    <td>Baja</td>
                                    <td><input type ="checkbox" name ="estatus[]" value ="2" class ="estatus"></td>
                                    <td>Licencia</td>
                                    <td><input type ="checkbox" name ="estatus[]" value ="4" class ="estatus"></td>
                                </tr>
                            </table>
                            <input type ="reset" value ="Limpiar campos" id ="reset">
                        </td>
                    </tr>
                </table>
            </form>
            <div id ="finder"><input type ="button" class ="btn" value ="Buscar" id ="btnSearch"></div>
            <table id ="actions">
                <tr>
                    <td><span id ="counter">0</span> elementos seleccionados</td>
                    <td><input type ="button" class ="btn selection" action ="true"  value ="Seleccionar todos" ></td>
                    <td><input type ="button" class ="btn selection" action ="false"  value ="Deseleccionar todos" ></td>
                    <td><input type ="button" class ="btn selection" value ="Exportar selección" id ="btnExport"></td>
                    <td><input type ="button" class ="btn" value ="Enviar a listado" id ="btnSend"></td>
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
        </center>
    </div>
    <div id ="report">
        <center>
            <table id ="tbl-rep">
                <tr>
                    <td>RFC</td>
                    <td><input type ="text" id ="txtRFCRep"></td>
                    <td>Año de verificación</td>
                    <td>
                        <select id ="cmbYearRep">
                            <?for($y=Date('Y'); $y>=$context->min; $y--){?>
                            <option value ="<?=$y?>"><?=$y?></option>
                            <?}?>
                        </select>
                    </td>
                    <td><input type ="button" class ="btn" id ="btnDoReport" value ="Mostrar"></td>
                    <td><input type ="button" class ="btn" id ="btnExportReport" value ="Exportar"></td>
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
                     <td><div id="grid_report" style ="height: 600px"></div></td>
                </tr>
                <tr>
                     <td class = "RowCount"></td>
                </tr>
            </table>
        </center>
    </div>
    <?}?>
</div>
<? } ?>