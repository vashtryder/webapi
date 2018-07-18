<?php
    namespace App\Model;

    use PDO;
    use App\Lib\Database;
    use App\Lib\Response;

    class TemaModel
    {
        private $db;
        private $table = 'tb_tema';
        private $view = 'vb_tema';
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

                $stm = $this->db->prepare("SELECT * FROM $this->table WHERE idTema = ? ");
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
                $stm = $this->db->prepare("DELETE FROM $this->table WHERE idTema = ?");			          
                $stm->execute(array($id));
            
                $this->response->setResponse(true);
                return $this->response;
                
            } catch (Exception $e) {
                $this->response->setResponse(false, $e->getMessage());
            }
        }

        public function InsertOrUpdate($data , $file, $url)
        {
            try{
                if (isset($data['idTema'])) {
                    
                    if ($file != null) {
                        $sql = "UPDATE $this->table SET
                            idCurso  = ?,
                            idModulo = ?,
                            nombre   = ?,
                            archivo  = ?,
                            link     = ?
                        WHERE idTema = ?";
                    } else {
                        $sql = "UPDATE $this->table SET
                            idCurso  = ?,
                            idModulo = ?,
                            nombre   = ?
                        WHERE idTema = ?";
                    }

                    if ($file != null) {
                        $arrayData =  array(
                            $data['idCurso'],
                            $data['idModulo'],
                            $data['nombreTema'],
                            $file,
                            $url,
                            $data['idTema']
                        );
                    } else {
                        $arrayData = array(
                            $data['idCurso'],
                            $data['idModulo'],
                            $data['nombreTema'],
                            $data['idTema']
                        );
                    };

                    $this->db->prepare($sql)
                        ->execute(
                            $arrayData
                    );

                } else {
                    $sql = "INSERT INTO $this->table ( idCurso, idModulo, nombre, archivo, link) 
                    VALUES (?,?,?,?,?)";
                    $this->db->prepare($sql)
                        ->execute(
                            array(
                                $data['idCurso'],
                                $data['idModulo'],
                                $data['nombreTema'],
                                $file,
                                $url
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