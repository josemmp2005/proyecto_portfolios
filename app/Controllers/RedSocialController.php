<?php
namespace App\Controllers;

use App\Models\Usuarios;
use App\Models\Trabajos;
use App\Controllers\BaseController;
use App\Models\CategoriaSkills;
use App\Models\Proyectos;
use App\Models\RedesSociales;

require_once __DIR__ . '/../lib/generar_token.php';
require_once __DIR__ . '/../lib/conectar.php';

use PDO;
use PDOException;

class RedSocialController extends BaseController
{
    public function anadirRedSocialAction(){
        if (!isset($_SESSION['id'])) {
            header('Location: /');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $redesSocialesCol = $_POST['nombre'] ?? null;
            $url = $_POST['url'] ?? null;
            $usuarios_id = $_SESSION['id'];
            $redSocial = RedesSociales::getInstancia();
            $redSocial-> anadirRedSocial($redesSocialesCol, $url, $usuarios_id);
            header('Location: /edit');
        }else{
            $this->renderHTML('../views/new_red_social.php');
        }
    }

    public function editarRedSocial()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id) {
            echo "<h2>ID no proporcionado</h2>";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $redesSocialesCol = $_POST['nombre'] ?? null;
            $url = $_POST['url'] ?? null;
            $usuarios_id = $_SESSION['id'];
            $redSocial = RedesSociales::getInstancia();
            $redSocial->editarRedSocial($id, $redesSocialesCol, $url, $usuarios_id);
            header('Location: /edit');
        } else {
            $redSocial = RedesSociales::getInstancia();
            $redSocial = $redSocial->getRedesSocialesPorUsuariosId($_SESSION['id']);
            $this->renderHTML('../views/edit_redes_sociales_view.php', [
                'redSocial' => $redSocial,
            ]);
        }
    }

    public function eliminarRedSocial()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if (!$id) {
            echo "<h2>ID no proporcionado</h2>";
            return;
        }
        
        $redSocial = RedesSociales::getInstancia();
        $redSocial->eliminarRedSocial($id);
        header('Location: /edit');

       
    }
}