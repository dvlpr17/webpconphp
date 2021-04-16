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

    #SUBIR Y GUARDAR SOLO UN ARCHIVO
    $dir_subida = 'm/';
    $fichero_subido = $dir_subida . basename($_FILES['formFile']['name']);
    $fileName = basename($_FILES['formFile']['tmp_name']);
    move_uploaded_file($_FILES['formFile']['tmp_name'], $fichero_subido);
    

    #CONVERTIR ARCHIVO WEBP
    $name = basename($_FILES['formFile']['name']);
    $porciones = explode(".", $name);
    $newName = $porciones[0].'.webp';

    //$img = imagecreatefromjpeg($dir_subida . $name);
    $img = convertImageToWebP($name, $dir_subida);

    imagepalettetotruecolor($img);
    imagealphablending($img, true);
    imagesavealpha($img, true);
    imagewebp($img, $dir_subida . $newName, 80);
    imagedestroy($img);
    
    unlink($fichero_subido);

   

    /*
    echo '<pre>';
    print_r($_FILES);
    echo '</pre>';
    */

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
                    <h1>Selecciona una imagen</h1>
                    <form action="uno.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="formFile" class="form-label"></label>
                            <input class="form-control" type="file" id="formFile" name="formFile">
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
