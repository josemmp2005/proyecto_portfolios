<?php
namespace App\Models;
require_once("DBAbstractModel.php");
use PDO;

class Proyectos extends DBAbstractModel
{
    private static $instancia;

    private $db;

    private function __construct()
    {
        $this->db = conectaDB();
    }
    public static function getInstancia()
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function __clone()
    {
        trigger_error("La clonación no está permitida.", E_USER_ERROR);
    }

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

    public function set()
    {
    }

    public function get($id = '')
    {
    }

    public function edit()
    {
    }

    public function delete()
    {
    }

    public function getAllProyectos()
    {
        $this->query = "SELECT * FROM proyectos";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getProyectosPorUsuariosId($id = '')
    {
        $sql = "SELECT * FROM proyectos WHERE usuarios_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $proyectos;
    }

    public function anadirProyecto($titulo, $descripcion, $logo, $tecnologias, $visible, $usuarios_id)
    {
        $stmt = $this->db->prepare("INSERT INTO proyectos (titulo, descripcion, logo, tecnologias, visible, usuarios_id) VALUES (:titulo, :descripcion, :logo, :tecnologias, :visible, :usuarios_id)");
        $stmt->execute(['titulo' => $titulo, 'descripcion' => $descripcion, 'logo'=> $logo, 'tecnologias'=>$tecnologias, 'visible' => $visible, 'usuarios_id' => $usuarios_id]);
        if ($stmt->rowCount() > 0) {
            $this->mensaje = 'Proyecto añadido';
        } else {
            $this->mensaje = 'Error al añadir proyecto';
        }
        $this->get_results_from_query();
    }

    public function eliminarProyecto($id)
    {
        $stmt = $this->db->prepare("DELETE FROM proyectos WHERE id = :id") ;
        $stmt->execute(['id' => $id]);
        if ($stmt->rowCount() > 0) {
            $this->mensaje = 'Proyecto eliminado';
        } else {
            $this->mensaje = 'Error al eliminar proyecto';
        }
        $this->get_results_from_query();
    }

    public function ocultarProyecto($id)
    {
        $this->query = "SELECT * FROM proyectos WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();

        if ($this->rows[0]['visible'] == 1) {
            $this->query = "UPDATE proyectos SET visible = 0 WHERE id = :id";
            $this->parametros['id'] = $id;
            $this->get_results_from_query();
            $this->mensaje = 'Proyecto ocultado';
        } else {
            $this->query = "UPDATE proyectos SET visible = 1 WHERE id = :id";
            $this->parametros['id'] = $id;
            $this->get_results_from_query();
            $this->mensaje = 'Proyecto mostrado';
        }
    }
}
