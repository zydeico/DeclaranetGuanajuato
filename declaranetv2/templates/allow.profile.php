<script>
    $(function(){
       $('.btn').button(); 
    });
</script>
<form id = "frm-profile" class ="avoid">
    <center>
        <input type = "hidden" value = "<?=$context->id?>" name = "id">
        <div>Perfil</div>
        <br>
        <div><input type = "text" class ="large" name = "profile" value = "<?=$context->name?>"></div>
        <br>
        <input type = "button" class = "btn" value = "Guardar" id = "btnSaveProfile">
    </center>
</form>