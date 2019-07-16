<script>
    $(function(){
        var cont = 1;
    
        <?foreach($context->data as $d){?>
             Transaction("depend", "persist_depend_<?=$d['ID']?>", 0, [<?=$d['ID']?>]);
        <?}?>
        
        $('#addDepend').click(function(){
           if(Full($('#tbl-depend'))){
                var id = "depend_" + cont++;
                var div = "<div class = 'elem' action = '" + id + "' title = 'Modificar'>"
                        + "<b>" + $('#cmbRelation').val() + "</b> - "
                        + $('#txtNombreDepend').val()
                        + "</div>";
                $('#list-depend').append(div);

                var val = new Array();
                val.push($('#cmbRelation').val());
                val.push($('#txtNombreDepend').val());
                val.push($('#txtRFCDepend').val());
                val.push($('#txtDomicilioDepend').val());
                val.push($('#txtNacimientoDepend').val());
                val.push($('#cmbOcupacionDepend').val());
                val.push($('#txtAport').val());
                Transaction("depend", id, 0, val);

                $('#tbl-depend').find('input:text').val('');
                $('#txtAport').val('0');
                $('#tbl-depend').find('select').each(function(){
                   $(this).find('option:first').attr('selected', 'selected');
                });
           }
           
        });
    });
</script>
<div id ="dependientes" class ="appear">
    <div class ="title-category corner">Cónyuge y Dependientes</div>
    <div class ="container">
        <div class ="head-list">Dependientes Actuales</div>
        <div id ="list-depend" class ="list corner">
            <?foreach($context->data as $d){?>
            <div class ="elem" title ="Modificar" action ="persist_depend_<?=$d['ID']?>">
                <b><?=$d['Tipo']?></b> - <?=$d['Info']?>
            </div>
            <?}?>
        </div>
        <div class ="data">
            <table id ="tbl-depend">
                <tr><td colspan ="2" class ="label">Agregar dependiente</td></tr>
                <tr>
                    <td>Relación</td>
                    <td>
                        <select id ="cmbRelation" class ="large">
                            <option value ="CONYUGE">CONYUGE</option>
                            <option value ="HIJO">HIJO(A)</option>
                            <option value ="HERMANO">HERMANO(A)</option>
                            <option value ="PADRE">PADRE</option>
                            <option value ="MADRE">MADRE</option>
                            <option value ="OTRO">OTRO</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Nombre Completo</td>
                    <td><input type ="text" id ="txtNombreDepend" class ="large require"></td>
                </tr>
                <tr>
                    <td>RFC</td>
                    <td><input type ="text" id ="txtRFCDepend" class ="large require"></td>
                </tr>
                <tr>
                    <td>Domicilio</td>
                    <td><input type ="text" id ="txtDomicilioDepend" class ="large require"></td>
                </tr>
                 <tr>
                    <td>Lugar de nacimiento</td>
                    <td><input type ="text" id ="txtNacimientoDepend" class ="large require"></td>
                </tr>
                 <tr>
                    <td>Ocupación</td>
                    <td>
                        <select id ="cmbOcupacionDepend" class ="large">
                            <option value ="TRABAJA">TRABAJA</option>
                            <option value ="ESTUDIANTE">ESTUDIANTE</option>
                            <option value ="HOGAR">HOGAR</option>
                            <option value ="OTRO">OTRO</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Aportación Anual $</td>
                    <td><input type ="text" class ="large numeric require" id ="txtAport" value ="0"></td>
                </tr>
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
        <input type ="button" class ="btn reset tooltip" action ="dependientes" value ="Deshacer cambios" title ="Volver a mis datos originales">
        <input type ="button" class ="btn next goto tooltip" action ="inversiones" value ="Siguiente" title ="Siguiente sección">
    </div>
</div>