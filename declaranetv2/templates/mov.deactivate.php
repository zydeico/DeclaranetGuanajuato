<script>
    $(function(){
       $('.btn').button(); 
        
    });
</script>

<form id ="deactivate">
    <input type ="hidden" value ="<?=$context->id?>" name ="id">
    <center>
        <div class ="warning">Seguro de desactivar este registro?</div>
        <div class ="section">Observaciones:</div>
        <div>
            <textarea name ="obs" cols ="50" rows ="4"></textarea>
        </div>
        <br>
        <table class ="actions">
            <tr>
                <td><input type ="button" class ="btn" value ="Continuar" id ="btnDeactivate"></td>
                <td><input type ="button" class ="btn" value ="Cancelar" id ="btnCancel"></td>
            </tr>
        </table>
    </center>
</form>