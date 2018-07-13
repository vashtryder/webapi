<?php
use App\Model\TemaModel;

#-- Ruta: Perfil Usuario/Cliente
$app->group('/server/tema/', function() {
    
    $this->get('Lista', function($req, $res, $args){
        $um = new TemaModel();

        return $res
        ->withHeader('Content-type','application/json')
        ->getBody()
        ->write(
            json_encode(
                $um->GetAll()
            )
        );
    });

    $this->get('vista', function($req, $res, $args){
        $um = new TemaModel();
        return $res
        ->withHeader('Content-type','application/json')
        ->getBody()
        ->write(
            json_encode(
                $um->GetVista()
            )
        );
    });
    
    $this->get('get/{id}', function($req, $res, $args){
        $um = new TemaModel();
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
        $um = new TemaModel();

        return $res
        ->withHeader('Content-type','application/json')
        ->getBody()
        ->write(
            json_encode(
                $um->GetAll()
            )
         );
    });

    $this->get('delete/{id}', function($req, $res, $args){
        $um = new TemaModel();
    
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

