<style type ="text/css">
    .navi {cursor: pointer; }
    .close {margin: 10px auto; text-align: center;}
    .element th {text-align: center; padding: 5px 10px; font-size: 9pt;}
    .element td {padding: 5px; }
    .title-verify {width: 90%; margin: 10px auto; }
    .title-verify td {padding: <?=$context->prev||$context->next?"0px":"10px"?>; }
    .title-dec {background-color: #4E76B8; font-weight: bold; color: white; text-align: center; padding: 5px;}
    .elem-type {text-align: center; font-weight: bold; background-color: #C0C0C0;  font-size: 9pt; color: #4E76B8;}
    .observ {color: #B42142; font-weight: bold;}
    .aclaracion {color: #679A3C; font-weight: bold;}
    .action {text-align: center; }
    .data {margin: 0px auto 10px auto; color: #0073EA; font-size: 8pt;}
    .down-dec {cursor: pointer; padding: 0px 10px; }
    .dec-info {width: 40%; margin: 0px auto; }
    #legend {width: 80%; padding: 5px; font-size: 10pt; color: #2D5FAB; background-color: #FFCF11; box-shadow: 5px 5px 5px #888888; text-align: center; margin: 5px auto 20px auto;}
</style>
<script>
    $(function(){
        $('.btn').button();
        $('.corner').corner();
        $('.accordion').accordion({heightStyle: "content"});
        $('.check').buttonset();
        setTimeout(function(){
            $('#legend').slideUp();
        }, 10000);
        
        $('.navi').click(function(){
           doSexy('verify.php?action=<?=hideVar('show')?>&id=' + $(this).attr('id') + '&ver=<?=$context->ver?>', 1000, $(window).height() - 100, "Verificación"); 
        });
        
        $('.valid').click(function(){
            var seg = $(this).parents('tr').find('.seg').val();
            var trans = $(this).parents('tr').find('.trans').val();
            var id = $(this).parents('tr').find('.id').val();
            var st = $(this).parents('tr').find('.option').val();
            var verif = $(this).parents('tr').find('.verif').val();
            var obs = $(this).parents('tr').find('.obs').val();
            var resp = <?=$context->resp?$context->resp:0?>;
            var self = $(this);
            var ok = true;
            if(st == "2" && !verif){
                ok = false;
                $.msgBox({title: "Revise", content: "Debe llenar el campo de verificación para declinar"});
            }
            if(ok){
                fakeLoad($(this).parent());
                $.post('verify.php?action=<?=hideVar('save')?>', {seg: seg, trans: trans, id: id, st: st, verif: verif, obs: obs, resp: resp}, function(data){
                    ready();
                    if(data)
                        $.msgBox({title: "Error", content: data, type: "error"});
                    else{
                        $(self).val("Listo!");
                        setTimeout(function(){
                            $(self).val('Guardar');
                        }, 3000);
                    }
                });
            }
        });
        
        $('#btnClose').click(function(){
            var ok = true;
            $('.option').each(function(){
               if($(this).val() == "0")
                   ok = false;
            });
            if(ok){
                Loading();
                $.get('verify.php?action=<?=hideVar('close')?>&id=<?=$context->ver?>', function(data){
                    if(data){
                        $('.mask, .loading').remove();
                        $.msgBox({title: "Error", content: data, type: "error"});
                    }else{
                        closeSexy();
                        Reload(list, 'data/loadVerify.php?year=' + $('#cmbYear').val());
                    }
                });
            }else
                $.msgBox({title: "Revise", content: "No se ha completado la validación de todos los registros"});
        });
        
        $('.down-dec').click(function(){
            fakeLoad($(this).parent());
            $.get('history.php?action=<?=hideVar('generate')?>&type=Declaracion&id=' + $(this).attr('id'), function(data){
               ready();
               location.href = "file.php?id=" + data;
            });
        });
    });
</script>
<div id ="legend" class ="corner">Esta información es confidencial y tu acceso ha sido registrado por políticas de seguridad.</div>
<div id ="verify">
    
    <table class ="title-verify">
        <tr>
            <td width ="40">
            <?if($context->prev){?>
            <img id ="<?=$context->prev?>" src ="img/prev.png" class ="navi prev" width ="40" height ="40" title ="Anterior">
            <?}?>
            </td>
            <td class ="title-dec corner">
                <table class ="dec-info">
                    <tr>
                        <td><?=$context->dec . " (" . $context->date . ")"?></td>
                        <td><img id ="<?=hideVar($context->id)?>" class ="down-dec" src ="img/download.png" width ="50" height ="30" title ="Descargar"></td>
                    </tr>
                </table>
            </td>
            <td width ="40">
            <?if($context->next){?>
            <img id ="<?=$context->next?>" src ="img/next.png" class ="navi next" width ="40" height ="40" title ="Siguiente">
            <?}?>
            </td>
        </tr>
    </table>
    
    <div class ="close">
        <?if($context->resp == $_SESSION['UI'] && !$context->close){?>
            <input type ="button" class ="btn" value ="Cerrar verificación" id ="btnClose">
        <?}elseif($context->close){?>
            CERRADO (<?=$context->close?>)
        <?}?>
    </div>
    <div class ="accordion">
        <?foreach($context->data as $k => $v){?>
        
            <h3><?=$k?></h3>
            <div>
                <table class ="element">
                    <thead>
                    <th width ="250">Declarado</th>
                    <th width ="200">Operación</th>
                    <th>Verificación</th>
                    <th>Observaciones</th>
                    <th width ="150">Validación</th>
                    </thead>
                    <?if($v['ME']){?>
                        <tr>
                            <td class ="elem-type" colspan ="5">DECLARANTE</td>
                        </tr>
                        <?foreach($v['ME'] as $e){?>
                        <tr>
                            <td>
                                <?=InterpretElem($e);?>
                            </td>
                            <td>
                                <?=InterpretTrans($e, $context->dec);?>
                            </td>
                            <td>
                                <textarea class ="verif" cols ="25" rows ="6" <?=($context->resp!=$_SESSION['UI'] || $context->close?"disabled":"")?>><?=$e['Verificacion']?></textarea>
                            </td>
                            <td>
                                <textarea class ="obs" cols ="25" rows ="6" <?=($context->resp!=$_SESSION['UI'] || $context->close?"disabled":"")?>><?=$e['ObsSeg']?></textarea>
                            </td>
                            <td class ="action">
                                <input type ="hidden" class ="seg" value ="<?=$e['ID_Seg']?>">
                                <input type ="hidden" class ="trans" value ="<?=$e['ID_Trans']?>">
                                <input type ="hidden" class ="id" value ="<?=$context->ver?>">
                                <div class ="data"><?=$e['Resp']?> (<?=$e['Fecha_Seg']?$e['Fecha_Seg']:"Sin validación"?>)</div>
                                <select name ="valid" class ="option" <?=($context->resp!=$_SESSION['UI'] || $context->close?"disabled":"")?>>
                                    <option value ="0" >Pendiente</option>
                                    <option value ="1" <?=($e['StSeg']=="1"?"selected":"")?>>Validado</option>
                                    <option value ="2" <?=($e['StSeg']=="2"?"selected":"")?>>Declinado</option>
                                </select> 
                                <p>
                                <?if($context->resp==$_SESSION['UI'] && !$context->close){?>
                                <input type ="button" class ="btn valid" value ="Guardar">
                                </p>
                                <?}?>
                            </td>
                        </tr>
                        <?}?>
                    <?}?>
                    <?if(is_array($v['CONYUGE'])){?>
                        <tr>
                            <td class ="elem-type" colspan ="5">CÓNYUGE</td>
                        </tr>
                        <?foreach($v['CONYUGE'] as $e){?>
                        <tr>
                            <td>
                               <?=InterpretElem($e)?>
                            </td>
                            <td>
                                <?=InterpretTrans($e, $context->dec)?>
                            </td>
                            <td>
                                <textarea class ="verif" cols ="25" rows ="6" <?=($context->resp!=$_SESSION['UI'] || $context->close?"disabled":"")?>><?=$e['Verificacion']?></textarea>
                            </td>
                            <td>
                                <textarea class ="obs" cols ="25" rows ="6" <?=($context->resp!=$_SESSION['UI'] || $context->close?"disabled":"")?>><?=$e['ObsSeg']?></textarea>
                            </td>
                            <td class ="action">
                                <input type ="hidden" class ="seg" value ="<?=$e['ID_Seg']?>">
                                <input type ="hidden" class ="trans" value ="<?=$e['ID_Trans']?>">
                                <input type ="hidden" class ="id" value ="<?=$context->ver?>">
                                <div class ="data"><?=$e['Resp']?> (<?=$e['Fecha_Seg']?$e['Fecha_Seg']:"Sin validación"?>)</div>
                                <select name ="valid" class ="option" <?=($context->resp!=$_SESSION['UI'] || $context->close?"disabled":"")?>>
                                    <option value ="0" >Pendiente</option>
                                    <option value ="1" <?=($e['StSeg']=="1"?"selected":"")?>>Validado</option>
                                    <option value ="2" <?=($e['StSeg']=="2"?"selected":"")?>>Declinado</option>
                                </select> 
                                <p>
                                <?if($context->resp==$_SESSION['UI'] && !$context->close){?>
                                <input type ="button" class ="btn valid" value ="Guardar">
                                </p>
                                <?}?>
                            </td>
                        </tr>
                        <?}?>
                    <?}elseif(isset($v['CONYUGE'])){?>
                        <tr>
                            <td class ="elem-type" colspan ="5">CÓNYUGE</td>
                        </tr>
                        <tr>
                            <td>Ingresos: </td>
                            <td>$ <?=number_format($v['CONYUGE'], 2)?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?}?>
                    <?if(is_array($v['DEPEND'])){?>
                        <tr>
                            <td class ="elem-type" colspan ="5">DEPENDIENTES</td>
                        </tr>
                        <?foreach($v['DEPEND'] as $e){?>
                        <tr>
                            <td>
                                <?=InterpretElem($e)?>
                            </td>
                            <td>
                                <?=InterpretTrans($e, $context->dec)?>
                            </td>
                            <td>
                                <textarea class ="verif" cols ="25" rows ="6" <?=($context->resp!=$_SESSION['UI'] || $context->close?"disabled":"")?>><?=$e['Verificacion']?></textarea>
                            </td>
                            <td>
                                <textarea class ="obs" cols ="25" rows ="6" <?=($context->resp!=$_SESSION['UI'] || $context->close?"disabled":"")?>><?=$e['ObsSeg']?></textarea>
                            </td>
                            <td class ="action">
                                <input type ="hidden" class ="seg" value ="<?=$e['ID_Seg']?>">
                                <input type ="hidden" class ="trans" value ="<?=$e['ID_Trans']?>">
                                <input type ="hidden" class ="id" value ="<?=$context->ver?>">
                                <div class ="data"><?=$e['Resp']?> (<?=$e['Fecha_Seg']?$e['Fecha_Seg']:"Sin validación"?>)</div>
                                <select name ="valid" class ="option" <?=($context->resp!=$_SESSION['UI'] || $context->close?"disabled":"")?>>
                                    <option value ="0" >Pendiente</option>
                                    <option value ="1" <?=($e['StSeg']=="1"?"selected":"")?>>Validado</option>
                                    <option value ="2" <?=($e['StSeg']=="2"?"selected":"")?>>Declinado</option>
                                </select> 
                                <p>
                                <?if($context->resp==$_SESSION['UI'] && !$context->close){?>
                                <input type ="button" class ="btn valid" value ="Guardar">
                                </p>
                                <?}?>
                            </td>
                        </tr>
                        <?}?>
                    <?}elseif(isset($v['DEPEND'])){?>
                        <tr>
                            <td class ="elem-type" colspan ="5">DEPENDIENTES</td>
                        </tr>
                        <tr>
                            <td>Ingresos: </td>
                            <td>$ <?=number_format($v['DEPEND'], 2)?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?}?>
                </table>
            </div>
        
        <?}?>
    </div>
</div>