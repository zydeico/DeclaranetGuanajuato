<center>
    <div class ="title-alert"><?=$context->window?></div>
    <table class ="tbl-alert">
        <thead>
        <tH>#</tH>
        <?foreach($context->head as $h){?>
        <th><?=$h?></th> 
        <?}?>
        </thead>
        <?$cont = 1;?>
        <?foreach($context->data as $d){?>
        <tr class ="<?=($cont%2==0?"lightblue":"")?>">
            <td><?=$cont++?></td>
            <?foreach($context->fields as $f){?>
            <td><?=$d[$f]?></td>
            <?}?>
        </tr>
        <?}?>
    </table>
</center>
