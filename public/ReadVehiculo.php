<?php
// Check existence of id parameter before processing further
if (isset($_GET["patente"]) && !empty(trim($_GET["patente"]))) {
    // Include config file
    require_once "config.php";

    // Prepare a select statement
    $sql = "SELECT * FROM vehiculo WHERE patente = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_patente);

        // Set parameters
        $param_patente = trim($_GET["patente"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Retrieve individual field values
                $patente = $row["patente"];
                $modelo = $row["modelo"];
                $estado = $row["estado"];
                $detalle = $row["detalle"];
                $fkid_cliente = $row["fkid_cliente"];

            } else {
                // URL doesn't contain valid patente parameter. Redirect to error page
                header("location: error.php");
                exit();
            }

        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($link);
} else {
    // URL doesn't contain patente parameter. Redirect to error page
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
            width: 1000px;
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
                        <label>Patente</label>
                        <p><b><?php echo $row["patente"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Modelo</label>
                        <p><b><?php echo $row["modelo"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <p><b><?php echo $row["estado"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Detalle</label>
                        <p><b><?php echo $row["detalle"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Cliente</label>
                        <p><b><?php echo $row["fkid_cliente"]; ?></b></p>
                    </div>
                    <p><a href="CrudVehiculo.php" class="btn btn-primary">Volver</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>