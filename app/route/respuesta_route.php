<?php
use App\Model\RespuestaModel;

#-- Ruta: Perfil Usuario/Cliente
$app->group('/admin/respuesta/', function() {
    
    $this->get('Lista', function($req, $res, $args){
        $um = new RespuestaModel();

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
        $um = new RespuestaModel();
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
        $um = new RespuestaModel();

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
        $um = new RespuestaModel();
    
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

