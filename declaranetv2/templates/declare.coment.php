<script>
    $(function(){
        $('.btn').button();
        $('textarea').focus();
        
        $('#btnSendComent').click(function(){
            if(Full($('#coment'))){
                fakeLoad($(this).parent());
                $.post('declare.php?action=<?=hideVar('coment')?>', $('#coment').serialize(), function(data){
                    ready();
                    if(data)
                        $.msgBox({title: "Error", content: data, type: "error"});
                    else
                        closeSexy();
                });
            }
        });
    });
</script>
<form id ="coment">
    <input type ="hidden" name ="id" value ="<?=$context->id?>">
    <center>
        Aclaración / Comentario:
        <p></p>
        <textarea name ="coment" rows ="5" cols ="60" class ="require"></textarea>
        <p></p>
        <div><input type ="button" class ="btn" value ="Enviar" id ="btnSendComent"></div>
    </center>
</form>