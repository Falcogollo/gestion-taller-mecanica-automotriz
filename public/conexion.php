<?php

$host = "localhost";
$user = "root";
$clave = "";
$bd = "taller";



try{
    $conectar = new PDO("mysql:host=$host;bdname=$bd",$user,$clave);
    echo "conexion exitosa";
} catch (Exception $e){
    echo $e -> getMessage();
}


?>