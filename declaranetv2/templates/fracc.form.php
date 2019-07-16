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
<form id ="frmFraccion" class="avoid">
    <input type ="hidden" name ="id" value ="<?=$obj->ID_Fraccion?>">
    <center>
        <table  class="separado">
            <tr>
                <td>Nombre de la Fracción</td>
                <td><input type ="text" class ="large require" name ="Fraccion" value ="<?=$obj->Fraccion?>"></td>
            </tr>
                <td>Descripción</td>            
                <td>
                	<textarea cols="40" rows="10"  class ="require" name ="Descripcion"><?=$obj->Descripcion?></textarea>
                	
                </td>
            </tr>         
        </table>
        <br>
        <input type ="button" class ="btn" value ="Guardar" id ="btnSaveFraccion">
    </center>
</form>