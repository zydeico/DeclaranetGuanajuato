<?php

    require_once('lib/secure.php');
    require_once('lib/ext.php');
    require_once('lib/DBConn.php');
    require_once('lib/templates.php');
    require_once('lib/document.php');

    
    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    $context->title = "";
    
    if(!$action){
        $dec = $_GET['dec'];
        $id = $_GET['id'];
        if(!$id) $id = $_SESSION['UI'];
        $context->consult = isset($_GET['consult']);
        
        $sql = "select * from estados order by Estado";
        $context->estate = $db->getArray($sql);
        
        $sql = "select * from ciudades order by Ciudad";
        $context->city = $db->getArray($sql);
       
        $sql = "select CONCAT_WS(' ', Paterno, Materno, Nombre) as Nombre, "
                . "IF(Dependencia like '%JUDICIAL%', 'JUDICIAL', 'EJECUTIVO') as Poder, "
                . "Dependencia, Puesto, Civil, Ciudad, Estado "
                . "from servpub sp "
                . "join dependencias d on d.ID_Dependencia = sp.ID_Dependencia "
                . "join puestos p on p.ID_Puesto = sp.ID_Puesto "
                . "join infoserv i on i.ID_Serv = sp.ID_Serv "
                . "join ciudades c on c.ID_Ciudad = i.ID_Ciudad "
                . "join estados e on e.ID_Estado = c.ID_Estado "
                . "where sp.ID_Serv = " . $id . " "
                . "order by ID_Info DESC LIMIT 1";
        $context->data = $db->getObject($sql);
        
        $sql = "select * from intereses_economicos where " . ($dec?"ID_DecInt = " . $dec: "Estatus = 1 and ID_Serv = " . $id);
        $context->eco = $db->getArray($sql);
        $sql = "select * from intereses_profesionales where " . ($dec?"ID_DecInt = " . $dec: "Estatus = 1 and ID_Serv = " . $id);
        $context->prof = $db->getArray($sql);
        $sql = "select * from intereses_diversos where " . ($dec?"ID_DecInt = " . $dec: "Estatus = 1 and ID_Serv = " . $id);
        $context->div = $db->getArray($sql);
        
        $sql = "select ID_DecInt from intereses_dec where YEAR(Fecha_DecInt) = YEAR(NOW()) and ID_Serv = " . $id;
        $context->dec = $dec || $db->getOne($sql);
        $sql = "select ID_Dec from declaraciones where YEAR(Fecha_Dec) = YEAR(NOW()) and ID_Serv = " . $id;
        $context->patrimonial = $db->getOne($sql);
        
        $sql = "select ID_DecInt, Fecha_DecInt from intereses_dec where ID_Serv = " . $id . " order by ID_DecInt DESC";
        $context->hist = $db->getArray($sql);
        
        if($context->dec){
            $sql = "select ID_DecInt from intereses_dec where ID_Serv = " . $id . " and ID_DecInt < " . $context->dec;
            $context->prev = $db->getArray($sql);
            $sql = "select ID_DecInt from intereses_dec where ID_Serv = " . $id . " and ID_DecInt > " . $context->dec; 
            $context->next = $db->getArray($sql);
        }
        
        RenderTemplate('templates/interest.tpl.php', $context, 'templates/base.php');
        
    }elseif($action == "save"){
//        if(!$db->exist("ID_DecInt", "intereses_dec", "YEAR(Fecha_DecInt) = YEAR(NOW()) and ID_Serv = " . $_SESSION['UI'])){
        
            $records = 0;
            $search = array("$", ",");
            foreach($_POST as $k => $v){

                if(is_array($v)){
                    $value = array();
                    foreach($v as $val)
                        $value[] = $val;
                }else{
                    $value = $v;
                }
                $$k = $value;
            }

            $dec = $db->getID("ID_DecInt", "intereses_dec");

            $sql = "insert into intereses_dec values("
                    . $dec . ", "
                    . $_SESSION['UI'] . ", "
                    . "(select ID_Info from infoserv where ID_Serv = " . $_SESSION['UI'] . " order by ID_Info DESC LIMIT 1), "
                    . "NOW() )";
            $db->execute($sql);

            //////////////////////////////////////////// ECONOMICOS - DECLARANTE - CONSEJOS /////////////////////////////
            for($i=0; $i<count($enterprise_eco); $i++){
                if ($enterprise_eco[$i]){
                    $sql = "insert into intereses_economicos "
                            . "(ID_Serv, ID_DecInt, RazonSocial, SectorEco, Pais, Cargo, Participacion, MontoAnual, Registro, Tipo, Captura, Estatus) "
                            . "values("
                            . "'" . $_SESSION['UI'] . "', "
                            . "'" . $dec . "', "
                            . "'" . $enterprise_eco[$i] . "', "
                            . "'" . $sector_eco[$i] . "', "
                            . "'" . $pais_eco[$i] . "', "
                            . "'" . $cargo_eco[$i] . "', "
                            . "'" . $part_eco[$i] . "', "
                            . "'" . str_replace($search, "", $monto_eco[$i]) . "', "
                            . "'DECLARANTE', "
                            . "'CONSEJOS', "
                            . "NOW(), 0)";
                    $db->execute($sql);
                }
            }

            //////////////////////////////////////////// ECONOMICOS - DEPEND - CONSEJOS /////////////////////////////
            for($i=0; $i<count($depend_parent_eco); $i++){
                if($depend_parent_eco[$i]){
                    $sql = "insert into intereses_economicos "
                            . "(ID_Serv, ID_DecInt, DependEco, RazonSocial, SectorEco,  Pais, Cargo, Participacion, Registro, Tipo, Captura, Estatus) "
                            . "values("
                            . "'" . $_SESSION['UI'] . "', "
                            . "'" . $dec . "', "
                            . "'" . $depend_parent_eco[$i] . "', "
                            . "'" . $depend_enterprise_eco[$i] . "', "
                            . "'" . $depend_sector_eco[$i] . "', "
                            . "'" . $depend_pais_eco[$i] . "', "
                            . "'" . $depend_cargo_eco[$i] . "', "
                            . "'" . $depend_part_eco[$i] . "', "
                            . "'DEPEND', "
                            . "'CONSEJOS', "
                            . "NOW(), 0)";
                    $db->execute($sql);
                }
            }

            //////////////////////////////////////////// ECONOMICOS - DECLARANTE - SOCIEDADES /////////////////////////////
            for($i=0; $i<count($enterprise_soc); $i++){
                if($enterprise_soc[$i]){
                    $sql = "insert into intereses_economicos "
                            . "(ID_Serv, ID_DecInt, RazonSocial, SectorEco, Pais, Antiguedad, Porcentaje, Mayoritario, Registro, Tipo, Captura, Estatus) "
                            . "values("
                            . "'" . $_SESSION['UI'] . "', "
                            . "'" . $dec . "', "
                            . "'" . $enterprise_soc[$i] . "', "
                            . "'" . $sector_soc[$i] . "', "
                            . "'" . $pais_soc[$i] . "', "
                            . "'" . $antig_soc[$i] . "', "
                            . "'" . $porcent_soc[$i] . "', "
                            . "'" . $mayor_soc[$i] . "', "
                            . "'DECLARANTE', "
                            . "'SOCIEDADES', "
                            . "NOW(), 0)";
                    $db->execute($sql);
                }
            }

             //////////////////////////////////////////// ECONOMICOS - DEPEND - SOCIEDADES /////////////////////////////
            for($i=0; $i<count($depend_parent_soc); $i++){
                if($depend_parent_soc[$i]){
                    $sql = "insert into intereses_economicos "
                            . "(ID_Serv, ID_DecInt, DependEco, RazonSocial, SectorEco, Pais, Antiguedad, Porcentaje, Mayoritario, Registro, Tipo, Captura, Estatus) "
                            . "values("
                            . "'" . $_SESSION['UI'] . "', "
                            . "'" . $dec . "', "
                            . "'" . $depend_parent_soc[$i] . "', "
                            . "'" . $depend_enterprise_soc[$i] . "', "
                            . "'" . $depend_sector_soc[$i] . "', "
                            . "'" . $depend_pais_soc[$i] . "', "
                            . "'" . $depend_antig_soc[$i] . "', "
                            . "'" . $depend_porcent_soc[$i] . "', "
                            . "'" . $depend_mayor_soc[$i] . "', "
                            . "'DEPEND', "
                            . "'SOCIEDADES', "
                            . "NOW(), 0)";
                    $db->execute($sql);
                }
            }

             //////////////////////////////////////////// ECONOMICOS - OTROS /////////////////////////////
            for($i=0; $i<count($otros_enterprise_eco); $i++){
                if($otros_enterprise_eco[$i]){
                    $sql = "insert into intereses_economicos "
                            . "(ID_Serv, ID_DecInt, RazonSocial, Titular, Actividad, Registro, Tipo, Captura, Estatus) "
                            . "values("
                            . "'" . $_SESSION['UI'] . "', "
                            . "'" . $dec . "', "
                            . "'" . $otros_enterprise_eco[$i] . "', "
                            . "'" . $otros_titular_eco[$i] . "', "
                            . "'" . $otros_desc_eco[$i] . "', "
                            . "'DECLARANTE', "
                            . "'OTROS', "
                            . "NOW(), 0)";
                    $db->execute($sql);
                }
            }

             //////////////////////////////////////////// PROFESIONALES - DECLARANTE - CARGOS /////////////////////////////
            for($i=0; $i<count($enterprise_prof); $i++){
                if($enterprise_prof[$i]){
                    $sql = "insert into intereses_profesionales "
                            . "(ID_Serv, ID_DecInt, RazonSocial, Cargo, Pais, FechaInicio, FechaTermino, MontoAnual, Registro, PersonaFisica, Captura, Estatus) "
                            . "values("
                            . "'" . $_SESSION['UI'] . "', "
                            . "'" . $dec . "', "
                            . "'" . $enterprise_prof[$i] . "', "
                            . "'" . $cargo_prof[$i] . "', "
                            . "'" . $pais_prof[$i] . "', "
                            . "'" . $start_prof[$i] . "', "
                            . "'" . $end_prof[$i] . "', "
                            . "'" . str_replace($search, "", $monto_prof[$i]) . "', "
                            . "'DECLARANTE', "
                            . "'0', NOW(), 0)";
                    $db->execute($sql);
                }
            }

             //////////////////////////////////////////// PROFESIONALES - DECLARANTE - FISIcA /////////////////////////////
            for($i=0; $i<count($fisic_activ_prof); $i++){
                if($fisic_activ_prof[$i]){
                    $sql = "insert into intereses_profesionales "
                            . "(ID_Serv, ID_DecInt, Cargo, RazonSocial, Pais, FechaInicio, FechaTermino, MontoAnual, Registro, PersonaFisica, Captura, Estatus) "
                            . "values("
                            . "'" . $_SESSION['UI'] . "', "
                            . "'" . $dec . "', "
                            . "'" . $fisic_activ_prof[$i] . "', "
                            . "'" . $fisic_enterprise_prof[$i] . "', "
                            . "'" . $fisic_pais_prof[$i] . "', "
                            . "'" . $fisic_start_prof[$i] . "', "
                            . "'" . $fisic_end_prof[$i] . "', "
                            . "'" . str_replace($search, "", $fisic_monto_prof[$i]) . "', "
                            . "'DECLARANTE', "
                            . "'1', NOW(), 0)";
                    $db->execute($sql);
                }
            }

             //////////////////////////////////////////// PROFESIONALES - DEPEND - CARGOS /////////////////////////////
            for($i=0; $i<count($fisic_depend_parent); $i++){
                if($fisic_depend_parent[$i]){
                    $sql = "insert into intereses_profesionales "
                            . "(ID_Serv, ID_DecInt, DependProf,  Cargo, SectorEco, Actividad, Pais, Registro, Captura, Estatus) "
                            . "values("
                            . "'" . $_SESSION['UI'] . "', "
                            . "'" . $dec . "', "
                            . "'" . $fisic_depend_parent[$i] . "', "
                            . "'" . $fisic_depend_cargo[$i] . "', "
                            . "'" . $fisic_depend_sector[$i] . "', "
                            . "'" . $fisic_depend_activ[$i] . "', "
                            . "'" . $fisic_depend_pais[$i] . "', "
                            . "'DEPEND', "
                            . "NOW(), 0)";
                    $db->execute($sql);
                }
            }

            //////////////////////////////////////////// DIVERSOS - DECLARANTE - HONO /////////////////////////////
            for($i=0; $i<count($div_hono_enterprise); $i++){
                if($div_hono_enterprise[$i]){
                    $sql = "insert into intereses_diversos "
                            . "(ID_Serv, ID_DecInt, RazonSocial, Cargo, Anio, Vigente, Tipo, Registro, Captura, Estatus) "
                            . "values("
                            . "'" . $_SESSION['UI'] . "', "
                            . "'" . $dec . "', "
                            . "'" . $div_hono_enterprise[$i] . "', "
                            . "'" . $div_hono_cargo[$i] . "', "
                            . "'" . $div_hono_anio[$i] . "', "
                            . "'" . $div_hono_vigente[$i] . "', "
                            . "'HONORARIOS', "
                            . "'DECLARANTE', "
                            . "NOW(), 0)";
                    $db->execute($sql);
                }
            }

            //////////////////////////////////////////// DIVERSOS - DECLARANTE - FILAN /////////////////////////////
            for($i=0; $i<count($div_fila_enterprise); $i++){
                if($div_fila_enterprise[$i]){
                    $sql = "insert into intereses_diversos "
                            . "(ID_Serv, ID_DecInt, RazonSocial, Participacion, Anio, Vigente, Tipo, Registro, Captura, Estatus) "
                            . "values("
                            . "'" . $_SESSION['UI'] . "', "
                            . "'" . $dec . "', "
                            . "'" . $div_fila_enterprise[$i] . "', "
                            . "'" . $div_fila_part[$i] . "', "
                            . "'" . $div_fila_anio[$i] . "', "
                            . "'" . $div_fila_vigente[$i] . "', "
                            . "'FILANTROPICA', "
                            . "'DECLARANTE', "
                            . "NOW(), 0)";
                    $db->execute($sql);
                }
            }

            //////////////////////////////////////////// DIVERSOS - DEPEND - FILAN /////////////////////////////
            for($i=0; $i<count($div_fila_depend_parent); $i++){
                if($div_fila_depend_parent[$i]){
                    $sql = "insert into intereses_diversos "
                            . "(ID_Serv, ID_DecInt, DependDiv, RazonSocial, Participacion, Anio, Tipo, Registro, Captura, Estatus) "
                            . "values("
                            . "'" . $_SESSION['UI'] . "', "
                            . "'" . $dec . "', "
                            . "'" . $div_fila_depend_parent[$i] . "', "
                            . "'" . $div_fila_depend_enterprise[$i] . "', "
                            . "'" . $div_fila_depend_part[$i] . "', "
                            . "'" . $div_fila_depend_anio[$i] . "', "
                            . "'FILANTROPICA', "
                            . "'DEPEND', "
                            . "NOW(), 0)";
                    $db->execute($sql);
                }
            }

            //////////////////////////////////////////// DIVERSOS - VIAJES /////////////////////////////
            for($i=0; $i<count($div_travel_enterprise); $i++){
                if($div_travel_enterprise[$i]){
                    $sql = "insert into intereses_diversos "
                            . "(ID_Serv, ID_DecInt, RazonSocial, Receptor, Fecha, Pais, Descripcion, ValorTotal, Tipo, Registro, Captura, Estatus) "
                            . "values("
                            . "'" . $_SESSION['UI'] . "', "
                            . "'" . $dec . "', "
                            . "'" . $div_travel_enterprise[$i] . "', "
                            . "'" . $div_travel_person[$i] . "', "
                            . "'" . $div_travel_date[$i] . "', "
                            . "'" . $div_travel_pais[$i] . "', "
                            . "'" . $div_travel_desc[$i] . "', "
                            . "'" . str_replace($search, "", $div_travel_monto[$i]) . "', "
                            . "'VIAJE', "
                            . "'DECLARANTE', "
                            . "NOW(), 0)";
                    $db->execute($sql);
                }
            }

            /////////////////////////////////////////// DIVERSOS - PATROCINIOS /////////////////////////////
            for($i=0; $i<count($div_cort_recep); $i++){
                if($div_cort_recep[$i]){
                    $sql = "insert into intereses_diversos "
                            . "(ID_Serv, ID_DecInt, Receptor, RazonSocial, Descripcion, ValorTotal, Tipo, Registro, Captura, Estatus) "
                            . "values("
                            . "'" . $_SESSION['UI'] . "', "
                            . "'" . $dec . "', "
                            . "'" . $div_cort_recep[$i] . "', "
                            . "'" . $div_cort_enterprise[$i] . "', "
                            . "'" . $div_cort_desc[$i] . "', "
                            . "'" . str_replace($search, "", $div_cort_monto[$i]) . "', "
                            . "'PATROCINIO', "
                            . "'DECLARANTE', "
                            . "NOW(), 0)";
                    $db->execute($sql);
                }
            }

            /////////////////////////////////////////// DIVERSOS - DONATIVOS /////////////////////////////
            for($i=0; $i<count($div_don_emisor); $i++){
                if($div_don_emisor[$i]){
                    $sql = "insert into intereses_diversos "
                            . "(ID_Serv, ID_DecInt, Emisor, RazonSocial, Descripcion, Anio, ValorTotal, Tipo, Registro, Captura, Estatus) "
                            . "values("
                            . "'" . $_SESSION['UI'] . "', "
                            . "'" . $dec . "', "
                            . "'" . $div_don_emisor[$i] . "', "
                            . "'" . $div_don_enterprise[$i] . "', "
                            . "'" . $div_don_desc[$i] . "', "
                            . "'" . $div_don_anio[$i] . "', "
                            . "'" . str_replace($search, "", $div_don_monto[$i]) . "', "
                            . "'DONATIVO', "
                            . "'DECLARANTE', "
                            . "NOW(), 0)";
                    $db->execute($sql);
                }
            }

             /////////////////////////////////////////// OTROS INTERESES /////////////////////////////
            for($i=0; $i<count($otros); $i++){
                if($otros[$i]){
                    $sql = "insert into intereses_otros "
                            . "(ID_Serv, ID_DecInt, Descripcion, Captura, Estatus) "
                            . "values("
                            . "'" . $_SESSION['UI'] . "', "
                            . "'" . $dec . "', "
                            . "'" . $otros[$i] . "', "
                            . "NOW(), 0)";
                    $db->execute($sql);
                }
            }

            $sql = "update intereses_economicos set Estatus = 2 where Estatus = 1 and ID_Serv = " . $_SESSION['UI'];
            $db->execute($sql);
            $sql = "update intereses_profesionales set Estatus = 2 where Estatus = 1 and ID_Serv = " . $_SESSION['UI'];
            $db->execute($sql);
            $sql = "update intereses_diversos set Estatus = 2 where Estatus = 1 and ID_Serv = " . $_SESSION['UI'];
            $db->execute($sql);
            $sql = "update intereses_otros set Estatus = 2 where Estatus = 1 and ID_Serv = " . $_SESSION['UI'];
            $db->execute($sql);
            $sql = "update intereses_economicos set Estatus = 1 where Estatus = 0 and ID_Serv = " . $_SESSION['UI'];
            $db->execute($sql);
            $sql = "update intereses_profesionales set Estatus = 1 where Estatus = 0 and ID_Serv = " . $_SESSION['UI'];
            $db->execute($sql);
            $sql = "update intereses_diversos set Estatus = 1 where Estatus = 0 and ID_Serv = " . $_SESSION['UI'];
            $db->execute($sql);
            $sql = "update intereses_otros set Estatus = 1 where Estatus = 0 and ID_Serv = " . $_SESSION['UI'];
            $db->execute($sql);
//        }
        
        sleep(1);
    
    }elseif($action == "generate"){
        $id = showVar($_GET['id']);
        if(is_numeric($id)){
            $sql = "select ID_DecInt,  YEAR(Fecha_DecInt) as Anio, DATE(Fecha_DecInt) as Fecha, Fecha_DecInt from intereses_dec where ID_DecInt = " . $id;
            $dec = $db->getObject($sql);
            $date = explode("-", $dec->Fecha);
            $data['fecha'] = DayOfWeek($date[0], $date[1], $date[2]) . ", " . DateFormat($dec->Fecha_DecInt, 1);
            $data['hora'] = DateFormat($dec->Fecha_DecInt, 2) . " hrs.";
            $data['servidor'] = $_SESSION['NM'];
//            $data['tipo'] = "intereses";
//            $data['periodo'] = $dec->Anio;
//            $data['control'] = "I" . $dec->Anio . "-" . format($dec->ID_DecInt, 10, "0");
            echo hideVar(GenerateDocument($id, "Intereses", $data, $param));
        }
    }
    