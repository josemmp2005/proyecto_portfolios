<?php

namespace App\Models;

require_once("DBAbstractModel.php");

use PDO;

// Clase para gestionar los trabajos uso del patrón Singleton
class Trabajos extends DBAbstractModel
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
    private $id;
    private $titulo;
    private $descripcion;
    private $fecha_inicio;
    private $fecha_fin;
    private $logros;
    private $visible;
    private $created_at;
    private $updated_at;

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setID($id)
    {
        $this->id = $id;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function setFecha_ini($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;
    }
    public function setFecha_fin($fecha_fin)
    {
        $this->fecha_fin = $fecha_fin;
    }

    public function setLogros($logros)
    {
        $this->logros = $logros;
    }

    public function setVisible($visible)
    {
        $this->visible = $visible;
    }
    public function set() {}

    // Método para obtener un trabajo
    public function get($id = "") {
        if ($id != '') {
            $this->query = "SELECT * FROM trabajos WHERE id = :id";
            $stmt = $this->db->prepare($this->query);
            $stmt->execute(['id' => $id]);
            $this->rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        $this->mensaje = ($stmt->rowCount() > 0) ? 'Trabajo encontrado' : 'Error al encontrar trabajo';
        $this->get_results_from_query();

    }

    public function edit() {}

    public function delete() {}

    // Método para obtener todos los trabajos
    public function getAllTrabajos()
    {
        $this->query = "SELECT * FROM trabajos";
        $this->get_results_from_query();
        return $this->rows;
    }

    // Método para obtener los trabajos de un usuario
    public function getTrabajosPorUsuariosId($id = '')
    {
        $sql = "SELECT * FROM trabajos WHERE usuarios_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $trabajos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $trabajos;
    }

    // Método para obtener un trabajo por su ID
    public function getTrabajoPorId($id)
    {
        $this->query = "SELECT * FROM trabajos WHERE id = :id";
        $stmt = $this->db->prepare($this->query);
        $stmt->execute(['id' => $id]);
        $trabajo = $stmt->fetch(PDO::FETCH_ASSOC);
        return $trabajo;
    }
    // Método para añadir un trabajo
    public function anadirTrabajo($titulo, $descripcion, $fecha_inicio, $fecha_final, $logros, $visible, $usuarios_id)
    {
        $stmt = $this->db->prepare("INSERT INTO trabajos (titulo, descripcion, fecha_inicio, fecha_final, logros, visible, usuarios_id) VALUES (:titulo, :descripcion, :fecha_inicio, :fecha_final, :logros, :visible, :usuarios_id)");
        $stmt->execute([
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha_inicio' => $fecha_inicio,
            'fecha_final' => $fecha_final,
            'logros' => $logros,
            'visible' => $visible,
            'usuarios_id' => $usuarios_id
        ]);
        if ($stmt->rowCount() > 0) {
            $this->mensaje = 'Trabajo añadido';
        } else {
            $this->mensaje = 'Error al añadir trabajo';
        }
    }

    // Método para eliminar un trabajo
    public function eliminarTrabajo($id = '') {
        if ($id != '') {
            $this->query = "DELETE FROM trabajos WHERE id = :id";
            $stmt = $this->db->prepare($this->query);
            $stmt->execute(['id' => $id]);
            $this->mensaje = ($stmt->rowCount() > 0) ? 'Trabajo eliminado' : 'Error al eliminar trabajo';
        } else {
            $this->mensaje = 'ID no proporcionado';
        }
    }

    // Método para editar un trabajo
    public function editarTrabajo($id, $titulo, $descripcion, $fecha_inicio, $fecha_final, $logros, $visible, $usuarios_id){
        $stmt = $this->db->prepare("UPDATE trabajos SET titulo = :titulo, descripcion = :descripcion, fecha_inicio = :fecha_inicio, fecha_final = :fecha_final, logros = :logros, visible = :visible, usuarios_id = :usuarios_id WHERE id = :id");
        $stmt->execute([
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha_inicio' => $fecha_inicio,
            'fecha_final' => $fecha_final,
            'logros' => $logros,
            'visible' => $visible,
            'usuarios_id' => $usuarios_id,
            'id' => $id
        ]);
        if ($stmt->rowCount() > 0) {
            $this->mensaje = 'Trabajo editado';
        } else {
            $this->mensaje = 'Error al editar trabajo';
        }
    }
}