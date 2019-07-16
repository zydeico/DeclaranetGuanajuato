<?php

require_once('lib/secure.php');
require_once('lib/ext.php');
require_once('lib/num2letras.php');
require_once('lib/pdf/mc_table.php');

function GenerateDocument($id, $doc, $data, $param = null){
    $pdf = new PDF_MC_Table("P");
    $pdf->AliasNbPages( '{total}' );
//    $pdf->SetAutoPageBreak(true, 30);

    switch($doc){
        case "R.Inicial":
            $pdf->SetMargins(15, 15 , 15); 
            foreach($data as $d){
                $pdf->AddPage();
                $pdf->Image("img/Watermark.png", 15, 10, 180, 250);
                $pdf->SetXY(15, 20);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->SetTextColor(255);
                $pdf->SetFillColor(37, 171, 226);
                $pdf->MultiCell(0, 6, utf8_decode("Nuevo Declaranet Guanajuato"), 0, 'C', true);
                $pdf->MultiCell(0, 6, utf8_decode("Notificación de obligación a rendir declaración patrimonial inicial"), 0, 'C', true);
                $pdf->Ln(5);
                $pdf->SetTextColor(0);
                $pdf->SetFont('Arial', '');
                $pdf->MultiCell(180, 5, utf8_decode("Guanajuato, Gto. a " . DayOfWeek(Date('Y'), Date('m'), Date('d')) . ", " . DateFormat(Date('Y-m-d'), 1)), 0, 'R');
                $pdf->Ln(10);
                $pdf->MultiCell(180, 5, utf8_decode($d['Nombre']));
                $pdf->MultiCell(180, 5, utf8_decode($d['Puesto']));
                $pdf->MultiCell(180, 5, utf8_decode($d['Dependencia']));
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode("P r e s e n t e"));
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode("Me complace felicitarle por su ingreso a la administración pública en fecha " . DateFormat($d['Fecha_Inicio'], 1) . " dentro de " . $d['Dependencia'] . ". Asimismo, me permito comentarle que, de conformidad con lo previsto en los artículos 13, fracción X y 32, fracción V inciso d) de la Ley Orgánica del Poder Ejecutivo para el Estado de Guanajuato; los artículos 11, fracción XVIII, 64 y 67 de la Ley de Responsabilidades Administrativas de los Servidores Públicos del Estado de Guanajuato y sus Municipios; 15, fracción VI del Reglamento Interno de la Secretaría de la Transparencia y Rendición de Cuentas; así como en lo dispuesto en el vigente Listado de Cargos Afectos a la Obligación de presentar declaración patrimonial, usted está obligado/a a rendir informe de situación patrimonial inicial, anual o final, según corresponda."), 0, 'J');
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode("A fin de dar cumplimiento con dicha obligación, la Secretaría de la Transparencia y Rendición de Cuentas pone a su disposición el Sistema WEB Nuevo Declaranet Guanajuato en la liga http://declaranet.guanajuato.gob.mx ; antes de ingresar a éste sitio es necesario la suscripción de un Convenio sobre las condiciones de uso del Sistema; si no ha realizado éste trámite, es necesario acudir al área de Recursos Humanos de su Secretaría, Dependencia o Entidad, sólo necesita llevar una copia de identificación oficial vigente."), 0, 'J');
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode("Por lo anterior le hago la más cordial invitación a que cumpla con esta obligación en un plazo de " . getParam(3) . " días hábiles, contados a partir de la fecha de toma de posesión del cargo obligado para la presentación de su declaración inicial, con fecha límite el día " . DateFormat(Calculate($d['Fecha_Inicio'], getParam(3), $param), 1) . "."), 0, 'J');
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode("Me permito hacer énfasis en la importancia de su cumplimiento, puesto que la omisión es causa de responsabilidad administrativa."), 0, 'J');
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode("El equipo de la Dirección de Asesoría Legal, Situación Patrimonial y Responsabilidades se encuentra a su disposición para cualquier duda, en los teléfonos 01 473 735 13 00 y 01 473 735 13 13 de en un horario de lunes a viernes de 08:30 a 16:00 hrs. o a través del correo electrónico declaranet@guanajuato.gob.mx."), 0, 'J');
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode("Sin otro particular, le envío un cordial saludo."), 0, 'J');
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode("A T E N T A M E N T E"), 0, 'J');
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode(getParam(1)), 0, 'J');
                $pdf->MultiCell(180, 5, utf8_decode("Directora de Asesoría Legal, Situación Patrimonial y Responsabilidades"), 0, 'J');                
            }
        break;
        case "R.Final":
            $pdf->SetMargins(15, 15 , 15); 
            foreach($data as $d){
                $pdf->AddPage();
                $pdf->Image("img/Watermark.png", 15, 10, 180, 250);
                $pdf->SetXY(15, 20);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->SetTextColor(255);
                $pdf->SetFillColor(37, 171, 226);
                $pdf->MultiCell(0, 6, utf8_decode("Nuevo Declaranet Guanajuato"), 0, 'C', true);
                $pdf->MultiCell(0, 6, utf8_decode("Notificación de obligación a rendir declaración patrimonial final"), 0, 'C', true);
                $pdf->Ln(5);
                $pdf->SetTextColor(0);
                $pdf->SetFont('Arial', '');
                $pdf->MultiCell(180, 5, utf8_decode("Guanajuato, Gto. a " . DayOfWeek(Date('Y'), Date('m'), Date('d')) . ", " . DateFormat(Date('Y-m-d'), 1)), 0, 'R');
                $pdf->Ln(10);
                $pdf->MultiCell(180, 5, utf8_decode($d['Nombre']));
                $pdf->MultiCell(180, 5, utf8_decode($d['Puesto']));
                $pdf->MultiCell(180, 5, utf8_decode($d['Dependencia']));
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode("P r e s e n t e"));
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode("Ahora que ha concluido su etapa en " . $d['Dependencia'] . " como es conveniente informarle que, de conformidad con lo previsto en los artículos 11, fracción XVIII, 64 y 67 de la Ley de Responsabilidades Administrativas de los Servidores Públicos del Estado de Guanajuato y sus Municipios, los servidores públicos que al terminar su encargo, o al asumir otro no obligado, dentro de la administración pública estatal, estamos obligados a rendir informe de situación patrimonial final."), 0, 'J');
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode("Por lo anterior le hago la más cordial invitación a que cumpla con esta obligación en un plazo de " . getParam(3) . " días hábiles, contados a partir de la fecha de toma de baja del cargo obligado para la presentación de su declaración final, teniendo como fecha límite el día " . DateFormat(Calculate($d['Fecha_Termino'], getParam(3), $param), 1) . "."), 0, 'J');
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode("Me permito hacer énfasis en la importancia de su cumplimiento, puesto que la omisión es causa de responsabilidad administrativa."), 0, 'J');
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode("Asimismo, no omito mencionarle que, si dentro del plazo de 60 días hábiles señalado, Usted reingresa a la Administración Pública Estatal para ocupar nuevamente un cargo obligado, no será necesario que presente declaración de situación patrimonial final ni inicial, sino que podrá continuar realizando su declaración anual de manera habitual."), 0, 'J');
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode("El equipo de la Dirección de Asesoría Legal, Situación Patrimonial y Responsabilidades se encuentra a su disposición para cualquier duda, en los teléfonos 01 800 506 16 16 y 7351364 de en un horario de lunes a viernes de 08:30 a 16:00 hrs. o a través del correo electrónico declaranet@guanajuato.gob.mx."), 0, 'J');
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode("Sin otro particular, le envío un cordial saludo."), 0, 'J');
                $pdf->Ln(10);
                $pdf->MultiCell(180, 5, utf8_decode("A T E N T A M E N T E"));
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode(getParam(1)));
                $pdf->MultiCell(180, 5, utf8_decode("Directora de Asesoría Legal, Situación Patrimonial y Responsabilidades"));
            }
        break;
        case "Convenio":
            $colwidth = 98;
            $colheight = 3.5;
            $separate = 107;
            
            $pdf->SetMargins(5, 10 , 5); 
            $pdf->AddPage();
            $pdf->Image("img/Watermark.png", 15, 10, 180, 250);
            $pdf->SetXY(5, 15);
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->SetTextColor(255);
            $pdf->SetFillColor(37, 171, 226);
            $pdf->MultiCell(0, 6, utf8_decode("Nuevo Declaranet Guanajuato"), 0, 'C', true);
            $pdf->MultiCell(0, 6, utf8_decode("Condiciones Generales"), 0, 'C', true);
            $pdf->Ln(1);
            $pdf->SetTextColor(0);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->MultiCell(200, $colheight, utf8_decode("A LAS QUE SE SUJETARÁ EL SERVIDOR PÚBLICO EN EL USO DEL SISTEMA DE RECEPCIÓN DE LA INFORMACIÓN PATRIMONIAL DE LOS SERVIDORES PÚBLICOS DENOMINADO NUEVO DECLARANET GUANAJUATO, EN LO SUCESIVO \"EL SISTEMA\" QUE SUSCRIBE EL/LA C. " . $data['name'] . ", EN SU CALIDAD DE SERVIDOR PÚBLICO DE LA ADMINISTRACIÓN PÚBLICA DEL ESTADO DE GUANAJUATO, EN ADELANTE \"EL SERVIDOR PÚBLICO\", MANIFESTANDO LO SIGUIENTE:"), 0, 'J');
            $pdf->Ln(2);
            $pdf->SetFont('Arial', '');
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("1. Llamarse como ha quedado escrito, ser de nacionalidad Mexicana, mayor de edad, con registro federal de contribuyentes " . $data['RFC'] . "; que se identifica con " . $data['card'] . " con número " . $data['key'] . ", en pleno ejercicio de sus derechos, con domicilio particular el ubicado en " . $data['address'] . ", de la ciudad de " . $data['city'] . "."), 0, 'J');
            $pdf->Ln(1);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("2. Ser Servidor Público de la Administración Pública del Gobierno del Estado de Guanajuato y que presta sus servicios en " . $data['dep'] . ", con el cargo de " . $data['pos'] . " y está obligado a enterar informe de situación patrimonial en los términos de la Ley de Responsabilidades Administrativas de los Servidores Públicos del Estado de Guanajuato y sus Municipios a partir del " . DateFormat($data['date'], 1) . "."), 0, 'J');
            $pdf->Ln(1);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("3. Estar enterado que la Secretaría de la Transparencia y Rendición de Cuentas, en lo sucesivo \"La Secretaría\" es la Dependencia facultada por la Ley Orgánica del Poder Ejecutivo para el Estado de Guanajuato a efecto de recibir y registrar las declaraciones patrimoniales de los servidores públicos que se encuentran adscritos a la Administración Pública Estatal."), 0, 'J');
            $pdf->Ln(1);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("4. Que es su voluntad hacer uso de \"El Sistema\", a efecto de dar cumplimiento a la presentación de las declaraciones patrimoniales, venciendo su plazo para dar cumplimiento a la declaración patrimonial inicial el día " . DateFormat($data['limit'], 1) . " por lo que manifiesta su voluntad para activar ante \"La Secretaría\" su cuenta de usuario, misma que se integra por su RFC y contraseña de acceso a \"El Sistema\"."), 0, 'J');
            $pdf->Ln(1);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("5. Acepta que la vigencia de la cuenta que \"La Secretaría\" le asigne iniciará a partir de la presentación de este instrumento ante el personal autorizado, y concluirá 1 año después de que pierda, por cualquier motivo, el carácter de servidor público o bien, pase a ocupar un cargo no obligado."), 0, 'J');
            $pdf->Ln(1);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("6. Se manifiesta conocedor de que, una vez dados los supuestos señalados en el punto anterior, y vuelva a ocupar un cargo obligado, se interrumpirá el plazo a que hace referencia dicho punto, pudiendo utilizar su cuenta para presentar las subsecuentes declaraciones."), 0, 'J');
            $pdf->Ln(1);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("7. Asimismo, acepta que en el supuesto de que tenga un cambio de denominación de puesto, por cualquier circunstancia o sea sujeto de una promoción interna, o de la promoción por dependencia la cuenta proporcionada por \"La Secretaría\" continuará vigente."), 0, 'J');
            $pdf->Ln(1);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("8. Acepta que en caso de duda sobre la interpretación y cumplimiento de este instrumento, \"La Secretaría\" resolverá de acuerdo a la normatividad vigente."), 0, 'J');
            $pdf->Ln(1);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("9. Manifiesta que suscribe el presente instrumento por su libre voluntad, sin que exista ningún tipo de vicios del consentimiento, tales como el error, el engaño, el dolo, la violencia o la mala fe, y somete su voluntad para hacer uso de \"El Sistema\" en los términos y condiciones establecidos por \"La Secretaría\" y que a continuación se enlistan:"), 0, 'J');
            $pdf->Ln(1);
            $pdf->SetFont('Arial', 'B');
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("CONDICIONES DE USO DEL SISTEMA DE RECEPCIÓN DE LA INFORMACIÓN PATRIMONIAL DE LOS SERVIDORES PÚBLICOS DENOMINADO DECLARANET GUANAJUATO"), 0, 'C');
            $pdf->Ln(1);
            $pdf->SetFont('Arial', '');
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("PRIMERA.- \"El Servidor Público\" se obliga a utilizar \"El Sistema\" en los términos y condiciones que se plasman en el presente instrumento, y aquellos que sean señalados por “La Secretaría” en el ejercicio de sus atribuciones."), 0, 'J');
            $pdf->Ln(1);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("SEGUNDA.- \"El servidor Público\" acepta que la confidencialidad de la información sea garantizada por los métodos y técnicas de seguridad previstos en \"El Sistema\"."), 0, 'J');
            $pdf->Ln(1);
            $y = $pdf->GetY();
            //Segunda columna 
            $pdf->SetXY($separate, 41);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("TERCERA.- \"La Secretaría\" proporcionará al \"Servidor Público\" acceso a \"El Sistema\" a través de una cuenta personal, integrada por un nombre de usuario y contraseña, siendo estos el RFC del servidor público en mayúsculas y que se activará una vez que haya proporcionado el presente instrumento debidamente firmado y rubricado al personal autorizado por \"La Secretaría\"."), 0, 'J');
            $pdf->Ln(1);
            $pdf->SetX($separate);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("CUARTA.- Una vez obtenida la cuenta personal, \"El Servidor Público\" deberá de cambiar la contraseña y realizará todas sus declaraciones patrimoniales por este medio (inicial, anual y final) según corresponda."), 0, 'J');
            $pdf->Ln(1);
            $pdf->SetX($separate);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("QUINTA.- \"El Servidor Público\" recibida que la información capturada a través de su cuenta personal y aceptada por \"La Secretaría\" e integrada a la base de datos de \"El Sistema\", será totalmente atribuible a él."), 0, 'J');
            $pdf->Ln(1);
            $pdf->SetX($separate);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("SEXTA.- “El Servidor Público” reconoce que:"), 0, 'J');
            $pdf->Ln(1);
            $pdf->SetX($separate);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("I. La cuenta de usuario de \"El Servidor Público\", integrada por nombre de usuario y contraseña, son personalísimos e intransmisibles, siendo responsable de su uso."), 0, 'J');
            $pdf->Ln(1);
            $pdf->SetX($separate);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("II. En caso de que \"El servidor Público\" detecte cualquier uso indebido de su cuenta de usuario, deberá notificar de inmediato dicha circunstancia a \"La Secretaría\", a fin de que aquélla tome las providencias que el caso amerite."), 0, 'J');
            $pdf->Ln(1);
            $pdf->SetX($separate);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("III. \"El Servidor Público\" deberá hacer uso de \"El Sistema\" de acuerdo con las indicaciones que el mismo señala, siendo su responsabilidad cualquier dato que ingrese incorrectamente."), 0, 'J');
            $pdf->Ln(1);
            $pdf->SetX($separate);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("IV. Cuando la información patrimonial haya sido capturada, \"El Sistema\" generará el acuse de recibo, único comprobante con el que podrá acreditar, en su caso, que ha cumplido con la obligación de rendir su informe patrimonial."), 0, 'J');
            $pdf->Ln(1);
            $pdf->SetX($separate);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("SÉPTIMA.- En caso de que una vez remitida la información patrimonial \"El Servidor Público\" detecte haber omitido o manifestado incorrectamente algún dato, deberá informar dicha circunstancia a \"La Secretaría\", mediante documento escrito."), 0, 'J');
            $pdf->Ln(1);
            $pdf->SetX($separate);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("OCTAVA.- En caso de que \"El Servidor Público\" olvide su contraseña, podrá solicitar una nueva a través de \"El Sistema\"."), 0, 'J');
            $pdf->Ln(1);
            $pdf->SetX($separate);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("NOVENA.- \"El Servidor Público\" deberá proporcionar una cuenta de correo electrónico, atendiendo a los datos que son requeridos en \"El Sistema\", con el objeto de que \"La Secretaría\", otorgue un mejor servicio sobre los trámites relacionados con la información patrimonial."), 0, 'J');
            $pdf->Ln(1);
            $pdf->SetX($separate);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("DÉCIMA.- \"La Secretaría\" dará a la información patrimonial presentada por \"El Servidor Público\" a través de \"El Sistema\", el carácter de confidencial que le otorga la Ley de Transparencia y Acceso a la Información Pública para el Estado y los Municipios de Guanajuato."), 0, 'J');
            $pdf->Ln(1);
            $pdf->SetX($separate);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("DECIMO PRIMERA.-  Así mismo, los datos recabados serán protegidos en los términos de lo dispuesto por la Ley de Protección de Datos Personales para el Estado y los Municipios de Guanajuato, y para efectos de la cesión de dicha información, se estará a lo previsto en la misma."), 0, 'J');
            $pdf->Ln(1);
            $pdf->SetX($separate);
            $pdf->MultiCell($colwidth, $colheight, utf8_decode("DECIMO SEGUNDA.- La información patrimonial de \"El Servidor Público\" es recabada por \"La Secretaría\" con fundamento en los artículos 64, 66, 67, 68 y 69 de la Ley de Responsabilidades Administrativas de los Servidores Públicos del Estado de Guanajuato y sus Municipios. La finalidad de dicha acción consiste en vigilar que la evolución del patrimonio de los servidores públicos del Gobierno sea congruente con respecto a sus ingresos lícitos."), 0, 'J');
            $pdf->Ln(1);
            // Parte final
            if($y > $pdf->GetY())
                $pdf->SetY($y);
            $pdf->SetTextColor(255);
            $pdf->SetFont('Arial', 'B');
            $pdf->MultiCell(200, 5, utf8_decode("Cesión de Datos Personales"), 0, 'C', true);
            $pdf->Ln(1);
            $pdf->SetFont('Arial', '');
            $pdf->SetTextColor(0);
            $pdf->MultiCell(200, $colheight, utf8_decode("10.- Cesión de datos personales. "));
            $pdf->Ln(1);
            $pdf->MultiCell(200, $colheight, utf8_decode("De conformidad con el artículo 20, fracciones I y IV de la Ley de Transparencia y Acceso a la Información Pública para el Estado y los Municipios de Guanajuato y  artículos 6º, fracción I; 9º , fracciones III y IV; y el artículo 16 de la  Ley de Protección de Datos Personales para el Estado y los Municipios de Guanajuato."), 0, 'J');
            $pdf->Ln(3);
            $pdf->Cell(60, $colheight, "");
            $pdf->Cell(20, $colheight, utf8_decode("Autorizo"), 0);
            $pdf->Cell(5, $colheight, utf8_decode(""), 1);
            $pdf->Cell(20, $colheight, "");
            $pdf->Cell(20, $colheight, utf8_decode("No autorizo"), 0);
            $pdf->Cell(5, $colheight, utf8_decode(""), 1);
            $pdf->Ln(5);
            $pdf->MultiCell(200, $colheight, utf8_decode("A \"La Secretaría\" para la cesión de mis datos personales, en mi calidad de titular de los mismos, manifiesto libremente que conozco la naturaleza y alcance de dicha  autorización o negativa, en el entendido que en todo momento puedo revocar el consentimiento aquí otorgado, mediante aviso o notificación escrita ante \"La Secretaría\", que tengo derecho de conocer la identidad de los terceros a quienes se hayan cedido mis datos y que el uso que se les vaya a dar debe mantener congruencia con la finalidad para la cual se obtuvieron. "), 0, 'J');
            $pdf->Ln(1);
            $pdf->MultiCell(200, $colheight, utf8_decode("11.-Enterado del contenido, alcance, efectos y fuerza legal del presente instrumento, lo firma de conformidad en dos tantos, el día " . DayOfWeek(Date('Y'), Date('m'), Date('d')) . ", " . DateFormat(Date('Y-m-d'), 1) . "."), 0, 'J');
            $pdf->Ln(2);
            $pdf->MultiCell(200, 5, utf8_decode("\"El Servidor Público\""), 0, 'C');
            $pdf->Ln(3);
            $pdf->Line(70, $pdf->GetY(), 140, $pdf->GetY());
            $pdf->MultiCell(200, 5, utf8_decode($data['name']), 0, 'C');
            
        break;
        case "Acuse":
                $pdf->SetMargins(15, 15 , 15); 
                $pdf->AddPage();
                $pdf->Image("img/Watermark.png", 15, 10, 180, 250);
                $pdf->SetXY(15, 20);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->SetTextColor(255);
                $pdf->SetFillColor(37, 171, 226);
                $pdf->MultiCell(0, 6, utf8_decode("Nuevo Declaranet Guanajuato"), 0, 'C', true);
                $pdf->MultiCell(0, 6, utf8_decode("Acuse de recibido"), 0, 'C', true);
                $pdf->Ln(10);
                $pdf->SetTextColor(0);
                $pdf->SetFont('Arial', '');
                $pdf->MultiCell(180, 5, utf8_decode("Gobierno del Estado de Guanajuato"), 0, 'R');
                $pdf->MultiCell(180, 5, utf8_decode("Secretaría de la Transparencia y Rendición de Cuentas"), 0, 'R');
                $pdf->Ln(5);
                $pdf->MultiCell(180, 5, utf8_decode($data['fecha']), 0, 'R');
                $pdf->MultiCell(180, 5, utf8_decode($data['hora']), 0, 'R');
                $pdf->Ln(15);
                $pdf->SetFont('Arial', 'B');
                $pdf->MultiCell(180, 5, utf8_decode("Estimado/a"));
                $pdf->MultiCell(180, 5, utf8_decode($data['servidor']));
                $pdf->Ln(5);
                $pdf->SetFont('Arial', '');
                $pdf->MultiCell(180, 5, utf8_decode("Le comunico la recepción de su información " . ($data['tipo']=="intereses"?"capturada":"patrimonial") . " a través del Nuevo Sistema Declaranet Guanajuato relativa a la declaración " . ($data['tipo']=="intereses"?"de intereses":"patrimonial ".$data['tipo']) . ($data['tipo']=="ANUAL"||$data['tipo']=="intereses"?" del periodo " . $data['periodo']:"")  . " registrada bajo el número de declaración " . $data['control'] . ", de conformidad con lo dispuesto en los artículos 13, fracción X y 32, fracción V inciso d) de la Ley Orgánica del Poder Ejecutivo para el Estado de Guanajuato; 11, fracción XVII, 64, 65, 65 Ter, 67 y 68 de la Ley de Responsabilidades Administrativas de los Servidores Públicos del Estado de Guanajuato y sus Municipios, así como 15, fracción VI del Reglamento Interno de la Secretaría de la Transparencia y Rendición de Cuentas."), 0, 'J');
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode("Asimismo, no omito señalarle que en el supuesto de que existan incongruencias en su declaración de situación patrimonial, se le notificará personalmente el contenido de las mismas, para que dentro del plazo de treinta días hábiles contados a partir de la recepción de la notificación, formule las aclaraciones pertinentes."), 0, 'J');
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode("Sin embargo, lo anterior no es impedimento para que usted informe las aclaraciones que estime convenientes previo al citado requerimiento."), 0, 'J');
                $pdf->Ln();
                $pdf->MultiCell(180, 5, utf8_decode("Para cualquier duda respecto a su declaración, estamos a sus órdenes en los siguientes números telefónicos 01 800 506 16 16 o 473 73 5 13 64, en un horario  de lunes a viernes de las 8:30 a las 16:00 horas."), 0, 'J');
                $pdf->Ln(10);
                $pdf->MultiCell(180, 5, utf8_decode("Quedo a sus órdenes"));
                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B');
                $pdf->MultiCell(180, 5, utf8_decode(getParam(1)));  
                $pdf->SetFont('Arial', '');
                $pdf->MultiCell(180, 5, utf8_decode("Directora de Asesoría Legal, Situación Patrimonial y Responsabilidades"));

            break;		
            case "Intereses":
                $pdf->SetMargins(15, 15 , 15); 
                $pdf->AddPage();
                $pdf->Image("img/Watermark.png", 15, 10, 180, 250);
                $pdf->SetXY(15, 20);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->SetTextColor(255);
                $pdf->SetFillColor(37, 171, 226);
                $pdf->MultiCell(0, 6, utf8_decode("Nuevo Declaranet Guanajuato"), 0, 'C', true);
                $pdf->MultiCell(0, 6, utf8_decode("Acuse de recibido"), 0, 'C', true);
                $pdf->Ln(10);
                $pdf->SetTextColor(0);
                $pdf->SetFont('Arial', '');
                $pdf->MultiCell(180, 5, utf8_decode("Gobierno del Estado de Guanajuato"), 0, 'R');
                $pdf->MultiCell(180, 5, utf8_decode("Secretaría de la Transparencia y Rendición de Cuentas"), 0, 'R');
                $pdf->Ln(5);
                $pdf->MultiCell(180, 5, utf8_decode($data['fecha']), 0, 'R');
                $pdf->MultiCell(180, 5, utf8_decode($data['hora']), 0, 'R');
                $pdf->Ln(15);
                $pdf->SetFont('Arial', 'B');
                $pdf->MultiCell(180, 5, utf8_decode("Estimado/a"));
                $pdf->MultiCell(180, 5, utf8_decode($data['servidor']));
                $pdf->Ln(5);
                $pdf->SetFont('Arial', '');
                $pdf->MultiCell(180, 5, utf8_decode("Con esta fecha se acusa recibo de su declaración de intereses, rendida a través del Sistema Declaranet Guanajuato, en términos del acuerdo que establece la obligación de los servidores públicos estatales de presentar su declaración de intereses, dentro de sus declaraciones de situación patrimonial, publicado el 28 de junio de 2016, en el Periódico Oficial del Gobierno del Estado de Guanajuato."), 0, 'J');
                $pdf->Ln(10);
                $pdf->SetFont('Arial', 'B');
                $pdf->MultiCell(180, 5, utf8_decode("Atentamente:"));  
                $pdf->Ln(5);
                $pdf->MultiCell(180, 5, utf8_decode("Dirección General de Asuntos Jurídicos"));  
                $pdf->Ln(5);
                $pdf->MultiCell(180, 5, utf8_decode("Secretaría de la Transparencia y Rendición de Cuentas"));  
            break;
            case "Constancia":
                $pdf->SetMargins(15, 15 , 15); 
                $pdf->AddPage();
                $pdf->Image(getParam(19), 15, 10, 30, 45);
                $pdf->SetXY(55, 35);
                $pdf->SetFont('Arial', 'B', 14);
                $pdf->MultiCell(120, 5, utf8_decode("CONSTANCIA DE INEXISTENCIA DE REGISTRO DE DECLARACIÓN PATRIMONIAL"), 0, 'L');
                $pdf->SetXY(15, 65);
                $pdf->SetFont('Arial', '', 12);
                $exp = explode(" ", $data->Fecha_Proc);
                $date = explode("-", $exp[0]); 
                $time = explode(":", $exp[1]);
                $record = explode("-", ($data->Omision=="INICIAL"?$data->Fecha_Inicio:$data->Fecha_Termino));
                $pdf->MultiCell(180, 5, utf8_decode("En la ciudad de Guanajuato, Gto., siendo las " . DateFormat($data->Fecha_Proc, 2) . " " . FormatNum($time[0]) . " horas con " . FormatNum($time[1]) . " minutos del día " . $date[2] . " " . FormatNum($date[2]) . " de " . Month($date[1]) . " de " . $date[0] . " " . FormatNum($date[0]) . ", la suscrita " . getParam(1) . ", Directora de Asesoría Legal, Situación Patrimonial y Responsabilidades de la Secretaría de la Transparencia y Rendición de Cuentas, HAGO CONSTAR:"), 0, 'J');
                $pdf->Ln(8);
                $pdf->MultiCell(180, 5, utf8_decode("Que una vez verificado el reporte de servidores públicos omisos en la presentación de la declaración de situación patrimonial " . $data->Omision . " en la base de datos del Sistema Declaranet Guanajuato, correspondiente a " . $data->Dependencia . ", no se encontró registro de presentación de la declaración de situación patrimonial " . $data->Omision . " del servidor público " . $data->Nombre . ", con el cargo de " . $data->Puesto . ", quien de acuerdo con los datos obtenidos del mismo Sistema causó " . ($data->Omision=="INICIAL"?"alta":"baja") . " en fecha " . $record[2] . " " . FormatNum($record[2]) . " de " . Month($record[1]) . " de " . $record[0] . " " . FormatNum($record[0]) . "."), 0, 'J');
                $pdf->Ln(8);
                $pdf->MultiCell(180, 5, utf8_decode("Lo anterior con fundamento en los artículos 1,3 fracción I inciso b) numeral b1, 4, 13 fracción I y 15 fracciones VI, VII y XVII del Reglamento Interior de la Secretaría de la Transparencia y Rendición de Cuentas."), 0, 'J');
