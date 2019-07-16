<script>
    $(function(){
       $('.btn').button(); 
    });
</script>
<form>
    <input type ="hidden" id ="txtID" value ="<?=$context->id?>">
    <center>
        Perfiles de usuario:
        <div id ="list-profile">
            <table>
                <?foreach($context->data as $d){?>
                <tr>
                    <td><img src ="img/delete.png" class ="del-pro" id ="<?=$d['ID_Pro']?>" title ="Quitar"></td>
                    <td><?=$d['Perfil']?></td>
                </tr>
                <?}?>
            </table>
        </div>
        <?if($context->profiles){?>
        <br>
        <table>
            <tr>
                <td>
                    <select id ="cmbProfile">
                        <?foreach($context->profiles as $p){?>
                        <option value ="<?=$p['ID_Perfil']?>"><?=$p['Perfil']?></option>
                        <?}?>
                    </select>
                </td>
                <td><input type ="button" value ="Agregar" class ="btn" id ="btnAdd"></td>
            </tr>
        </table>
        <?}?>
    </center>
</form>