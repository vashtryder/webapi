<?php
use App\Model\TemaModel;
use Slim\Http\UploadedFile;

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
        $um = new TemaModel();

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

    $this->get('delete/{id}', function($req, $res, $args){
        $um = new TemaModel();
        $arrayData = (array) $um->Set($args['id']);
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
                $request
            )
        );
    });
});

function removeUploadedFile($directory, $data)
{
    $enviarDatos = []; // Errores se guardara en esta variable
    $arrayExtensions = array('pdf','docx','doc','xls','xlsx','avi','mkv','mp4');
    $errors          = true;
    
    $fileName        = empty($data['archivo']) ? null : $data['archivo'];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $uploadDirectory = array(
        'pdf'  => DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR,
        'mp4'  => DIRECTORY_SEPARATOR . 'video' . DIRECTORY_SEPARATOR,
        'mkv'  => DIRECTORY_SEPARATOR . 'video' . DIRECTORY_SEPARATOR,
        'avi'  => DIRECTORY_SEPARATOR . 'video' . DIRECTORY_SEPARATOR,
        'docx' => DIRECTORY_SEPARATOR . 'doc' . DIRECTORY_SEPARATOR,
        'xlsx '=> DIRECTORY_SEPARATOR . 'doc' . DIRECTORY_SEPARATOR
    );

    switch ($fileExtension) {
        case 'pdf':
            $target_file = $directory . $uploadDirectory[$fileExtension] . $fileName;
            $url_file = 'http://api.elearn.com/uploads/' . $fileExtension . '/' .  $fileName;
            $errors = true;
            break;
        case 'avi':
        case 'mkv':
        case 'mp4':
            $target_file = $directory . $uploadDirectory[$fileExtension] . $fileName;
            $url_file = 'http://api.elearn.com/uploads/' . $fileExtension . '/' .  $fileName;
            $errors = true;
            break;
        default:
            $target_file = '';
            $url_file = '';
            $errors = false;
            break;
    }

    if(empty($fileName)){
        $enviarDatos = array(1,"El archivo no existe o ha sido borrado. Inténtalo de nuevo o contacta al administrador");
        $errors = false;
    }

    if($errors){
        @unlink($target_file);
        $enviarDatos = array(1,"El Archivo ". basename($fileName)." ha sido eliminado.");
    } 

    // $enviarDatos = array(
    //     $errors,
    //     $fileName,
    //     $fileExtension,
    //     $target_file,
    //     $directory,
    //     $data
    // );

    return $enviarDatos;
}


function moveUploadedFile($directory, UploadedFile $uploadedFile)
{
    $enviarDatos = []; // Errores se guardara en esta variable

    $arrayExtensions = array('pdf','docx','doc','xls','xlsx','avi','mkv','mp4');
    $suffixes        = array('', 'KB', 'MB', 'GB', 'TB');
    $errors          = true;

    $fileName      = $uploadedFile->getClientFilename();
    $fileSize      = $uploadedFile->getSize();
    $fileType      = $uploadedFile->getClientMediaType();
    $fileExtension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $fileBase      = log($fileSize,1024);
    $fileWeight    = round(pow(1024, $fileBase - floor($fileBase)));

    $uploadDirectory = array(
        'pdf'  => DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR,
        'mp4'  => DIRECTORY_SEPARATOR . 'video' . DIRECTORY_SEPARATOR,
        'mkv'  => DIRECTORY_SEPARATOR . 'video' . DIRECTORY_SEPARATOR,
        'avi'  => DIRECTORY_SEPARATOR . 'video' . DIRECTORY_SEPARATOR,
        'docx' => DIRECTORY_SEPARATOR . 'doc' . DIRECTORY_SEPARATOR,
        'xlsx '=> DIRECTORY_SEPARATOR . 'doc' . DIRECTORY_SEPARATOR
      );
    
    switch ($fileExtension) {
        case 'pdf':
            $target_file = $directory . $uploadDirectory[$fileExtension] . $fileName;
            $url_file = 'http://api.elearn.com/uploads/' . $fileExtension . '/' .  $fileName;
            $errors = true;
            break;
        case 'avi':
        case 'mkv':
        case 'mp4':
            $target_file = $directory . $uploadDirectory[$fileExtension] . $fileName;
            $url_file = 'http://api.elearn.com/uploads/' . $fileExtension . '/' .  $fileName;
            $errors = true;
            break;
        default:
            $target_file = '';
            $url_file = '';
            $errors = false;
            break;
    }
 
    if(!in_array($fileExtension, $arrayExtensions )) {
        $enviarDatos = array(0,"Esta extensión de archivo no está permitida. Cargue solo archivos AVI | MKV | MP4 | PDF ");
        $errors = false;
    }

    if ($fileSize > 500000000) {
        $enviarDatos = array(0,"El tamaño del archivo ". basename($_FILES["upfile"]["name"])." es ". $fileWeight . $suffixes[floor($fileBase)]." <br>. Lo siento, tiene que ser menor o igual a 50MB.");
        $errors = false;
    }

    if (file_exists($target_file)) {
        $enviarDatos = array(0,"El archivo " . basename($fileName). " ya fue cargado. Inténtalo de nuevo o contacta al administrador");
        $errors = false;
    }

    if($errors){
        $uploadedFile->moveTo($target_file);
        $enviarDatos = array(1,"El Archivo ". basename($fileName)." ha sido cargado.", $url_file);
    } 

    // $enviarDatos = array(
    //     $fileName,
    //     $fileSize,
    //     $fileType,
    //     $fileExtension,
    //     $fileWeight.$suffixes[floor($fileBase)],
    //     $target_file,
    //     $directory,
    //     $errors
    // );

    return $enviarDatos;
}

