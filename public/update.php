<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";

$estado = 0;
$fecha_estimada = $descripcion  =  "";
$fecha_estimada_err = $descripcion_err = $estado_err =  "";

// Processing form data when form is submitted
if(isset($_POST["id_orden_trabajo"]) && ! empty($_POST["id_orden_trabajo"])){
    // Get hidden input value
    $id_orden = $_POST["id_orden_trabajo"];

    // Validate descripcion
    $input_descripcion = trim($_POST["descripcion"]);
    if(empty($input_descripcion)){
        $descripcion_err = "ingrese descripcion";
    } elseif(!filter_var($input_descripcion, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $descripcion_err = "ingrese descripcion con caracteres validos";
    } else{
        $descripcion = $input_descripcion;
    }

    /* Validate fechaestimada > fechaactual
         $input_fecha = trim($_POST["fecha_estimada"]);
        if(empty($input_fecha)){
         $fecha_estimada_err = "ingrese una fecha valida";
        } else{
       $fecha_estimada = $input_fecha;
    */

    // Validate estado int
    $input_estado = trim($_POST["estado"]);
    if(empty($input_estado)){
        $estado_err = "ingrese un estado";
    } elseif(!ctype_digit($input_estado) ){
        $estado_err = "ingrese un estado valido 1.- no iniciado ,2.- en curso, 3.- finalizado";
    } else{
        $estado = $input_estado;
    }
    echo "antes de valida correcta";
    // verificar errores
    if(empty($descripcion_err) && empty($estado_err)){
        //actualizar orden
        echo "validacion correcta";

        //  $sql = "UPDATE employees SET name=?, address=?, salary=? WHERE id=?";
        $sql = "UPDATE orden_de_trabajo SET fecha_estimada=?, descripcion=?, estado=? WHERE id_orden_trabajo=?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_fechaEstimada, $param_descripcion, $param_estado, $param_id);

            // Set parameters
            $param_fechaEstimada = $fecha_estimada;
            $param_descripcion = $descripcion;
            $param_estado = $estado;
            $param_id = $id_orden;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
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
    if(isset($_GET["id_orden_trabajo"]) && !empty(trim($_GET["id_orden_trabajo"]))){
        // Get URL parameter
        $id =  trim($_GET["id_orden_trabajo"]);

        // Prepare a select statement
        $sql = "SELECT * FROM orden_de_trabajo WHERE id_orden_trabajo = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $fecha_estimada = $row["fecha_estimada"];
                    $descripcion = $row["descripcion"];
                    $estado = $row["estado"];
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
    }  else{
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
    <title>Actualizar orden de trabajo</title>
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
                <h2 class="mt-5">Actualizar Orden de trabajo</h2>
                <p>Ingrese los datos correspondidos para actualizar Orden de trabajo.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group">
                        <label>Fecha Estimada</label>
                        <input type="date" name="name" class="form-control">
                        <span class="invalid-feedback"><?php echo $name_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Descripcion</label>
                        <textarea name="descripcion" class="form-control <?php echo (!empty($descripcion_err)) ? 'is-invalid' : ''; ?>"><?php echo $descripcion; ?></textarea>
                        <span class="invalid-feedback"><?php echo $descripcion_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Estado</label>
                        <input type="text" name="estado" class="form-control <?php echo (!empty($estado_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $estado; ?>">
                        <span class="invalid-feedback"><?php echo $estado_err;?></span>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="submit" class="btn btn-primary" value="Actualizar">
                    <a href="vista.php" class="btn btn-secondary ml-2">Volver</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>