//                $pdf->Image($param[2], 80, $pdf->GetY()+10, 40, 80);
            break;
            case "Verificacion":
                $pdf->SetMargins(15, 15 , 15); 
                $pdf->AddPage();
                $pdf->Image(getParam(19), 15, 10, 30, 45);
                $pdf->SetXY(55, 25);
                $pdf->SetFont('Arial', 'B', 14);
                $pdf->MultiCell(140, 5, utf8_decode("PROCESO DE VERIFICACIÓN"), 0, 'R');
                $pdf->SetFont('Arial', '', 12);
                $pdf->SetXY(55, 35);
                $pdf->MultiCell(140, 5, utf8_decode($param['name']), 0, 'R');
                $pdf->SetXY(55, 40);
                $pdf->MultiCell(140, 5, utf8_decode($param['dep']), 0, 'R');
                $pdf->SetXY(55, 45);
                $pdf->MultiCell(140, 5, utf8_decode($param['pos']), 0, 'R');
                $pdf->SetXY(15, 60);
                $pdf->SetWidths(array(45, 45, 45, 45));
                
                foreach($data as $dec){
                    $pdf->SetFillColor(199, 209, 241);
                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->MultiCell(180, 5, utf8_decode($dec['type'] . " (" . $dec['date'] . ")"), 0, 'C', true);
                    $pdf->SetFillColor(209, 207, 209);
                    foreach($dec['elem'] as $k => $v){
                        $pdf->Ln(3);
                        $pdf->SetFont('Arial', '', 12);
                        $pdf->MultiCell(180, 5, utf8_decode($k), 0, 'C');
                        $pdf->Ln(3);
                        $pdf->Cell(45, 5, utf8_decode("Declarado"), 0, 0, 'C');
                        $pdf->Cell(45, 5, utf8_decode("Detalles"), 0, 0, 'C');
                        $pdf->Cell(45, 5, utf8_decode("Verificación"), 0, 0, 'C');
                        $pdf->Cell(45, 5, utf8_decode("Observaciones"), 0, 0, 'C');
                        $pdf->Ln(7);
                        $pdf->SetFont('Arial', '', 10);
                        $pdf->MultiCell(180, 5, utf8_decode("Declarante"), 0, 'L', true);
                        if($v['ME']){
                            foreach($v['ME'] as $e){
                                $inter = explode("<br>", InterpretElem($e));
                                $row[0] = "";
                                foreach($inter as $i)
                                    $row[0] .= utf8_decode (trim($i)) . "\n";
                                $inter = explode("<br>", InterpretTrans($e, $dec['type']));
                                $row[1] = "";
                                foreach($inter as $i)
                                    $row[1] .= utf8_decode (trim($i)) . "\n";
                                $row[2] = utf8_decode($e['Verificacion']);
                                $row[3] = utf8_decode($e['ObsSeg']);
                                $pdf->Row($row);
                            }
                        }else{
                            $pdf->Row(array("", "", "", ""));
                        }
                        
                        if($v['CONYUGE']){
                            $pdf->Ln(3);
                            $pdf->MultiCell(180, 5, utf8_decode("Cónyuge"), 0, 'L', true);
                            foreach($v['CONYUGE'] as $e){
                                $inter = explode("<br>", InterpretElem($e));
                                $row[0] = "";
                                foreach($inter as $i)
                                    $row[0] .= utf8_decode (trim($i)) . "\n";
                                $inter = explode("<br>", InterpretTrans($e, $dec['type']));
                                $row[1] = "";
                                foreach($inter as $i)
                                    $row[1] .= utf8_decode (trim($i)) . "\n";
                                $row[2] = utf8_decode($e['Verificacion']);
                                $row[3] = utf8_decode($e['ObsSeg']);
                                $pdf->Row($row);
                            }
                        }
                        
                        if($v['DEPEND']){
                            $pdf->Ln(3);
                            $pdf->MultiCell(180, 5, utf8_decode("Dependientes"), 0, 'L', true);
                            foreach($v['DEPEND'] as $e){
                                $inter = explode("<br>", InterpretElem($e));
                                $row[0] = "";
                                foreach($inter as $i)
                                    $row[0] .= utf8_decode (trim($i)) . "\n";
                                $inter = explode("<br>", InterpretTrans($e, $dec['type']));
                                $row[1] = "";
                                foreach($inter as $i)
                                    $row[1] .= utf8_decode (trim($i)) . "\n";
                                $row[2] = utf8_decode($e['Verificacion']);
                                $row[3] = utf8_decode($e['ObsSeg']);
                                $pdf->Row($row);
                            }
                        }
                        $pdf->Ln(5);
                    }
                    $pdf->Ln(7);
                }
            break;
            case "Declaracion":
                $page = 1;
                $pdf->SetMargins(15, 15 , 15); 
                $pdf->AddPage();
                $pdf->Image("img/Watermark.png", 15, 10, 180, 250);
                $pdf->SetXY(15, 20);
                $pdf->SetFont('Arial', 'B', 11);
                $pdf->SetTextColor(255);
                $pdf->SetFillColor(37, 171, 226);
                $pdf->MultiCell(0, 6, utf8_decode("Nuevo Declaranet Guanajuato"), 0, 'C', true);
                $pdf->MultiCell(0, 6, utf8_decode("Resúmen de declaración patrimonial"), 0, 'C', true);
                $pdf->Ln(5);
                $pdf->SetTextColor(0);
                $pdf->SetFont('Arial', 'B', 14);
                $pdf->MultiCell(180, 5, utf8_decode("DECLARACIÓN PATRIMONIAL " . $param['dec']), 0, 'R');
                $pdf->SetFont('Arial', '', 12);
                $pdf->Ln(1);
                $pdf->MultiCell(180, 5, utf8_decode($param['date']), 0, 'R');
                $pdf->Ln(1);
                $pdf->MultiCell(180, 5, utf8_decode($param['name']), 0, 'R');
                $pdf->Ln(1);
                $pdf->MultiCell(180, 5, utf8_decode($param['dep']), 0, 'R');
                $pdf->Ln(1);
                $pdf->MultiCell(180, 5, utf8_decode($param['pos']), 0, 'R');
                $pdf->Ln();
                $pdf->SetFillColor(209, 207, 209);
                foreach($data as $k => $v){
                    if($page < $pdf->PageNo()){
                       $page++;
                       $pdf->Image("img/Watermark.png", 15, 10, 180, 250);
                    }
                    $pdf->Ln(3);
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->MultiCell(180, 5, utf8_decode($k), 0, 'C');
                    $pdf->Ln(3);
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->MultiCell(180, 5, utf8_decode("Declarante"), 0, 'L', true);
                    if($v['ME']){
                        foreach($v['ME'] as $e){
                            $txt = "";
                            $inter = explode("<br>", InterpretElem($e));
                            foreach($inter as $i)
                                $txt .= ($i?utf8_decode(trim($i)) . ", ":"");
                            $pdf->MultiCell(180, 7, substr($txt, 0, -2), 'LTR', 'L');
                            if(!in_array($k, array("INGRESOS", "PENSIONES"))){
                                $pdf->SetFont('Arial', 'B');
                                $pdf->MultiCell(180, 7, utf8_decode("DETALLES DE OPERACIÓN:"), 'LR', 'L');
                                $pdf->SetFont('Arial', '');
                            }
                            $txt = "";
                            $inter = explode("<br>", InterpretTrans($e, $param['dec']));
                            foreach($inter as $i)
                                $txt .= ($i?utf8_decode (trim($i)) . ", ":"");
                            $pdf->MultiCell(180, 7, substr($txt, 0, -2), 'LBR', 'L');
                        }
                    }else
                        $pdf->MultiCell(180, 7, "", 1, 'L');

                    if($v['CONYUGE']){
                        $pdf->Ln(3);
                        $pdf->MultiCell(180, 5, utf8_decode("Cónyuge"), 0, 'L', true);
                        foreach($v['CONYUGE'] as $e){
                            $txt = "";
                            $inter = explode("<br>", InterpretElem($e));
                            foreach($inter as $i)
                                $txt .= ($i?utf8_decode(trim($i)) . ", ":"");
                            $pdf->MultiCell(180, 7, substr($txt, 0, -2), 'LTR', 'L');
                            if($k != "INGRESOS"){
                                $pdf->SetFont('Arial', 'B');
                                $pdf->MultiCell(180, 7, utf8_decode("DETALLES DE OPERACIÓN:"), 'LR', 'L');
                                $pdf->SetFont('Arial', '');
                            }
                            $txt = "";
                            $inter = explode("<br>", InterpretTrans($e, $param['dec']));
                            foreach($inter as $i)
                                $txt .= ($i?utf8_decode (trim($i)) . ", ":"");
                            $pdf->MultiCell(180, 7, substr($txt, 0, -2), 'LBR', 'L');
                        }
                    }

                    if($v['DEPEND']){
                        $pdf->Ln(3);
                        $pdf->MultiCell(180, 5, utf8_decode("Dependientes"), 0, 'L', true);
                        foreach($v['DEPEND'] as $e){
                            $txt = "";
                            $inter = explode("<br>", InterpretElem($e));
                            foreach($inter as $i)
                                $txt .= ($i?utf8_decode(trim($i)) . ", ":"");
                            $pdf->MultiCell(180, 7, substr($txt, 0, -2), 'LTR', 'L');
                            if($k != "INGRESOS"){
                                $pdf->SetFont('Arial', 'B');
                                $pdf->MultiCell(180, 7, utf8_decode("DETALLES DE OPERACIÓN:"), 'LR', 'L');
                                $pdf->SetFont('Arial', '');
                            }
                            $txt = "";
                            $inter = explode("<br>", InterpretTrans($e, $param['dec']));
                            foreach($inter as $i)
                                $txt .= ($i?utf8_decode (trim($i)) . ", ":"");
                            $pdf->MultiCell(180, 7, substr($txt, 0, -2), 'LBR', 'L');
                        }
                    }
                    $pdf->Ln(5);
                }
//                $pdf->Ln(5);
//                $pdf->SetFont('Arial', 'I', 10);
//                $pdf->MultiCell(180, 7, utf8_decode("\"2014, Año de Efraín Huerta\"") , 0, 'C');
//                $pdf->Ln(3);
//                $pdf->MultiCell(180, 7, utf8_decode("\"Únete Guanajuato. Por el derecho de las mujeres a una vida libre de violencia\"") , 0, 'C');
                
            break;
    }
    $path = "documents/".$doc."_".$id.".pdf";
    $pdf->Output($path);
    return $path;
}

function FormatNum($num){
    return trim(strtolower(str_replace("pesos /100 M.N.", "", num2letras($num))));
}

?>
