<?php
namespace App\Controllers;

// Inclusión de clases necesarias
use App\Controllers\BaseController;
use App\Models\Skills;
use App\Models\CategoriaSkills;

// Inclusión de archivos de funciones
require_once __DIR__ . '/../lib/generar_token.php';
require_once __DIR__ . '/../lib/conectar.php';

class SkillController extends BaseController
{
    // Método para añadir una habilidad
    public function anadirSkillAction()
    {
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];

        // Si no hay un usuario autenticado, redirige a la página principal
        if (!isset($_SESSION['id'])) {
            header('Location: /');
            return;
        }

        // Verifica si la solicitud es de tipo POST y obtiene los datos enviados desde el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $habilidades = $_POST['habilidades'] ?? null;
            $categoria = $_POST['categoria_habilidad'] ?? null;
            $usuarios_id = $_SESSION['id'];
            $visible = 1;

            // Crea una instancia de la clase Skills y añade la habilidad
            $skill = Skills::getInstancia();
            $skill-> anadirSkill($habilidades, $visible, $categoria, $usuarios_id);
            header('Location: /edit');
        }
        else{
            // Si la solicitud no es de tipo POST, muestra el formulario para añadir una habilidad
            $categorias = CategoriaSkills::getInstancia();
            $categorias = $categorias->getAll();
            $this->renderHTML('../views/new_skill.php', [
                'categorias' => $categorias,
            ]);
        }
    }

    // Método para editar una habilidad
    public function editarSkill()
    {
        // Obtiene el ID de la habilidad a editar desde la URL
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];;

        // Si no se proporciona un ID, muestra un mensaje de error
        if (!$id) {
            echo "<h2>ID no proporcionado</h2>";
            return;
        }

        // Verifica si la solicitud es de tipo POST y obtiene los datos enviados desde el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $habilidades = $_POST['habilidades'] ?? null;
            $categoria = $_POST['categoria_habilidad'] ?? null;
            $usuarios_id = $_SESSION['id'];
            $visible = isset($_POST['visible']) ? 1 : 0;

            // Crea una instancia de la clase Skills y edita la habilidad
            $skill = Skills::getInstancia();
            $skill->editarSkill($id, $habilidades, $visible, $categoria, $usuarios_id);
            header('Location: /edit');
        } else {
            // Si la solicitud no es de tipo POST, muestra el formulario para editar una habilidad
            // Obtiene la habilidad a editar
            $skill = Skills::getInstancia();
            $skills = $skill->getSkillPorId($id);;
            if (!isset($_SESSION['id']) || $_SESSION['id'] !== $skills['usuarios_id']) {
                header('Location: /');
                return;
            }
            $skill = $skill->getSkillsPorUsuariosId($_SESSION['id']);

            // Obtiene las categorías de habilidades
            $categorias = CategoriaSkills::getInstancia();
            $categorias = $categorias->getAll();
            $this->renderHTML('../views/edit_skill_view.php', [
                'skill' => $skill,
                'categorias' => $categorias,
                'id' => $id,
            ]);
        }
    }

    // Método para eliminar una habilidad
    public function eliminarSkill() {
        // Obtiene el ID de la habilidad a eliminar desde la URL
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];;

        // Si no se proporciona un ID, muestra un mensaje de error
        if (!$id) {
            echo "<h2>ID no proporcionado</h2>";
            return;
        }

        // Crea una instancia de la clase Skills y elimina la habilidad
        $skill = Skills::getInstancia();
        $skills = $skill->getSkillPorId($id);;
        if (!isset($_SESSION['id']) || $_SESSION['id'] !== $skills['usuarios_id']) {
            header('Location: /');
            return;
        }
        $skill->eliminarSkill($id);

        // Redirige a la página de edición de habilidades si la habilidad se elimina correctamente
        if ($skill->getMensaje() == 'Skill eliminada') {
            header('Location: /edit');
        } else {
            echo "<h2>Error al eliminar la habilidad</h2>";
        }
    }
}