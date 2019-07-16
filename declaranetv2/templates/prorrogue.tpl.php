<?function Style($context){?>
<style type ="text/css">
    p {text-align: left;}
    #pro {width: 60%; font-size: 12pt; }
    #prorrogue {padding: 10px 15px;}
    .data td {padding: 10px 5px; }
    .waiting {color: #4973B6; margin: 50px; font-size: 14pt;}
    .accept {color: #436FB3; font-size: 14pt; margin: 50px; }
    .rejected {color: #B42142; font-size: 14pt; margin: 30px; }
    .rason {font-size: 12pt; }
    .aut {color: #529FF1; font-weight: bold;}
    .info {color: #5E81BD; font-weight: bold; margin: 10px auto; }
    .label {color: #B82142; font-style: oblique; text-align: left;}
    .result {color: #2E5FAB; font-weight: bold; font-size: 10pt; }
    .field {text-align: left;}
    .text {font-size: 10pt; width: 90%;}
</style>
<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    var grid; 
    
    $(function(){
        DatePicker($('.date'));
        <?if($context->params){?>
            Loading();
            <?=setGrid("grid", $context->params, true);?>
            Reload(grid, 'data/loadProrrogue.php');
        <?}?>
        
        $('#btnOK').click(function(){
           if(Full($('#pro'))){
                var inputFileImage = document.getElementById("txtFile");
                var file = inputFileImage.files[0];
                var data = new FormData();
                data.append('document', file);
                data.append('motive', $('#txtMotive').val());
                data.append('date', $('#txtDate').val());
                Loading();
                $.ajax({
                    url: 'prorrogue.php?action=<?=hideVar('save')?>',
                    type:'POST',
                    contentType:false,
                    data: data,
                    processData:false,
                    cache:false, 
                    success: function(msg){
                        $('.mask, .loading').remove();
                        if(msg)
                            $.msgBox({title: "Error", content: msg, type: "error"});
                        else{
                            location.reload();
                        }
                    }
                });
           } 
        });
       
        $('#btnAccept').live('click', function(){
            if(Full($('#prorrogue'))){
                fakeLoad($(this).parent());
                $.post('prorrogue.php?action=<?=hideVar('resp')?>&resp=<?=hideVar('1')?>', $('#prorrogue').serialize(), function(data){
                    ready();
                    if(data)
                        $.msgBox({title: "Error", content: data, type: "error"});
                    else{
                        Reload(grid, 'data/loadProrrogue.php');
                        closeSexy();
                    }
                });
            }
        });
      
        $('#btnReject').live('click', function(){
            if($('#txtResp').val() != ""){
                fakeLoad($(this).parent());
                $.post('prorrogue.php?action=<?=hideVar('resp')?>&resp=<?=hideVar('2')?>', $('#prorrogue').serialize(), function(data){
                    ready();
                    if(data)
                        $.msgBox({title: "Error", content: data, type: "error"});
                    else{
                        Reload(grid, 'data/loadProrrogue.php');
                        closeSexy();
                    }
                });
            }else
                $.msgBox({title: "Revise", content: "Debe agregar una respuesta para el servidor público"});
        });
        
        $('#btnAgain').click(function(){
            $.get('prorrogue.php?action=<?=hideVar('again')?>&id=<?=$context->data->ID_Prorroga?>', function(data){
                if(data)
                    $.msgBox({title: "Error", content: data, type: "error"});
                else
                    location.reload();
                
            });
        });
    });// END
    
    function View(id){
        doSexy('prorrogue.php?action=<?=hideVar('view')?>&id=' + id, 700, 450, "Detalles de prórroga");
    }
</script>
<? } ?>

<?function Body($context){?>
<div class ="section-title"><?=$context->title?> >_</div>
<center>
    <?if($_SESSION['PRO'] == "#SP"){?>
        <?if(!$context->data){?>
        <p class ="text">
            De acuerdo con lo previsto por el artículo 67 de la Ley de Responsabilidades Administrativas 
            de los Servidores Públicos del Estado de Guanajuato y sus municipios; la prórroga sólo podrá 
            ser otorgado cuando por motivos de salud o comisión laboral, no se pueda dar el cumplimiento 
            en los tiempos previstos para cada declaración patrimonial; para lo cual la solicitud debe de 
            estar acompañada de los documentos que acrediten la circunstancia dilatoria.
        </p>
        <p class ="text">
            El aviso podrá darse a más tardar el día anterior al del término de cumplimiento y deberá 
            contener además, la solicitud del plazo de prórroga para el cumplimiento de la declaración.
        </p>
        <br>
        <form id ="pro">
            <table class ="data">
                <tr>
                    <td>Describa brevemente el motivo de su solicitud</td>
                    <td><textarea cols ="40" rows =" 4" name ="motive" class ="require" id ="txtMotive"></textarea></td>
                </tr>
                <tr>
                    <td>Documento adjunto</td>
                    <td><input type ="file" name ="document" class ="require" id ="txtFile"></td>
                </tr>
                <tr>
                    <td>Fecha solicitada para realizar su declaración</td>
                    <td><input type ="txet" class ="require date" name ="date" id ="txtDate"></td>
                </tr>
            </table>
            <br>
            <input type ="button" class ="btn" value ="Solicitar" id ="btnOK">
        </form>
        <?}elseif($context->data->Estatus == 0){?>
        <div class ="waiting">
            Su solicitud fue guardada correctamente y será evaluada por el administrador del sistema 
            a la brevedad posible. Por favor revise después aquí el resultado.
        </div>
        <img src ="img/clock.png">
        <?}elseif($context->data->Estatus == 1){?>
        <div class ="accept">
            Su solicitud ha sido ACEPTADA con la siguiente información: 
        </div>
        <table>
            <tr>
                <td>Fecha límite de prórroga: </td>
                <td class ="aut"><?=$context->data->Fecha_Aut?></td>
            </tr>
            <tr>
                <td>Comentarios: </td>
                <td class ="aut"><?=$context->data->Respuesta?></td>
            </tr>
        </table>
        <br>
        <img src ="img/accept.png">
        <?}elseif($context->data->Estatus == 2){?>
        <div class ="rejected">Su solicitid ha sido RECHAZADA por la siguiente razón: </div>
        <br>
        <div class ="rason"><?=$context->data->Respuesta?></div>
        <br>
        <img src ="img/denied.png">
        <p></p>
        <input type ="button" class ="btn" value ="Solicitar de nuevo" id ="btnAgain">
        <?}?>
    <?}else{?>
        <table width="100%"  cellpadding="0" cellspacing="0">		
            <tr>
                 <td id="pager"></td>
            </tr>
            <tr>
                 <td><div id="infopage" style =""></div></td>
            </tr>
            <tr>
                 <td><div id="grid" style ="height: 800px"></div></td>
            </tr>
            <tr>
                 <td class = "RowCount"></td>
            </tr>
        </table>
    <?}?>
</center>

<? } ?>