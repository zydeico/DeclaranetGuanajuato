<?function Style($context){?>
<style type ="text/css">
    .error {margin: 20px auto; padding: 10px; background: #F2B0B0; font-weight: bold; text-align: center; color: #2E5FAB; font-size: 12pt;}
</style>
<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    
    $(function(){
       
    });// END
    
    
</script>
<? } ?>

<?function Body($context){?>
<div class ="section-title"><?=$context->title?> >_</div>
<center>
    <?if($context->error){?>
    <div class ="error"><?=$context->error?></div>
    <?}?>
    <form action ="#" method ="post">
        <table>
            <tr>
                <td>RFC</td>
                <td><input type ="text" id ="txtRFC" name ="rfc"></td>
                <td><input type ="submit" class ="btn" value ="Fake!" id ="btnFake"></td>
            </tr>
        </table>
    </form>
</center>

<? } ?>