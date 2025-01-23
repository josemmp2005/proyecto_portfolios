<?php
namespace App\Models;
require_once("DBAbstractModel.php");

use App\Models\Trabajos;
use App\Models\RedesSociales;
use App\Models\Skills;
use App\Core\EmailSender;
use PDO;
use PDOException;

// Clase para gestionar los usuarios uso del patrón Singleton
class Usuarios extends DBAbstractModel
{
    private static $instancia;

    private $db;

    // Constructor de la clase y conexión a la base de datos
    private function __construct()
    {
        $this->db = conectaDB();
    }

    // Método para obtener una instancia de la clase
    public static function getInstancia()
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    // Evita que el objeto se pueda clonar
    public function __clone()
    {
        trigger_error("La clonación no está permitida.", E_USER_ERROR);
    }

    // Propiedades de la clase
    public $id;
    public $nombre;
    public $email;
    public $password;
    public $created_at;
    public $updated_at;
    public $trabajos;

    public function setID($id)
    {
        $this->id = $id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }

    public function set(){}
    public function get($id = ""){}
    public function edit(){}
    public function delete(){}

    // Método para obtener todos los usuarios
    public function login($nombre, $password)
    {
        try {
            // Comprobar si el usuario existe y la cuenta está activa
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE nombre = :nombre AND password = :password AND cuenta_activa = 1");
            $stmt->execute([':nombre' => $nombre, ':password' => $password]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Si el usuario existe y la cuenta está activa, se asignan las propiedades del objeto
            if ($usuario) {
                foreach ($usuario as $propiedad => $valor) {
                    $this->$propiedad = $valor;
                }
                $this->mensaje = 'Usuario encontrado y cuenta activa.';
                return $usuario;
            } else {
                $this->mensaje = 'Usuario no encontrado o con cuenta sin activar. Por favor, revisa tu email y activa tu cuenta.';
                return null;
            }
        } catch (PDOException $e) {
            $this->mensaje = 'Error en la consulta: ' . $e->getMessage();
            return null;
        }
    }

    // Método para registrar un usuario
    public function registrar($nombre, $apellidos, $password, $email, $categorias_profesional, $resumen_perfil, $token, $fecha_creacion_token)
    {
        // Antescomprobar si el usuario existe
        $this->query = "SELECT * FROM usuarios WHERE nombre = :nombre";
        $this->parametros['nombre'] = $nombre;
        $this->get_results_from_query();
        if (count($this->rows) > 0) {
            $this->mensaje = 'El usuario con ese nombre ya existe en la base de datos';
            return;
        }
        
        $foto = "default.png";
        $visible = 0;
        $cuenta_activa = 0;

        // Una vez comprobado que el usuario no existe, se hace el registro
        $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, apellidos, foto ,categoria_profesional, email, resumen_perfil, password, visible, token, fecha_creacion_token, cuenta_activa) VALUES (:nombre, :apellidos, :foto, :categoria_profesional, :email, :resumen_perfil, :password, :visible, :token, :fecha_creacion_token, :cuenta_activa)");
        $stmt->execute([
            ':nombre' => $nombre,
            ':apellidos' => $apellidos,
            ':foto' => $foto,
            ':categoria_profesional' => $categorias_profesional,
            ':email' => $email,
            ':resumen_perfil' => $resumen_perfil,
            ':password' => $password,
            ':visible' => $visible,
            ':token' => $token,
            ':fecha_creacion_token' => $fecha_creacion_token,
            ':cuenta_activa' => $cuenta_activa

        ]);
        if ($stmt->rowCount() > 0) {
            echo "<h2>Usuario registrado</h2>";
            header('Location: /');
        } else {
            echo "<h2>Error al registrar usuario</h2>";
        }
        $this->get_results_from_query();


        // // Enviar correo de confirmación
        $emailSender = new EmailSender;
        $emailSender->sendConfirmationMail($nombre, $apellidos, $email, $token);
    }

