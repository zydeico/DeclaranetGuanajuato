<style type ="text/css">
    .dec th {padding: 10px 0px;}
    #personal td {padding: 5px 10px ; }
    #graph {height: 100%; width: 100%; }
    .movement th {padding: 10px; }
    .movement {width: 100%; border-collapse: collapse; }
    .movement td {border: 1px solid #C3C7C9; padding: 3px;}
    .positive {color: #57C910; }
    .negative {color: #F9365D; }
    .stuff {margin: 5px ; }
    .sell {padding: 0px 10px; color: #7892C7; }
    .legend-info {margin: 10px; font-weight: bold; font-size: 10pt; color: #4872B5; text-align: center; }
    #legend {width: 80%; padding: 5px; font-size: 10pt; color: #2D5FAB; background-color: #FFCF11; box-shadow: 5px 5px 5px #888888; text-align: center; margin: 5px auto 20px auto;}
    #main-title {color: #ED3B96; margin: 10px auto;}
   #uploader {width: 90%; margin: 20px auto; padding: 10px; background: #DDDEEF; font-size: 12pt;}
   #history {width: 40%; margin: 20px auto; font-size: 12pt;}
   #iframe {width: 700px; height: 500px; float: right; margin: 10px; }
   #list {width: 400px; float: left; height: 500px; overflow: auto; }
   .item { width: 90%; padding: 15px; text-align: left; font-size: 14pt; border-radius: 15px; background: #F0F0F0; margin: 10px 5px; cursor: pointer;}
   .active {background-color: #2395CA !important;}
   #notdec {widows: 90%; padding: 15px; text-align: center; margin: 20px auto; background: #FC4B66; color: white; font-size: 14pt;}
   .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
    background: #f6f6f6 url("css/images/ui-bg_highlight-soft_100_f6f6f6_1x100.png") repeat-x scroll 50% 50%;
    border: 1px solid #dddddd;
    color: #0073ea;
    font-weight: bold;
}
</style>
<script type ="text/javascript">
    var json = null;
    
       
        
</script>
<form id ="acuerdopub">
    <input type ="hidden" name ="id" value ="<?=$context->general->ID_AcuerdoPub?>">
<div id ="view">
    <div id ="general">
        <table id ="personal">
            <tr>
                <td><b>Nombre</b></td>
                <td><?=$context->general->Nombre?></td>
            </tr>
            <tr>
                <td><b>Dependencia</b></td>
                <td><?=$context->general->Dependencia?></td>
            </tr>
            <tr>
                <td><b>Cargo</b></td>
                <td><?=$context->general->Puesto?></td>
            </tr>
            <tr>
                <td><b>Motivo</b></td>
                <td><textarea id ="txtMotivo" rows ="5" cols ="50" class ="require" name ="txtMotivo"><?=$context->general->Motivo?></textarea></td>
            </tr>
            <tr>
                <td colspan="2">
                    <iframe id ="iframe" src ="<?=$context->general->Documento?>#view=FitH"></iframe>
                </td>
            </tr>
        </table>
        <br>
        <?if($context->general->Estatus == 0){?>
        <center>
        <div>
            <input type ="button" class ="btn ui-button ui-widget ui-state-default ui-corner-all" type="button" value ="Aceptar" id ="btnAccept">
            <input type ="button" class ="btn ui-button ui-widget ui-state-default ui-corner-all" type="button" value ="Rechazar" id ="btnReject">
        </div>
            </center>
        <?}elseif($context->general->Estatus == 1){?>
        <div class ="result">Aprobada</div>
        <?}elseif($context->general->Estatus == 2){?>
        <div class ="result">Rechazada</div>
        <?}?>
        
        <br>
    </div>
    
</div>
</form>
