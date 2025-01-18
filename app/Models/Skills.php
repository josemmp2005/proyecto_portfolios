<?php
namespace App\Models;

require_once("DBAbstractModel.php");

use PDO;

// Clase para gestionar las habilidades uso del patrón Singleton
class Skills extends DBAbstractModel
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
    private $habilidades;
    private $created_at;
    private $updated_at;
    private  $usuarios_id;


    public function setID($id)
    {
        $this->id = $id;
    }

    public function setHabilidades($habilidades)
    {
        $this->habilidades = $habilidades;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }

    public function set() {}

    public function get($id = '') {}

    public function edit() {}

    public function delete() {}

    // Método para obtener todas las habilidades
    public function getAllSkills()
    {
        $this->query = "SELECT * FROM skills";
        $this->get_results_from_query();
        return $this->rows;
    }

    // Método para obtener las habilidades de un usuario
    public function getSkillsPorUsuariosId($id = '')
    {
            $sql = "SELECT * FROM skills WHERE usuarios_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $skills = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $skills;
    }

    // Método para obtener las habilidades de un usuario
    public function anadirSkill($habilidades, $visible, $categorias_skills, $usuarios_id)
    {
        $visible = 1;
        $stmt = $this->db->prepare("INSERT INTO skills (habilidades, visible, categorias_skills_categoria, usuarios_id) VALUES (:habilidades, :visible, :categorias_skills_categoria, :usuarios_id)");
        $stmt->execute([':habilidades' => $habilidades, 'visible'=>$visible, ':categorias_skills_categoria' => $categorias_skills, ':usuarios_id' => $usuarios_id]);

        if ($stmt->rowCount() > 0) {
            $this->mensaje = 'Skill añadida';
        } else {
            $this->mensaje = 'Error al añadir skill';
        }
    }

    // Método para eliminar una habilidad
    public function eliminarSkill($id)
    {
        $this->query = "DELETE FROM skills WHERE id = :id";
        $stmt = $this->db->prepare($this->query);
        $stmt->execute(['id' => $id]);
        $this->mensaje = ($stmt->rowCount() > 0) ? 'Skill eliminada' : 'Error al eliminar skill';
        
    }

    // Método para editar una habilidad
    public function editarSkill( $id, $habilidades, $visible, $categorias_skills, $usuarios_id)
    {
        $stmt = $this->db->prepare("UPDATE skills SET habilidades = :habilidades, visible = :visible, categorias_skills_categoria = :categorias_skills_categoria, usuarios_id = :usuarios_id WHERE id = :id");
        $stmt->execute([':habilidades' => $habilidades, ':visible' => $visible, ':categorias_skills_categoria' => $categorias_skills, ':usuarios_id' => $usuarios_id, ':id' => $id]);
        if ($stmt->rowCount() > 0) {
            $this->mensaje = 'Skill editada';
        } else {
            $this->mensaje = 'Error al editar skill';
        }

    }
}
