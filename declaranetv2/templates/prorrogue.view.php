<script>
    $(function(){
        $('.btn').button();
        DatePicker($('.date'));
        
        <?if($context->data->Estatus > 0){?>
           $('input, textarea').attr('disabled', 'disabled');
        <?}?>
    });
</script>

<form id ="prorrogue">
    <center>
        <div class ="info">Detalles de prórroga</div>
        <input type ="hidden" name ="id" value ="<?=$context->data->ID_Prorroga?>">
        <table>
            <tr>
                <td class ="field">Nombre</td>
                <td class ="label"><?=$context->data->Nombre?></td>
            </tr>
            <tr>
                <td class ="field">Dependencia</td>
                <td class ="label"><?=$context->data->Dependencia?></td>
            </tr>
            <tr>
                <td class ="field">Fecha de solicitud</td>
                <td class ="label"><?=$context->data->Fecha_Solicitud?></td>
            </tr>
            <tr>
                <td class ="field">Fecha propuesta</td>
                <td class ="label"><?=$context->data->Fecha_Pro?></td>
            </tr>
            <tr>
                <td class ="field">Motivo</td>
                <td class ="label"><?=$context->data->Motivo?></td>
            </tr>
            <tr>
                <td class ="field">Documento</td>
                <td class ="label"><a href = "file.php?id=<?=hideVar($context->data->Ruta_Doc)?>">Descargar</a></td>
            </tr>
        </table>
        <br>
        <div class ="info">Resolución</div>
        <table>
            <tr>
                <td class ="field">Respuesta</td>
                <td class ="field"><textarea id ="txtResp" rows ="5" cols ="50" class ="require" name ="text"><?=$context->data->Respuesta?></textarea></td>
            </tr>
            <tr>
                <td class ="field">Fecha autorizada</td>
                <td class ="field"><input type ="text" class ="require date" name ="date" value ="<?=$context->data->Fecha_Aut?>" readonly></td>
            </tr>
        </table>
        <br>
        <?if($context->data->Estatus == 0){?>
        <div>
            <input type ="button" class ="btn" value ="Aceptar" id ="btnAccept">
            <input type ="button" class ="btn" value ="Rechazar" id ="btnReject">
        </div>
        <?}elseif($context->data->Estatus == 1){?>
        <div class ="result">Aprobada</div>
        <?}elseif($context->data->Estatus == 2){?>
        <div class ="result">Rechazada</div>
        <?}?>
    </center>
</form> 