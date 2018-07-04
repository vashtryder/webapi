<?php

namespace App\Model;

use PDO;
use App\Lib\Database;
use App\Lib\Response;

class EstudianteModel
{
    private $db;
    private $table = 'tb_estudiante';
    private $response;

    public function __CONSTRUCT(){
        $this->db = Database::StartUp();
        $this->response = new Response;
    }

    public function GetAll()
    {
        try{
            $sql = "SELECT * FROM `$this->table`";
            $stm = $this->db->prepare($sql);
            $stm->execute();

            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();
            return $this->response;
        } catch(Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }

    public function Get($id){
        try{
            $result = array();
            $stm = $this->db->prepare("SELECT * FROM $this->table WHERE id = ?");
            $stm->execute(array($id));
            $this->response->setResponse(true);
            $this->response->result = $stm->fetch();
            return $this->response;
        } catch(Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }   
    }

    public function Delete($id){
        try{
            $result = array();
            $stm = $this->db->prepare("DELETE FROM $this->table WHERE id = ?");
            $stm->execute(array($id));
            $this->response->setResponse(true);
            return $this->response;
        } catch(Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        } 
    }

    public function InsertOrUpdate($data){
        try{
            if (isset($data['id'])) {
                $sql = "UPDATE tb_estudiante SET
                        Nombres            = ?,
                        Apellidos          = ?,
                        dni                = ?,
                        email              = ?
                    WHERE 
                        idEstudiante = ? ";

                $this->db->prepare($sql)
                    ->execute(
                        array(
                            $data['nombre'],
                            $data['apellido'],
                            $data['dni'],
                            $data['email'],
                            $data['id']
                        )
                    );
            } else {
                $sql = "INSERT INTO tb_estudiante(idEstudiante, idLogin , Nombres, Apellidos, dni, email)
                VALUES (?,?,?,?,?,?)";
                $this->db->prepare($sql)
                    ->execute(
                        array(
                            $data['ida'],
                            $data['idl'],
                            $data['nombre'],
                            $data['apellido'],
                            $data['dni'],
                            $data['email']
                        )
                    );
            }

            $this->response->setResponse(true);
            return $this->response;
        } catch(Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }
    
}