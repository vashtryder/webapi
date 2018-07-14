<?php
use App\Model\ExamenModel;

#-- Ruta: Perfil Usuario/Cliente
$app->group('/admin/examen/', function() {
    
    $this->get('Lista', function($req, $res, $args){
        $um = new ExamenModel();

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
        $um = new ExamenModel();
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
        $um = new ExamenModel();
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
        $um = new ExamenModel();

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
        $um = new ExamenModel();
    
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


