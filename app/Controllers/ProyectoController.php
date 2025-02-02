<?php
namespace App\Controllers;

// Inclusión de clases necesarias
use App\Controllers\BaseController;
use App\Models\Proyectos;

// Inclusión de archivos de funciones
/**
 * __DIR__ es una constante mágica de PHP que devuelve el directorio del archivo actual. 
 * 
 */
require_once __DIR__ . '/../lib/generar_token.php';
require_once __DIR__ . '/../lib/conectar.php';

class ProyectoController extends BaseController
{
    // Método para añadir un proyecto
    public function anadirProyectoAction(){
        // Verifica si la solicitud es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Si no hay un usuario autenticado, redirige a la página principal
            if (!isset($_SESSION['id'])) {
                header('Location: /');
                return;
            }
            // Obtiene los datos enviados desde el formulario
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $logo = $_POST['logo'];
            $tecnologias = $_POST['tecnologias'];
            $visible = 1;
            $usuarios_id = $_SESSION['id'];

            // Crea una instancia de la clase Proyectos y añade el proyecto
            $proyecto = Proyectos::getInstancia();
            $proyecto-> anadirProyecto($titulo, $descripcion, $logo, $tecnologias, $visible, $usuarios_id);
            header('Location: /edit');
        }else{
            // Si la solicitud no es de tipo POST, muestra el formulario para añadir un proyecto
            $this->renderHTML('../views/new_proyecto.php');
        }
    }

    // Método para editar un proyecto
    public function editarProyecto()
    {
        // Obtiene el ID del proyecto a editar desde la URL
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];;

        // Si no se proporciona un ID, muestra un mensaje de error
        if (!$id) {
            echo "<h2>ID no proporcionado</h2>";
            return;
        }

        // Verifica si la solicitud es de tipo POST y obtiene los datos enviados desde el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'] ?? null;
            $descripcion = $_POST['descripcion'] ?? null;
            $logo = $_POST['logo'] ?? null;
            $tecnologias = $_POST['tecnologias'] ?? null;
            $visible = isset($_POST['visible']) ? 1 : 0;
            $usuarios_id = $_SESSION['id'];

            // Crea una instancia de la clase Proyectos y edita el proyecto
            $proyecto = Proyectos::getInstancia();
            $proyecto->editarProyecto($id, $titulo, $descripcion, $logo, $tecnologias, $visible, $usuarios_id);
            header('Location: /edit');
        } else {
            // Si la solicitud no es de tipo POST, muestra el formulario para editar el proyecto
            $proyecto = Proyectos::getInstancia();
            $proyectos = $proyecto->getProyectoPorId($id);
            if (!isset($_SESSION['id']) || $_SESSION['id'] == '' || $_SESSION['id'] !== $proyectos['usuarios_id']) {
                header('Location: /');
                return;
            }
            $proyecto = $proyecto->getProyectosPorUsuariosId($_SESSION['id']);
            $this->renderHTML('../views/edit_proyecto_view.php', [
                'proyecto' => $proyecto,
                'id' => $id,
            ]);
        }
    }

    // Método para eliminar un proyecto
    public function eliminarProyecto()
    {
        // Obtiene el ID del proyecto a eliminar desde la URL
        $id = explode('/', $_SERVER['REQUEST_URI'])[2];;

        // Si no se proporciona un ID, muestra un mensaje de error
        if (!$id) {
            echo "<h2>ID no proporcionado</h2>";
            return;
        }

        // Crea una instancia de la clase Proyectos y elimina el proyecto
        $proyecto = Proyectos::getInstancia();
        $proyectos = $proyecto->getProyectoPorId($id);
        if (!isset($_SESSION['id']) || $_SESSION['id'] == '' || $_SESSION['id'] !== $proyectos['usuarios_id']) {
            header('Location: /');
            return;
        }
        $proyectos->eliminarProyecto($id);

        // Redirige a la página de edición de proyectos
        if ($proyectos->getMensaje() == 'Proyecto eliminado') {
            header('Location: /edit');
        } else {
            echo "<h2>Error al eliminar el proyecto</h2>";
        }
    }
}