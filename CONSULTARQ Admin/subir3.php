<?php
session_start();
if(@$_SESSION['id_user']==''){
?>
<?php
  echo '<meta http-equiv="refresh" content="0;index.php">';
  exit(0);
}
?>

<?php require_once "vistas/parte_superior.php"?>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Subir imagenes</h1>



<?php
include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT * FROM service;";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);
?>


    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <h2>Selecciona una imagen</h2>
                <form method="POST" enctype="multipart/form-data" >
                    <input name="myfile" type="file">
                    <input class="btn btn-success" type="submit" value="Guardar Imagen">
                </form>

            </div>
        </div>
    </div>
    <br>


<?php
# Conectamos con MySQL
$mysqli=new mysqli("localhost","root","","consultarq");
if (mysqli_connect_errno()) {
die("Error al conectar: ".mysqli_connect_error());
}

if (isset($_FILES) && isset($_FILES['myfile']) && !empty($_FILES['myfile']['name'] && !empty($_FILES['myfile']['tmp_name']))) {

    if(is_uploaded_file($_FILES['myfile']['tmp_name'])){
            echo "Error: El fichero encontrado no fue procesado correctamente";
            exit;
    }

    $source= $_FILES['myfile']['tmp_name'];
    $destination= __DIR__.'/assets/'.$_FILES['myfile']['tmp_name'];

    if (is_file($destination)) {
        echo "Error: Ya existe un fichero con ese nombre";
        @unlink(ini_get('upload_tmp_dir').$_FILES['myfile']['tmp_name']);
        exit;
    }

    if (!@move_uploaded_file($source, $destination)) {
        echo "Error: No se ha podido mover el fichero enviado a la carpeta destino";
        @unlink(ini_get('upload_tmp_dir').$_FILES['myfile']['tmp_name']);
        exit;
        # code...
    }
    echo "Fichero subido correctamente a: ".$destination;
}
?>

<?php require_once "vistas/parte_inferior.php"?>
