<?php
namespace App\Models;

require_once("DBAbstractModel.php");

use PDO;

// Clase para gestionar las categorías de skills uso del patrón Singleton
class CategoriaSkills extends DBAbstractModel
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

    private $categoria;
    
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    public function getMessage()
    {
        return $this->mensaje;
    }

    public function set() {}

    public function get($id = '') {}

    public function edit() {}

    public function delete() {}

    // Método para obtener todas las categorías de skills
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM categorias_skills");
        $stmt->execute();
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $categorias;    }
}
