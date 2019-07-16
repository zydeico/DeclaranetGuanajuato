<script>
    $(function(){
        $('.btn').button();
        $('#txtRecover').val($('#txtUser').val());
    });

    
</script>

<form id ="send">
    <center>
        <div class ="legend">
            Ingrese sus datos de usuario para enviar una contraseña de 
            acceso temporal que estara activa solo por este día
            <p style = 'color: black; font-size: 9pt;'><b>En caso de tener dudas, consulte nuestro <a target = "_blank" href = "media/Pasos.pdf">Manual de Recuperación.</a></b></p>
        </div>
        <br>
        <table id ="tbl-send">
            <tr>
                <td><input type ="text" id ="txtRecover" class ="large require" name ="data" placeholder ="RFC (sin homoclave)"></td>
            </tr>
        </table>
        <br>
        <div><input type ="button" class ="btn" value ="Enviar" id ="btnSend"></div>
    </center>
</form>