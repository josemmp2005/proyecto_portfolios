<?php
namespace App\Models;

require_once("DBAbstractModel.php");

use PDO;

// Clase para gestionar las redes sociales uso del patrón Singleton
class RedesSociales extends DBAbstractModel
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
    private $url;
    private $created_at;
    private $updated_at;
    private  $usuarios_id;


    public function setID($id)
    {
        $this->id = $id;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }

    public function set() {}

    public function get($id = '') {}

    public function edit() {}

    public function delete() {}

    // Método para obtener todas las redes sociales
    public function getAllRedesSociales()
    {
        $this->query = "SELECT * FROM redes_sociales";
        $this->get_results_from_query();
        return $this->rows;
    }
    
    // Método para obtener las redes sociales de un usuario
    public function getRedesSocialesPorUsuariosId($id = '')
    {
        $sql = "SELECT * FROM redes_sociales WHERE usuarios_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $redes_sociales = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $redes_sociales;
    }

    // Método para añadir una red social
    public function anadirRedSocial( $redes_socialescol, $url, $usuarios_id)
    {
        $stmt = $this->db->prepare("INSERT INTO redes_sociales (redes_socialescol, url, usuarios_id) VALUES (:redes_socialescol, :url, :usuarios_id)");
        $stmt->execute([
            'redes_socialescol' => $redes_socialescol,
            'url' => $url,
            'usuarios_id' => $usuarios_id
        ]);
        if ($stmt->rowCount() > 0) {
            $this->mensaje = 'Red social añadida';

            header('Location: /edit');
        } else {
            $this->mensaje = 'Error al añadir la red social';
        }
        $this->get_results_from_query();

    }

    // Método para eliminar una red social
    public function eliminarRedSocial($id)
    {
        $this->query = "DELETE FROM redes_sociales WHERE id = :id";
        $stmt = $this->db->prepare($this->query);
        $stmt->execute(['id' => $id]);
        if ($stmt->rowCount() > 0) {
            $this->mensaje = 'Red social eliminada';
        } else {
            $this->mensaje = 'Error al eliminar red social';
        }
    }

    // Método para editar una red social
    public function editarRedSocial($id, $redes_socialescol, $url, $usuarios_id)
    {
        $stmt = $this->db->prepare("UPDATE redes_sociales SET redes_socialescol = :redes_socialescol, url = :url, usuarios_id = :usuarios_id WHERE id = :id");
        $stmt->execute([
            'redes_socialescol' => $redes_socialescol,
            'url' => $url,
            'usuarios_id' => $usuarios_id,
            'id' => $id
        ]);
        if ($stmt->rowCount() > 0) {
            $this->mensaje = 'Red social editada';
        } else {
            $this->mensaje = 'Error al editar red social';
        }
    }
}
