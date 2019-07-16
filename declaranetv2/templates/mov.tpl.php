<?function Style($context){?>
<style type ="text/css">
    #filter {margin: 10px auto 15px auto; }
    .datakey {margin: 20px auto; }
    .datakey td {padding: 5px 10px; }
    .tbl-correct { width: 95%; font-size: 10pt; }
    .tbl-correct th {text-align: left; padding: 10px 0px;}
    .tbl-correct td {padding: 3px 5px;}
    .origin {color: #4D75B7;}
    .correct {color: red; }
    .resumen {color: #4D75B7;  margin: 5px 10px; width: 95%; font-size: 10pt;}
    #correction {padding: 10px 20px; }
    .section {margin: 15px 0px; color: #217FB1;}
    .actions {margin: 10px auto;}
    .result {margin: 10px auto; text-align: center; color: #BE2652; }
    .tbl-down td{text-align: center; padding: 5px; }
    .attach {display: none; }
    .label {color: #BB244E; }
    #fracc {border: 1px solid #C0C5E3; width: 80%; overflow: auto; height: 50px; padding: 10px; }
    .fracc-label {font-size: 10pt; }
    #fn-iist {border: 1px solid #C0C5E3; width: 80%; overflow: auto; height: 150px; padding: 10px; }
    #fn-tbl {width: 99%; font-size: 10pt; }
    #txtFn {width: 500px; }
    .quit {cursor: pointer; }
    #addFn {cursor: pointer;}
    #panel-pending {float: right; margin: 10px; }
</style>
<?}?>

<?function Script($context){?>
<script type ="text/javascript">
    var grid, gridlic, gridcorrect;
    
    $(function(){
    ////////////////////////// General /////////////////////////////////////////////////
        $( "#tabs" ).tabs({
            beforeLoad: function( event, ui ) {
                ui.jqXHR.error(function() {
                    ui.panel.html("Ocurrió un error mientras se cargaba la sección deseada");
                });
            }
        });
        
//       Loading();
       <?setGrid("grid", $context->params, true);?> 
//       Reload(grid, 'data/loadMov.php?dep=' + $('#cmbDep').val());
       
       $('#cmbDep').change(function(){
           if($(this).val() != ""){
                Loading();
                $('#chkShowDown').removeAttr('checked');
                $('#link-lic').attr('href', "mov.php?action=<?=hideVar('view')?>&target=<?=hideVar('license')?>&dep=" + $(this).val());
                Reload(grid, 'data/loadMov.php?dep=' + $('#cmbDep').val());
           }
       });
       
       $('#chkShowDown').click(function(){
            if($('#cmbDep').val() != ""){
                Loading();
                Reload(grid, 'data/loadMov.php?dep=' + $('#cmbDep').val() + '&down=' + ($(this).is(':checked')?"1":"0"));
            }
       });
       
       $('#btnExport').click(function(){
           grid.toExcel('js/dhtmlxGrid/grid-excel-php/generate.php'); 
       });
       
       ////////////////////////// Key /////////////////////////////////////////////////
       
       $('#btnKey').live('click', function(){
          if(Full($('#key'))){ 
            $.post('mov.php?action=<?=hideVar('key')?>', $('#key').serialize(), function(data){
                if(data)
                    $.msgBox({title: "Error", content: data, type: "error"});
                else
                    closeSexy();
            });
          }
       });
       
       ////////////////////////// Correct /////////////////////////////////////////////////
       
       $('#btnRegister').live('click', function(){
            if(Full($('#register'))){
                fakeLoad($(this).parent());
                $.post('mov.php?action=<?=hideVar('correct')?>', $('#register').serialize(), function(data){
                    ready();
                    if(data)
                        $.msgBox({title: "Error", content: data, type: "error"});
                    else
                        closeSexy();
                });
            }
       });
       
       $('.makeCorrect').live('click', function(){
            fakeLoad($(this).parent());
            $.post('mov.php?action=<?=hideVar('validate')?>&st=' + $(this).attr('action'), $('#correction').serialize(), function(data){
                ready();
                if(data)
                   $.msgBox({title: "Error", content: data, type: "error"});
                else{
//                   Reload(grid,s 'data/loadMov.php?dep=' + $('#cmbDep').val()); 
                   Reload(gridcorrect, 'data/loadCorrect.php?pending=' + ($('#chkPending').is(':checked')?"1":"0"));
                   closeSexy();
                }
            });
       });
       
       ////////////////////////// Down /////////////////////////////////////////////////
       
       $('#btnDown').live('click', function(){
          if(Full($('#down'))){
                fakeLoad($(this).parent());
                var inputFileImage = document.getElementById("file");
                var file = inputFileImage.files[0];
                var data = new FormData();
                data.append('act', file);
                data.append('id', $('#txtDownID').val());
                data.append('date', $('#txtDownDate').val());
                data.append('type', $('#cmbDown').val());
                $.ajax({
                    url: 'mov.php?action=<?=hideVar('down')?>',
                    type:'POST',
                    contentType:false,
                    data: data,
                    processData:false,
                    cache:false, 
                    success: function(msg){
                        ready();
                        if(msg)
                            $.msgBox({title: "Error", content: msg, type: "error"});
                        else{
                            $('#chkShowDown').removeAttr('checked');
                            Reload(grid, 'data/loadMov.php?dep=' + $('#cmbDep').val());
                            closeSexy();
                        }
                    }
                });

            }
       
       });
       
       ////////////////////////// Deactivate /////////////////////////////////////////////////
       $('#btnCancel').live('click', function(){
            closeSexy();
       });
       
       $('#btnDeactivate').live('click', function(){
          fakeLoad($(this).parent());
          $.post('mov.php?action=<?=hideVar('deactivate')?>', $('#deactivate').serialize(), function(data){
            ready(); 
            if(data)
                $.msgBox({title: "Error", content: data, type: "error"});
            else{
                $('#chkShowDown').removeAttr('checked');
                Reload(grid, 'data/loadMov.php?dep=' + $('#cmbDep').val());
                closeSexy();
            }
                 
          });
       });
       
       ////////////////////////// License /////////////////////////////////////////////////
       $('#btnLicense').live('click', function(){
          if(Full($('#license'))){
              fakeLoad($(this).parent());
              $.post('mov.php?action=<?=hideVar('license')?>', $('#license').serialize(), function(data){
                 ready();
                 if(data)
                     $.msgBox({title: "Error", content: data, type: "error"});
                 else{
                    closeSexy();
                    Loading();
                    $('#chkShowDown').removeAttr('checked');
                    Reload(gridlic, 'data/loadLicense.php?dep=' + $('#cmbDep').val());
                    Reload(grid, 'data/loadMov.php?dep=' + $('#cmbDep').val());
                 }
              });
          }
       });
       
       ////////////////////////// Promocion /////////////////////////////////////////////////
       $('.quit').live('click', function(){
            $(this).parents('tr').remove();
       });
       
       $('#addFn').live('click', function(){
           var fn = $.trim($('#txtFn').val());
            if(fn.length > 0){
                var html = "<tr class ='fn'>"
                         + "<td><img src = 'img/delete.png' class = 'quit'></<td>"
                         + "<td>" + fn + "</td>"
                         + "<input type = 'hidden' name = 'fn[]' value = '" + fn + "'>"
                         + "</tr>";
                 if($('.fn').length > 0)
                     $('.fn:last').after(html);
                 else
                     $(this).parents('tr').before(html);
                 $('#txtFn').val('');
                 $('#txtFn').focus();
            }
       });
       
       $('#btnPromo').live('click', function(){
            if(Full($('#promo'))){
                if($('.fn').length > 0){
                    if($('.chkfracc:checked').length > 0){
                        fakeLoad($(this).parent());
                        $.post('mov.php?action=<?=hideVar('promo')?>', $('#promo').serialize(), function(data){
                            ready();
                            if(data)
                                $.msgBox({title: "Error", content: data, type: "error"});
                            else{
                                $('#chkShowDown').removeAttr('checked');
                                Reload(grid, 'data/loadMov.php?dep=' + $('#cmbDep').val());
                                closeSexy();
                            }
                        });
                    }else
                        $.msgBox({title: "Revise", content: "Debe seleccionar al menos una fracción"});
                }else
                    $.msgBox({title: "Revise", content: "Debe agregar al menos una función"});
            }
       });
       
      
    });// END
    
    function Load(opt, id, w, h){
        var title;
        switch(opt){
            case "Down": title = "Crear baja"; break;
            case "License": title = "Crear licencia"; break;
            case "Deactivate": title = "Desactivar servidor"; break;
            case "Promo": title = "Crear promoción"; break;
            case "Correct": title = "Realizar corrección"; break;
            case "Key": title = "Cambiar contraseña"; break;
        }
        doSexy('mov.php?action=<?=hideVar('load')?>&opt=' + opt + '&id=' + id, w, (h=="*"?$(window).height() - 100:h), title);
    }
</script>
<?}?>

<?function Body($context){?>
    <div class ="section-title"><?=$context->title?> >_</div>
    <div id="tabs">
        <ul>
            <li><a href="#default">Consulta general</a></li>
            <?if(in_array(14, $context->allow)){?>
            <li><a id ="link-lic" href="mov.php?action=<?=hideVar('view')?>&target=<?=hideVar('license')?>&dep=0">Licencias</a></li>
            <?}?>
            <?if(in_array(38, $context->allow)){?>
            <li><a href="mov.php?action=<?=hideVar('view')?>&target=<?=hideVar('correct')?>">VoBo. Correcciones</a></li>
            <?}elseif(in_array(37, $context->allow)){?>
            <li><a href="mov.php?action=<?=hideVar('view')?>&target=<?=hideVar('correct')?>">Mis Correcciones</a></li>
            <?}?>
        </ul>
        <div id="default">
            <div id ="filter">
                <center>
                    <table>
                        <tr>
                            <td>Dependencia</td>
                            <td>
                                <select id ="cmbDep">
                                    <option value ="">Seleccione...</option>
                                    <?foreach($context->dep as $d){?>
                                    <option value ="<?=$d['ID_Dependencia']?>"><?=$d['Dependencia']?></option>
                                    <?}?>
                                </select>
                            </td>
                            <td style ="padding: 0 15px;">
                                 Mostrar bajas <input type ="checkbox" id ="chkShowDown">
                            </td>
                            <td>
                                <input type ="button" class ="btn" id ="btnExport" value ="Exportar">
                            </td>
                        </tr>
                    </table>
                </center>
            </div>

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
        </div>
    </div>
<?}?>