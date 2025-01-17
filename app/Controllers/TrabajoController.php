<?php
namespace App\Controllers;

use App\Models\Trabajos;
use App\Controllers\BaseController;

require_once __DIR__ . '/../lib/conectar.php';

class TrabajoController extends BaseController
{
    public function anadirTrabajoAction()
    {
        if (!isset($_SESSION['id'])) {
            header('Location: /');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'] ?? null;
            $descripcion = $_POST['descripcion'] ?? null;
            $fecha_inicio = $_POST['fecha_inicio'] ?? null;
            $fecha_final = $_POST['fecha_final'] ?? null;
            $logros = $_POST['logros'] ?? null;
            $visible = 1;
            $usuarios_id = $_SESSION['id'];
            $trabajo = Trabajos::getInstancia();
            $trabajo->anadirTrabajo($titulo, $descripcion, $fecha_inicio, $fecha_final, $logros, $visible, $usuarios_id);
            header('Location: /edit');
        } else {
            $this->renderHTML('../views/new_trabajo.php');
        }
    }

    public function editarTrabajo(){
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id) {
            echo "<h2>ID no proporcionado</h2>";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'] ?? null;
            $descripcion = $_POST['descripcion'] ?? null;
            $fecha_inicio = $_POST['fecha_inicio'] ?? null;
            $fecha_final = $_POST['fecha_final'] ?? null;
            $logros = $_POST['logros'] ?? null;
            $visible = isset($_POST['visible']) ? 1 : 0;
            $usuarios_id = $_SESSION['id'];
            $trabajo = Trabajos::getInstancia();
            $trabajo->editarTrabajo($id, $titulo, $descripcion, $fecha_inicio, $fecha_final, $logros, $visible, $usuarios_id);
            header('Location: /edit');
        } else {
            $trabajo = Trabajos::getInstancia();
            $trabajo = $trabajo->getTrabajosPorUsuariosId($_SESSION['id']);
            $this->renderHTML('../views/edit_trabajo_view.php', [
                'trabajo' => $trabajo,
            ]);
        }
    }
    
    public function eliminarTrabajo()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id) {
            echo "<h2>ID no proporcionado</h2>";
            return;
        }
        
        $trabajo = Trabajos::getInstancia();
        $trabajo->eliminarTrabajo($id);

        if ($trabajo->getMensaje() == 'Trabajo eliminado') {
            header('Location: /edit');
        } else {
            echo "<h2>Error al eliminar el trabajo</h2>";
        }
    }

}