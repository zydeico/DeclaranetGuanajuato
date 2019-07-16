<?function Style($context){?>
<style type ="text/css">
   #main-title {color: #ED3B96; margin: 10px auto;}
   #uploader {width: 90%; margin: 20px auto; padding: 10px; background: #fff; font-size: 12pt;}
   #history {width: 40%; margin: 20px auto; font-size: 12pt;}
   #iframe {width: 400px; height: 500px; float: right; margin: 10px; }
   #list {width: 400px; float: left; height: 500px; overflow: auto; }
   .item { width: 90%; padding: 15px; text-align: left; font-size: 14pt; border-radius: 15px; background: #F0F0F0; margin: 10px 5px; cursor: pointer;}
   .active {background-color: #2395CA !important;}
   #notdec {widows: 90%; padding: 15px; text-align: center; margin: 20px auto; background: #FC4B66; color: white; font-size: 14pt;}
   .widget-main {
    padding: 2px;
}
.alert {
    border-radius: 0;
    font-size: 14px;
}
.alert-info {
    background-color: #d9edf7;
    border-color: #bce8f1;
    color: #3a87ad;
}
.widget-body {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: #fff;
    border-color: #ccc #ccc #ccd;
    border-image: none;
    border-style: solid solid solid;
    border-width: 1px 1px 1px;
    width: 76%;
}

#callout{width: 80%;}

.bs-callout-danger {
    border-left-color: #ce4844 !important;
}
.bs-callout {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: #eee;
    border-image: none;
    border-radius: 3px;
    border-style: solid;
    border-width: 1px 1px 1px 5px;
    margin: 20px 0;
    padding: 20px;
}
.bs-callout-danger h4 {
    color: #ce4844;
}
.bs-callout-info {
    border-left-color: #1b809e;
}
.bs-callout-info h4 {
    color: #1b809e;
}
.navi-extra_pub {width: 75%; margin: 20px; text-align: center; color: #2397CC; font-size: 12pt; padding: 5px 10px;}
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
<h1 id ="main-title">Acuerdo Declaración Patrimonial Pública</h1>
<div class ="navi-extra_pub">
    <a href ="home.php" id ="go-center">Volver al Centro de Declaraciones</a>
    <a href ="login.php?action=<?=hideVar('logout')?>" id ="go-out"> Salir</a>
</div>

<?if(!$context->dec || $context->dec[0]['Estatus']==2){?>
<div class="widget-body">Su acuerdo fue rechazado por el siguiente motivo:
<div class="widget-main"><p class="alert alert-info"><?=$context->dec[0]['Motivo']?></p></div>
</div>
<form id ="uploader" action ="declaracionpub.php?action=<?=hideVar('upload')?>" method ="post" enctype="multipart/form-data" >
    <input type ="hidden" name ="id" value ="<?=hideVar($context->dec[0]['ID_AcuerdoPub'])?>">
    <div id="callout" class="bs-callout bs-callout-danger">
    <h4>Paso 1: Descargar acuerdo.</h4>
    <p>Descargue el acuerdo de Declaración Patrimonial Púbica.</p>

    <a href = 'printacuerdo.php?id=<?=hideVar($_SESSION['UI'])?>' target = '_blank'><img src ="img/pdf.png" width ="40" height ="40" id ="" class ="down tooltip" action ="Acuerdo" title ="Descargar acuerdo"></a>
    
    </div>
    
    <div id="callout" class="bs-callout bs-callout-info">
    <h4>Paso 2: Agregar nuevo acuerdo.</h4>
    <p>Escanee el acuerdo firmado de Declaración Patrimonial Púbica y anéxelo como PDF.</p>
    <input id ="txtUpload" type ="file" name ="document">
    <p><input type ="button" class ="btn" id ="btnUpload" value ="Subir archivo"></p>
    </div>

</form>




<?}?>
<div id ="history">
    <h3></h3>
    <?if($context->dec){?>
    <iframe id ="iframe" src ="<?=$context->dec[0]['Documento']?>#view=FitH"></iframe>
    
    <?}else{?>
    
    <div id ="notdec">Por el momento no cuenta con el acuerdo de declaración pública</div>
    
    <?}?>
</div>

<? } ?>