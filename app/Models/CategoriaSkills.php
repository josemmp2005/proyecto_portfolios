<?php
namespace App\Models;
require_once("DBAbstractModel.php");
use PDO;

class CategoriaSkills extends DBAbstractModel
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

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM categorias_skills");
        $stmt->execute();
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $categorias;    }
}
