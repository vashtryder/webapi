<?php
use App\Model\ExamenModel;
use Slim\Http\UploadedFile;


#-- Ruta: Perfil Usuario/Cliente
$app->group('/server/examen/', function() {

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
        $um = new ExamenModel();
        $data = $req->getParsedBody(); //retornará todo los valores que nos hayan enviado.
        $files = $req->getUploadedFiles();
        
        if (empty($files['upfile'])) {
            // throw new Exception('Expected a upfile');
            $um->InsertOrUpdate($data, null, null );
            $request = "El registro se actualizo correctamente.";
        } else {
            $uploadedFile = $files['upfile'];
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $directory = $this->get('upload_directory');
                $uploadFileName = $uploadedFile->getClientFilename();
                $filename = moveUploadedFile($directory, $uploadedFile);
                if ($filename[0] == 0) {
                    $request = $filename[1];
                } else {
                    $um->InsertOrUpdate($data, $uploadFileName, $filename[2]);
                    $request = $filename[1];
                }
            }
        }

        return $res
        ->withHeader('Content-type','application/json')
        ->getBody()
        ->write(
            json_encode(
                $request
            )
         );
        
    });

    $this->post('delete/{id}', function($req, $res, $args){
        $um = new ExamenModel();
        $arrayData = (array) $um->Get($args['id']);
        $directory = $this->get('upload_directory');
        $filename = removeUploadedFile($directory, $arrayData);
        
        if ($filename[0] == 0) {
            $request = $filename[1];
        } else {
            $um->Delete($args['id']);
            $request = $filename[1];
        }
        
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


