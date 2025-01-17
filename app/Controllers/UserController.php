<?php
namespace App\Controllers;

use App\Models\Usuarios;
use App\Models\Trabajos;
use App\Controllers\BaseController;
use App\Models\CategoriaSkills;
use App\Models\Proyectos;
use App\Models\RedesSociales;
use App\Models\Skills;

require_once __DIR__ . '/../lib/generar_token.php';
require_once __DIR__ . '/../lib/conectar.php';

use PDO;
use PDOException;

class UserController extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = conectaDB();
    }
    public function IndexAction()
    {
        $claseUsuario = Usuarios::getInstancia();
        if (isset($_SESSION['autenticado'])) {
            $autenticado = $_SESSION['autenticado'];
        } else {
            $autenticado = false;
        }
        $portfolios = [];

        try {
            if (isset($_POST["search"]) && !empty($_POST["nombre"])) {
                $nombre = $_POST["nombre"];
                $portfolios = $claseUsuario->search($nombre);
            } else {
                $portfolios = $claseUsuario->getAll();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $this->renderHTML('index_view.php', [
            'autenticado' => $autenticado,
            'portfolios' => $portfolios,
        ]);
    }

    public function verPortfolio(){
        $id = $_GET['id'] ?? null;
        if ($id) {
            $claseUsuario = Usuarios::getInstancia();
            $claseTrabajo = Trabajos::getInstancia();
            $claseProyecto = Proyectos::getInstancia();
            $claseRedSocial = RedesSociales::getInstancia();
            $claseSkill = Skills::getInstancia();
            $usuario = $claseUsuario->getById($id);

            $trabajos = $claseTrabajo->getTrabajosPorUsuariosId($id);
            $proyectos = $claseProyecto->getProyectosPorUsuariosId($id);
            $redes_sociales = $claseRedSocial->getRedesSocialesPorUsuariosId($id);
            $skills = $claseSkill->getSkillsPorUsuariosId($id);

            if ($usuario) {
                $this->renderHTML('portfolio_view.php', ['id'=>$id, 'usuario' => $usuario, 'trabajos' => $trabajos, 
                'proyectos' => $proyectos, 'redes_sociales' => $redes_sociales, 'skills' => $skills]);
            } else {
                echo "<h2>Usuario no encontrado</h2>";
            }
        }else{
            $this->renderHTML('portfolio_view.php');
        }
    }

    public function loginAction()
    {
        $nombre = $_POST['nombre'] ?? null;
        $password = $_POST['password'] ?? null;
        if (isset($_POST['submit'])) {
            $claseUsuario = Usuarios::getInstancia();
            $usuario = $claseUsuario->login($nombre, $password);
            if ($usuario) {
                $_SESSION['autenticado'] = true;
                $_SESSION['usuario'] = $usuario['nombre'];
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['tipo'] = 'Usuario';
                header('Location: /');
            } else {
                echo "<h2>Usuario o contraseña incorrectos</h2>";
            }
        } else {
            $this->renderHTML('../views/login_view.php');
        }
    }

    public function cerrarSesionAction()
    {
        $_SESSION["autenticado"] = false;
        session_destroy();
        header('Location: /');
    }

    public function registrarAction()
    {
        $secureToken = generarToken();
        $fecha_creacion_token = date('Y-m-d H:i:s');
        $nombre = $_POST['nombre'] ?? null;
        $apellidos = $_POST['apellidos'] ?? null;
        $password = $_POST['password'] ?? null;
        $email = $_POST['email'] ?? null;
        $categorias_profesional = $_POST['categoria_profesional'] ?? null;
        $resumen_perfil = $_POST['resumen_perfil'] ?? null;

        if (isset($_POST['submit'])) {
            $claseUsuario = Usuarios::getInstancia();
            $claseUsuario->registrar($nombre, $apellidos, $password, $email, $categorias_profesional, $resumen_perfil, $secureToken, $fecha_creacion_token);
        } else {
            $this->renderHTML('../views/registrar_view.php');
        }
    }

    public function verificarAction()
    {
        // var_dump(value: $_SERVER['REQUEST_URI']);
        $token = explode('/', string: $_SERVER['REQUEST_URI']);
        $token = array_slice($token, 2);
        $token = implode('/', $token);
        var_dump($token);
        $claseUsuario = Usuarios::getInstancia();
        $claseUsuario->verificarToken($token);
        if ($claseUsuario->getMensaje() == 'Usuario verificado') {
            echo "<h2>" . $claseUsuario->getMensaje() . "</h2>";
            $_SESSION['auth'] = true;
            $_SESSION['usuario'] = $claseUsuario->nombre;
            $_SESSION['tipo'] = 'Usuario';
            header('Location: /');
        } else {
            echo "<h2>" . $claseUsuario->getMensaje() . "</h2>";
        }
    }

    public function editAction()
    {
        $id = $_SESSION['id'] ?? null;
        $_SESSION["categoria"] = ["Desarrollador", "Diseñador", "Tester", "Analista"];
        if ($id) {
            $claseUsuario = Usuarios::getInstancia();
            $claseTrabajo = Trabajos::getInstancia();
            $claseProyecto = Proyectos::getInstancia();
            $claseRedSocial = RedesSociales::getInstancia();
            $claseSkill = Skills::getInstancia();
            $usuario = $claseUsuario->getById($id);

            $trabajos = $claseTrabajo->getTrabajosPorUsuariosId($id);
            $proyectos = $claseProyecto->getProyectosPorUsuariosId($id);
            $redes_sociales = $claseRedSocial->getRedesSocialesPorUsuariosId($id);
            $skills = $claseSkill->getSkillsPorUsuariosId($id);

            if ($usuario) {
                if (isset($_POST['submit'])) {
                    $nombre = $_POST['nombre'] ?? $usuario['nombre'];
                    $apellidos = $_POST['apellidos'] ?? $usuario['apellidos'];
                    $password = $_POST['password'] ?? $usuario['password'];
                    $email = $_POST['email'] ?? $usuario['email'];
                    $categoria_profesional = $_POST['categoria_profesional'] ?? $usuario['categoria_profesional'];
                    $resumen_perfil = $_POST['resumen_perfil'] ?? $usuario['resumen_perfil'];
                    $visible = isset($_POST['visible']) ? 1 : 0;
                    $updated = $claseUsuario->update($id, $nombre, $apellidos, $password, $email, $categoria_profesional, $resumen_perfil, $visible);

                    if ($updated) {
                        echo "<h2>Usuario actualizado</h2>";
                        header('Location: /');
                    } else {
                        echo "<h2>Error al actualizar usuario</h2>";
                        header('Location: /');

                    }

                } else {
                    $this->renderHTML('../views/edit_view.php', ['usuario' => $usuario, 'trabajos' => $trabajos, 
                    'proyectos' => $proyectos, 'redes_sociales' => $redes_sociales, 'skills' => $skills]);
                }
            } else {
                echo "<h2>Usuario no encontrado</h2>";
            }
        }else{
            header('Location: /');
        }
    }
}
?>