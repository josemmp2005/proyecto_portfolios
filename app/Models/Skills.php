<?php
namespace App\Models;
require_once("DBAbstractModel.php");
use PDO;

class Skills extends DBAbstractModel
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

    public function getAllSkills()
    {
        $this->query = "SELECT * FROM skills";
        $this->get_results_from_query();
        return $this->rows;
    }

    public function getSkillsPorUsuariosId($id = '')
    {
            $sql = "SELECT * FROM skills WHERE usuarios_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $skills = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $skills;
    }

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
        $this->get_results_from_query();
    }

    public function eliminarSkill($id)
    {
        $this->query = "DELETE FROM skills WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
    }

    public function ocultarSkill($id)
    {
        $this->query = "SELECT * FROM skills WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        
        if ($this->rows[0]['visible'] == 1) {
            $this->query = "UPDATE skills SET visible = 0 WHERE id = :id";
            $this->parametros['id'] = $id;
            $this->get_results_from_query();
            $this->mensaje = 'Skill ocultada';
        } else {
            $this->query = "UPDATE skills SET visible = 1 WHERE id = :id";
            $this->parametros['id'] = $id;
            $this->get_results_from_query();
            $this->mensaje = 'Skill mostrada';
        }
    }
}
