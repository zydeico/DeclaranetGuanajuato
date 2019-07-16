<?function Style($context){?>
    <style tpe ="text/css">
        .title-error {font-size: 15pt; color: #B42142; margin: 30px auto; }
        .error {font-size: 13pt; color: #3364AD; margin: 20px auto; }
        .img-error {margin: 10px auto; }
        .redirect {margin: 20px auto; font-size: 11pt; }
        .crono {margin: 10px auto; font-size: 16pt; color: #8AC041; font-weight: bold; }
    </style>
<?}?>

<?function Script($context){?>
    <script type ="text/javascript">
         
          $(function(){
                var clock = setInterval(function(){
                    var time = parseInt($('.crono').text());
                    time -= 1;
                    $('.crono').text(time);
                    if(time <= 0){
                        clearInterval(clock);
                        location.href = "index.php";
                    }
                }, 1000);
          });// END
          
    </script>
<?}?>

<?function Body($context){?>
    <center>
        <div class ="title-error"><?=$context->title?></div>
        <div class ="error"><?=$context->error?></div>
        <?if($context->img){?>
        <div class ="img-error"><img src ="<?=$context->img?>"></div>
        <?}?>
        <div class ="redirect">En un momento será redireccionado</div>
        <div class ="crono"><?=($context->crono?$context->crono:15)?></div>
    </center>
<?}?>
