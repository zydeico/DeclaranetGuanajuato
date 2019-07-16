<?function Style($context){?>
<style type ="text/css">
   #rubros {margin: 10px auto; text-align: center; width: 99%; height: 120px;}
    .category {cursor: pointer; border: 2px solid black; margin: 0px 5px; padding: 5px; }
    .title-cat {color: #3C6AB1; font-size: 11pt; }
    .cat-selected {background-color: #26ABE2 !important; border: 2px solid #26ABE2 !important;}
    .cat-over {border-top: 2px solid #26ABE2; border-left: 2px solid #26ABE2; border-bottom: 2px solid #26ABE2; border-right: 2px solid #26ABE2;}
    #start-sp {width: 99%; height: 30px; }
    #patrimony {color: #EB008A; font-size: 16pt; text-align: left; margin: 5px 20px;  float: left; width: 45%;}
    #gocenter {width: 45%; float: right; text-align: right; margin: 5px 20px; font-size: 11pt;}
    #sending { margin: 20px auto;  cursor: pointer; width: 300px;}
    #SendDeclare {border: 3px solid #B9BFE0; padding: 10px 15px; font-size: 9pt; font-weight: bold;}
    .blocked {background-color: #C0C0C0; color: white; }
    .available {background-color: #CCE2FE; color: #B42164;}
    .ready {background-color: #7791C6; color: white;}
    #legend-sp {margin: 15px auto; font-size: 12pt; color: #5178B9;}
    #myStuff {width: 99%; padding: 10px; text-align: left; margin: 10px; }
    .heading {font-weight: bold; cursor: pointer; text-decoration: underline;}
    .description {cursor: pointer; text-decoration: underline; }
    .title-stuff {width: 95%; height: 20px; margin: 0px 0px 35px 0px; }
    .title-info {float: left; font-size: 14pt; text-decoration: underline; color: #285FAB;}
    .elem {padding: 5px; text-align: left; background-color: #CCE2FE;  border: 1px solid black; width: 95%; overflow: auto; margin: 5px 0px; min-height: 40px; font-size: 12pt;}
    .empty {padding: 5px; text-align: left; background-color: #C0C0C0; color: white;  border: 1px solid black; width: 95%; overflow: auto; margin: 5px 0px; font-size: 12pt;}
    .adding {float:right; border: 2px solid #26ABE2; }
    .pointer {cursor: pointer;}
   .options { float: right; color: #B42142 !important;}
   .elem-info {float: left; min-height: 40px; width: 70%;}
   .declare-info {font-size: 10pt; font-style: oblique; color: #BF2142; font-weight: bold;}
   .opt {cursor: pointer; padding: 0px 5px;}
   .info-help {float: right; padding: 0px 5px; cursor: pointer;}
   .appear {display: none; }
   .title-manage {margin: 10px auto; color: #3B6AB1; background-color: #D4D6EB; width: 90%; padding: 5px; font-weight: bold; font-size: 10pt;}
   .data td {padding: 2px 5px; }
   .small {font-size: 9pt;  }
   .legend {color: red; font-weight: bold;}
   .overthis {color: #679A3C; }
   .modify {font-size: 9pt;}
   .manage {border: 2px solid #C5C9E5; padding: 10px 5px; margin: 5px 10px;}
   .manage td { padding: 5px;}
   .label-manage {margin: 15px auto; color: #2599CE; }
   .sell {padding: 5px 10px; color: red; font-size: 10pt;}
   .final {display: none;}
   .navigate {width: 70%; position: absolute; bottom:10px; left: 120px; right: 120px; }
   .prev {float: left; margin: 15px; }
   .next {float: right; margin: 15px; }
   .title-final {margin: 15px auto; background-color: #CCE2FE; border: 1px solid black; width: 90%; padding: 5px; font-style: oblique;}
   .count-final {color: #2D00EE; font-style: normal;}
   #panel-list {float: left; width: 45%; height: 350px; margin: 10px; }
   #panel-add {float: right; width: 49%; margin: 10px; font-size: 10pt; margin-top: 20px; }
   #legend-income {margin: 10px auto; width: 99%; color: #0000EE; font-size: 11pt;}
   #list-income {border: 1px solid #7B93C8; widrh: 99%; height: 95%; overflow: auto; padding: 5px;}
   .income {display: none; }
   /*#add-income {cursor: pointer; text-decoration: underline; font-size: 10pt; color: #6082BE; }*/
   .count-final {font-size: 10pt; font-weight:  bold; }
   .inc {background-color: #CCE2FE; width: 96%; padding: 5px; text-align: left; border: 1px solid black; margin: 5px 0px; font-size: 10pt;}
   th {font-size: 10pt; padding: 10px 5px;}
   .income-tbl td {padding: 5px 2px;}
   .finish {font-size: 10pt; }
   .title-coment {margin: 5px auto 5px auto; font-weight: bold; font-size: 10pt; color: #3B6AB1;}
   .coment {font-size: 9pt; width: 450px; text-align: justify; padding: 5px; border: 2px solid #C0C0C0; }
   #declare {font-size: 11pt;}
   .format {text-align: center;}
   #intro p{text-align: left; padding: 0px 20px;}
   .title-intro {box-shadow: 5px 5px 5px #888888; background: #25ABE2; border: 1px solid black; padding: 5px 10px; font-size: 12pt; font-weight: bold; margin: 10px auto; color: white; width: 90%;}
   .readonly {padding: 0px 10px; font-style: oblique; color: #3B69B0; }
   .overflow {overflow: auto; height: 400px; width: 100%; }
   .quitIncome {color: #4772B5; text-decoration: underline;}
   #panel-final {display: none; width: 800px; height: 550px; border-radius: 15px; position: absolute; background-color: white; z-index: 100001; border: 3px solid black;}
   .addcoment {margin: 20px auto;}
   #warning {font-size: 12pt; padding: 10px; }
   .separate {border-top: 2px solid #C0C0C0; margin: 5px;}
   .imported {background: #F49595;}
   .import-item {font-size: 10pt; font-style: oblique; color: #2E61AB;}
   .import-value {border: 1px solid #7A93C8;}
   #cmbImportElem {display: none;}
   .opened {border: 3px solid #8BC242;}
   #help {margin: 35px auto 15px auto; width: 100%;}
   #help table {margin: 0 auto;}
   #help table td {padding: 3px 5px;}
   .color-help {width: 40px; height: 15px; }
   #color-notopen {background: black;}
   #color-actual {background: #26ABE2; }
   #color-open {background: #8BC242;}
   .info-advertise {color: #8BC242; font-size: 10pt; font-style: oblique; text-align: center; margin: 20px auto; width: 80%;}
   .omit-step {margin: 20px auto; padding: 10px; font-weight: bold; font-size: 12pt; text-align: center; background: #73AFF4; width: 60%;}
   .legend-step {text-shadow: 2px 2px #AEAEAF; font-size: 16pt; padding: 5px; width: 100%;}
</style>
<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    
    $(function(){
       Counter();
       
       <?if($_SESSION['DEC'] == "ANUAL"){?>
       doSexy('declare.php?action=<?=hideVar('aviso')?>', 500, $(window).height() - 100, 'Aviso importante');
       <?}?>
           
       $('.category').click(function(){
           $(this).removeClass('notopen').addClass('opened');
           if(!$(this).hasClass('cat-selected')){
                var action = $(this).attr('action');
                Load(action);
           }
        });

        $('.category').hover(function(){
            $(this).addClass('cat-over');
        }, function(){
            $(this).removeClass('cat-over'); 
        });

        $('.elem').live('mouseenter', function(){
           $(this).addClass('overthis'); 
//           $(this).find('.options').show();
        });

        $('.elem').live('mouseleave', function(){
            $(this).removeClass('overthis');
//            $(this).find('.options').hide();
        });
        
        $('.adding').live('click', function(){
            var action = $(this).attr('action');
            var h = $(this).attr('height');
            doSexy('declare.php?action=<?=hideVar('details')?>&target=' + action, 700, (h=="max"?$(window).height()-100:h), "Agregar " + action);
        });
        
        $('.opt').live('click', function(){
           var target =$(this).parents('.elem').attr('action');
           var id = $(this).parents('.elem').attr('id'); 
           var action = $(this).attr('action');
           var dim = $(this).attr('dim');
           var self = $(this).parents('.elem');
           if(action == 0){
                $.msgBox({title: 'Confirme', 
                  content: '¿Seguro de eliminar este elemento?', 
                  type: 'confirm', 
                  buttons: [{ value: "OK" }, { value: "Cancelar"}],
                  success: function (result) {
                    if (result == "OK") {
                        Loading();
                        $.get('declare.php?action=<?=hideVar('del')?>&target=' + target + '&id=' + id, function(data){
                            $('.mask, .loading').remove();
                            if(data)
                                $.msgBox({title: "Error", content: data, type: "error"});
                            else{
                                if($(self).parents('.appear').find('.elem').length == 1){
                                    $(self).parents('.appear').append("<div class ='empty corner'><span class ='tooltip' title ='Pulse el botón AGREGAR para añadir elementos'><b>Vacio > </b>Ningún elemento declarado</span></div>");
                                    $('.corner').corner();
                                    $('.tooltip').tooltip();
                                }
                                $(self).remove();
                                Counter();
                            }
                        });
                    }
                  }
               });
           }else
                doSexy('declare.php?action=<?=hideVar('manage')?>&target=' + target + '&opt=' + action + '&id=' + id, 600, dim, "Modificar elemento");
        });
        
        $('.description').live('click', function(){
            var target = $(this).parents('.elem').attr('action');
            var id = $(this).parents('.elem').attr('id');
            var h = ($(this).parents('.appear').find('.adding').attr('height'));
            doSexy('declare.php?action=<?=hideVar('details')?>&target=' + target + '&id=' + id, 700, (h=="max"?$(window).height()-100:h), "Detalles");
        });
        
        $('.unblock').live('click', function(){
            if($(this).is(':checked')){
                $(this).parents('.data').find('input:text, select, textarea').not('.important').removeAttr('disabled');
                $(this).parents('.data').find('.btn:first').show();
                $(this).parents('.data').find('.addcoment').hide();
            }else{
                $(this).parents('.data').find('input:text, select, textarea').attr('disabled', 'disabled');
                $(this).parents('.data').find('.btn:first').hide();
                $(this).parents('.data').find('.addcoment').show();
            }
        });
        
        $('.available').hover(function(){
           $(this).addClass('ready');
        }, function(){
            $(this).removeClass('ready');
        });
        
        $('#sending').click(function(){
           <?if($_SESSION['DEC']){?>
           if($('.notopen').length > 0){
               $.msgBox({title: "Revise", content: "Revise cada uno de los rubros antes de enviar su declaración. Verifique el color marcado en cada uno", success: function() {
                        $('.notopen').animate({'background-color': '#7C94C8'}, 1000, function(){
                            $(this).animate({'background-color': '#FFFFFF'}, 500);
                        });
                    }
                });
           }else if($('.elem.imported').length > 0){
               $.msgBox({title: "Revise", content: "Por favor valide sus registros importados mediante sistema, eligiendo la opción \"Validar\" o \"Descartar\" según sea el caso", success: function() {
                        var action = $('.elem.imported:first').parents('.appear').attr('id');
                        Load(action);
                    }
                });
           }else
               ShowFinal();
           <?}else{?>
                doSexy('declare.php?action=<?=hideVar('warning')?>', 600, 200, "Aviso Informativo");
           <?}?>
        });
        
        $('.addcoment').live('click', function(){
            doSexy('declare.php?action=<?=hideVar('add')?>&id=' + $('#txtTrans').val(), 600, 180, "Agregar aclaración");
        });
        
        
    });// END
    
    function ShowFinal(){
        Mask();
        $.scrollTo( 50, 800, {queue:true} );
        $('#panel-final').remove();
        $(document.body).append("<div id = 'panel-final'></div>");
        $('#panel-final').css({'top': 100, 'left': $(document).width() / 2 - 400});
        $('#panel-final').load('declare.php?action=<?=hideVar('final')?>', function(){
           $(this).fadeIn();
        });
    }
    
    function Counter(){
         $.getJSON('declare.php?action=<?=hideVar('count')?>',function(json){
            $('.float').remove(); 
            $.each(json[0], function(key, val){
//                console.log(key + " - " + val);
                $(document.body).append("<div class = 'float' id = 'num-" + key + "'>" + val + "</div>");
                $('#num-' + key).css({
                    'position': 'absolute', 
                    'top': $('#cat-' + key).offset().top, 
                    'left': $('#cat-' + key).offset().left + 80,
                    'font-weight': 'normal', 
                    'color': 'white', 
                    'background-color': '#EB0089', 
                    'padding': '3px 7px', 
                    'font-size': '10pt'
                }); 
            });
            $('.float').corner();
         });
    }
    
    function Load(action){
        $('.category').removeClass('cat-selected');
        $('.category').each(function(){
           if($(this).attr('action') == action)
               $(this).addClass('cat-selected'); 
        });
        $('.appear').hide();
        if($('#' + action).length > 0){
            $('#' + action).fadeIn();
        }else{
            var div = $("<div id = '" + action + "' class = 'appear'></div>");
            $('#myStuff').append(div);
            $(div).load('declare.php?action=<?=hideVar('view')?>&cat=' + action, function(){
                $('.btn').button();
                $('.corner').corner();
                $('.tooltip').tooltip();
                $(div).fadeIn(); 
            });
        }
    }
    
</script>

<? } ?>

<?function Body($context){?>
<div class ="legend-step">Paso 1:</div>
<div id ="patrimony">Mi Patrimonio >_</div>
<div id ="gocenter"><a href = "home.php">Volver al Centro de Declaraciones</a></div>
<div id ="help">
    <table>
        <tr>
            <td class ="color-help" id ="color-notopen"></td>
            <td class ="legend-help">Sin revisar</td>
            <td class ="color-help" id ="color-actual"></td>
            <td class ="legend-help">En revisión</td>
            <td class ="color-help" id ="color-open"></td>
            <td class ="legend-help">Revisado</td>
        </tr>
    </table>
</div>
<table id ="rubros">
    <tr>
        <td class ="title-cat">Cónyuge y<br>dependientes</td>
        <td class ="title-cat">Adeudos</td>
        <td class ="title-cat">Inversiones</td>
        <td class ="title-cat">Inmuebles</td>
        <td class ="title-cat">Muebles</td>
        <td class ="title-cat">Vehículos</td>
    </tr>
    <tr>
        <td><div class ="category corner tooltip notopen" action ="dependientes" title ="Conyuge y dependientes"><img src ="img/dependientes.png" width ="85" height ="85" id ="cat-dep"></div></td>
        <td><div class ="category corner tooltip notopen" action ="adeudos" title ="Adeudos"><img src ="img/credit.png" width ="85" height ="85" id ="cat-ade"></div></td>
        <td><div class ="category corner tooltip notopen" action ="inversiones" title ="Inversiones"><img src ="img/inversiones.png" width ="85" height ="85" id ="cat-inv"></div></td>
        <td><div class ="category corner tooltip notopen" action ="inmuebles" title ="Inmuebles"><img src ="img/inmuebles.png" width ="85" height ="85" id ="cat-inm"></div></td>
        <td><div class ="category corner tooltip notopen" action ="muebles" title ="Muebles"><img src ="img/muebles.png" width ="85" height ="85" id ="cat-mue"></div></td>
        <td><div class ="category corner tooltip notopen" action ="vehiculos" title ="Vehículos"><img src ="img/vehiculos.png" width ="85" height ="85" id ="cat-veh"></div></td>
   </tr>
</table>
<form id ="myStuff" class ="corner">
    
</form>
<div class ="legend-step">Paso 2:</div>
<div id ="sending"><span id ="SendDeclare" class ="corner tooltip <?=($_SESSION['DEC']?"available":"blocked")?>" title ="<?=($_SESSION['DEC']?"Enviar ahora":"Próxima declaración: ". DateFormat($_SESSION['DT'], 1))?>"><?=($_SESSION['MODIFY']?"MODIFICAR":"REGISTRAR")?> INFORMACIÓN <?=$_SESSION['DEC']?></span></td></div>
<? } ?>