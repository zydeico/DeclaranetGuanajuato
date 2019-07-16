<script>
    $(function(){
        $('.btn').button();
        
        $('#btnProced').click(function(){
           fakeLoad($(this).parent());
           $.get('procedure.php?action=<?=hideVar('new')?>&type=1&ver=<?=$context->ver?>&id=<?=$context->data->ID_Serv?>', function(data){
                ready();
                if(data)
                    $.msgBox({title: "Error", content: "Ya existe un procedimiento iniciado", type: "error"});
                else
                    $.msgBox({title: "OK", content: "Se he iniciado el procedimiento correctamente", type: "info"});
           });
        });
    });
</script>
<form>
    <center>
        <div class ="title-result">Resultados de la verificación</div>
        <table class ="tbl-result">
            <tr>
                <td>Fecha de Inclusión</td>
                <td class ="result"><?=$context->data->Fecha_Inclusion?></td>
            </tr>
            <tr>
                <td>Fecha de Cierre</td>
                <td class ="result"><?=$context->data->Fecha_Cierre?></td>
            </tr>
            <tr>
                <td>Estatus</td>
                <td class ="result"><?=($context->data->General==1?"Correcto":"Observaciones")?></td>
            </tr>
            <tr>
                <td>Responsable</td>
                <td class ="result"><?=$context->data->Resp?></td>
            </tr>
        </table>
        <?if($context->data->General==2 && in_array(48, $_SESSION['PM'])){?>
        <br>
        <div><input type ="button" class ="btn" value ="Iniciar procedimiento" id ="btnProced"></div>
        <?}?>
    </center>
</form>