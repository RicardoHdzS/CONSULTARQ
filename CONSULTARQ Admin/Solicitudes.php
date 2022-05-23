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
    <h1>Solicitudes</h1>

<?php
include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$consulta = "SELECT nombre, fecha, numero FROM service INNER JOIN solicitud ON service.id_servicio = solicitud.id_servicio ORDER BY fecha DESC;";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data=$resultado->fetchAll(PDO::FETCH_ASSOC);

$consulta2 = "SELECT solicitud.id_servicio, nombre FROM solicitud INNER JOIN service ON service.id_servicio = solicitud.id_servicio GROUP BY nombre";
$resultado2 = $conexion->prepare($consulta2);
$resultado2->execute();
$data2=$resultado2->fetchAll(PDO::FETCH_ASSOC);

$consulta3 = "SELECT id_servicio, nombre FROM service";
$resultado3 = $conexion->prepare($consulta3);
$resultado3->execute();
$data3=$resultado3->fetchAll(PDO::FETCH_ASSOC);
?>

    <div class="container">
        <div class="row">
            <div class="col"> 
            <label for="fechaInicial" class="col-form-label">Fecha inicial:</label>
            <input type="date" class="form-control" id="fechaInicial">
            </div>
            <div class="col"> 
            <label for="fechaFinal" class="col-form-label">Fecha final:</label>
            <input type="date" class="form-control" id="fechaFinal">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12">  
         <!--   <button id="btnNuevo5" type="button" class="btn btn-success" data-toggle="modal">Nuevo</button>    -->      
            <button id="btnGeneral" type="button" class="btn btn-success" data-toggle="modal">Reporte general</button>
            <button id="btnMensual" type="button" class="btn btn-success" data-toggle="modal">Reporte mensual</button>
            <button id="btnDiario" type="button" class="btn btn-success" data-toggle="modal">Reporte por fecha</button>
            </div>    
        </div>    
    </div>    
    <br> 
    
    <!--Modal para gráficos-->    
    <div id="modal-1" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                 <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>        
                    <div class="modal-body"> 
                        <!--En este container se muestran los gráficos-->
                        <div id="contenedor-modal" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    </div>                    
            </div>
        </div>
    </div>

    <div id="modal-2" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                 <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>   

                    <center> 
                    <div class="modal-body"> 
                        <!--En este container se muestran los gráficos-->
                        <div class="row">
                            <div class="col"> 
                            <select name="id_diario" id="id_diario" class="form-control" placeholder="Servicio *" required="required">
                                <option style="">Elige un Servicio:</option>
                                <?php                            
                                foreach($data2 as $dat) {                                    
                                ?>
                                <option value="<?php echo $dat['id_servicio'] ?>"><?php echo $dat['nombre'] ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            </div>
                            <div class="col" style="margin-right: -5rem;"> 
                            <button type="submit" id="btnDiarioS" class="btn btn-success">Graficar</button>
                            </div>
                        </div>
                        
                        <div id="contenedor-modal2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    </div>   
                    </center>                    
            </div>
        </div>
    </div> 

    <div class="container">
        <div class="row">
            <div class="col-lg-12">            
            <button id="btnNuevo5" type="button" class="btn btn-success" data-toggle="modal">Nuevo</button></div>    
        </div>    
    </div> 

    <br>
    
    <div class="container">
        <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">        
                        <table id="tablaServicios" class="table table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Servicio</th>
                                <th>Fecha</th>
                                <th>N° Solicitudes</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                            
                            foreach($data as $dat) {                                                        
                            ?>
                            <tr>
                                <td><?php echo $dat['nombre'] ?></td>
                                <td><?php echo $dat['fecha'] ?></td>
                                <td><?php echo $dat['numero'] ?></td>
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
    <div class="modal fade" id="modalCRUD5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formDescripcion5">    
                <div class="modal-body">
                    <div class="form-group">
                    <label for="nombre" class="col-form-label">Servicio:</label>
                    <!---<input type="text" class="form-control" id="nombre" placeholder="Número del Servicio"> --->
                    <!--<label>Estatus:
                              <select  name="tipo" aria-describedby="exampleHelpText2" required >
                                  <option value="">Selecciona un Tipo</option>
                                  <option value="0">0 (Ocultar)</option>
                                  <option value="1">1 (Mostrar)</option>
                              </select>
                        </label> -->

                    <select name="id_servicio5" id="id_servicio5" class="form-control" placeholder="Servicio *" required="required">
                                <option style="">Elige un Servicio:</option>
                                <?php                            
                                foreach($data3 as $dat) {                                    
                                ?>
                                <option value="<?php echo $dat['id_servicio'] ?>"><?php echo $dat['nombre'] ?></option>
                                <?php
                                    }
                                ?>
                    </select>
                    </div>  

                    <div class="form-group">
                    <label for="fecha" class="col-form-label">Fecha:</label>
                    <input type="date" class="form-control" id="fecha" placeholder="Nombre del servicio">
                    </div>  

                    <div class="form-group">
                    <label for="numero" class="col-form-label">Número de Solicitudes:</label>
                    <input type="text" class="form-control" id="numero" placeholder="#">
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

    <script src="popper/popper.min.js"></script>
        
     <!-- Highcharts JS -->              
    <script src="pluggins/Highcharts_7.0.3/code/highcharts.js"></script>
    <script src="pluggins/Highcharts_7.0.3/code/modules/exporting.js"></script>
    <script src="pluggins/Highcharts_7.0.3/code/modules/export-data.js"></script>        
    <script src="pluggins/Highcharts_7.0.3/code/modules/drilldown.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>

<?php require_once "vistas/parte_inferior.php"?>