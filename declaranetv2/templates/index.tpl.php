<?function Style($context){?>
    <style tpe ="text/css">
        #portal {margin: 0; background-image: url('img/background.png'); background-repeat: no-repeat; background-size: cover; width: 100%; height: 100%; position: absolute; top: 0; left: 0;}
        #portal-logo {position: absolute; top: 0; left: 43%; background-image: url('img/logo.png'); width: 145px; height: 118px;}
        #portal-opt {top: 0; left: 60%; margin: 0 10px; float: right;} 
        .focus {display: none;}
        .opt-login {margin: 0; cursor: pointer;}
        #portal-login {width: <?=($_SESSION['TRY']>3?800:470)?>px; background-image: url('img/back-login.png'); position: absolute; top: 125px; left: calc(100% - <?=($_SESSION['TRY']>3?820:490)?>px); }
        #portal-login .input {font-size: 12pt; margin: 5px; padding: 5px; border-radius: 5px; width: 150px;}
        #enter {margin-top: 7px;  }
        #error {display: none; top: <?=($_SESSION['TRY']>3?255:200)?>px; color: white; background: red; border-radius: 5px; padding: 10px; margin: 15px; font-size: 14pt; position: absolute; left: calc(100% - 520px); width: 470px; text-align: right; }
        #declaranet {position: absolute; color: #EC3692; font-size: 36pt; bottom: 80px; left: calc(100% - 560px); font-weight: bold;}
        #portal-info {position: absolute; bottom: 20px; text-align: right; left: calc(100% - 400px); }
        
        #link-container {text-align: center; margin: 10px auto; width: 100%; height: 150px;}
        #login {width: 350px; padding: 20px; margin: 20px auto 30px auto;}
        .div-login {width: 99%; height: 25px; text-align: center;}
        .label {background-color: #2D60AB; color: white; padding: 5px 20px; font-size: 10pt; margin: 0px 20px;}
        .txtlogin {border-top: 3px solid #2D60AB; border-right: 8px solid #2D60AB; border-bottom: 5px solid #2D60AB; border-left: 3px solid #2D60AB;}
        .all-links {margin: 10px auto; }
        .all-links td {padding: 5px 15px;}
        .showlink {cursor: pointer; }
        #container-index {width: 99%; margin: 5px auto; text-align: center;}
        
        .legend-change {margin: 25px auto; width: 90%; font-size: 14pt; color: #25A4DA; }
        .tbl-change td {color: #C7295E; padding: 10px 5px; font-size: 12pt;}
        .instruc {color: black; font-size: 10pt; margin: 20px; }
        #btnChange {margin: 10px auto; }
        #captcha {position: absolute; top: 200px; left: calc(100% - 340px); }
        /*#recover {color: #A7B1D9; text-decoration: underline; cursor: pointer; font-size: 10pt; margin-top: 20px;}*/
        .legend {width: 95%; text-align: center; color: #8EA0D0; margin: 10px auto; font-size: 11pt;}
        #tbl-send {text-align: center;}
        .title-alert {background-color: #DDDEEF; color: #446FB4; font-size: 10pt; padding: 5px; margin: 10px auto; width: 90%;}
        .tbl-alert td {padding: 3px 25px; }
        .tbl-alert th {background-color: #ECECEC; padding: 10px 25px; }
        h3 {text-align: left;}
        .movement {border-collapse: collapse;}
        .movement th {padding: 5px 15px; text-align: left; }
        .movement td {text-align: left; padding: 3px; font-size: 10pt; }
        .actions td {padding: 5px;}
        .opt {cursor: pointer; padding: 3px;}
        .pending {font-size: 12pt; padding: 20px; color: #ED3B96; }
        .none {font-size: 12pt; padding: 20px; color: gray;}
        .tbl-find {margin: 10px auto; }
        .tbl-find td {padding: 10px; }
        .lightblue td {background-color: #CCE2FE; }
        .loaderindex {width: 600px; border: 1px solid black; padding: 10px; text-align: center; background-color: white; overflow: auto; display: none;}
        .closeloader {height: 30px; }
        .close {float: right; cursor: pointer; }
        .list-items td {text-align: left; font-size: 10pt; padding: 5px; }
        #txtRecover {height: 20px; padding: 5px; font-size: 10pt; }
        #legend-login {font-size: 10pt; color: #EB008A;}
        #tbl-control {margin: 10px auto; font-size: 12pt; }
        #tbl-control td {padding: 0px 10px;}
        .control-notfound {padding: 100px; color: red; font-size: 12pt;}
        .list-dec {border-collapse: collapse;}
        .list-dec td {padding: 5px;  border: 1px solid #F0F0F0; }
        .list-dec tr:hover {background: #F0F0F0; }
        .list-dec th {color: #285DAA; padding: 10px; }
        #cmbDepPublic {width: 350px; }
        #tbl-public {margin: 15px auto;}
        #tbl-public .btn {width: 100px;} 
        
    </style>
<?}?>

<?function Script($context){?>
    <script type ="text/javascript">
          var grid, gridcontrol, gridpublic; 
          
          $(function(){
               
               $('#accordion').accordion({heightStyle: 'content', active: false, collapsible: true});
               
               $('.traslucid').mouseenter(function(){
                  $(this).hide().parent().find('.focus').show();
               });
               
               $('.focus').mouseleave(function(){
                   $(this).hide().parent().find('.traslucid').show();
               });
               
               $('#enter').click(function(){
                  $('#portal-login').submit();
               });
               
               $('#txtPwd').keypress(function(e){
                  if(e.which == 13) $('#portal-login').submit();
               });
               
               $('.showlink').click(function(){
                    $('.mask, .loaderindex').remove();
                    Mask();
                    $(document.body).append("<div class = 'loaderindex'><div class = 'closeloader'><img src = 'img/delete.png' class = 'close'></div><div class = 'realloader'></div></div>");
                    $('.loaderindex').css({
                       'position': 'absolute', 
                       'height': 200,
                       'width': 700,
                       'top': 50, 
                       'left': $(window).width() / 2 - 350, 
                       'z-index': 100002
                    });
                    $('.loaderindex').corner();
                    $('.realloader').load('index.php?action=<?=hideVar('load')?>&target=' + $(this).attr('action'), function(){
                        $('.loaderindex').show('Slide');
                    });
               });
               
               $('.close').live('click', function(){
                   $('.loaderindex').hide('explode', function(){
                       $('.mask, .loaderindex').remove();
                   });
               });
               
               <?if($_SESSION['PWD'] || $_SESSION['MAIL']){?>
                   Mask();
                   $(document.body).append("<form  class = 'floating corner'></form>");
                   $('.floating').css({
                      'position': 'absolute',
                      'width': 600, 
                      'height': <?=($_SESSION['PWD']?300:0)?> + <?=($_SESSION['MAIL']?220:0)?>, 
                      'border': '2px solid black', 
                      'background-color': 'white',
                      'top': 150, 
                      'left': $(document).width() / 2 - 300, 
                      'z-index': 100002
                   });
                   $('.floating').load('index.php?action=<?=hideVar('change')?>', function(){
                        $('.corner').corner();
                        $('.btn').button();
                   });
               <?}?>
                
                if($('#error').text().length > 0)
                    $('#error').show('shake', 'slow');
                
                $('#btnChange').live('click', function(){
                    if(Full($('.floating'))){
                       fakeLoad($(this).parent());
                       $.post('index.php?action=<?=hideVar('data')?>', $('.floating').serialize(), function(data){
                            ready();
                            if(data){
                                 $.msgBox({title: "Error", content: data, type: "error"});
                            }else{
                                location.href = "<?=$_SESSION['HOME']?>";
                            }
                       });
                    }
                });
                
                $('#recover').click(function(){
                   doSexy('index.php?action=<?=hideVar('recover')?>', 600, 250, "Recuperar contraseña"); 
                });
                
                $('#btnSend').live('click', function(){
                    fakeLoad($(this).parent());
                    $.post('index.php?action=<?=hideVar('send')?>', $('#send').serialize(), function(data){
                        ready();
                        if(data.indexOf("@") > -1){
                            var mails = data.split("|");
                            var html = "<center><span style = 'color: red; font-size: 10pt;'>Correo enviado a las siguiente(s) direccion(es):<p><b>";
                                for(var i=0; i<mails.length; i++)
                                   html += mails[i] + "<br>";      
                                html += "</b></p>";
                            $('#btnSend').parent().html(html);
                        }else
                            $.msgBox({title: "Error", content: data, type: "error"});
                    });
                });
                
                <?if(in_array(60, $context->allow?$context->allow:array())){?>
                    <?setGrid("grid", $context->params, true);?>
                    <?setGrid("gridcontrol", $context->control, true);?>
                        
                    Reload(gridcontrol, 'data/loadControl.php');
                    DatePicker($('.date'), null);
                    
                    $('.first, .second').hover(function(){
                        $(this).find('td').addClass('over');
                        if($(this).hasClass('first')){
                            $(this).next().find('td').addClass('over');
                        }else{
                            $(this).prev().find('td').addClass('over');
                        }   
                    }, function(){
                        $(this).find('td').removeClass('over');
                        if($(this).hasClass('first')){
                            $(this).next().find('td').removeClass('over');
                        }else{
                            $(this).prev().find('td').removeClass('over');
                        }   
                    });

                    $('.opt').click(function(){
                        var newid = $(this).parents('tr').find('.newid').val();
                        var newst = $(this).parents('tr').find('.newst').val();
                        var oldid = $(this).parents('tr').find('.oldid').val();
                        var oldst = $(this).parents('tr').find('.oldst').val();
                        var action = $(this).attr('action');
                        var self = $(this);
                        var legend;
                        switch(action){
                            case "promo": legend = "¿Seguro de aplicar esta PROMOCIÓN?"; break;
                            case "back": legend = "¿Seguro de aplicar este REINGRESO?"; break;
                            case "ignore": legend = "¿Seguro de aplicar esta EXCEPCIÓN?"; break;
                        }
                        if(oldst == "1" && action != "ignore")
                            $.msgBox({title: "Revise", content: "Requiere capturar BAJA primero"});
                        else{
                            $.msgBox({title: 'Confirme', 
                                content: legend,
                                type: 'confirm', 
                                buttons: [{ value: "OK" }, { value: "Cancelar"}],
                                success: function (result) {
                                    if (result == "OK") {
                                        Loading();
                                        $.post('index.php?action=<?=hideVar('fix')?>', {opt: action, newid: newid, newst: newst, oldid: oldid, oldst: oldst}, function(data){
                                            $('.mask, .loading').remove();
                                            if(data)
                                                $.msgBox({title: "Error", content: data, type: "error"});
                                            else{
                                                $(self).parents('tr').next().remove();
                                                $(self).parents('tr').remove();
                                            }
                                        });
                                    }
                                }
                            });
                        }
                        
                    });
                    
                    $('#btnFind').click(function(){
                        Loading();
                        Reload(grid, 'data/loadAlert.php?d1=' + $('#txtDate1').val() + '&d2=' + $('#txtDate2').val());
                    });
                    
                    $('#btnExport').click(function(){
                        grid.toExcel('js/dhtmlxGrid/grid-excel-php/generate.php');
                    });
                    
                    $('#btnControlSearch').click(function(){
                        var rfc = $.trim($('#txtControlRFC').val());
                        if(rfc.length == 10){
                            doSexy('index.php?action=<?=hideVar('control')?>&rfc=' + rfc, 1000, 150, "Permitir modificación de declaraciones");
                        }else
                            $.msgBox({title: "Revise", content: "Ingrese un RFC completo"});
                    });
                    
                    $('#cmbDepPublic').change(function(){
                        if($(this).val()){
                            Reload(gridpublic, 'data/loadPublic.php?dep=' + $(this).val());
                        }
                    });
                    
                    $('#CheckAllPublic').click(function(){
                       gridpublic.checkAll(true); 
                    });
                    
                    $('#UncheckAllPublic').click(function(){
                       gridpublic.checkAll(false); 
                    });
                    
                    $('#SendPublic').click(function(){
                        Loading();
                        Clear(gridpublic);
                        gridpublic.filterByAll();
                        setTimeout(function(){
                            var select = gridpublic.getCheckedRows(1);
                            if(select.length > 0){
                                var ids = select.split(",");
                                $.post('index.php?action=<?=hideVar('invitation')?>', {ids: ids}, function(data){
                                    $('.mask, .loading').remove();
                                    if(data)
                                        $.msgBox({title: "Error", content: data, type: "error"});
                                    else
                                        $.msgBox({title: "OK", content: "Correos enviados correctamente", type: "info"});
                                });
                            }else{
                                $('.mask, .loading').remove();
                                $.msgBox({title: "Revise", content: "Debe seleccionar al menos una persona"});
                            }
                        }, 1000);
                    });
                    
                <?}?>
                
                <?if(!$_SESSION['UI'] && getModule() == "index.php"){?>
//                   doSexy('index.php?action=<?=hideVar('aviso')?>', 850, $(window).height() - 100, "Aviso importante");
                <?}?>

          });// END
          
          <?if(is_array($_SESSION['PRO'])){?>
                function View(id, date){
                    doSexy('index.php?action=<?=hideVar('details')?>&id=' + id + '&date=' + date, 600, 300, "Detalle de consultas");
                }

                function PublicHistory(id){
                    doSexy('index.php?action=<?=hideVar('history')?>&id=' + id, 600, $(window).height() - 100, "Historial de publicaciones");
                }
          <?}?>
          
    </script>
<?}?>

<?function Body($context){?>
    <div id ="container-index">
        <?if(is_array($_SESSION['PRO'])){?>
            <?if(in_array(60, $_SESSION['PM'])){?>
            <div class ="section-title">Panel de alertas >_</div>
            <div id ="accordion">
                <h3>Duplicados en el padrón (<?=count($context->mov)?>)</h3>
                <div>
                    <table class ="movement">
                        <thead>
                        <th></th>
                        <th>RFC</th>
                        <th>Nombre</th>
                        <th>Dependencia</th>
                        <th>Puesto</th>
                        <th>Estatus</th>
                        <th>Opciones</th>
                        </thead>
                        <?foreach($context->mov as $m){?>
                        <tr class ="first">
                            <input type ="hidden" class ="newid" value ="<?=$m['new']['ID_Serv']?>">
                            <input type ="hidden" class ="newst" value ="<?=$m['new']['Estatus']?>">
                            <input type ="hidden" class ="oldid" value ="<?=$m['old']['ID_Serv']?>">
                            <input type ="hidden" class ="oldst" value ="<?=$m['old']['Estatus']?>">
                            <td><b>Nuevo</b></td>
                            <td><?=$m['new']['RFC']?></td>
                            <td><?=$m['new']['Nombre']?></td>
                            <td><?=$m['new']['Dependencia']?></td>
                            <td><?=$m['new']['Puesto']?></td>
                            <td><?=$m['new']['Estatus']=="1"?"Activo":"Baja"?></td>
                            <td rowspan ="2" align ="left">
                                <table class ="actions">
                                    <tr>
                                        <?if($m['opt'] == "promo"){?>
                                        <td><img src ="img/star.png" width ="24" height ="24" class ="opt hoverimg tooltip" title ="Promoción" action ="promo"></td>
                                        <?}else{?>
                                        <td><img src ="img/back.png" width ="24" height ="24" class ="opt hoverimg tooltip" title ="Reingreso" action ="back"></td>
                                        <?}?>
                                        <td><img src ="img/block.png" width ="24" height ="24" class ="opt hoverimg tooltip" title ="Ignorar" action ="ignore"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class ="second">
                            <td><b>Anterior</b></td>
                            <td><?=$m['old']['RFC']?></td>
                            <td><?=$m['old']['Nombre']?></td>
                            <td><?=$m['old']['Dependencia']?></td>
                            <td><?=$m['old']['Puesto']?></td>
                            <td><?=$m['old']['Estatus']=="1"?"Activo":"Baja"?></td>
                        </tr>
                        <?}?>
                    </table>
                </div>
                <h3>Prórrogas (<?=$context->pro?>)</h3>
                <div>
                    <a href ="prorrogue.php"><span class ="<?=$context->pro?"pending":"none"?>"><?=$context->pro?> solicitud(es) pendiente(s)</span></a>
                </div>
                <h3>Vo.Bo. Correcciones (<?=$context->correct?>)</h3>
                <div>
                    <a href ="mov.php"><span class ="<?=$context->correct?"pending":"none"?>"><?=$context->correct?> correción(es) pendiente(s)</span></a>
                </div>
                <h3>Bitácora de consultas</h3>
                <div>
                    <form id ="filter">
                        <table class ="tbl-find">
                            <tr>
                                <td>Consultas entre </td>
                                <td><input type ="text" class ="date" id ="txtDate1" readonly></td>
                                <td> y </td>
                                <td><input type ="text" class ="date" id ="txtDate2" readonly></td>
                                <td><input type ="button" class ="btn" value ="Buscar" id ="btnFind"></td>
                                <td><input type ="button" class ="btn" value ="Exportar" id ="btnExport"></td>
                            </tr>
                        </table>                    
                    </form>
                    <table width="100%"  cellpadding="0" cellspacing="0">		
                        <tr>
                             <td id="pager"></td>
                        </tr>
                        <tr>
                             <td><div id="infopage" style =""></div></td>
                        </tr>
                        <tr>
                             <td><div id="grid" style ="height: 600px"></div></td>
                        </tr>
                        <tr>
                             <td class = "RowCount"></td>
                        </tr>
                    </table>
                </div>
                <h3>Control de declaraciones modificadas</h3>
                <div>
                    <center>
                        <table id ="tbl-control">
                            <tr>
                                <td>RFC </td>
                                <td><input type ="text" id ="txtControlRFC" maxlength ="10"></td>
                                <td><input type ="button" class ="btn" value ="Buscar" id ="btnControlSearch"></td>
                            </tr>
                        </table>
                    </center>
                    <table width="100%"  cellpadding="0" cellspacing="0">		
                        <tr>
                             <td id="pager"></td>
                        </tr>
                        <tr>
                             <td><div id="infopage" style =""></div></td>
                        </tr>
                        <tr>
                             <td><div id="gridcontrol" style ="height: 600px"></div></td>
                        </tr>
                        <tr>
                             <td class = "RowCount"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <?}?>
        <?}elseif(!isset($_SESSION['PRO'])){?>
        <img id ="logo-declaranet" src ="img/declaranet.png">
        <div id ="portal">
            <div id ="portal-logo"></div>
            <div id ="portal-opt">
                <table id ="tbl-opt">
                    <tr>
                        <td>
                            <a href ="media/Calendario2017.pdf" target ="_blank" class ="tooltip" title ="Calendario organizacional para presentar declaración patrimonial anual. En éste ícono consulte la fecha asignada por Dependencia para presentar y/o recibir asesoría para la Declaración Patrimonial Anual. Ésta declaración patrimonial puede presentarla desde el mes de enero o dentro del periodo programado.">
                                <img class ="opt-login traslucid" src ="img/calendario1.png" width="155" height="120">
                                <img class ="opt-login focus" src ="img/calendario2.png" width="155" height="120">
                            </a>
                        </td>
                        <td>
                            <div id ="recover" class ="tooltip" title ="Proceso para recuperación de contraseña de acceso">
                                <img class ="opt-login traslucid" src ="img/clave1.png" width="155" height="120">
                                <img class ="opt-login focus" src ="img/clave2.png" width="155" height="120">
                            </div>
                        </td>
                        <td>
                            <div class ="showlink tooltip" action ="descargas" title="Lista de documentos disponibles para su descarga">
                                <img class ="opt-login traslucid" src ="img/descargas1.png" width="155" height="120">
                                <img class ="opt-login focus" src ="img/descargas2.png" width="155" height="120">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <form id ="portal-login" class ="login-form" action="login.php" method="post">
                <table> 
                    <tr>
                        <td><input name="user" type="text" class="input" placeholder="RFC sin homoclave" id ="txtUser" /></td>
                        <td><input name="pwd" type="password" class="input" placeholder="Contraseña" id ="txtPwd" /></td>
                        <?if($_SESSION['TRY'] > 3){?>
                        <td>
                            <div><?=recaptcha_get_html(CAPTCHA_PUBLIC_KEY, null)?></div>
                        </td>
                        <?}?>
                        <td>
                            <div id="enter">
                                <img class ="opt-login traslucid" src ="img/entrar1.png" width="110" height="50">
                                <img class ="opt-login focus" src ="img/entrar2.png" width="110" height="50">
                            </div>
                        </td>
                    </tr>
                </table>
            </form>
            <div id ="error"><?=$context->error?></div>
            <div id ="declaranet">DeclaraNet Guanajuato</div>
            <div id ="portal-info"><?=getParam(16)?></div>
        </div>
        <?}?>
    </div>
<?}?>
