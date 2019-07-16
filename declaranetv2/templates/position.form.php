<style>
.separado td{
	padding-top:4px;
}
</style>
<script>
    $(function(){
       $('.btn').button(); 
    });
</script>
    

<?$obj = $context->data;?> 
<form id ="frmPuesto" class="avoid">
    <input type ="hidden" name ="id" value ="<?=$obj->ID_Puesto?>">
    <center>
        <table  class="separado">
            <tr>
                <td>Nombre del puesto</td>
                <td><input type ="text" class ="large require" name ="puesto" value ="<?=$obj->Puesto?>"></td>
            </tr>
        </table>
        <br>
        <input type ="button" class ="btn" value ="Guardar" id ="btnSavePuesto">
    </center>
</form>