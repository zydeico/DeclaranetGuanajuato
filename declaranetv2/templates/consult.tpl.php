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
         
         $('#btnFinder').click(function(){
             Loading();
             Reload(grid, 'data/loadConsult.php?st=' + $('#cmbEstatus').val() + '&rfc=' + $('#txtRFC').val() + '&dep=' + $('#cmbDep').val());
         });
        
    });// END
    
    function Look(id){
        Loading();
        $.get('verify.php?action=<?=hideVar('verify')?>&id=' + id + '&look=true', function(data){
            $('.mask, .loading').remove();
            if(isNumeric(data))
               doSexy('verify.php?action=<?=hideVar('show')?>&id=' + data, 1000, $(window).height() - 100, "Declaración patrimonial");
            else
               $.msgBox({title: "Error", content: data, type: "error"});
        });
    }
    
    function interes(id){
        doSexy('interest.php?consult&id=' + id, ($(window).width() >= 1200 ? 1200 : $(window).width()), $(window).height()-100, "Declaración de intereses");
    }
    
    function fiscal(id){
        doSexy('fiscal.php?action=<?=hideVar('view')?>&id=' + id, 700, $(window).height()-100, "Declaración fiscal");
    }
    
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
                    <option value ="1">Activo</option>
                    <option value ="2">Baja</option>
                    <option value ="4">Licencia</option>
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