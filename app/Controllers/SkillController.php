<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Skills;

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
            $this->renderHTML('../views/new_skill.php');
        }
    }
}