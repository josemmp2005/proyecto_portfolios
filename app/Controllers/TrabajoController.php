<?php
namespace App\Controllers;

// Inclusión de clases necesarias
use App\Models\Trabajos;
use App\Controllers\BaseController;

// Inclusión de archivos de funciones
require_once __DIR__ . '/../lib/generar_token.php';
require_once __DIR__ . '/../lib/conectar.php';

class TrabajoController extends BaseController
{
    // Método para añadir un trabajo
    public function anadirTrabajoAction()
    {
        // Si no hay un usuario autenticado, redirige a la página principal
        if (!isset($_SESSION['id'])) {
            header('Location: /');
            return;
        }

        // Verifica si la solicitud es de tipo POST y obtiene los datos enviados desde el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'] ?? null;
            $descripcion = $_POST['descripcion'] ?? null;
            $fecha_inicio = $_POST['fecha_inicio'] ?? null;
            $fecha_final = $_POST['fecha_final'] ?? null;
            $logros = $_POST['logros'] ?? null;
            $visible = 1;
            $usuarios_id = $_SESSION['id'];

            // Crea una instancia de la clase Trabajos y añade el trabajo
            $trabajo = Trabajos::getInstancia();
            $trabajo->anadirTrabajo($titulo, $descripcion, $fecha_inicio, $fecha_final, $logros, $visible, $usuarios_id);
            header('Location: /edit');
        } else {
            // Si la solicitud no es de tipo POST, muestra el formulario para añadir un trabajo
            $this->renderHTML('../views/new_trabajo.php');
        }
    }

    public function editarTrabajo(){
        // Obtiene el ID del trabajo a editar desde la URL
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];

        // Si no se proporciona un ID, muestra un mensaje de error
        if (!$id) {
            echo "<h2>ID no proporcionado</h2>";
            return;
        }

        // Verifica si la solicitud es de tipo POST y obtiene los datos enviados desde el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'] ?? null;
            $descripcion = $_POST['descripcion'] ?? null;
            $fecha_inicio = $_POST['fecha_inicio'] ?? null;
            $fecha_final = $_POST['fecha_final'] ?? null;
            $logros = $_POST['logros'] ?? null;
            $visible = isset($_POST['visible']) ? 1 : 0;
            $usuarios_id = $_SESSION['id'];

            // Crea una instancia de la clase Trabajos y edita el trabajo
            $trabajo = Trabajos::getInstancia();
            $trabajo->editarTrabajo($id, $titulo, $descripcion, $fecha_inicio, $fecha_final, $logros, $visible, $usuarios_id);
            header('Location: /edit');
        } else {
            // Si la solicitud no es de tipo POST, muestra el formulario para editar el trabajo
            $trabajo = Trabajos::getInstancia();
            $trabajos = $trabajo->getTrabajoPorId($id);
            if (!isset($_SESSION['id']) || $_SESSION['id'] !== $trabajos['usuarios_id']) {
                header('Location: /');
                return;
            }
            $trabajo = $trabajo->getTrabajosPorUsuariosId($_SESSION['id']);
            $this->renderHTML('../views/edit_trabajo_view.php', [
                'trabajo' => $trabajo,
                'id'=>$id
            ]);
        }
    }
    
    // Método para eliminar un trabajo
    public function eliminarTrabajo()
    {
         // Obtiene el ID del trabajo a eliminar desde la URL
         $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];;

        // Si no se proporciona un ID, muestra un mensaje de error
        if (!$id) {
            echo "<h2>ID no proporcionado</h2>";
            return;
        }

        // Crea una instancia de la clase Trabajos y elimina el trabajo
        $trabajo = Trabajos::getInstancia();
        $trabajos = $trabajo->getTrabajoPorId($id);
        if (!isset($_SESSION['id']) || $_SESSION['id'] !== $trabajos['usuarios_id']) {
            header('Location: /');
            return;
        }
        $trabajo->eliminarTrabajo($id);

        // Redirige a la página de edición de trabajos si el trabajo se elimina correctamente
        if ($trabajo->getMensaje() == 'Trabajo eliminado') {
            header('Location: /edit');
        } else {
            echo "<h2>Error al eliminar el trabajo</h2>";
        }
    }

}