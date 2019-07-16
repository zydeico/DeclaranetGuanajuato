<?function Style($context){?>
<style>
.imprimir{
	font-size:14px;
	color:#809A3C;
	vertical-align:middle !important;
	margin-top:10px;
	

	}
	.sinformato{
	font-size:14px;
	color:#809A3C !important;		
		text-decoration:none;
	}
    .print {width: 50%; margin: 10px auto; font-size: 12pt; color: #679A3C; }
    .print td {padding: 10px 5px;}
    .declare {height: 100px; }
    .down {cursor: pointer;}
    #publication {margin: 10px auto; width: 95%; background: #D2D4EA; padding: 10px; min-height: 30px;}
    #publication table {float: right; font-size: 10pt; margin: -5px;}
    #publication table td {padding: 5px;}
    #switch {width: 80px !important;}
</style>
<? } ?>
<?function Script($context){?>
<script>
$(function() {
	$( "#accordion" ).accordion({heightStyle: 'content'});

        $('.down').click(function(){
            var id = $(this).attr('id');
            var action = $(this).attr('action');
            Loading();
            $.get('history.php?action=<?=hideVar('generate')?>&type=' + action + '&id=' + id, function(data){
                $('.mask, .loading').remove();
                location.href = "file.php?id=" + data; 
            });
        });
        
        $('#switch').makeSwitch({
           language: 'es',
           status: '<?=$context->public?"on":"off"?>', 
           fnOn: function(){
               $.get('history.php?action=<?=hideVar('public')?>&st=' + $('#switch').getStatus());
           }, 
           fnOff: function(){
               $.get('history.php?action=<?=hideVar('public')?>&st=' + $('#switch').getStatus());
           }
        });
        
	
});
function generaDoc(i){
        Loading();
	$.post('history.php?action=<?=hideVar('generaAcuse')?>&i='+i, $('#frm-faq').serialize(), function(data){
	if(data)
            $('.mask, .loading').remove();
            location.href='file.php?id=' + data;
	});
}
</script>
<?}?>
<?function Body($context){
$obj = $context->data;

?>
<div class ="container">
    <div class ="section-title"><?=$context->title?> >_</div>
<!--    <div id ="publication">
        <table>
            <tr>
                <td><b>Publicar mi historial de declaraciones:</b></td>
                <td><div id ="switch" title = "Click para cambiar"></div></td>
            </tr>
        </table>
    </div>-->
    <div id="accordion">
	<? foreach($obj as $objj){?>
            <h3 align="left"><?=$objj['Tipo_Dec']?> - <?=DateFormat($objj['Fecha_Dec'],1)?></h3>
            <div class ="declare">
                <table class ="print">
                    <tr>
                        <td>Descargar acuse</td>
                        <td><img src ="img/pdf.png" width ="40" height ="40" id ="<?=hideVar($objj['ID_Dec'])?>" class ="down tooltip" action ="Acuse" title ="Descargar acuse"></td>
                        <td>Descargar declaración</td>
                        <td><img src ="img/pdf2.png" width ="40" height ="40" id ="<?=hideVar($objj['ID_Dec'])?>" class ="down tooltip" action ="Declaracion" title ="Descargar declaración"></td>
                    </tr>
                </table>
            </div>
	<?}?>
    </div>  
</div>

<? } ?>