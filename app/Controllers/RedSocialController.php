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
}