<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$rut = $nombre = $especialidad = "";
$rut_err = $nombre_err = $especialidad_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Rut
    $input_rut = trim($_POST["rut"]);
    if (empty($input_rut)) {
        $rut_err = "Por favor ingresa el Rut.";
    } else {
        $rut = $input_rut;
    }

    // Validate Nombre
    $input_nombre = trim($_POST["nombre"]);
    if (empty($input_nombre)) {
        $nombre_err = "Por favor ingresa el Nombre.";
    } else {
        $nombre = $input_nombre;
    }

    // Validate Especialidad
    $input_especialidad = trim($_POST["especialidad"]);
    if (empty($input_especialidad)) {
        $especialidad_err = "Por favor ingresa la Especialidad.";
    } else {
        $especialidad = $input_especialidad;
    }

    // Check input errors before inserting in database
    if (empty($rut_err) && empty($nombre_err) && empty($especialidad_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO trabajador (rut, nombre, especialidad) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_rut, $param_nombre, $param_especialidad);
            // Set parameters
            $param_rut = $rut;
            $param_nombre = $nombre;
            $param_especialidad = $especialidad;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: CrudTrabajador.php");
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
    <title>Crear Trabajador</title>
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
                    <h2>Crear Trabajador</h2>
                    <p>Por favor complete el formulario para agregar un nuevo trabajador.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($rut_err)) ? 'has-error' : ''; ?>">
                            <label>Rut</label>
                            <input type="text" name="rut" class="form-control" value="<?php echo $rut; ?>">
                            <span class="help-block"><?php echo $rut_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($nombre_err)) ? 'has-error' : ''; ?>">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $nombre; ?>">
                            <span class="help-block"><?php echo $nombre_err; ?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($especialidad_err)) ? 'has-error' : ''; ?>">
                            <label>Especialidad</label>
                            <input type="text" name="especialidad" class="form-control" value="<?php echo $especialidad; ?>">
                            <span class="help-block"><?php echo $especialidad_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Ingresar">
                        <a href="crudtrabajador.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>