<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Skills;
use App\Models\CategoriaSkills;

require_once __DIR__ . '/../lib/conectar.php';

class SkillController extends BaseController
{
    public function anadirSkillAction(){
        if (!isset($_SESSION['id'])) {
            header('Location: /');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $habilidades = $_POST['habilidades'] ?? null;
            $categoria = $_POST['categoria_habilidad'] ?? null;
            $usuarios_id = $_SESSION['id'];
            $visible = 1;
            $skill = Skills::getInstancia();
            $skill-> anadirSkill($habilidades, $visible, $categoria, $usuarios_id);
            header('Location: /edit');
        }
        else{
            $categorias = CategoriaSkills::getInstancia();
            $categorias = $categorias->getAll();
            $this->renderHTML('../views/new_skill.php', [
                'categorias' => $categorias,
            ]);
        }
    }

    public function editarSkill()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id) {
            echo "<h2>ID no proporcionado</h2>";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $habilidades = $_POST['habilidades'] ?? null;
            $categoria = $_POST['categoria_habilidad'] ?? null;
            $usuarios_id = $_SESSION['id'];
            $visible = isset($_POST['visible']) ? 1 : 0;
            $skill = Skills::getInstancia();
            $skill->editarSkill($id, $habilidades, $visible, $categoria, $usuarios_id);
            header('Location: /edit');
        } else {
            $skill = Skills::getInstancia();
            $skill = $skill->getSkillsPorUsuariosId($_SESSION['id']);
            $categorias = CategoriaSkills::getInstancia();
            $categorias = $categorias->getAll();
            $this->renderHTML('../views/edit_skill_view.php', [
                'skill' => $skill,
                'categorias' => $categorias,
            ]);
        }
    }

    public function eliminarSkill() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id) {
            echo "<h2>ID no proporcionado</h2>";
            return;
        }

        $skill = Skills::getInstancia();
        $skill->eliminarSkill($id);

        if ($skill->getMensaje() == 'Skill eliminada') {
            header('Location: /edit');
        } else {
            echo "<h2>Error al eliminar la habilidad</h2>";
        }
    }
}