<?php
//Comprobar la conexión a la base de datos

require '../../app/lib/conectar.php';

try {
    $db = conectaDB();
    echo "Conexión a la base de datos exitosa.";
} catch (Exception $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}