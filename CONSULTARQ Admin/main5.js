$(document).ready(function(){

    tablaServicios = $("#tablaServicios").DataTable({
        //Para cambiar el lenguaje a español
            "columnDefs":[{
            "targets": -1,
            "data":null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btnEditar5'>Editar</button><button class='btn btn-danger btnBorrar5'>Borrar</button></div></div>"
         }],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast":"Último",
                "sNext":"Siguiente",
                "sPrevious": "Anterior"
             },
             "sProcessing":"Procesando...",
        }
    });
    
});

$("#btnNuevo5").click(function(){
    $("#formDescripcion").trigger("reset");
    $(".modal-header").css("background-color", "#1cc88a");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Nueva solicitud");
    $("#modalCRUD5").modal("show");
    fechaA=null;
    numeroA=null;
    nombre=null;
    opcion = 1; //alta
});

$(document).on("click", ".btnEditar5", function(){
    fila = $(this).closest("tr");
    nombre = fila.find('td:eq(0)').text();
    fechaA = fila.find('td:eq(1)').text();
    numeroA = fila.find('td:eq(2)').text();

    $("#id_servicio5 option:selected").text(nombre);
    $("#fecha").val(fechaA);
    $("#numero").val(numeroA);

    opcion = 2; //editar

    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Editar Solicitud");
    $("#modalCRUD5").modal("show");

});

$("#formDescripcion5").submit(function(e){
    e.preventDefault();
    id_servicio = parseInt($("#id_servicio5").val());
    fecha = $.trim($("#fecha").val());
    numero = $.trim($("#numero").val());

    $.ajax({
        url: "bd/crud5.php",
        type: "POST",
        dataType: "json",
        data: {id_servicio:id_servicio, fecha:fecha, numero:numero, nombre:nombre, fechaA:fechaA, opcion:opcion},
        success: function(data){
            console.log(data);
            nombre = data[0].nombre;
            fecha = data[0].fecha;
            numero = data[0].numero;
            if(opcion == 1){
              tablaServicios.row.add([nombre,fecha,numero]).draw();
            }
            else{
              tablaServicios.row(fila).data([nombre,fecha,numero]).draw();
            }
        },
        error:function(){
            console.log("nel");
        }
    });
    $("#modalCRUD5").modal("hide");

});

$(document).on("click", ".btnBorrar5", function(){
    fila = $(this);
    nombre = $(this).closest("tr").find('td:eq(0)').text();
    fecha = $(this).closest("tr").find('td:eq(1)').text();
    numero = $(this).closest("tr").find('td:eq(2)').text();
    opcion=3;

    var respuesta = confirm("¿Está seguro de eliminar el registro Servicio: "+nombre+", Fecha: "+fecha+", N° Solicidudes: "+numero+"?");

    if(respuesta){
        $.ajax({
            url: "bd/crud5.php",
            type: "POST",
            data: {opcion:opcion, nombre:nombre, fecha:fecha},
            success: function(){
                tablaServicios.row(fila.parents('tr')).remove().draw();
            }
        });
    }
});