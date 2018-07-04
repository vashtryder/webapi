<?php
    use App\Model\UserModel;

    $app->group('/user/', function() {
        
        $this->get('test/{id}', function($req, $res, $args){
            $um = new UserModel();

            return $res->getBody()
                ->write(
            
                    $args['id']
                );

        });

        $this->get('getAll', function($req, $res, $args){
            $um = new UserModel();

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
            $um = new UserModel();
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
            // $data = $req->getParsedBody(); retornará todo los valores que nos hayan enviado.
            $um = new UserModel();

            return $res
            ->withHeader('Content-type','application/json')
            ->getBody()
            ->write(
                json_encode(
                    $um->GetAll()
                )
             );
        });

        $this->post('delete/{id}', function($req, $res, $args){
            $um = new UserModel();
        
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

    $app->group('/admin/',function() {
        $this->get('test', function($req, $res, $args){
            $um = new UserModel();
            return $res->getBody()
                ->write(
                    $args['id']
                );
        });
    }