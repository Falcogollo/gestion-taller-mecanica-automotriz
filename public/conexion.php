<?php

$host = "localhost";
$user = "KNDADMIN";
$clave = "KND.1029384756";
$bd = "tallergestion";



try{
    $conectar = new PDO("mysql:host=$host;bdname=$bd",$user,$clave);
    echo "conexion exitosa";
} catch (Exception $e){
    echo $e -> getMessage();
}


?>