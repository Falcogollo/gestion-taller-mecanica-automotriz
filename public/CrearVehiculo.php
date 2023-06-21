<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$patente = $modelo = $estado = $detalle = $fkid_cliente = "";
$patente_err = $modelo_err = $estado_err = $detalle_err = $fkid_cliente_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Patente
    $input_patente = trim($_POST["patente"]);
    if (empty($input_patente)) {
        $patente_err = "Por favor ingresa la Patente.";
    } else {
        $patente = $input_patente;
    }

    // Validate Modelo
    $input_modelo = trim($_POST["modelo"]);
    if (empty($input_modelo)) {
        $modelo_err = "Por favor ingresa el Modelo.";
    } else {
        $modelo = $input_modelo;
    }

    // Validate Estado
    $input_estado = trim($_POST["estado"]);
    if (empty($input_estado)) {
        $estado_err = "Por favor ingresa el Estado.";
    } else {
        $estado = $input_estado;
    }

    // Validate Detalle
    $input_detalle = trim($_POST["detalle"]);
    if (empty($input_detalle)) {
        $detalle_err = "Por favor ingresa el Detalle.";
    } else {
        $detalle = $input_detalle;
    }

    // Validate FKID_Cliente
    $input_fkid_cliente = trim($_POST["fkid_cliente"]);
    if (empty($input_fkid_cliente)) {
        $fkid_cliente_err = "Por favor ingresa el ID del Cliente.";
    } else {
        $fkid_cliente = $input_fkid_cliente;
    }

    // Check input errors before inserting in database
    if (empty($patente_err) && empty($modelo_err) && empty($estado_err) && empty($detalle_err) && empty($fkid_cliente_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO vehiculo (patente, modelo, estado, detalle, fkid_cliente) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_patente, $param_modelo, $param_estado, $param_detalle, $param_fkid_cliente);
            // Set parameters
            $param_patente = $patente;
            $param_modelo = $modelo;
            $param_estado = $estado;
            $param_detalle = $detalle;
            $param_fkid_cliente = $fkid_cliente;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: CrudVehiculo.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crear Vehiculo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
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
                    <h2>Crear Vehiculo</h2>
                    <p>Por favor complete este formulario para agregar un nuevo vehiculo a la base de datos.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($patente_err)) ? 'has-error' : ''; ?>">
                            <label>Patente</label>
                            <input type="text" name="patente" class="form-control" value="<?php echo $patente; ?>">
                            <span class="help-block"><?php echo $patente_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($modelo_err)) ? 'has-error' : ''; ?>">
                            <label>Modelo</label>
                            <input type="text" name="modelo" class="form-control" value="<?php echo $modelo; ?>">
                            <span class="help-block"><?php echo $modelo_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($estado_err)) ? 'has-error' : ''; ?>">
                            <label>Estado</label>
                            <input type="text" name="estado" class="form-control" value="<?php echo $estado; ?>">
                            <span class="help-block"><?php echo $estado_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($detalle_err)) ? 'has-error' : ''; ?>">
                            <label>Detalle</label>
                            <input type="text" name="detalle" class="form-control" value="<?php echo $detalle; ?>">
                            <span class="help-block"><?php echo $detalle_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($fkid_cliente_err)) ? 'has-error' : ''; ?>">
                            <label>ID Cliente</label>
                            <input type="text" name="fkid_cliente" class="form-control" value="<?php echo $fkid_cliente; ?>">
                            <span class="help-block"><?php echo $fkid_cliente_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Guardar">
                        <a href="CrudVehiculo.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>