<script>
    $(function(){
       $('.btn').button(); 
    });
</script>
<form id ="correction">
    <input type ="hidden" value ="<?=$context->data->ID_Correccion?>" name ="id">
    <input type ="hidden" value ="<?=$context->data->ID_Serv?>" name ="serv">
    <input type ="hidden" value ="<?=$context->data->ID_Temp?>" name ="temp">
    <table class ="tbl-correct">
        <thead>
            <th width ="250">Campo</th>
            <th>Original</th>
            <th>Corrección</th>
        </thead>
        <tbody>
            <tr>
                <td>RFC</td>
                <td class ="origin"><?=$context->data->SP_RFC?></td>
                <td class ="correct"><?=$context->data->TEMP_RFC?></td>
            </tr>
            <tr>
                <td>Nombre</td>
                <td class ="origin"><?=$context->data->SP_Nombre?></td>
                <td class ="correct"><?=$context->data->TEMP_Nombre?></td>
            </tr>
            <tr>
                <td>Ap. Paterno</td>
                <td class ="origin"><?=$context->data->SP_Paterno?></td>
                <td class ="correct"><?=$context->data->TEMP_Paterno?></td>
            </tr>
            <tr>
                <td>Ap. Materno</td>
                <td class ="origin"><?=$context->data->SP_Materno?></td>
                <td class ="correct"><?=$context->data->TEMP_Materno?></td>
            </tr>
            <tr>
                <td>Dependencia</td>
                <td class ="origin"><?=$context->data->SP_Dep?></td>
                <td class ="correct"><?=$context->data->TEMP_Dep?></td>
            </tr>
            <tr>
                <td>Puesto</td>
                <td class ="origin"><?=$context->data->SP_Pos?></td>
                <td class ="correct"><?=$context->data->TEMP_Pos?></td>
            </tr>
            <tr>
                <td>Cargo funcional</td>
                <td class ="origin"><?=$context->data->SP_Funcional?></td>
                <td class ="correct"><?=$context->data->TEMP_Funcional?></td>
            </tr>
            <tr>
                <td>Contratación</td>
                <td class ="origin"><?=$context->data->SP_Contra?></td>
                <td class ="correct"><?=$context->data->TEMP_Contra?></td>
            </tr>
            <tr>
                <td>Art del AG172</td>
                <td class ="origin"><?=$context->data->SP_ART?></td>
                <td class ="correct"><?=$context->data->TEMP_ART?></td>
            </tr>
            <tr>
                <td>Nivel tabular</td>
                <td class ="origin"><?=$context->data->SP_Level?></td>
                <td class ="correct"><?=$context->data->TEMP_Level?></td>
            </tr>
            <tr>
                <td>Área</td>
                <td class ="origin"><?=$context->data->SP_Area?></td>
                <td class ="correct"><?=$context->data->TEMP_Area?></td>
            </tr>
            <tr>
                <td>Calle del lugar de trabajo</td>
                <td class ="origin"><?=$context->data->SP_Street?></td>
                <td class ="correct"><?=$context->data->TEMP_Street?></td>
            </tr>
            <tr>
                <td>Número del lugar de trabajo</td>
                <td class ="origin"><?=$context->data->SP_Num?></td>
                <td class ="correct"><?=$context->data->TEMP_Num?></td>
            </tr>
            <tr>
                <td>Colonia del lugar de trabajo</td>
                <td class ="origin"><?=$context->data->SP_Col?></td>
                <td class ="correct"><?=$context->data->TEMP_Col?></td>
            </tr>
            <tr>
                <td>C.P. del lugar de trabajo</td>
                <td class ="origin"><?=$context->data->SP_CP?></td>
                <td class ="correct"><?=$context->data->TEMP_CP?></td>
            </tr>
            <tr>
                <td>Ciudad y Estado del lugar de trabajo</td>
                <td class ="origin"><?=$context->data->SP_City?></td>
                <td class ="correct"><?=$context->data->TEMP_City?></td>
            </tr>
            <tr>
                <td>Teléfono del lugar de trabajo</td>
                <td class ="origin"><?=$context->data->SP_Tel?></td>
                <td class ="correct"><?=$context->data->TEMP_Tel?></td>
            </tr>
            <tr>
                <td>Percepción mensual $ </td>
                <td class ="origin"><?=$context->data->SP_Percep?></td>
                <td class ="correct"><?=$context->data->TEMP_Percep?></td>
            </tr>
            <tr>
                <td>Fecha de Posesión</td>
                <td class ="origin"><?=$context->data->SP_Inicio?></td>
                <td class ="correct"><?=$context->data->TEMP_Inicio?></td>
            </tr>
        </tbody>
    </table>
    <div class ="section">Resúmen de corrección</div>
    <div class ="resumen"><?=$context->data->Correccion?></div>
    <div class ="section">Observaciones</div>
    <textarea name ="obs" cols ="95" rows ="3" <?=($context->data->Estatus!=0?"readonly":"")?>><?=$context->data->Observaciones?></textarea>
    
    <?if($context->data->Estatus == 0 && in_array(38, $_SESSION['PM'])){?>
    <table class ="actions">
        <tr>
            <td><input type ="button" action ="1" class ="btn makeCorrect" value ="Validar" id ="btnValidate"></td>
            <td><input type ="button" action ="2" class ="btn makeCorrect" value ="Rechazar" id ="btnRefuse"></td>
        </tr>
    </table>
    <?}elseif($context->data->Estatus == 1){?>
    <div class ="result">Validado [<?=$context->data->Valida?>]</div>
    <?}elseif($context->data->Estatus == 2){?>
    <div class ="result">Rechazado [<?=$context->data->Valida?>]</div>
    <?}?>
</form>