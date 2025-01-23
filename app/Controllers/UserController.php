<?php
namespace App\Controllers;

// Inclusión de clases necesarias
use App\Models\Usuarios;
use App\Models\Trabajos;
use App\Controllers\BaseController;
use App\Models\Proyectos;
use App\Models\RedesSociales;
use App\Models\Skills;

// Inclusión de archivos de funciones
require_once __DIR__ . '/../lib/generar_token.php';
require_once __DIR__ . '/../lib/conectar.php';

// Inclusión de la clase PDOException
use PDOException;

class UserController extends BaseController
{
    // Método para mostrar la página principal
    public function IndexAction()
    {
        // Verifica si el usuario está autenticado
        $claseUsuario = Usuarios::getInstancia();

        // Si el usuario está autenticado, se muestra la página principal
        if (isset($_SESSION['autenticado'])) {
            $autenticado = $_SESSION['autenticado'];
            $claseUsuario = Usuarios::getInstancia();
            $usuario = $claseUsuario->getById($_SESSION['id']);
            $_SESSION["nombre"] = $usuario['nombre'];
        } else {
            // Si el usuario no está autenticado, se muestra la página principal sin la opcion de editar perfil
            $autenticado = false;
        }

        // Declara un array para almacenar los portafolios
        $portfolios = [];

        // Obtiene los portafolios de la base de datos
        try {
            // Verifica si se ha enviado una solicitud de búsqueda y si el campo de búsqueda no está vacío
            if (isset($_POST["search"]) && !empty($_POST["nombre"])) {
                // Obtiene el nombre de usuario a buscar desde el formulario de búsqueda y realiza la búsqueda
                $nombre = $_POST["nombre"];
                $portfolios = $claseUsuario->search($nombre);
            } else {
                // Si no se ha enviado una solicitud de búsqueda, obtiene todos los portafolios
                $portfolios = $claseUsuario->getAll();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        // Muestra la página principal con los portafolios obtenidos
        $this->renderHTML('index_view.php', [
            'autenticado' => $autenticado,
            'portfolios' => $portfolios,
        ]);
    }

    // Método para ver un portafolio
    public function verPortfolio(){
        // Obtiene el ID del portafolio desde la URL
        $id = explode('/', string: $_SERVER['REQUEST_URI'])[2];

        // Si se proporciona un ID, muestra el portafolio
        if ($id) {
            // Crea instancias de las clases necesarias y obtiene los datos del portafolio
            $claseUsuario = Usuarios::getInstancia();
            $claseTrabajo = Trabajos::getInstancia();
            $claseProyecto = Proyectos::getInstancia();
            $claseRedSocial = RedesSociales::getInstancia();
            $claseSkill = Skills::getInstancia();

            // Obtiene los datos del portafolio
            $usuario = $claseUsuario->getById($id);
            $trabajos = $claseTrabajo->getTrabajosPorUsuariosId($id);
            $proyectos = $claseProyecto->getProyectosPorUsuariosId($id);
            $redes_sociales = $claseRedSocial->getRedesSocialesPorUsuariosId($id);
            $skills = $claseSkill->getSkillsPorUsuariosId($id);

            // Si el portafolio existe, muestra los datos del portafolio
            if ($usuario) {
                $this->renderHTML('portfolio_view.php', ['id'=>$id, 'usuario' => $usuario, 'trabajos' => $trabajos, 
                'proyectos' => $proyectos, 'redes_sociales' => $redes_sociales, 'skills' => $skills]);
            } else {
                // Si el portafolio no existe, muestra un mensaje de error
                echo "<h2>Usuario no encontrado</h2>";
            }
        }else{
            // Si no se proporciona un ID, redirige a la página principal
            header('Location: /');
        }
    }

    // Método para iniciar sesión
    public function loginAction()
    {
        // Obtiene los datos enviados desde el formulario de inicio de sesión
        $nombre = $_POST['nombre'] ?? null;
        $password = $_POST['password'] ?? null;

        // Verifica si se ha enviado el formulario de inicio de sesión
        if (isset($_POST['submit'])) {
            // Crea una instancia de la clase Usuarios y verifica las credenciales del usuario
            $claseUsuario = Usuarios::getInstancia();
            $usuario = $claseUsuario->login($nombre, $password);
            
            // Si las credenciales son correctas, inicia la sesión y redirige a la página principal
            if ($usuario) {
                $_SESSION['autenticado'] = true;
                $_SESSION['usuario'] = $usuario['nombre'];
                $_SESSION['id'] = $usuario['id'];
                header('Location: /');
            } else {
                // Si las credenciales son incorrectas, muestra un mensaje de error
                header('Location: /login');
            }
        } else {
            // Si no se ha enviado el formulario de inicio de sesión, muestra el formulario de inicio de sesión
            $this->renderHTML('../views/login_view.php');
        }
    }

    // Método para cerrar sesión
    public function cerrarSesionAction()
    {
        // Cierra la sesión y redirige a la página principal
        $_SESSION["autenticado"] = false;
        session_destroy();
        header('Location: /');
    }

    public function registrarAction()
    {
        // Obtiene los datos enviados desde el formulario de registro
        $secureToken = generarToken();
        $fecha_creacion_token = date('Y-m-d H:i:s');
        $nombre = $_POST['nombre'] ?? null;
        $apellidos = $_POST['apellidos'] ?? null;
        $password = $_POST['password'] ?? null;
        $email = $_POST['email'] ?? null;
        $categorias_profesional = $_POST['categoria_profesional'] ?? null;
        $resumen_perfil = $_POST['resumen_perfil'] ?? null;

        // Verifica si se ha enviado el formulario de registro
        if (isset($_POST['submit'])) {
            $claseUsuario = Usuarios::getInstancia();
            $claseUsuario->registrar($nombre, $apellidos, $password, $email, $categorias_profesional, $resumen_perfil, $secureToken, $fecha_creacion_token);
        } else {
            // Si no se ha enviado el formulario de registro, muestra el formulario de registro
            $this->renderHTML('../views/registrar_view.php');
        }
    }

    // Método para verificar el token
    public function verificarAction()
    {
        // Obtiene el token de la URL
        $token = explode('/', string: $_SERVER['REQUEST_URI']);
        // Elimina los dos primeros elementos del array $token y los une en una cadena separada por / y lo almacena en la variable $token
        $token = array_slice($token, 2);
        $token = implode('/', $token);

        // Crea una instancia de la clase Usuarios y verifica el token
        $claseUsuario = Usuarios::getInstancia();
        $claseUsuario->verificarToken($token);

        // Si el token es válido, muestra un mensaje de éxito y redirige a la página principal
        if ($claseUsuario->getMensaje() == 'Usuario verificado') {
            $_SESSION['autenticado'] = true;
            $_SESSION['usuario'] = $claseUsuario->nombre;
            header('Location: /');
        } else {
            echo "<h2>" . $claseUsuario->getMensaje() . "</h2>";
            header('Location: /');
        }
    }

    // Método para editar un portafolio
    public function editAction()
    {
        // Si no hay un usuario autenticado, redirige a la página principal
        $id = $_SESSION['id'] ?? null;
        $_SESSION["categoria"] = ["Desarrollador", "Diseñador", "Tester", "Analista"];
        if ($id) {
            // Crea instancias de las clases necesarias y obtiene los datos del portafolio
            $claseUsuario = Usuarios::getInstancia();
            $claseTrabajo = Trabajos::getInstancia();
            $claseProyecto = Proyectos::getInstancia();
            $claseRedSocial = RedesSociales::getInstancia();
            $claseSkill = Skills::getInstancia();

            // Obtiene los datos del portafolio
            $usuario = $claseUsuario->getById($id);
            $trabajos = $claseTrabajo->getTrabajosPorUsuariosId($id);
            $proyectos = $claseProyecto->getProyectosPorUsuariosId($id);
            $redes_sociales = $claseRedSocial->getRedesSocialesPorUsuariosId($id);
            $skills = $claseSkill->getSkillsPorUsuariosId($id);

            // Si el portafolio existe, muestra los datos del portafolio
            if ($usuario) {
                if (isset($_POST['submit'])) {
                    $foto = $_POST['foto'] ?? "default.png";
                    $nombre = $_POST['nombre'] ?? $usuario['nombre'];
                    $apellidos = $_POST['apellidos'] ?? $usuario['apellidos'];
                    $password = $_POST['password'] ?? $usuario['password'];
                    $email = $_POST['email'] ?? $usuario['email'];
                    $categoria_profesional = $_POST['categoria_profesional'] ?? $usuario['categoria_profesional'];
                    $resumen_perfil = $_POST['resumen_perfil'] ?? $usuario['resumen_perfil'];
                    $visible = isset($_POST['visible']) ? 1 : 0;
                    $updated = $claseUsuario->update($id, $nombre, $apellidos, $foto, $password, $email, $categoria_profesional, $resumen_perfil, $visible);

                    // Si se actualiza el usuario, redirige a la página principal
                    if ($updated) {
                        echo "<h2>Usuario actualizado</h2>";
                        header('Location: /');
                    } else {
                        echo "<h2>Error al actualizar usuario</h2>";
                        header('Location: /');

                    }
                // Si no se envía el formulario de edición, muestra el formulario de edición
                } else {
                    $this->renderHTML('../views/edit_view.php', ['usuario' => $usuario, 'trabajos' => $trabajos, 
                    'proyectos' => $proyectos, 'redes_sociales' => $redes_sociales, 'skills' => $skills]);
                }
            } else {
                echo "<h2>Usuario no encontrado</h2>";
            }
        // Si no se proporciona un ID, redirige a la página principal
        }else{
            header('Location: /');
        }
    }
}
?>