<center>
<?if($_SESSION['PWD']){?>
<div class ="legend-change">
    En vista de que su contraseña actual es nueva<?=($_SESSION['PRO']=="#SP"?"":" o ha sobrepasado los 60 días")?>, 
    por motivos de seguridad se le solicita que sea cambiada para poder continuar...
</div>
<div class ="instruc">
     Las contraseñas deben ser de tipo ALFANUMÉRICAS (Números y Letras), además de tener una LONGITUD MÍNIMA de 8 caracteres
</div>
<table class ="tbl-change">
    <tr>
        <td>Contraseña nueva</td>
        <td><input type ="password" class ="large require" name ="pwd"></td>
    </tr>
     <tr>
        <td>Confirmar contraseña</td>
        <td><input type ="password" class ="large require" name ="confirm" ></td>
    </tr>
</table>
<?}?>
<?if($_SESSION['MAIL']){?>
<div class ="instruc">
    Debe ingresar una dirección de correo electrónico ya sea institucional o personal,<br>
    ya que esta sera requerida para el envío de información inherente al sistema.<br>
    Más adelante podrá actualizar esta dirección en la sección de Información Personal.
</div>
<table class ="tbl-change">
    <tr>
        <td>Correo electrónico principal</td>
        <td><input type ="text" class ="large require" name ="mail"></td>
    </tr>
    <tr>
        <td>Correo electrónico alternativo</td>
        <td><input type ="text" class ="large" name ="alter"></td>
    </tr>
</table>
<?}?>
<div>
    <input type ="button" class ="btn" value ="Cambiar" id ="btnChange">
       <a href ="login.php?action=<?=hideVar('logout')?>">Cancelar</a>
</div>
</center>