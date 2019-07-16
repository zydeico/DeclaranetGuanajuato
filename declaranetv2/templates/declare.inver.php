<script>
    
    $(function(){
        var cont = 1;
        
    });
</script>

<div id ="inversiones" class ="appear">
    <div class ="title-category corner">Inversiones</div>
    <div class ="container">
        <div class ="head-list">Inversiones Actuales</div>
        <div id ="list-depend" class ="list corner">
            <?foreach($context->data as $d){?>
            <div class ="elem" title ="Modificar" action ="persist_inver_<?=$d['ID']?>">
                <b><?=$d['Tipo']?></b> - <?=$d['Info']?>
            </div>
            <?}?>
        </div>
        <div class ="data">
            <table id ="tbl-depend">
                <tr><td colspan ="2" class ="label">Agregar inversion</td></tr>
            </table>
            <table class ="adding corner tooltip" id ="addDepend" title ="Agregar a mi lista">
                <tr>
                    <td>Agregar</td>
                    <td><img src ="img/add3.png" class ="pointer" ></td>
                </tr>
            </table>
        </div>
    </div>
    <div class ="navigate">
        <input type ="button" class ="btn prev goto tooltip" action ="depend" value ="Anterior" title ="Sección anterior">
        <input type ="button" class ="btn reset tooltip" action ="inversiones" value ="Deshacer cambios" title ="Volver a mis datos originales">
        <input type ="button" class ="btn next goto tooltip" action ="adeudos" value ="Siguiente" title ="Siguiente sección">
    </div>
</div>