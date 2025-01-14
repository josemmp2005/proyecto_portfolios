<?php

namespace App\Models;
require_once("DBAbstractModel.php");

use App\Models\RedesSociales;
use App\Models\Skills;
use App\Core\EmailSender;
use PDO;
use PDOException;


class Trabajos extends DBAbstractModel
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
    private $descripcion;
    private $fecha_inicio;
    private $fecha_fin;
    private $logros;
    private $visible;
    private $created_at;
    private $updated_at;

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

    public function getMensaje()
    {
        return $this->mensaje;
    }

    public function set() {}

    public function get($id = "") {}

    public function edit() {}

    public function delete() {}

    public function getAllTrabajos()
    {
        $this->query = "SELECT * FROM trabajos";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getTrabajosPorUsuariosId($id = '')
    {
        $sql = "SELECT * FROM trabajos WHERE usuarios_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $trabajos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $trabajos;
    }

    public function anadirTrabajo($titulo, $descripcion, $fecha_inicio, $fecha_final, $logros, $usuarios_id)
    {
        $visible = 1;
        $stmt = $this->db->prepare("INSERT INTO trabajos (titulo, descripcion, fecha_inicio, fecha_final, logros, visible, usuarios_id) VALUES (:titulo, :descripcion, :fecha_inicio, :fecha_final, :logros, :visible, :usuarios_id)");
        $stmt->execute([
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha_inicio' => $fecha_inicio,
            'fecha_final' => $fecha_final,
            'logo' => $logros,
            'visible' => $visible,
            'usuarios_id' => $usuarios_id
        ]);
        if ($stmt->rowCount() > 0) {
            $this->mensaje = 'Trabajo añadido';
        } else {
            
        }
        $this->get_results_from_query();
    }
    

    public function eliminarTrabajo($id)
    {
        $this->query = "DELETE FROM trabajos WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Trabajo eliminado';
    }

    public function ocultarTrabajo($id)
    {
        $this->query = "SELECT * FROM trabajos WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        
        if ($this->rows[0]['visible'] == 1) {
            $this->query = "UPDATE trabajos SET visible = 0 WHERE id = :id";
            $this->parametros['id'] = $id;
            $this->get_results_from_query();
            $this->mensaje = 'Trabajo ocultado';
        } else {
            $this->query = "UPDATE trabajos SET visible = 1 WHERE id = :id";
            $this->parametros['id'] = $id;
            $this->get_results_from_query();
            $this->mensaje = 'Trabajo mostrado';
        }
    }

}