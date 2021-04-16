<?php 

    function convertImageToWebP($source, $destination) {
        $extension = pathinfo($source, PATHINFO_EXTENSION);

        if ($extension == 'jpeg' || $extension == 'jpg')
            $image = imagecreatefromjpeg($destination . $source);
        elseif ($extension == 'gif')
            $image = imagecreatefromgif($destination . $source);
        elseif ($extension == 'png')
            $image = imagecreatefrompng($destination . $source);

        return $image;
    }
    

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {


    # PAGINA DEL EJEMPLO | SUBIR MULTIPLES ARCHIVOS
    //https://codigosdeprogramacion.com/2017/06/01/subir-multiples-archivos-o-imagenes-con-php/

    //Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
    foreach($_FILES["formFile"]['tmp_name'] as $key => $tmp_name) {
        //Validamos que el archivo exista
        if($_FILES["formFile"]["name"][$key]) {
            $filename = $_FILES["formFile"]["name"][$key]; //Obtenemos el nombre original del archivo
            $source = $_FILES["formFile"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
            
            $directorio = 'm/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
            
            //Validamos si la ruta de destino existe, en caso de no existir la creamos
            if(!file_exists($directorio)){
                mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");    
            }
            
            $dir=opendir($directorio); //Abrimos el directorio de destino
            $target_path = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
            
            //Movemos y validamos que el archivo se haya cargado correctamente
            //El primer campo es el origen y el segundo el destino


            move_uploaded_file($_FILES["formFile"]["tmp_name"][$key], $target_path);
            // move_uploaded_file($_FILES['formFile']['tmp_name'], $fichero_subido);
            
            #CONVERTIR ARCHIVO WEBP
            $name = basename($_FILES['formFile']['name'][$key]);
            $porciones = explode(".", $name);
            $newName = $porciones[0].'.webp';

            //$img = imagecreatefromjpeg($dir_subida . $name);
            $img = convertImageToWebP($name, $directorio);

            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);
            imagewebp($img, $directorio . $newName, 80);
            imagedestroy($img);
            
            unlink($target_path);

            closedir($dir); //Cerramos el directorio de destino
        }
    }


}






?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="author" content="" />
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>

        <section class="container">
            <div class="row">
                <div class="col-6">
                    <h1>Selecciona las imagens</h1>
                    <form action="varios.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="formFile" class="form-label"></label>
                            <input class="form-control" type="file" id="formFile[]" name="formFile[]" multiple="">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
                <div class="col-12 mt-5">
                    <a class="btn btn-info" href="index.php">Volver</a>
                </div>
            </div>
        </section>





        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/script.js" type="text/javascript"></script>
    </body>
</html>
