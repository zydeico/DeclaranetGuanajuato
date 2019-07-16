
<style type ="text/css">
   #main-title {color: #ED3B96; margin: 10px auto;}
   #uploader {width: 90%; margin: 20px auto; padding: 10px; background: #DDDEEF; font-size: 12pt;}
   #history {width: 70%; margin: 20px auto; font-size: 12pt;}
   #iframe {width: 400px; height: 500px; float: right; margin: 10px; }
   #list {width: 400px; float: left; height: 100px; overflow: auto; }
   .item { width: 90%; padding: 15px; text-align: left; font-size: 14pt; border-radius: 15px; background: #F0F0F0; margin: 10px 5px; cursor: pointer;}
   .active {background-color: #2395CA !important;}
   #notdec {widows: 90%; padding: 15px; text-align: center; margin: 20px auto; background: #FC4B66; color: white; font-size: 14pt;}
</style>

<script>
    $(function () {
        $('.btn').button();
    });

    $(function () {

        $('.item').hover(function () {
            $(this).animate({'background-color': 'black', 'color': 'white'}, 500);
        }, function () {
            $(this).animate({'background-color': '#F0F0F0', 'color': 'black'}, 500);
        });



        $('.item').click(function () {
            $('.item').removeClass('active');
            $(this).addClass('active');
            LoadDocument($(this));
        });
    });// END

    function LoadDocument(div) {
        var url = $(div).attr('action');
        $('#iframe').attr('src', url + '#view=FitH');
    }
</script>



<form>
    <center>
        <h1 id ="main-title">Declaración fiscal de servidores públicos</h1>
    </center>
    <div id ="history">
        <center><h3>Lista de declaraciones anteriores</h3></center>
        <?if($context->dec){?>
        <div id="list">
            <?foreach($context->dec as $d){?>
            <div class ="item <?= (!$active ? "active" : "") ?>" action ="<?= $d['Documento'] ?>">Declaración <?= (substr($d['Fecha_DecFis'], 0, 4)) ?></div>
            <?$active = true;?>
            <?}?>
        </div>
        <iframe id ="iframe" src ="<?= $context->dec[0]['Documento'] ?>#view=FitH"></iframe>
        <?}else{?>
        <div id ="notdec">Por el momento no cuenta con declaraciones</div>
        <?}?>
    </div>
</form>