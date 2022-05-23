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

<div class="container">
    <h1>Imagenes Guardadas</h1>


<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'consultarq';
$conexion = @new mysqli($server, $username, $password, $database);

$sql="SELECT* from imagephp;";



$result = $conexion->query($sql); //usamos la conexion para dar un resultado a la variable


?>


 <div class="container">
       <button id="btnNuevo" type="button" class="btn btn-success" data-toggle="modal"><a href="subir.php">Subir Nueva Imagen</a></button>
       <br>

        <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">        
                        <table id="tablaDescripcion4" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Identificador</th>
                                <th>Altura</th>
                                <th>Anchura</th>
                                <th>Imagen</th> 
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            
                            
                                while ($row = $result->fetch_array(MYSQLI_ASSOC))
                                    {
                                
                            ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['altura'] ."px"?></td>
                                <td><?php echo $row['anchura']."px" ?></td> 
                                <td><center>
	                              <img WIDTH='150' HEIGHT='150' src="<?php echo '../CONSULTARQMERO/assets/img/servicios/'.$row['imagen'] ?>">
	                                </center>
	                            </td> 
                                
                                <td></td>
                            </tr>
                            <?php
                                }
                            ?>                                
                        </tbody>        
                       </table>                    
                    </div>
                </div>
        </div>     
</div>  
    


 <?php $conexion->close(); //cerramos la conexión

?><?php require_once "vistas/parte_inferior.php"?>

   