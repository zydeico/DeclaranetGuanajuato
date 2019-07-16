<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?=getParam(17)?></title>
        <link rel="shortcut icon" href="img/favicon.ico" >
        <link rel="stylesheet" type="text/css" href="css/fonts.css" >
        <link rel ="stylesheet" type ="text/css" href ="css/jquery-ui-1.10.3.custom.css">
        <link rel="stylesheet" type="text/css" href="js/sexylightbox/jQuery/sexylightbox.css" media="all" />
        <link rel="stylesheet" type="text/css" href="js/amcharts_3.1.1/samples/style.css" />
        <link rel="stylesheet" type="text/css" href="js/dhtmlxGrid/codebase/dhtmlxgrid.css">
        <link rel="stylesheet" type="text/css" href="js/dhtmlxGrid/codebase/skins/dhtmlxgrid_dhx_skyblue.css">
        <link rel="STYLESHEET" type="text/css" href="js/dhtmlxToolbar/codebase/skins/dhtmlxtoolbar_dhx_skyblue.css">
        <link rel="STYLESHEET" type="text/css" href="js/jquery.msgBox/Styles/msgBoxLight.css">
        <link rel="STYLESHEET" type="text/css" href="css/login.css">
        <link rel="STYLESHEET" type="text/css" href="css/magic.min.css">
        <style type="text/css">
            body {margin: 0; font-family:'Conv_Intro Regular',Sans-Serif !important;}
            .logo {margin: 5px auto; }
            .main-body  {width: 94%; margin: 5px auto 10px auto; min-height: 30px;}
            .left {float: left; }
            .right {float: right; }
            .header {width: 95%; margin: 10px auto; min-height: 100px; text-align: center;}
            .menu-icon {cursor: pointer; margin: 0px auto;}
            #banner {background-image: url('img/banner.png'); width: 1100px; height: 20px; color: white; font-weight: bold; padding: 5px; text-align: center; font-size: 12pt;}
            #footer {color: #A6B1D9; font-size: 11pt; margin: 15px auto; }
            #browsers {margin: 0px auto 10px auto; }
            #browsers td {padding: 5px; color: black;}
            #logo-declaranet {margin: 5px auto;}
            #base-container {width: 1200px; overflow: auto; }
            #main-menu {float: left; width: 250px; border: 1px solid #DDDEEF; min-height: 400px; }
            #menu-title {color: #EB008A; font-style: oblique; text-align: center; margin: 20px auto 5px auto; font-size: 12pt;}
            #main-content { min-height: <?=($_SESSION['UI']?"880px":"0")?>; margin: 5px 10px; float: left; width: <?=($context->menu?"900px":"99%")?>; overflow: hidden;}
            #menu-general {height: 180px;}
            #menu-options {height: <?=(250 - setPadding(count($context->menu)) * 2)?>px; background-image: url('img/circle.png'); padding: <?=setPadding(count($context->menu))?>px; text-align: center;}
            #menu-extras {height: 250px; margin: 10px auto;}
            #welcome {color: #679A3C; margin: 10px auto; font-size: 14pt;}
            #userNameData {color: #26ABE2;font-size: 12pt; }
            #cmbMainProfile {color: #B42143; font-size: 10pt; margin: 3px 0px; }
            #userDepData {color: #B42143; padding: 5px 5px 5px 0px; font-size: 10pt;}
            #tray {margin: 5px; text-decoration: underline; font-size: 12pt;}
            .icon-tray {padding: 5px 0px 5px 5px; }
            .counter {padding: 5px 15px 5px 5px; color: red; font-weight: bold; }
            .menu-rullet {margin: 5px auto;}
            .menu-rullet td {text-align: center; padding: 7px;}
            .menu-sub {padding: 10px 10px 5px 10px; width: 88%;}
            .menu-link {color: white; font-size: 9pt; }
            /*.img-active {background: #DCDFE8; border: 1px solid black; padding: 3px; border-radius: 10px;}*/
            .img-active {background: #DCDFE8; margin-bottom: 10px; border-radius: 10px; }
            .hidden {display: none; }
            .menu-active {background-color: #2D5FAB;}
            .section-title {font-size: 13pt; color: #EB008A; text-align: left; font-style: oblique; margin: 0px 0px 20px 0px; width: 99%;  }
            .btn {font-size: 9pt !important; }
            .large {width: 300px; }
            .watch {border: 2px solid red; }
            .RowCount {color: #6F8CC4; font-size: 10pt; float: right; padding: 10px; }
            #chat-legend {color: #EB008A; font-style: oblique; text-align: center; font-size: 10pt; margin: 10px auto;}
            #reference {margin: 10px auto; text-align: center; font-size: 12pt; color: #406DB2; }
            #reference td {padding: 0px 5px;}
            #legend-test {color: red; font-size: 26pt; margin: 50px auto; text-shadow: black 0.1em 0.1em 0.1em;}            
            .tbl-showinfo {margin: 20px auto; border-collapse: collapse; width: 95%;}
            .tbl-showinfo td {border: 1px solid #F0F0F0; padding: 10px 5px;}
            .over {background-color: #ECECEC; }
            .notfound-info {color: red; text-decoration: underline; margin: 50px auto; font-size: 12pt;}
            .icon-declared {width: 25px; height: 25px; cursor: pointer; }
            .navi-extra {width: 90%; margin: 20px; text-align: center; color: #2397CC; font-size: 12pt; padding: 5px 10px; min-height: 20px;}
            #go-center {float: left; }
            #go-out {float: right; }
        </style>
        <?Style($context)?>
        <?if(!$context->consult){?>
        <script type ="text/javascript" src ="js/jquery-1.8.3.min.js"></script>
        <script type ="text/javascript" src ="js/jquery-ui-1.10.3.custom.js"></script>
        <script type ="text/javascript" src ="js/jquery.corner.js"></script>
        <script type = "text/javascript" src="js/dhtmlxGrid/codebase/dhtmlxcommon.js"></script>
        <script type = "text/javascript" src="js/dhtmlxGrid/codebase/dhtmlxgrid.js"></script>
        <script type = "text/javascript" src="js/dhtmlxGrid/codebase/dhtmlxgridcell.js"></script>
        <script type = "text/javascript" src="js/dhtmlxGrid/codebase/ext/dhtmlxgrid_srnd.js"></script>
        <script type = "text/javascript" src="js/dhtmlxGrid/codebase/ext/dhtmlxgrid_filter.js"></script> 		
        <script type = "text/javascript" src="js/dhtmlxGrid/codebase/ext/dhtmlxgrid_pgn.js"></script>
        <script type = "text/javascript" src="js/dhtmlxGrid/codebase/ext/dhtmlxgrid_splt.js"></script>
        <!--<script type = "text/javascript" src="js/dhtmlxGrid/codebase/ext/dhtmlxgrid_export.js"></script>-->
        <script type = "text/javascript" src="js/dhtmlxToolbar/codebase/dhtmlxtoolbar.js"></script>
        <script src='js/dhtmlxGrid/grid2excel/client/dhtmlxgrid_export.js'></script>		
        <script src='js/dhtmlxGrid/grid2pdf/client/dhtmlxgrid_export.js'></script>
        <script type ="text/javascript" src ="js/jquery.msgBox/Scripts/jquery.msgBox.js"></script>
        <script type ="text/javascript" src ="js/sexylightbox/jQuery/sexylightbox.v2.3.jquery.js"></script>
        <script type = "text/javascript" src="js/amcharts_3.1.1/amcharts/amcharts.js"></script>
        <script type = "text/javascript" src="js/amcharts_3.1.1/amcharts/serial.js"></script>
        <script type = "text/javascript" src="js/amcharts_3.1.1/amcharts/gauge.js"></script>
        <script type = "text/javascript" src="js/amcharts_3.1.1/amcharts/pie.js"></script>
        <script type = "text/javascript" src="js/ajax-switch/jquery.iphone-switch.js"></script>
        <script type = "text/javascript" src="js/switch/switch.js"></script>
        <script type = "text/javascript" src="js/jquery.scrollTo.min.js"></script>
        <script type ="text/javascript" src ="js/menu.js"></script>
        <script type = "text/javascript" src="js/fn.js"></script>
        <script type ="text/javascript">
            $(function(){
                $('.corner').corner();
                $('.btn').button();
                $('.tooltip').tooltip();
                
                SexyLightbox.initialize({
                        find          : 'sexylightbox', // rel="sexylightbox"
                        color         : 'black',
                        dir           : 'js/sexylightbox/jQuery/sexyimages',
                        emergefrom    : 'top',
                        OverlayStyles : {
                                'background-color': 'black',
                                'opacity' : 0.7
                        }
                });	
                
                $('.hoverimg').live('mouseenter', function(){
                    $(this).addClass('img-active');
                });
                
                $('.hoverimg').live('mouseleave', function(){
                    $(this).removeClass('img-active');
                });
                
                <?if(is_array($_SESSION['PRO'])){?>
                $('#cmbMainProfile').change(function(){
                   location.href = "login.php?action=<?=hideVar('switch')?>&pro=" + $(this).val(); 
                });
                <?}?>
                
                <?if(is_array($_SESSION['PRO']) && in_array(44, $_SESSION['PM'])){?>
                $('#switch-chat').iphoneSwitch(<?=($_SESSION['CHAT']?"'on'":"'off'")?>,
                   function() {
                       cambiar_status(1);
                   },
                   function() {
                       cambiar_status(0);
                   },
                   {
                     switch_on_container_path: 'js/ajax-switch/iphone_switch_container_on.png', 
                     switch_off_container_path: 'js/ajax-switch/iphone_switch_container_off.png', 
                     switch_path: 'js/ajax-switch/iphone_switch.png' 
                   }
                );
                <?}?>
                    
                <?if(is_array($_SESSION['PRO']) && in_array(58, $_SESSION['PM'])){?>
                   $('#btnFastConsult').click(function(){
                       if($('#txtConsult').val().length >= 4){
                           doSexy('index.php?action=<?=hideVar('consult')?>&rfc=' + $('#txtConsult').val(), 900, 350, 'Resultados de búsqueda');
                       }else
                           $.msgBox({title: "Revise", content: "Debe ingresar al menos las primeras 4 letras del RFC"});
                   });
                <?}?>
            });// END
        </script>
        <?}?>
        <?Script($context)?>
    </head>
   
    <body>
        <a id = "ankor" href = "#" rel = "sexylightbox"></a>
        <?if(!$context->consult){?>
        <div class ="main-body">
            <center>
                <?if($_SERVER['HTTP_HOST'] == "172.22.5.38"){?>
                <div id ="legend-test">Versión de Prueba</div>
                <?}else{?>
                <img src ="<?=getParam(18)?>" class ="logo">
                <?}?>
            </center>
            <?if($_SESSION['UI']){?>
            <div id ="banner" class ="logo"><?=getParam(14)?></div>
            <?}?>
        </div>
        <?}?>
        <div class ="main-body" id ="base-container">
            <?if($context->menu){?>
                <div id ="main-menu" class ="corner">
                    <a href ="<?=$_SESSION['HOME']?>"><img id ="logo-declaranet" src ="img/declaranet.png" width ="220" height ="70"></a>
                    <div class ="menu-section" id ="menu-general">
                        <table id ="welcome">
                            <tr>
                                <td width ="200">Bienvenido: </td>
                                <td><a href ="login.php?action=<?=hideVar('logout')?>">Salir</a></td>
                            </tr>
                        </table>
                        <table id ="personalData">
                            <tr><td id="userNameData" title ="<?=$_SESSION['UI']?>"><?=$_SESSION['NM']?></td></tr>
                            <?if($_SESSION['PRO'] == "#SP"){?>
                            <tr>
                                <td id ="userDepData"><?=$_SESSION['WORK']?></td>
                            </tr>
                            <?}else{?>
                            <tr>
                                <td id ="userProfileData">
                                    <select id ="cmbMainProfile">
                                        <?foreach($_SESSION['PRO'] as $pro){?>
                                        <option value ="<?=$pro['ID']?>" <?=($pro['ID']==$_SESSION['CU']?"selected":"")?>><?=$pro['PRO']?></option>
                                        <?}?>
                                    </select>
                                </td>
                            </tr>
                            <?}?>
                        </table>
                        <table id ="tray">
                            <tr>
                                <td>Mi bandeja: </td>
                                <td class ="icon-tray"><a href ="message.php"><img src ="<?=($_SESSION['PRO']=="#SP"?"img/notif1.png":"img/mail2.png")?>" class ="tooltip" title ="<?=($_SESSION['PRO']=="#SP"?"Notificaciones":"Mensajes")?>"></a></td>
                                <td class ="counter" id ="notifCounter"><?=CountMsg()?></td>
                            </tr>
                        </table>
                    </div>
                    <?if($_SESSION['PRO'] != "#SP" && in_array(58, $_SESSION['PM'])){?>
                    <div class ="menu-section" id ="menu-consult">
                        <table>
                            <tr>
                                <td>RFC</td>
                                <td><input type ="text" id ="txtConsult" maxlength ="10" style ="width: 100px"></td>
                                <td><input type ="button" value ="Consultar" class ="btn" id ="btnFastConsult"></td>
                            </tr>
                        </table>
                    </div>
                    <?}?>
                    <div id ="menu-title">Menú principal</div>
                    <div class ="menu-section" id ="menu-options">
                        <?$cont = 0;?>
                        <?foreach(setLayout(count($context->menu)) as $l){?>
                        <table class ="menu-rullet">
                            <tr>
                                <?for($i=0; $i<$l; $i++){?>
                                <td>
                                    <img class ="menu-icon tooltip" src ="<?=$context->menu[$cont]->getImg()?>" width ="40" height ="40" title ="<?=$context->menu[$cont]->getName()?>">
                                    <?foreach($context->menu[$cont++]->getSub() as $s){?>
                                    <span class ="hidden" action= "<?=$s["page"]?>"><?=$s["title"]?></span>
                                    <?}?>
                                </td>
                                <?}?>
                            </tr>
                        </table>
                        <?}?> 
                    </div>
                    <div class ="menu-section" id ="menu-extras">
                        <? // include('chat/chat.php');?>
                    </div>
                    <?if($_SESSION['PRO'] != "#SP"){?>
                    <div class ="menu-section" id ='reference'>
                        <center>
                            <table>
                                <tr>
                                    <td>Recursos: </td>
                                    <td><a href ="file.php?id=<?=hideVar(getParam(4))?>"><img src ="img/book1.png" width ="50" height ="50" class ="tooltip" title ="Manual de usuario"></a></td>
                                    <td><a href ="file.php?id=<?=hideVar("media/ManualAdmin.pdf")?>"><img src ="img/book2.png" width ="50" height ="50" class ="tooltip" title ="Manual de administrador"></a></td>
                                </tr>
                            </table>
                        </center>
                    </div>
                    <?}?>
                </div>
            <?}?>
            <div id ="main-content">
                 <center>
                    <?Body($context)?>
                </center>
            </div>
        </div>
        <?if($_SESSION['UI'] && !$context->consult){?>
        <div class ="main-body" id ="footer">
            <center>
                <table id ="browsers">
                    <tr>
                        <td>Este sitio esta recomendado para </td>
                        <td><a href ="//www.mozilla.org/es-MX/"><img src ="img/firefox.png" title ="Mozilla Firefox" width ="32" height ="32"></a></td>
                        <td><a href ="//www.google.com/intl/es/chrome/"><img src ="img/chrome.png" title ="Google Chrome" width ="32" height ="32"></a></td>
                        <td><a href ="//www.apple.com/mx/safari/"><img src ="img/safari.png" title ="Safari" width ="32" height ="32"></a></td>
                        <td>En una resolución de 1200x700</td>
                    </tr>
                </table>
                <?=getParam(16)?>
            </center>
        </div>
        <?}?>
        <br>
    </body>
    
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-91560396-1', 'auto');
  ga('send', 'pageview');

</script>

</html>

