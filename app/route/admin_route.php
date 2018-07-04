<?php
    # -- Ruta: Perfil Administrador
    $app->group('/admin/',function() {
        $this->get('test', function($req, $res, $args){
            $um = new UserModel();
            return $res->getBody()
                ->write(
                    "Estas en el nivel Administrador"
                );
        });
    });