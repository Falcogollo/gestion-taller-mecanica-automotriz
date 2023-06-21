<?php

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


$select ="select * from orden_de_trabajo";


if (mysqli_query($conectar, $select)) {
    header('Location: vista.php');
    //crear advertencia
    exit();
} else {
    echo "Error al seleccionar el dato: " . mysqli_error($conectar);
}



?>