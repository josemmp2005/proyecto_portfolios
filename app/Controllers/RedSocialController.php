<?php
namespace App\Controllers;

// Inclusión de clases necesarias
use App\Controllers\BaseController;
use App\Models\RedesSociales;

// Inclusión de archivos de funciones
require_once __DIR__ . '/../lib/generar_token.php';
require_once __DIR__ . '/../lib/conectar.php';

class RedSocialController extends BaseController
{
    // Método para añadir una red social
    public function anadirRedSocialAction(){
        // Si no hay un usuario autenticado, redirige a la página principal
        if (!isset($_SESSION['id'])) {
            header('Location: /');
            return;
        }
        // Verifica si la solicitud es de tipo POST y obtiene los datos enviados desde el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $redesSocialesCol = $_POST['nombre'] ?? null;
            $url = $_POST['url'] ?? null;
            $usuarios_id = $_SESSION['id'];

            // Crea una instancia de la clase RedesSociales y añade la red social
            $redSocial = RedesSociales::getInstancia();
            $redSocial-> anadirRedSocial($redesSocialesCol, $url, $usuarios_id);
            header('Location: /edit');
        }else{
            // Si la solicitud no es de tipo POST, muestra el formulario para añadir una red social
            $this->renderHTML('../views/new_red_social.php');
        }
    }

    // Método para editar una red social
    public function editarRedSocial()
    {
        // Obtiene el ID de la red social a editar desde la URL
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        // Si no se proporciona un ID, muestra un mensaje de error
        if (!$id) {
            echo "<h2>ID no proporcionado</h2>";
            return;
        }

        // Verifica si la solicitud es de tipo POST y obtiene los datos enviados desde el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $redesSocialesCol = $_POST['nombre'] ?? null;
            $url = $_POST['url'] ?? null;
            $usuarios_id = $_SESSION['id'];

            // Crea una instancia de la clase RedesSociales y edita la red social
            $redSocial = RedesSociales::getInstancia();
            $redSocial->editarRedSocial($id, $redesSocialesCol, $url, $usuarios_id);
            header('Location: /edit');
        } else {
            // Si la solicitud no es de tipo POST, muestra el formulario para editar una red social
            $redSocial = RedesSociales::getInstancia();
            $redSocial = $redSocial->getRedesSocialesPorUsuariosId($_SESSION['id']);
            $this->renderHTML('../views/edit_redes_sociales_view.php', [
                'redSocial' => $redSocial,
            ]);
        }
    }

    // Método para eliminar una red social
    public function eliminarRedSocial()
    {
        // Obtiene el ID de la red social a eliminar desde la URL
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        // Si no se proporciona un ID, muestra un mensaje de error
        if (!$id) {
            echo "<h2>ID no proporcionado</h2>";
            return;
        }
        
        // Crea una instancia de la clase RedesSociales y elimina la red social
        $redSocial = RedesSociales::getInstancia();
        $redSocial->eliminarRedSocial($id);
        header('Location: /edit');
    }
}