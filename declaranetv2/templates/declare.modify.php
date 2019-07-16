<script>
    $(function(){
        $('.btn').button();
        
    });
</script>

<form id ="modify">
    <center>
        <input type ="hidden" value ="<?=$context->id?>" id ="txtID">
        <div class ="title-mod">Elija una opción para el estado actual de su <?=$context->elem?></div>
        <table class ="opt-mod">
            <thead>
                <?if(in_array("Actualizar", $context->opt)){?>
                <th>Actualizar</th>
                <?}?>
                <?if(in_array("Vender", $context->opt)){?>
                <th>Vendido</th>
                <?}?>
                <?if(in_array("Donar", $context->opt)){?>
                <th>Donado</th>
                <?}?>
                <?if(in_array("Perder", $context->opt)){?>
                <th>Perdido</th>
                <?}?>
                <?if(in_array("Separar", $context->opt)){?>
                <th>Ya no depende de mi</th>
                <?}?>
                <?if(in_array("Liquidar", $context->opt)){?>
                <th>Finiquitar</th>
                <?}?>
            </thead>
            <tr>
                <?if(in_array("Actualizar", $context->opt)){?>
                <td action ="0"><img src ="img/update.png"></td>
                <?}?>
                <?if(in_array("Vender", $context->opt)){?>
                <td action ="2"><img src ="img/win.png"></td>
                <?}?>
                 <?if(in_array("Donar", $context->opt)){?>
                <td action ="4"><img src ="img/gift.png"></td>
                <?}?>
                 <?if(in_array("Perder", $context->opt)){?>
                <td action ="5"><img src ="img/minus.png"></td>
                <?}?>
                <?if(in_array("Separar", $context->opt)){?>
                <td action ="5"><img src ="img/separate.png"></td>
                <?}?>
                <?if(in_array("Liquidar", $context->opt)){?>
                <td action ="6"><img src ="img/cancel.png"></td>
                <?}?>
            </tr>
        </table>
        <table class ="data-mod">
            
        </table>
        <br>
        <table>
            <tr>
                <td><input type ="button" class ="btn" value ="Aceptar" action="<?=$context->type?>" id ="btnOK"></td>
            </tr>
        </table>
    </center>
</form>