    // Verificar token del usuario
    public function verificarToken($token)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE token = :token");
        $stmt->execute([':token' => $token]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario) {
            // Comprobar si el token ha caducado
            $fecha_creacion_token = $usuario['fecha_creacion_token'];
            $fecha_actual = date('Y-m-d H:i:s');
            $diferencia = strtotime($fecha_actual) - strtotime($fecha_creacion_token);
            if ($diferencia < 86400) {
                $stmt = $this->db->prepare("UPDATE usuarios SET token = NULL, fecha_creacion_token = NULL, visible = 1 , cuenta_activa = 1 WHERE token = :token", );
                $stmt->execute([':token' => $token]);
                $this->mensaje = 'Usuario verificado';
            } else {
                $this->mensaje = 'El token ha caducado';
            }
        } else {
            $this->mensaje = 'Token no encontrado';
        }
    }

    // Método para eliminar un usuario
    public function update($id, $nombre, $apellidos, $foto, $password, $email, $categoria_profesional, $resumen_perfil, $visible)
    {
        try {
            $stmt = $this->db->prepare("UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, foto = :foto, password = :password, email = :email, categoria_profesional = :categoria_profesional, resumen_perfil = :resumen_perfil, visible = :visible WHERE id = :id");
            $stmt->execute([
                ':nombre' => $nombre,
                ':apellidos' => $apellidos,
                ':foto' => $foto,
                ':password' => $password,
                ':email' => $email,
                ':categoria_profesional' => $categoria_profesional,
                ':resumen_perfil' => $resumen_perfil,
                ':visible' => $visible,
                ':id' => $id
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getAll()
    {
        // Obtener todos los usuarios
        $stmt = $this->db->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);


        // Obtener todos los trabajos asociados a cada usuario y agregarlos al resultado
        foreach ($usuarios as &$usuario) {
            $idUsuario = $usuario['id'];
            $trabajosModel = new Trabajos;
            $trabajos = $trabajosModel->getTrabajosPorUsuariosId($idUsuario);
            $usuario['trabajos'] = $trabajos;
        }

        // Obtener todos los proyectos asociados a cada usuario y agregarlos al resultado
        foreach ($usuarios as &$usuario) {
            $idUsuario = $usuario['id'];
            $proyectosModel = new Proyectos;
            $proyectos = $proyectosModel->getProyectosPorUsuariosId($idUsuario);
            $usuario['proyectos'] = $proyectos;
        }

        // Obtener todas las redes sociales asociadas a cada usuario y agregarlas al resultado
        foreach ($usuarios as &$usuario) {
            $idUsuario = $usuario['id'];
            $redesSocialesModel = new RedesSociales;
            $redesSociales = $redesSocialesModel->getRedesSocialesPorUsuariosId($idUsuario);
            $usuario['redes_sociales'] = $redesSociales;
        }

        // Obtener todas las habilidades asociadas a cada usuario y agregarlas al resultado
        foreach ($usuarios as &$usuario) {
            $idUsuario = $usuario['id'];
            $skillsModel = new Skills;
            $skills = $skillsModel->getSkillsPorUsuariosId($idUsuario);
            $usuario['skills'] = $skills;
        }
        return $usuarios;
    }

    // Método para buscar usuarios por nombre
    public function search($nombre)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE nombre LIKE :nombre");
        $stmt->execute([':nombre' => "%$nombre%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Obtener todos los trabajos asociados a cada usuario y agregarlos al resultado
        foreach ($usuarios as &$usuario) {
            $idUsuario = $usuario['id'];
            $trabajosModel = new Trabajos;
            $trabajos = $trabajosModel->getTrabajosPorUsuariosId($idUsuario);
            $usuario['trabajos'] = $trabajos;
        }

        // Obtener todos los proyectos asociados a cada usuario y agregarlos al resultado
        foreach ($usuarios as &$usuario) {
            $idUsuario = $usuario['id'];
            $proyectosModel = new Proyectos;
            $proyectos = $proyectosModel->getProyectosPorUsuariosId($idUsuario);
            $usuario['proyectos'] = $proyectos;
        }

        // Obtener todas las redes sociales asociadas a cada usuario y agregarlas al resultado
        foreach ($usuarios as &$usuario) {
            $idUsuario = $usuario['id'];
            $redesSocialesModel = new RedesSociales;
            $redesSociales = $redesSocialesModel->getRedesSocialesPorUsuariosId($idUsuario);
            $usuario['redes_sociales'] = $redesSociales;
        }

        // Obtener todas las habilidades asociadas a cada usuario y agregarlas al resultado
        foreach ($usuarios as &$usuario) {
            $idUsuario = $usuario['id'];
            $skillsModel = new Skills;
            $skills = $skillsModel->getSkillsPorUsuariosId($idUsuario);
            $usuario['skills'] = $skills;
        }
        return $usuarios;
    }

    // Método para obtener un usuario por su ID
    public function getById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}