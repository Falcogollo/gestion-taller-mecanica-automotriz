<?php
// Check existence of id parameter before processing further
if(isset($_GET["id_orden_trabajo"]) && !empty(trim($_GET["id_orden_trabajo"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM orden_de_trabajo WHERE id_orden_trabajo = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id_orden_trabajo"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $idcliente = $row["id_orden_trabajo"];
                $FechaCreacion = $row["fecha_creacion"];
                $FechaActual= $row["fecha_actual"];
                $FechaEstimada = $row["fecha_estimada"];
                $Descripcion = $row["descripcion"];
                $Estado = $row["estado"];
                $fkCliente = $row["fkid_cliente"];
                $fkPatente = $row["fkid_patente"];
                $fkRut = $row["fkrut"];
                


            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 10000px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Id orden trabajo</label>
                        <p><b><?php echo $row["id_orden_trabajo"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Fecha Creacion</label>
                        <p><b><?php echo $row["fecha_creacion"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Fecha actual</label>
                        <p><b><?php echo $row["fecha_actual"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Fecha estimada de termino</label>
                        <p><b><?php echo $row["fecha_estimada"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Descripcion</label>
                        <p><b><?php echo $row["descripcion"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <p><b><?php echo $row["estado"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Nombre Cliente</label>
                        <p><b><?php echo $row["fkid_cliente"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Vehiculo</label>
                        <p><b><?php echo $row["fkid_patente"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Trabajador</label>
                        <p><b><?php echo $row["fkrut"]; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Volver</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>