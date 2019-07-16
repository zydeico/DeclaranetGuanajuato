<?function Style($context){?>
<style type ="text/css">
    #home-title {color: #228dc1; text-shadow: 2px 2px #707172; font-size: 24pt; margin: 50px auto;}
    #home-desc {color: #707172; font-weight: bold; font-size: 14pt; margin: 20px auto;}
    #home-panel {width: 70%; text-align: center;  margin-top: 50px; }
    .img-home {width: 33%; float: left; cursor: pointer;}
    .legend-home {text-align: center; color: #DD6413; font-size: 14pt; text-align: center; padding: 10px 0;}
</style>
<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    
    $(function(){
        
        $('.img-home').css({'width': (100 / $('.img-home').length) + '%'});
        
        $('.img-home').click(function(){
           var target = $(this).attr('action');
           $(this).find('img').removeClass().addClass('magictime puffOut');
            setTimeout(function(){
                location.href = target;
            }, 500);
        });
    });// END
    
    
</script>
<? } ?>

<?function Body($context){?>
<div id ="home-panel">
    <center>
        <div id ="home-title">Centro de Declaraciones</div>
        <div id ="home-desc">A continuación elija el tipo de declaración que desea revisar o capturar</div>
        <div class ="img-home" action ="declare.php">
            <img src ="img/patrim.png" width ="170" height ="150" class ="magictime tinUpIn">
            <p><span class ="legend-home">Declaración Patrimonial</span></p>
        </div>
        <div class ="img-home" action="interest.php">
            <img src ="img/intereses.png" width ="150" height ="150" class ="magictime tinDownIn">
            <p><span class ="legend-home">Declaración de Intereses</span></p>
        </div>
        <?if($_SESSION['FISCAL']){?>
<!--        <div class ="img-home" action="fiscal.php">
            <img src ="img/fiscal.png" width ="150" height ="150" class ="magictime tinUpIn">
            <p><span class ="legend-home">Declaración Fiscal</span></p>
        </div>-->
        <?}?>
        <?if($_SESSION['ACDO']){?>
<!--         <div class ="img-home" action ="declaracionpub.php">
            <img src ="img/document.jpg" width ="170" height ="150" class ="magictime tinUpIn">
            <p><span class ="legend-home">Acuerdo Declaración<br>Patrimonial Pública</span></p>
         </div>-->
        <?}?>
    </center>
</div>
<? } ?>