<?php
// Check existence of rut parameter before processing further
if(isset($_GET["rut"]) && !empty(trim($_GET["rut"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM trabajador WHERE rut = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_rut);
        
        // Set parameters
        $param_rut = trim($_GET["rut"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use a while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field values
                $rut = $row["rut"];
                $nombre = $row["nombre"];
                $especialidad = $row["especialidad"];
            } else{
                // URL doesn't contain a valid rut parameter. Redirect to the error page
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
    // URL doesn't contain a rut parameter. Redirect to the error page
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
                        <label>RUT</label>
                        <p><b><?php echo $row["rut"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Nombre</label>
                        <p><b><?php echo $row["nombre"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Especialidad</label>
                        <p><b><?php echo $row["especialidad"]; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>