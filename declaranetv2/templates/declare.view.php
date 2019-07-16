<div class ="title-stuff">
    <table class ="title-info">
        <tr>
            <td><?=$context->title?></td>
            <td><img src ="img/question2.png" width ="20" height ="20" class ="pointer tooltip" title ="<?=$context->info?>"></td>
        </tr>
    </table>
    <input type ="button" class ="btn adding" action ="<?=$context->action?>" height ="<?=$context->height?>" min ="<?=$context->min?>" value ="Agregar <?=$context->action?>">
</div>
<?if($context->data){?>
    <?foreach($context->data as $d){?>
    <div id ="<?=hideVar($d['ID'])?>" class ="elem corner <?=($d['Estatus']==3?"imported":"")?>" action ="<?=$context->action?>">
        <div class ="elem-info">
            <span class ="description tooltip" title ="Click para ver detalles"><b><?=$d['Tipo']?> > </b>
            <?
                $exp = explode("|", $d['Descripcion']);
                $str = "";
                foreach($exp as $e)
                    $str .= showVar($e) . ", ";
                echo substr($str, 0, -2);
            ?>
            </span>
            <br>
            <span class ="declare-info"><?=($d['Declared']?"Declarado: " . $d['Declared']:"Sin declarar")?></span>
            <?if($d['Estatus'] == 2){?>
            <span class ="sell">(Vendido)</span>
            <?}elseif($d['Estatus'] == 3){?>
            <br><span class ="import-item">Registro importado por sistema. Favor de verificar</span>
            <?}?>
        </div>
        <table class ="options">
            <tr>
                <td>Opciones:</td>
            <?foreach($context->opt[$d['Estatus']] as $o){?>
                <td><img class ="opt tooltip" width ="28" height ="28" title ="<?=$o['title']?>" src ="<?=$o['img']?>" action ="<?=$o['action']?>" dim ="<?=$o['dim']?>"></td>
            <?}?>
            </tr>
        </table>
    </div>
    <? } ?>
<?}else{?>
    <div class ="empty corner">
        <span class ="tooltip" title ="Pulse el botón AGREGAR para añadir elementos"><b>Vacio > </b>Ningún elemento declarado</span>
    </div>
<?}?>
