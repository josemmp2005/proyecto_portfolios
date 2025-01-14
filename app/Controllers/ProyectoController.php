<?php
namespace App\Controllers;

use App\Models\Usuarios;
use App\Models\Trabajos;
use App\Controllers\BaseController;
use App\Models\Proyectos;

require_once __DIR__ . '/../lib/generar_token.php';
require_once __DIR__ . '/../lib/conectar.php';

use PDO;
use PDOException;

class ProyectoController extends BaseController
{
    public function anadirProyectoAction(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['id'])) {
                header('Location: /');
                return;
            }
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $logo = $_POST['logo'];
            $tecnologias = $_POST['tecnologias'];
            $visible = 1;
            $usuarios_id = $_SESSION['id'];
            $proyecto = Proyectos::getInstancia();
            $proyecto-> anadirProyecto($titulo, $descripcion, $logo, $tecnologias, $visible, $usuarios_id);
            header('Location: /edit');
        }else{
            $this->renderHTML('../views/new_proyecto.php');
        }
    }

    public function eliminarProyecto() {
        // Lógica para eliminar el proyecto de la base de datos
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /edit');
            return;
        }
        $proyecto = Proyectos::getInstancia();
        $proyecto->eliminarProyecto($id);
        // Redirigir a la vista de proyectos después de eliminar
        header('Location: /edit');
    }
}