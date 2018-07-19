<?php
    namespace App\Model;

    use PDO;
    use App\Lib\Database;
    use App\Lib\Response;

    class PerfilModel
    {
        private $db;
        private $table_login = 'tb_pefil';
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

        public function Get($id)
        {
            try{    
                $result = array();

                $stm = $this->db->prepare("SELECT * FROM $this->table WHERE idPerfil = ? ");
                $stm->execute(array($id));

                $this->response->setResponse(true);
                $this->response->result = $stm->fetch();
                
                return $this->response;

            }catch(Exception $e){
                $this->response->setResponse(false,$e->getMessage());
            }
        }

        public function Set($id)
        {
            try{    
                $result = array();

                $stm = $this->db->prepare("SELECT * FROM $this->table WHERE idPerfil = ? ");
                $stm->execute(array($id));
                return  $stm->fetch();
            }catch(Exception $e){
                $this->response->setResponse(false,$e->getMessage());
            }
        }

        public function Delete($id)
        {
            try 
            {
                $stm = $this->db->prepare("DELETE FROM $this->table WHERE idPerfil = ?");			          
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
                if (isset($data['idPerfil'])) {
                    $sql = "UPDATE $this->table SET
                            Nombres ?,
                            Apellidos,
                            email,
                            pass = ?
                            WHERE idPerfil = ?";

                    $this->db->prepare($sql)
                        ->execute(
                            array(
                                $data['nombres'],
                                $data['apellidos'],
                                $data['email'],
                                $data['idPerfil']
                            )
                        );
                } else {
                    $sql = "INSERT INTO $this->table (idLogin,Nombres,Apellidos, dni, email, foto) 
                    VALUES (?,?,?,?,?,?)";
                    $this->db->prepare($sql)
                        ->execute(
                            array(
                                $data['idLogin'],
                                $data['nombres'],
                                $data['apellidos'],
                                $data['dni'],
                                $data['email'],
                                null
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