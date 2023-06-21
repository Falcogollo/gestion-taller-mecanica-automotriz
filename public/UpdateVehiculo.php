<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$modelo = $estado = $detalle = "";
$modelo_err = $estado_err = $detalle_err = "";

// Processing form data when form is submitted
if(isset($_POST["patente"]) && !empty($_POST["patente"])){
    // Get hidden input value
    $id_patente = $_POST["patente"];

    // Validate modelo
    $input_modelo = trim($_POST["modelo"]);
    if(empty($input_modelo)){
        $modelo_err = "Ingrese el modelo del vehículo";
    } else{
        $modelo = $input_modelo;
    }

    // Validate estado
    $input_estado = trim($_POST["estado"]);
    if(empty($input_estado)){
        $estado_err = "Ingrese el estado del vehículo";
    } else{
        $estado = $input_estado;
    }

    // Validate detalle
    $input_detalle = trim($_POST["detalle"]);
    if(empty($input_detalle)){
        $detalle_err = "Ingrese el detalle del vehículo";
    } else{
        $detalle = $input_detalle;
    }

    // Check input errors before updating the database
    if(empty($modelo_err) && empty($estado_err) && empty($detalle_err)){
        // Prepare an update statement
        $sql = "UPDATE vehiculo SET modelo = ?, estado = ?, detalle = ? WHERE patente = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_modelo, $param_estado, $param_detalle, $param_patente);

            // Set parameters
            $param_modelo = $modelo;
            $param_estado = $estado;
            $param_detalle = $detalle;
            $param_patente = $id_patente;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: CrudVehiculo.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["patente"]) && !empty(trim($_GET["patente"]))){
        // Get URL parameter
        $id_patente = trim($_GET["patente"]);

        // Prepare a select statement
        $sql = "SELECT * FROM vehiculo WHERE patente = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_patente);

            // Set parameters
            $param_patente = $id_patente;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array.
                    Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field values
                    $modelo = $row["modelo"];
                    $estado = $row["estado"];
                    $detalle = $row["detalle"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Actualizar vehículo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Actualizar vehículo</h2>
                    <p>Ingrese los datos correspondientes para actualizar el vehículo.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Modelo</label>
                            <input type="text" name="modelo" class="form-control <?php echo (!empty($modelo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $modelo; ?>">
                            <span class="invalid-feedback"><?php echo $modelo_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <input type="text" name="estado" class="form-control <?php echo (!empty($estado_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $estado; ?>">
                            <span class="invalid-feedback"><?php echo $estado_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Detalle</label>
                            <textarea name="detalle" class="form-control <?php echo (!empty($detalle_err)) ? 'is-invalid' : ''; ?>"><?php echo $detalle; ?></textarea>
                            <span class="invalid-feedback"><?php echo $detalle_err;?></span>
                        </div>
                        <input type="hidden" name="patente" value="<?php echo $id_patente; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Actualizar">
                        <a href="crudvehiculo.php" class="btn btn-secondary ml-2">Volver</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>