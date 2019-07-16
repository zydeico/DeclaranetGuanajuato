<?function Style($context){?>
<style type ="text/css">
   #legend {margin: 15px auto; font-size: 12pt; }
   #filter {margin: 25px auto; font-size: 10pt; }
   #filter td {padding: 0px 5px; }
</style>
<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    var grid;
    
    $(function(){
         
         <?setGrid("grid", $context->params, true);?>
         Reload(grid, 'data/loadAdopublica.php');
         
         $('#btnFinder').click(function(){
             Loading();
             Reload(grid, 'data/loadAdopublica.php?st=' + $('#cmbEstatus').val() + '&rfc=' + $('#txtRFC').val() + '&dep=' + $('#cmbDep').val());
         });
        
    });// END
    
    function ver(id){
        doSexy('adopublica.php?action=<?=hideVar('acuerdo')?>&id=' + id, 800, 500, "Acuerdos");      
    }
    
    function LoadDocument(div){
    var url = $(div).attr('action');
    $('#iframe').attr('src', url + '#view=FitH');
    }
    
        $('#btnAccept').live('click', function(){
            if(Full($('#acuerdopub'))){
                fakeLoad($(this).parent());
                $.post('adopublica.php?action=<?=hideVar('resp')?>&resp=<?=hideVar('1')?>', $('#acuerdopub').serialize(), function(data){
                    ready();
                    if(data)
                        $.msgBox({title: "Error", content: data, type: "error"});
                    else{
                        Reload(grid, 'data/loadAdopublica.php');
                        closeSexy();
                    }
                });
            }
        });
      
        $('#btnReject').live('click', function(){
            if($('#txtMotivo').val() != ""){
                fakeLoad($(this).parent());
                $.post('adopublica.php?action=<?=hideVar('resp')?>&resp=<?=hideVar('2')?>', $('#acuerdopub').serialize(), function(data){
                    ready();
                    if(data)
                        $.msgBox({title: "Error", content: data, type: "error"});
                    else{
                        Reload(grid, 'data/loadAdopublica.php');
                        closeSexy();
                    }
                });
            }else
                $.msgBox({title: "Revise", content: "Debe agregar una respuesta para el servidor público"});
        });
    
</script>
<? } ?>

<?function Body($context){?>
<div class ="section-title"><?=$context->title?> >_</div>
<div id ="filter">
    <table>
        <tr>
            <td>RFC</td>
            <td><input type ="text" id ="txtRFC" maxlength ="10"></td>
            <td>Dependencia</td>
            <td>
                <select id ="cmbDep" class ="large">
                    <option value ="">TODAS</option>
                    <?foreach($context->dep as $d){?>
                    <option value ="<?=$d['ID_Dependencia']?>"><?=$d['Dependencia']?></option>
                    <?}?>
                </select>
            </td>
            <td>Estatus</td>
            <td>
                <select id ="cmbEstatus">
                    <option value ="0">Por validar</option>
                    <option value ="1">Validadas</option>
                    <option value ="2">Rechazadas</option>
                </select>
            </td>
            <td><input type ="button" class ="btn" value ="Buscar" id ="btnFinder"></td>
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