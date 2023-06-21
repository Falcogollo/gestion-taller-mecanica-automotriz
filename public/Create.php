<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$idOrdenTrabajo = $fechaCreacion = $fechaActual = $fechaEstimada = $descripcion = $estado = $idcliente = $idpatente = $rut = "";
$idOrdenTrabajo_err = $fechaCreacion_err = $fechaActual_err = $fechaEstimada_err = $descripcion_err = $estado_err = $idcliente_err = $idpatente_err = $rut_err = "";
 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate ID Orden de Trabajo
    $input_idOrdenTrabajo = trim($_POST["id_orden_trabajo"]);
    if (empty($input_idOrdenTrabajo)) {
        $idOrdenTrabajo_err = "Por favor ingresa el ID de la Orden de Trabajo.";
    } else {
        $idOrdenTrabajo = $input_idOrdenTrabajo;
    }

    // Validate Fecha Creacion
    $input_fechaCreacion = trim($_POST["fecha_creacion"]);
    if (empty($input_fechaCreacion)) {
        $fechaCreacion_err = "Por favor ingresa la Fecha de Creación.";
    } else {
        $fechaCreacion = $input_fechaCreacion;
    }

    // Validate Fecha actual
    $input_fechaActual = trim($_POST["fecha_actual"]);
    if (empty($input_fechaActual)) {
        $fechaActual_err = "Por favor ingresa la Fecha Actual.";
    } else {
        $fechaActual = $input_fechaActual;
    }

    // Validate Fecha Estimada
    $input_fechaEstimada = trim($_POST["fecha_estimada"]);
    if (empty($input_fechaEstimada)) {
        $fechaEstimada_err = "Por favor ingresa la Fecha Estimada.";
    } else {
        $fechaEstimada = $input_fechaEstimada;
    }

    // Validate Descripcion
    $input_descripcion = trim($_POST["descripcion"]);
    if (empty($input_descripcion)) {
        $descripcion_err = "Por favor ingresa la Descripción.";
    } else {
        $descripcion = $input_descripcion;
    }

    // Validate Estado
    $input_estado = trim($_POST["estado"]);
    if (empty($input_estado)) {
        $estado_err = "Por favor ingresa el Estado.";
    } else {
        $estado = $input_estado;
    }

    // Validate ID Cliente
    $input_idcliente = trim($_POST["fkid_cliente"]);
    if (empty($input_idcliente)) {
        $idcliente_err = "Por favor ingresa el ID del Cliente.";
    } else {
        $idcliente = $input_idcliente;
    }

    // Validate Patente
    $input_idpatente = trim($_POST["fkid_patente"]);
    if (empty($input_idpatente)) {
        $idpatente_err = "Por favor ingresa la Patente.";
    } else {
        $idpatente = $input_idpatente;
    }

    // Validate Rut
    $input_rut = trim($_POST["fkrut"]);
    if (empty($input_rut)) {
        $rut_err = "Por favor ingresa el Rut.";
    } else {
        $rut = $input_rut;
    }
    
    // Check input errors before inserting in database
    if (empty($idOrdenTrabajo_err) && empty($fechaCreacion_err) && empty($fechaActual_err) && empty($fechaEstimada_err) && empty($descripcion_err) && empty($estado_err) && empty($idcliente_err) && empty($idpatente_err) && empty($rut_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO orden_de_trabajo (id_orden_trabajo, fecha_creacion, fecha_actual, fecha_estimada, descripcion, estado, fkid_cliente, fkid_patente, fkrut) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
         
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssss", $param_idOrdenTrabajo, $param_fechaCreacion, $param_fechaActual, $param_fechaEstimada, $param_descripcion, $param_estado, $param_idcliente, $param_idpatente, $param_rut);
            // Set parameters
            $param_idOrdenTrabajo = $idOrdenTrabajo;
            $param_fechaCreacion = $fechaCreacion;
            $param_fechaActual = $fechaActual;
            $param_fechaEstimada = $fechaEstimada;
            $param_descripcion = $descripcion;
            $param_estado = $estado;
            $param_idcliente = $idcliente;
            $param_idpatente = $idpatente;
            $param_rut = $rut;
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
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

$query = "SELECT rut, nombre FROM cliente";
$result = mysqli_query($link, $query);

// Verifica si la consulta devuelve resultados
if ($result) {
    // Crea arrays para almacenar los datos de los clientes
    $clientes = array();

    // Recorre los resultados y almacena los datos en el array de clientes
    while ($row = mysqli_fetch_assoc($result)) {
        $clientes[$row['rut']] = $row['nombre'];
    }
} else {
    echo 'Error en la consulta de clientes: ' . mysqli_error($link);
}

// Realiza la consulta para obtener los datos de las patentes
$query = "SELECT patente, modelo FROM vehiculo";
$result = mysqli_query($link, $query);

// Verifica si la consulta devuelve resultados
if ($result) {
    // Crea arrays para almacenar los datos de las patentes
    $patentes = array();

    // Recorre los resultados y almacena los datos en el array de patentes
    while ($row = mysqli_fetch_assoc($result)) {
        $patentes[$row['patente']] = $row['modelo'];
    }
} else {
    echo 'Error en la consulta de patentes: ' . mysqli_error($link);
}

// Realiza la consulta para obtener los datos de los trabajadores
$query = "SELECT rut, nombre FROM trabajador";
$result = mysqli_query($link, $query);

// Verifica si la consulta devuelve resultados
if ($result) {
    // Crea arrays para almacenar los datos de los trabajadores
    $trabajadores = array();

    // Recorre los resultados y almacena los datos en el array de trabajadores
    while ($row = mysqli_fetch_assoc($result)) {
        $trabajadores[$row['rut']] = $row['nombre'];
    }
} else {
    echo 'Error en la consulta de trabajadores: ' . mysqli_error($link);
}

// Cierra la conexión a la base de datos
mysqli_close($link);
?>


 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Crear Orden De trabajo</title>
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
                    <h2 class="mt-5">Crear Orden De trabajo</h2>
                    <p>Ingrese los datos de la Orden de trabajo.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>ID Orden de Trabajo</label>
                            <input type="text" name="id_orden_trabajo" class="form-control <?php echo (!empty($idOrdenTrabajo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $idOrdenTrabajo; ?>">
                            <span class="invalid-feedback"><?php echo $idOrdenTrabajo_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Fecha Creacion</label>
                            <input type="date" name="fecha_creacion" class="form-control <?php echo (!empty($fechaCreacion_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fechaCreacion; ?>">
                            <span class="invalid-feedback"><?php echo $fechaCreacion_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Fecha actual</label>
                            <input type="date" name="fecha_actual" class="form-control <?php echo (!empty($fechaActual_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fechaActual; ?>">
                            <span class="invalid-feedback"><?php echo $fechaActual_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Fecha Estimada</label>
                            <input type="date" name="fecha_estimada" class="form-control <?php echo (!empty($fechaEstimada_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fechaEstimada; ?>">
                            <span class="invalid-feedback"><?php echo $fechaEstimada_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Descripcion</label>
                            <textarea name="descripcion" class="form-control <?php echo (!empty($descripcion_err)) ? 'is-invalid' : ''; ?>"><?php echo $descripcion; ?></textarea>
                            <span class="invalid-feedback"><?php echo $descripcion_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>estado</label>
                            <input type="number" name="estado" class="form-control <?php echo (!empty($estado_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $estado; ?>">
                            <span class="invalid-feedback"><?php echo $estado_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Cliente</label>
                            <select name="fkid_cliente" class="form-control <?php echo (!empty($idcliente_err)) ? 'is-invalid' : ''; ?>">
                                <?php
                                // Genera las opciones de la lista desplegable para los clientes
                                foreach ($clientes as $rut => $nombre) {
                                    echo "<option value='$rut'>$nombre</option>";
                                }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $idcliente_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label>Vehiculo</label>
                            <select name="fkid_patente" class="form-control <?php echo (!empty($idpatente_err)) ? 'is-invalid' : ''; ?>">
                                <?php
                                // Genera las opciones de la lista desplegable para las patentes
                                foreach ($patentes as $patente => $modelo) {
                                    echo "<option value='$patente'>$modelo</option>";
                                }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $idpatente_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label>Trabajador</label>
                            <select name="fkrut" class="form-control <?php echo (!empty($rut_err)) ? 'is-invalid' : ''; ?>">
                                <?php
                                // Genera las opciones de la lista desplegable para los ruts
                                foreach ($trabajadores as $rut => $nombre) {
                                    echo "<option value='$rut'>$nombre</option>";
                                }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $rut_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Ingresar">
                        <a href="vista.php" class="btn btn-secondary ml-2">Volver</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>