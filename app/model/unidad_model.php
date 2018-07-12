<?php
    namespace App\Model;

    use PDO;
    use App\Lib\Database;
    use App\Lib\Response;

    class UnidadModel
    {
        private $db;
        private $table = 'tb_unidad';
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

                $stm = $this->db->prepare("SELECT * FROM $this->table WHERE idUnidad = ? ");
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
                $stm = $this->db->prepare("DELETE FROM $this->table WHERE idUnidad = ?");
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
                if (isset($data['idUnidad'])) {
                    $sql ="UPDATE $this->table SET
                    nombreUnidad   = ?,
                    abrevUnidad    = ?
                    WHERE idUnidad = ?";

                    $this->db->prepare($sql)
                        ->execute(
                            array(
                                $data['nombreUnidad'],
                                $data['abrevUnidad'],
                                $data['idUnidad']
                            )
                        );
                } else {
                    $sql = "INSERT INTO $this->table (nombreUnidad, abrevUnidad)
                    VALUES (?,?)";
                    $this->db->prepare($sql)
                        ->execute(
                            array(
                                $data['nombreUnidad'],
                                $data['abrevUnidad']
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