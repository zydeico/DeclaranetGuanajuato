<?
    require_once ('lib/secure.php');    
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');

    $action = showVar($_GET['action']);
    $context = new Context();
    $db = new DBConn();
    $context->title = "Calendario Oficial";

    if(!$action){
        $context->allow = getAccess();
        $context->menu = setMenu();
        $sql = "select min(YEAR(Fecha)) from dias_inhabiles";
        $context->min = $db->getOne($sql);	
        RenderTemplate('templates/calendar.tpl.php', $context, 'templates/base.php');
    
    }elseif($action == "load"){
        $year = $_GET["year"];
        if(!$year)
            $year = Date('Y');
        $sql = "select * from dias_inhabiles where YEAR(Fecha) = " . $year . " order by Fecha";
        $data = $db->getArray($sql);
        $fechas = array();
        foreach($data as $d)
                $fechas[] = $d["Fecha"];
        $timeline = array();
        $timeline[] = array("Month" => "ENERO", "Num" => "01", "Days" => 31);
        $timeline[] = array("Month" => "FEBRERO", "Num" => "02", "Days" => ($year%4==0?29:28));
        $timeline[] = array("Month" => "MARZO", "Num" => "03", "Days" => 31);
        $timeline[] = array("Month" => "ABRIL", "Num" => "04", "Days" => 30);
        $timeline[] = array("Month" => "MAYO", "Num" => "05", "Days" => 31);
        $timeline[] = array("Month" => "JUNIO", "Num" => "06", "Days" => 30);
        $timeline[] = array("Month" => "JULIO", "Num" => "07", "Days" => 31);
        $timeline[] = array("Month" => "AGOSTO", "Num" => "08", "Days" => 31);
        $timeline[] = array("Month" => "SEPTIEMBRE", "Num" => "09", "Days" => 30);
        $timeline[] = array("Month" => "OCTUBRE", "Num" => "10", "Days" => 31);
        $timeline[] = array("Month" => "NOVIEMBRE", "Num" => "11", "Days" => 30);
        $timeline[] = array("Month" => "DICIEMBRE", "Num" => "12", "Days" => 31);		
        $html = "";				
        foreach($timeline as $key => $val){
            $day = 1;
            $html .= "<div class = 'timeline'>
                        <div class = 'title'>" . $val["Month"] . "</div>
                        <table class = 'month-maked' id = '" . $val["Num"] . "'>
                                <tr>
                                    <td class = 'titleday'>D</td>
                                    <td class = 'titleday'>L</td>
                                    <td class = 'titleday'>M</td>
                                    <td class = 'titleday'>X</td>
                                    <td class = 'titleday'>J</td>
                                    <td class = 'titleday'>V</td>
                                    <td class = 'titleday'>S</td>
                                </tr>";
                                for($i=1; $i<=6; $i++){
                                        $week = 0;
                                        $html .= "<tr>";
                                        for($j=1; $j<=7; $j++){
                                            if($day <= $val["Days"]){
                                                if($week == DayOfWeek(($year?$year:Date('Y')), $val["Num"], $day, 'int')){
                                                        $today = ($year?$year:Date('Y')) . "-" . $val["Num"] . "-" . format($day, 2, "0");
                                                        $html .= "<td class = '" . (in_array($today, $fechas)?"blocked":"day") . "' id = '" . $today . "'>" . ($day++) . "</td>";
                                                }else{
                                                        $html .= "<td class = 'titleday'> </td>";
                                                }
                                                $week++;
                                            }
                                        }
                                        $html .= "</tr>";
                                }
                        $html .= "</table></div>";
        }
        echo $html;
    
        
    }elseif($action == "add"){
        $date = $_GET['d'];
        $sql = "insert into dias_inhabiles(Fecha) values('" . $date . "')";
        $db->execute($sql);
        
    }elseif($action == "quit"){
        $date = $_GET['d'];
        $sql = "delete from dias_inhabiles where Fecha = '" . $date . "'";
        $db->execute($sql);
    }
?>