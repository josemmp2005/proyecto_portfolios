<?php
namespace App\Models;

require_once("DBAbstractModel.php");

use PDO;

// Clase para gestionar los proyectos uso del patrón Singleton
class Proyectos extends DBAbstractModel
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
    private $nombre;
    private $descripcion;
    private $tecnologias;
    private $created_at;
    private $updated_at;
    private $usuarios_id;


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

    public function setTecnologias($tecnologias)
    {
        $this->tecnologias = $tecnologias;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }

    public function set(){}

    public function get($id = ''){}

    public function edit(){}

    public function delete(){}

    // Método para obtener todos los proyectos
    public function getAllProyectos()
    {
        $this->query = "SELECT * FROM proyectos";
        $this->get_results_from_query();
        return $this->rows;
    }

    // Método para obtener un proyecto por su ID
    public function getProyectosPorUsuariosId($id = '')
    {
        $sql = "SELECT * FROM proyectos WHERE usuarios_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $proyectos;
    }

    // Método para obtener un proyecto por su ID
    public function anadirProyecto($titulo, $descripcion, $logo, $tecnologias, $visible, $usuarios_id)
    {
        $stmt = $this->db->prepare("INSERT INTO proyectos (titulo, descripcion, logo, tecnologias, visible, usuarios_id) VALUES (:titulo, :descripcion, :logo, :tecnologias, :visible, :usuarios_id)");
        $stmt->execute(['titulo' => $titulo, 'descripcion' => $descripcion, 'logo'=> $logo, 'tecnologias'=>$tecnologias, 'visible' => $visible, 'usuarios_id' => $usuarios_id]);
        if ($stmt->rowCount() > 0) {
            $this->mensaje = 'Proyecto añadido';
        } else {
            $this->mensaje = 'Error al añadir proyecto';
        }
    }

    // Método para eliminar un proyecto por su ID
    public function eliminarProyecto($id)
    {
        if ($id != '') {
            $this->query = "DELETE FROM proyectos WHERE id = :id";
            $stmt = $this->db->prepare($this->query);
            $stmt->execute(['id' => $id]);
            $this->mensaje = ($stmt->rowCount() > 0) ? 'Proyecto eliminado' : 'Error al eliminar proyecto';
        } else {
            $this->mensaje = 'ID no proporcionado';
        }
    }

    // MEtodo para editar un proyecto
    public function editarProyecto( $id, $titulo, $descripcion, $logo, $tecnologias, $visible, $usuarios_id)
    {
        $stmt = $this->db->prepare("UPDATE proyectos SET titulo = :titulo, descripcion = :descripcion, logo = :logo, tecnologias = :tecnologias, visible = :visible, usuarios_id = :usuarios_id WHERE id = :id");
        $stmt->execute([
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'logo' => $logo,
            'tecnologias' => $tecnologias,
            'visible' => $visible,
            'usuarios_id' => $usuarios_id,
            'id' => $id
        ]);
        if ($stmt->rowCount() > 0) {
            $this->mensaje = 'Proyecto editado';
        } else {
            $this->mensaje = 'Error al editar proyecto';
        }

    }
}
