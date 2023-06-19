<?php
//require 'conexion.php';

$host = "localhost";
$user = "root";
$clave = "";
$bd = "taller";

$conectar = mysqli_connect($host,$user,$clave,$bd);



$id_orden = $_POST['idOrden'];
$fecha_creacion = $_POST['fechaCreacion'];
$fecha_actual = $_POST['fechaActual'];
$fecha_estimada = $_POST['fechaEstimada'];
$descripcion = $_POST['descripcion'];
$estado = $_POST['estadoProceso'];


$insertar = "INSERT INTO orden_de_trabajo(id_orden_trabajo,fecha_creacion,fecha_actual,fecha_estimada,descripcion,estado) VALUES ('$id_orden','$fecha_creacion','$fecha_actual','$fecha_estimada','$descripcion','$estado') ";


//$query = mysqli_query($conectar,$insertar);

if (mysqli_query($conectar, $insertar)) {
    header('Location: vista.html');
    //crear advertencia
    exit();
} else {
    echo "Error al insertar el dato: " . mysqli_error($conectar);
}

//var_dump($_POST);


?>