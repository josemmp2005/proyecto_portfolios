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

    public function editarProyecto()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id) {
            echo "<h2>ID no proporcionado</h2>";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'] ?? null;
            $descripcion = $_POST['descripcion'] ?? null;
            $logo = $_POST['logo'] ?? null;
            $tecnologias = $_POST['tecnologias'] ?? null;
            $visible = isset($_POST['visible']) ? 1 : 0;
            $usuarios_id = $_SESSION['id'];
            $proyecto = Proyectos::getInstancia();
            $proyecto->editarProyecto($id, $titulo, $descripcion, $logo, $tecnologias, $visible, $usuarios_id);
            header('Location: /edit');
        } else {
            $proyecto = Proyectos::getInstancia();
            $proyecto = $proyecto->getProyectosPorUsuariosId($_SESSION['id']);
            $this->renderHTML('../views/edit_proyecto_view.php', [
                'proyecto' => $proyecto,
            ]);
        }
    }
    public function eliminarProyecto()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id) {
            echo "<h2>ID no proporcionado</h2>";
            return;
        }

        $proyectos = Proyectos::getInstancia();
        $proyectos->eliminarProyecto($id);

        if ($proyectos->getMensaje() == 'Proyecto eliminado') {
            header('Location: /edit');
        } else {
            echo "<h2>Error al eliminar el proyecto</h2>";
        }
    }
}