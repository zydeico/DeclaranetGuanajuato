<?function Style($context){?>

<style type ="text/css">
   #main-title {color: #ED3B96; margin: 10px auto;}
   #uploader {width: 90%; margin: 20px auto; padding: 10px; background: #DDDEEF; font-size: 12pt;}
   #history {width: 70%; margin: 20px auto; font-size: 12pt;}
   #iframe {width: 400px; height: 500px; float: right; margin: 10px; }
   #list {width: 400px; float: left; height: 500px; overflow: auto; }
   .item { width: 90%; padding: 15px; text-align: left; font-size: 14pt; border-radius: 15px; background: #F0F0F0; margin: 10px 5px; cursor: pointer;}
   .active {background-color: #2395CA !important;}
   #notdec {widows: 90%; padding: 15px; text-align: center; margin: 20px auto; background: #FC4B66; color: white; font-size: 14pt;}
</style>

<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    
    $(function(){
        
        $('.item').hover(function(){
            $(this).animate({'background-color': 'black', 'color': 'white'}, 500);
        }, function(){
            $(this).animate({'background-color': '#F0F0F0', 'color': 'black'}, 500);
        });
        
        $('#btnUpload').click(function(){
           var doc = $('#txtUpload').val();
           if(doc != ""){
               var exp = doc.split(".");
               var ext = exp[exp.length - 1];
               if(ext == "pdf"){
                    Loading();
                    $('#uploader').submit();
               }else
                   $.msgBox({title: 'Revise', content: 'Solo se permiten archivos PDF'});
           }else
               $.msgBox({title: 'Revise', content: 'No ha seleccionado ningún documento'});
        });
        
        $('.item').click(function(){
            $('.item').removeClass('active');
            $(this).addClass('active');
            LoadDocument($(this));
        });
    });// END
    
    function LoadDocument(div){
        var url = $(div).attr('action');
        $('#iframe').attr('src', url + '#view=FitH');
    }
    
</script>
<? } ?>

<?function Body($context){?>
<h1 id ="main-title">Declaración fiscal de servidores públicos</h1>
<div class ="navi-extra">
    <a href ="home.php" id ="go-center">Volver al Centro de Declaraciones</a>
    <a href ="login.php?action=<?=hideVar('logout')?>" id ="go-out"> Salir</a>
</div>
<?if(!$context->fiscal){?>
<form id ="uploader" action ="fiscal.php?action=<?=hideVar('upload')?>" method ="post" enctype="multipart/form-data" >
    <p><h3>Agregar nueva declaración</h3></p>
    <input id ="txtUpload" type ="file" name ="document">
    <p><input type ="button" class ="btn" id ="btnUpload" value ="Subir archivo"></p>
</form>
<?}?>
<div id ="history">
    <h3>Lista de declaraciones anteriores</h3>
    <?if($context->dec){?>
    
    <div id ="list">
        <?foreach($context->dec as $d){?>
        <div class ="item <?=(!$active?"active":"")?>" action ="<?=$d['Documento']?>">Declaración <?=(substr($d['Fecha_DecFis'], 0, 4))?></div>
        <?$active = true;?>
        <?}?>
    </div>
    <iframe id ="iframe" src ="<?=$context->dec[0]['Documento']?>#view=FitH"></iframe>
    
    <?}else{?>
    
    <div id ="notdec">Por el momento no cuenta con declaraciones</div>
    
    <?}?>
</div>

<? } ?>