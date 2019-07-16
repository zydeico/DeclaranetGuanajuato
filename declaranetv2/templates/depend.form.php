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
<form id ="frmDependencia"  class="avoid">
    <input type ="hidden" name ="id" value ="<?=$obj->ID_Dependencia?>">
    <center>
        <table  class="separado">
            <tr>
                <td>Nombre de la dependencia</td>
                <td><input type ="text" class ="large require" name ="dependencia" value ="<?=$obj->Dependencia?>"></td>
            </tr>
        </table>
        <br>
        <input type ="button" class ="btn" value ="Guardar" id ="btnSaveDependencia">
    </center>
</form>