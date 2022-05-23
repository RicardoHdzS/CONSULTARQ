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
    <h1>Personal</h1>

<?php
include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT * FROM user;";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);

?>


    <div class="container">
        <div class="row">
            <div class="col-lg-12">            
            <button id="btnNuevo3" type="button" class="btn btn-success" data-toggle="modal">Nuevo</button></div>    
        </div>    
    </div>    
    <br>  
    
    <div class="container">
        <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">        
                        <table id="tablaDescripcion3" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Identificador</th>
                                <th>Nombre</th>                              
                                <th>Correo Electrónico</th>
                                <th>Contraseña</th>
                                <th>Teléfono</th> 
                                <th>Tipo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            
                            foreach($data as $dat) {                                                        
                            ?>
                            <tr>
                                <td><?php echo $dat['id_user'] ?></td>
                                <td><?php echo $dat['nombreUser']." ".$dat['apellidosUser']?></td>
                                <td><?php echo $dat['correoUser'] ?></td> 
                                <td><?php echo $dat['password']?></td>
                                <td><?php echo $dat['telefonoUser'] ?></td>
                                <td><?php echo $dat['tipoUser'] ?></td>  
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
      
    <!--Modal para CRUD-->
    <div class="modal fade" id="modalCRUD3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title3" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <form id="formDescripcion3">    
                <div class="modal-body">
                    <div class="form-group">
                    <label for="nombreUser" class="col-form-label">Nombre:</label>
                    <input type="text" class="form-control" id="nombreUser"  placeholder="Nombre del empleado">
                    </div>  
                    <div class="form-group">
                    <label for="apellidosUser" class="col-form-label">Apellidos:</label>
                    <input type="text" class="form-control" id="apellidosUser"  placeholder="Apellidos del empleado">
                    </div>     
                    <div class="form-group">
                    <label for="correoUser" class="col-form-label">Correo Electrónico:</label>
                    <input type="text" class="form-control" id="correoUser"  placeholder="empleado@gmail.com">
                    </div> 
                    <div class="form-group">
                    <label for="password" class="col-form-label">Password:</label>
                    <input type="password" class="form-control" id="password"  placeholder="*****">
                    </div> 
                    <div class="form-group">
                    <label for="telefonoUser" class="col-form-label">Teléfono:</label>
                    <input type="text" class="form-control" id="telefonoUser"  placeholder="##########">
                    </div> 
                    <div class="form-group">
                    <label for="tipoUser" class="col-form-label">Tipo Usuario:</label>
                    <input type="text" class="form-control" id="tipoUser"  placeholder="Tipo del usuario">
                    </div> 
                    <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
                    </div>
                </div>
            </form>    
            </div>
        </div>
    </div>  
</div>

<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php"?>