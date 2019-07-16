<script>
    $(function(){
        DatePicker($('.date'), "<?=Date('Y-m-d')?>");
        
        $('.btn').button();
        
        $('#cmbDown').change(function(){
           if($(this).val() == "DEFUNCION")
               $('.attach').slideDown('slow');
           else
               $('.attach').slideUp('slow');
        });
    });
</script>
<form id ="down">
    <center>
    <input type ="hidden" value ="<?=$context->id?>" id ="txtDownID" name ="id">
    <table class ="tbl-down">
        <tr>
            <td class ="section">Fecha de baja</td>
        </tr>
        <tr>
            <td><input type ="text" class ="date require" name ="date" id ="txtDownDate" readonly></td>
        </tr>
        <tr>
            <td class ="section">Tipo de baja</td>
        </tr>
        <tr>
            <td>
                <select id ="cmbDown" name ="type">
                    <option value ="NORMAL" selected>Normal</option>
                    <option value ="DEFUNCION">Por defunción</option>
                </select>
            </td>
        </tr>
        <tr class ="attach">
            <td>Acta de defunción</td>
        </tr>
        <tr class ="attach">
            <td><input type ="file" id ="file" name="act" class ="require" ></td>
        </tr>
    </table>
    <table class ="actions">
        <tr>
            <td><input type ="button" class ="btn" value ="Registrar" id ="btnDown"></td>
        </tr>
    </table>
    </center>
</form>