<?php
use App\Models\Trabajos;

$titulo = $_POST['titulo'] ?? null;
$fecha_inicio = $_POST['fecha_inicio'] ?? null;
$fecha_final = $_POST['fecha_final'] ?? null;
$descripcion = $_POST['descripcion'] ?? null;
$claseTrabajo = Trabajos::getInstancia();
$claseTrabajo->set($titulo, $descripcion, $fecha_inicio, $fecha_final, $usuario['id']);
if ($claseUsuario->getMensaje() == 'Trabajo añadido') {
    echo "<h2>" . $claseUsuario->getMensaje() . "</h2>";
} else {
    echo "<h2>" . $claseUsuario->getMensaje() . "</h2>";
}