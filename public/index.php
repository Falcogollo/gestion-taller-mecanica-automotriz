<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 1000px;
            margin:  auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Ordenes de trabajo</h2>
                        <a href="create.php" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Agregar </a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT orden_de_trabajo.id_orden_trabajo, orden_de_trabajo.fecha_creacion, orden_de_trabajo.fecha_actual, orden_de_trabajo.fecha_estimada, orden_de_trabajo.descripcion, orden_de_trabajo.estado, cliente.nombre AS nombre_cliente, vehiculo.modelo AS modelo_vehiculo, trabajador.nombre AS nombre_trabajador
                    FROM orden_de_trabajo
                    JOIN cliente ON orden_de_trabajo.fkid_cliente = cliente.rut
                    JOIN vehiculo ON orden_de_trabajo.fkid_patente = vehiculo.patente
                    JOIN trabajador ON orden_de_trabajo.fkrut = trabajador.rut;";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>id_orden_trabajo</th>";
                                        echo "<th>Fecha Creacion</th>";
                                        echo "<th>Fecha Actual</th>";
                                        echo "<th>Fecha Estimada</th>";
                                        echo "<th>Descripcion</th>";
                                        echo "<th>estado</th>";
                                        echo "<th>Cliente</th>";
                                        echo "<th>Patente</th>";
                                        echo "<th>Trabajador</th>";
                                        echo "<th>Acciones</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id_orden_trabajo'] . "</td>";
                                        echo "<td>" . $row['fecha_creacion'] . "</td>";
                                        echo "<td>" . $row['fecha_actual'] . "</td>";
                                        echo "<td>" . $row['fecha_estimada'] . "</td>";
                                        echo "<td>" . $row['descripcion'] . "</td>";
                                        echo "<td>" . $row['estado'] . "</td>";
                                        echo "<td>" . $row['nombre_cliente'] . "</td>";
                                        echo "<td>" . $row['modelo_vehiculo'] . "</td>";
                                        echo "<td>" . $row['nombre_trabajador'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id_orden_trabajo='. $row['id_orden_trabajo'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?id_orden_trabajo='. $row['id_orden_trabajo'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?id_orden_trabajo='. $row['id_orden_trabajo'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>