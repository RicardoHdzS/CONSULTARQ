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
    <h1>Servicios</h1>
    
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
            <button id="btnNuevo" type="button" class="btn btn-success" data-toggle="modal">Nuevo</button></div>    
        </div>    
    </div>    
    <br>  
    
    <div class="container">
        <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">        
                        <table id="tablaDescripcion" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Identificador</th>
                                <th>Servicio</th>
                                <th>Descripción</th>
                                <th>Imagen</th>
                                <th>Estatus</th> 
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            
                            foreach($data as $dat) {                                                        
                            ?>
                            <tr>
                                <td><?php echo $dat['id_servicio'] ?></td>
                                <td><?php echo $dat['nombre'] ?></td>
                                <td><?php echo $dat['descripcion'] ?></td> 
                                <td><?php echo $dat['imagen'] ?></td>
                                <td><?php echo $dat['status'] ?></td>  
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
    <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <form id="formDescripcion">    
                <div class="modal-body">
                    <div class="form-group">
                    <label for="nombre" class="col-form-label">Servicio:</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Nombre del servicio">
                    </div>                
                    <div class="form-group">
                    <label for="descripcion" class="col-form-label">Descripción:</label>
                    <br>
                    <textarea id="descripcion" placeholder="Puntos de cada servicio." class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                    <label for="descripcion" class="col-form-label">Imagen:</label>
                    <input type="text" class="form-control" id="imagen" placeholder="# de id respectivo de la imagen a poner">
                    </div> 
                    <div class="form-group">
                    <label for="descripcion" class="col-form-label">Estatus:</label>
                    <input type="text" class="form-control" id="status" placeholder="0 para ocultar / 1 para mostrar"> 
                    <!--<label>Estatus:
                              <select  name="tipo" aria-describedby="exampleHelpText2" required >
                                  <option value="">Selecciona un Tipo</option>
                                  <option value="0">0 (Ocultar)</option>
                                  <option value="1">1 (Mostrar)</option>
                              </select>
                        </label> -->
                    </div>  
                    <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnGuardar" class="btn btn-dark" >Guardar</button>
                    </div>
                </div>
            </form>    
            </div>
        </div>
    </div>  
      
</div>
<!--FIN del cont principal-->

<?php require_once "vistas/parte_inferior.php"?>