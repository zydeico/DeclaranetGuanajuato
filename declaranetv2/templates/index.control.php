<script>
    $(function(){
        DatePicker($('.date'));
        $('.btn').button();
        
        $('#btnControlAllow').click(function(){
            if($('#txtControlDate').val() != ""){
                fakeLoad($(this).parent());
                $(this).hide();
                $.post('index.php?action=<?=hideVar('modify')?>&id=<?=$context->data->ID_Dec?>', $('#control').serialize(), function(data){
                   ready();
                   $('#btnControlAllow').show();
                   if(data)
                       $.msgBox({title: "Error", content: data, type: "error"});
                   else{
                       Reload(gridcontrol, 'data/loadControl.php');
                       closeSexy();
                   }
                });
            }else
                $.msgBox({title: "Revise", content: "Ingrese la fecha límite para la modificación"});
        });
        
        
    });
</script>
<form id ="control">
    <center>
        <?if($context->data){?>
        <table class ="list-dec">
            <thead>
            <th>RFC</th>
            <th>Nombre</th>
            <th>Dependencia</th>
            <th>Estatus</th>
            <th>Declaración</th>
            <th>Fecha Límite</th>
            <th>Permitir</th>
            </thead>
            <tr>
                <td><?=$context->data->RFC?></td>
                <td><?=$context->data->Nombre?></td>
                <td><?=$context->data->Dependencia?></td>
                <td><?=$context->data->St?></td>
                <td><b><?=$context->data->Tipo_Dec?></b></td>
                <td><input type ="text" class ="date"  name ="date" id ="txtControlDate" readonly></td>
                <td><input type ="button" class ="btn" value ="Permitir" id ="btnControlAllow"></td>
            </tr>
        <?}else{?>
        <span class ="control-notfound">No existen declaraciones para este usuario</span>
        <?}?>
    </center>
</form>