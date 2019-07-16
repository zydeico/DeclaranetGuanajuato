<?function Style($context){?>
<?}?>
<?function Script($context){?>
<script>
$(function() {
	$( "#accordion" ).accordion({
		collapsible:true,
		active:false
		});
	
});
</script>
<?}?>
<? function Body($context){
$obj = $context->data;?>
<div class ="container">
    <div class ="section-title"><?=$context->title?> >_</div>
    <div id="accordion">
	<? foreach($obj as $objj){
		?>

			<h3 align="left"><?=$objj['Descripcion']?></h3>
			<div>
				<p align="justify"><?=$objj['Respuesta']?></p>
			</div>
	<?}?>
  	</div>  
</div>
<?}?>