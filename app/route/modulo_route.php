<?php
use App\Model\ModuloModel;

#-- Ruta: Perfil Usuario/Cliente
$app->group('/server/modulo/', function() {
    
    $this->get('Lista', function($req, $res, $args){
        $um = new ModuloModel();

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
        $um = new ModuloModel();
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
        $data = $req->getParsedBody(); //retornará todo los valores que nos hayan enviado.
        $um = new ModuloModel();

        return $res
        ->withHeader('Content-type','application/json')
        ->getBody()
        ->write(
            json_encode(
                $um->InsertOrUpdate($data)
            )
         );
    });

    $this->get('delete/{id}', function($req, $res, $args){
        $um = new ModuloModel();
    
        return $res
        ->withHeader('Content-type', 'application/json')
        ->getBody()
        ->write(
            json_encode(
                $um->Delete($args['id'])
            )
        );
    });

    $this->get('vista', function($req, $res, $args){
        $um = new ModuloModel();

        return $res
        ->withHeader('Content-type','application/json')
        ->getBody()
        ->write(
            json_encode(
                $um->GetVista()
            )
        );
    });
});

