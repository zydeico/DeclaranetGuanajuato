<div class ="accordion">
<?foreach($context->data as $d){?>
<h3 align ="left"><?=$d['NAME']?></h3>
<div>
    <?if($d['JSON']){?>
    <input type ="hidden" class ="json" value ='<?=$d['JSON']?>'>
    <div id ="graph-<?=$d['ID']?>" class ="graphic"></div>
    <?}else{?>
    <div class ="comments">
        <table class ="comment-list">
            <?$cont = 1?>
            <?foreach(explode("|", $d['DATA']) as $c){?>
                <?if($c){?>
                <tr>
                    <td width = "30"><?=$cont++?>)</td>
                    <td><?=$c?></td>
                </tr>
                <?}?>
            <?}?>
        </table>
    </div>
    <?}?>
</div>
<? } ?>
</div>
