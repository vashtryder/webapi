<?php
    use App\Model\PerfilModel;

    #-- Ruta: Perfil Usuario/Cliente
    $app->group('/server/perfil/', function() {
        
        $this->get('Lista', function($req, $res, $args){
            $um = new PerfilModel();

            return $res
            ->withHeader('Content-type','application/json')
            ->getBody()
            ->write(
                json_encode(
                    $um->GetAll()
                )
            );
        });
        
        $this->get('get/{id}', function($req, $res, $args){
            $um = new PerfilModel();
            return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $um->Get($args['id'])
                )
            );
        });

        $this->post('save', function($req, $res){
            $data = $req->getParsedBody();
            $um = new PerfilModel();
            return $res
            ->withHeader('Content-type','application/json')
            ->getBody()
            ->write(
                json_encode(
                    $um->InsertOrUpdate($data)
                )
             );
        });

        $this->post('delete/{id}', function($req, $res, $args){
            $um = new PerfilModel();
        
            return $res
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $um->Delete($args['id'])
                )
            );
        });
    });