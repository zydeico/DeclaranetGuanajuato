<script>
    $(function(){
       $('.btn').button(); 
    });
</script>
<form id ="key">
    <center>
        <input type ="hidden" value ="<?=$context->id?>" name ="id">
        <table class ="datakey">
            <tr>
                <td>Nueva contraseña</td>
                <td><input type ="password" class ="large require" name ="pwd"></td>
            </tr>
            <tr>
                <td>Confirme contraseña</td>
                <td><input type ="password" class ="large require" name ="confirm"></td>
            </tr>
        </table>
        <input type ="button" class ="btn" value ="Cambiar" id ="btnKey">
    </center>
</form>