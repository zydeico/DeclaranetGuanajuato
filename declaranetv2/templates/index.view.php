<?if($context->data){?>
    <?foreach($context->data as $d){?>
    <div class ="details corner">
        <span class ="heading"><?=$d['Tipo']?></span> >
        <span class ="description"><?=$d['Descripcion']?></span>
    </div>
    <? } ?>
<?}else{?>
    <div class ="empty">
        <span class ="heading">Vacio</span> >
        <span class ="description">Ningún elemento declarado</span>
    </div>
<?}?>
