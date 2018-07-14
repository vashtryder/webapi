<?php
    namespace App\Model;

    use PDO;
    use App\Lib\Database;
    use App\Lib\Response;

    class ExamenModel
    {
        private $db;
        private $table = 'tb_examen';
        private $view = 'vb_examen';
        private $response;
        
        public function __CONSTRUCT()
        {
            $this->db = Database::StartUp();
            $this->response = new Response();
        }

        public function GetAll()
        {
            try{
                $result = array();

                $stm = $this->db->prepare("SELECT * FROM $this->table");
                $stm->execute();

                $this->response->setResponse(true);
                $this->response->result = $stm->fetchAll();

                return $this->response;

            } catch(Exception $e){
                $this->response->setResponse(false, $e->getMessage());
                $this->response;
            }
        }

        public function GetVista()
        {
            try{    
                $result = array();

                $stm = $this->db->prepare("SELECT * FROM $this->view");
                $stm->execute();

                $this->response->setResponse(true);
                $this->response->result = $stm->fetchAll();
                
                return $this->response;

            }catch(Exception $e){
                $this->response->setResponse(false,$e->getMessage());
            }
        }

        public function Get($id)
        {
            try{    
                $result = array();

                $stm = $this->db->prepare("SELECT * FROM $this->table WHERE idexamen  = ? ");
                $stm->execute(array($id));

                $this->response->setResponse(true);
                $this->response->result = $stm->fetch();
                
                return $this->response;

            }catch(Exception $e){
                $this->response->setResponse(false,$e->getMessage());
            }
        }

        public function Delete($id)
        {
            try 
            {
                $stm = $this->db->prepare("DELETE FROM $this->table WHERE idexamen  = ?");			          
                $stm->execute(array($id));
            
                $this->response->setResponse(true);
                return $this->response;
                
            } catch (Exception $e) {
                $this->response->setResponse(false, $e->getMessage());
            }
        }

        public function InsertOrUpdate($data)
        {
            try{
                if (isset($data['id'])) {
                    if ($data['rason'] == 1) {
                        $sql = "UPDATE $this->table SET
                            idCurso  = ?,
                            idModulo = ?,
                            nombre   = ?,
                            archivo  = ?,
                            link     = ?
                        WHERE idexamen = ?";
                    } else {
                        $sql = "UPDATE $this->table SET
                            idCurso  = ?,
                            idModulo = ?,
                            nombre   = ?
                        WHERE idexamen = ?";
                    }

                    if ($data['rason'] == 1) {
                        $arrayData =  array(
                            $data['idc'],
                            $data['idm'],
                            $data['nombre'],
                            $data['archivo'],
                            $data['link'],
                            $data['id']
                        );
                    } else {
                        $arrayData = array(
                            $data['idc'],
                            $data['idm'],
                            $data['nombre'],
                            $data['id']
                        );
                    };

                    $this->db->prepare($sql)
                        ->execute(
                            array($arrayData)
                    );

                } else {
                    $sql = "INSERT INTO $this->table (idexamen , idCurso, idModulo, nombre, archivo, link) 
                    VALUES (?,?,?,?,?,?)";
                    $this->db->prepare($sql)
                        ->execute(
                            array(
                                $data['ida'],
                                $data['idc'],
                                $data['idm'],
                                $data['nombre'],
                                $data['archivo'],
                                $data['link']
                            )
                        );
                }

                $this->response->setResponse(true);
                return $this->response;
            } catch(Exception $e){
                $this->response->setResponse(false, $e->getMessage());
            }
            
        }

    }