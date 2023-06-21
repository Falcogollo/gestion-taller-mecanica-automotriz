<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$nombre = $especialidad = "";
$nombre_err = $especialidad_err = "";
 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get hidden input value
    $id = $_POST["rut"];
    
    // Validate name
    $input_nombre = trim($_POST["nombre"]);
    if (empty($input_nombre)) {
        $nombre_err = "Please enter a name.";
    } else {
        $nombre = $input_nombre;
    }
    
    // Validate specialty
    $input_especialidad = trim($_POST["especialidad"]);
    if (empty($input_especialidad)) {
        $especialidad_err = "Please enter a specialty.";
    } else {
        $especialidad = $input_especialidad;
    }
    
    // Check input errors before updating in the database
    if (empty($nombre_err) && empty($especialidad_err)) {
        // Prepare an update statement
        $sql = "UPDATE trabajador SET nombre=?, especialidad=? WHERE rut=?";
         
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssi", $param_nombre, $param_especialidad, $param_id);
            
            // Set parameters
            $param_nombre = $nombre;
            $param_especialidad = $especialidad;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records updated successfully. Redirect to landing page
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
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["rut"]) && !empty(trim($_GET["rut"]))) {
        // Get URL parameter
        $id =  trim($_GET["rut"]);
        
        // Prepare a select statement
        $sql = "SELECT nombre, especialidad FROM trabajador WHERE rut = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
    
                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $nombre = $row["nombre"];
                    $especialidad = $row["especialidad"];
                } else {
                    // URL doesn't contain a valid id. Redirect to error page
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
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control <?php echo (!empty($nombre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nombre; ?>">
                            <span class="invalid-feedback"><?php echo $nombre_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Especialidad</label>
                            <input type="text" name="especialidad" class="form-control <?php echo (!empty($especialidad_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $especialidad; ?>">
                            <span class="invalid-feedback"><?php echo $especialidad_err; ?></span>
                        </div>
                        <input type="hidden" name="rut" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="CrudTrabajador.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>