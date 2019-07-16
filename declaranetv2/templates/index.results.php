<script>
    $(function(){
        $('.btn').button();
        
        $('.tbl-showinfo tr').hover(function(){
            $(this).find('td').addClass('over');
        }, function(){
            $(this).find('td').removeClass('over');
        });
        
        $('.showinfo').click(function(){
            doSexy('verify.php?action=<?=hideVar('view')?>&id=' + $(this).attr('id'), 900, $(window).height() - 120, "Consulta general de servidor público");
        });
        
        $('.icon-declared').tooltip();
    });
</script>

<form>
    <center>
        <?if($context->results){?>
        <table class ="tbl-showinfo">
            <thead>
            <th>RFC</th>
            <th>Nombre</th>
            <th>Dependencia</th>
            <th>Estatus</th>
            <th colspan ="3">Historial</th>
            <th></th>
            </thead>
            <?foreach($context->results as $r){?>
            <tr>
                <td><?=$r['RFC']?></td>
                <td><?=$r['Nombre']?></td>
                <td><?=$r['Dependencia']?></td>
                <td><?=$r['Estatus']?></td>
                <td><img <?=($r['Inicial']?"src = 'img/icon-inicial-on.png'":"src = 'img/icon-inicial-off.png'")?> title = "<?=$r['Inicial']?>" class ="icon-declared"></td>
                <td><img <?=($r['Anual']?"src = 'img/icon-anual-on.png'":"src = 'img/icon-anual-off.png'")?> title = "<?=$r['Anual']?>" class ="icon-declared"></td>
                <td><img <?=($r['Final']?"src = 'img/icon-final-on.png'":"src = 'img/icon-final-off.png'")?> title = "<?=$r['Final']?>" class ="icon-declared"></td>
                <td><input type ="button" class ="btn showinfo" value ="Mostrar" id="<?=$r['ID_Serv']?>"></td>
            </tr>
            <?}?>
        </table>
        <?}else{?>
        <div class ="notfound-info">Ningún registro encontrado</div>
        <?}?>
    </center>
</form>