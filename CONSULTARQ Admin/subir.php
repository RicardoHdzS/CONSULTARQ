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

                <!-- <button id="btnNuevo" type="button" class="btn btn-success" data-toggle="modal">Nueva</button>
            <button id="btnNuevo" type="button" class="btn btn-success" data-toggle="modal">Guardar cambios</button>
            -->

                <h2>Selecciona una imagen</h2>
                <form enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
                    <input name="userfile" type="file">
                    <p><input class="btn btn-success" type="submit" value="Guardar Imagen">
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

              # Cogemos la anchura y altura de la imagen
$info=getimagesize($_FILES["userfile"]["tmp_name"]);     

		$nombre_archivo = $_FILES['userfile']['name'];
        $tipo_archivo = $_FILES['userfile']['type'];
        $tamano_archivo = $_FILES['userfile']['size'];
        $tmp_archivo = $_FILES['userfile']['tmp_name'];
        
        

        //echo $nombre_archivo." nombre del archivo <br>";
        //echo $tipo_archivo." tipo <br>";
        //echo $tamano_archivo." tamaÒo del archivo<br>";
        //echo $tmp_archivo." archivo temporal <br>";

        ini_set('memory_limit','32M');
        @ini_set('memory_limit', '256M');
        ini_set('upload_max_filesize','100%');
        @ini_set('upload_max_filesize','100%');
        ini_set('post_max_size','100%');
        @ini_set('post_max_size','100%');
        ini_set('max_file_uploads','20');
        
        
       //renombrar archivo
        $xx=array();
        $xx=explode('.',$nombre_archivo);
        $nom= $xx[0];
        $ext= $xx[1];
        $nuevo=$nombre_archivo;

        
        if ($ext =="jpg" || $ext =="png" || $ext =="jpeg"|| $ext =="JPG" || $ext =="PNG" || $ext =="JPEG")
        {
                    $status = "";
                    if ($nombre_archivo != "")
                    {
                        // guardamos el archivo a la carpeta especificada
                        $destino =  "../CONSULTARQMERO/assets/img/servicios/".$nombre_archivo;
                        //echo $destino." destino <br>";
                    } else {
                        echo "<div class='error'>Error: El formato de archivo tiene que ser JPG, GIF, BMP o PNG.</div>";
                        }

                    if ($nombre_archivo!="")
                    {
                        if (move_uploaded_file($_FILES['userfile']['tmp_name'],$destino))
                            {
                    $status = "NOMBRE DEL ARCHIVO: <b>".$nombre_archivo."</b>";
                                //Renombramos el Archivo almacenado
                                    rename("../CONSULTARQMERO/assets/img/servicios/".$nombre_archivo,"../CONSULTARQMERO/assets/img/servicios/".$nuevo) or die('Error al Almacenar');
                                    $destino2 =  "../CONSULTARQMERO/assets/img/servicios/".$nuevo;
                                //termina renombre...
                            }
                            $ruta_imagen="../CONSULTARQMERO/assets/img/servicios/".$nuevo;
                            $miniatura_ancho_maximo = 350;
                            $miniatura_alto_maximo = 400;
                            $info_imagen = getimagesize($ruta_imagen);
                            $imagen_ancho = $info_imagen[0];
                            $imagen_alto = $info_imagen[1];
                            $imagen_tipo = $info_imagen['mime'];
                            $lienzo = imagecreatetruecolor( $miniatura_ancho_maximo, $miniatura_alto_maximo );
                            
                            switch ( $imagen_tipo )
                            {
                                case "image/jpg":
                                case "image/jpeg":
                                    $imagen = imagecreatefromjpeg( $ruta_imagen );
                                    break;
                                case "image/png":
                                    $imagen = imagecreatefrompng( $ruta_imagen );
                                    break;
                                case "image/gif":
                                    $imagen = imagecreatefromgif( $ruta_imagen );
                                    break;
                            }

                        imagecopyresampled($lienzo, $imagen, 0, 0, 0, 0, $miniatura_ancho_maximo, $miniatura_alto_maximo, $imagen_ancho, $imagen_alto);
                        imagejpeg( $lienzo, "$ruta_imagen", 90 );

                    }
                    


                      # Agregamos la imagen a la base de datos
			$sql="INSERT INTO `imagephp` (anchura,altura,tipo,imagen) VALUES (".$info[0].",".$info[1].",'".$_FILES["userfile"]["type"]."','".$nombre_archivo."')";
		
			$mysqli->query($sql);
	
			# Cogemos el identificador con que se ha guardado
			$id=$mysqli->insert_id;
			
			if($mysqli){
	        	echo " <meta http-equiv='Refresh' content='0 ;url=imagen.php'> ";
	        }
		
                    
        }
        
      

?>







<?php require_once "vistas/parte_inferior.php"?>
