<?php
    require_once ('lib/DBConn.php');
    require_once ('lib/ext.php');
    require_once ('lib/templates.php');
    
    $context = new Context();
    $db = new DBConn();
    $action = showVar($_GET['action']);
    
    if($action == "search"){
        $dep = $_GET['dep'];
        
        $sql = "select p.ID_Serv, CONCAT_WS(' ', Paterno, Materno, Nombre) as Servidor, RFC, Puesto, Fecha_Inicio "
                . "from publicaciones p "
                . "join servpub sp on sp.ID_Serv = p.ID_Serv "
                . "join puestos pos on pos.ID_Puesto = sp.ID_Puesto "
                . "where Fecha_Oculta is null and ID_Dependencia = " . $dep . " "
                . "order by RFC";
        $cont = 1;
        foreach($db->getArray($sql) as $x){
            echo "<tr>"
                . "<td>" . $cont++ . "</td>"
                . "<td>" . $x['RFC'] . "</td>"
                . "<td>" . $x['Servidor'] . "</td>"
                . "<td>" . $x['Puesto'] . "</td>"
                . "<td>" . $x['Fecha_Inicio'] . "</td>"
                . "<td><a class = 'btn btn-success btn-sm download' id = '" . hideVar($x['ID_Serv']) . "'>Declaración</a></td>"
                . "</tr>";
        }
        
    }elseif($action == "download"){
        $id = showVar($_GET['id']);
        if(is_numeric($id)){
            
        }else
            echo "No se encontró la información relacionada";
        
    }elseif(!$action){
        $sql = "select * from dependencias where Activo = 1 order by Dependencia";
        $context->dep = $db->getArray($sql);
    
?>

<html>
    <head>
        <title>Declaración patrimonial pública</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type ="text/css" rel ="stylesheet" href ="css/bootstrap.css" />
        <link type ="text/css" rel ="stylesheet" href ="css/select2/select2.css" />
        <link type ="text/css" rel ="stylesheet" href ="css/font-awesome-4.2.0/css/font-awesome.css" />
        <link type ="text/css" rel ="stylesheet" href ="js/dataTables/css/jquery.dataTables.min.css" />
        
        <style type ="text/css">
            #panel-search {margin-bottom: 30px;}

        </style>
        
        <script src ="js/jquery-1.8.3.min.js"></script>
        <script src ="js/bootstrap.js"></script>
        <script src ="js/select2.js"></script>
        <script src ="js/dataTables/jquery.dataTables.min.js"></script>
        
        <script type="text/javascript">
            $(function(){
                
                $('.select2').select2({
                        width: 'element',
                        placeholder: "Seleccione..."
                }).on('change', function(e){ 
                    $('#tbl-list tbody').load('?action=<?=hideVar('search')?>&dep=' + $(this).val(), function(){
                        $('.download').on('click', function(){
                           LoadButton($(this));
                        });
                    });
                });
                
                $('#tbl-list').DataTable({
                        "language": {
                          "sProcessing":     "Procesando...",
                          "sLengthMenu":     "Mostrar _MENU_ registros",
                          "sZeroRecords":    "No se encontraron resultados",
                          "sEmptyTable":     "Ningún registro encontrado",
                          "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                          "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                          "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                          "sInfoPostFix":    "",
                          "sSearch":         "Filtrar:",
                          "sUrl":            "",
                          "sInfoThousands":  ",",
                          "sLoadingRecords": "Cargando...",
                          "oPaginate": {
                              "sFirst":    "Primero",
                              "sLast":     "Último",
                              "sNext":     "Siguiente",
                              "sPrevious": "Anterior"
                          },
                          "oAria": {
                              "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                              "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                          }
                      }
                  });
            });
            
            function LoadButton(obj){
                $(obj).html("<i class = 'fa fa-spinner fa-spin'></i> " + $(obj).text());
                $(obj).attr('disabled', 'disabled');
            }
        </script>
    </head>
    <body>
        <div class ="container">
            <div class="panel panel-primary">
                <div class="panel-heading"><h3>Declaración patrimonial pública</h3></div>
                <div class="panel-body">
                    <div class ="row" id ="panel-search">
                        <div class ="col-md-offset-3 col-md-2">
                            <label>Seleccione una dependencia</label>
                        </div>
                        <div class ="col-md-3">
                            <select class ="select2" id ="cmbDep" style ="width: 400px">
                                <option></option>
                                <?foreach($context->dep as $d){?>
                                <option value ="<?=$d['ID_Dependencia']?>"><?=$d['Dependencia']?></option>
                                <?}?>
                            </select>
                        </div>
                    </div>
                    <div class ="row">
                        <table id ="tbl-list" class ="table table-striped table-hover table-condensed">
                            <thead>
                            <th style ="width: 10px">#</th>
                            <th style ="width: 50px">RFC</th>
                            <th style ="width: 400px">Nombre</th>
                            <th style ="width: 300px">Puesto</th>
                            <th style ="width: 50px">Ingreso</th>
                            <th>Descargar</th>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </body>
</html>

<?}?>