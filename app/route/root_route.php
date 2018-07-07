<?php
    # -- Ruta: Perfil Administrador
    $app->group('/users/',function() {
        $this->get('test', function($req, $res, $args){
            return $res->getBody()
                ->write(
                    "Nivel Usuario"
                );
        });

        $this->get('login', function($req, $res, $args){
            return $res->getBody()
                ->write(
                    "login aqui"
                );
        });
        
    });