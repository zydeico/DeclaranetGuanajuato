
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
<form id ="frm-faq" class="avoid">
    <input type ="hidden" name ="id" value ="<?=$obj->ID_Faq?>">
    <center>
        <table  class="separado">
            <tr>
                <td>Pregunta</td>
                <td><input type ="text" class ="large require" name ="pregunta" value ="<?=$obj->Descripcion?>"></td>
            </tr>
            <tr>
                <td>Respuesta</td>
                <td>
                	<textarea cols="37" rows="10"  class ="require" name ="respuesta"><?=$obj->Respuesta?></textarea>
                	
                </td>
            </tr>
        </table>
        <br>
        <input type ="button" class ="btn" value ="Guardar" id ="btnSaveFaq">
    </center>
</form>