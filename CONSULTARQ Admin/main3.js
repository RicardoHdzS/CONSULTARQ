$(document).ready(function(){

    tablaDescripcion3 = $("#tablaDescripcion3").DataTable({
       "columnDefs":[{
        "targets": -1,
        "data":null,
        "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btnEditar'>Editar</button><button class='btn btn-danger btnBorrar3'>Borrar</button></div></div>"
       }],

        //Para cambiar el lenguaje a español
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


$("#btnNuevo3").click(function(){
    $("#formDescripcion3").trigger("reset");
    $(".modal-header").css("background-color", "#1cc88a");
    $(".modal-header").css("color", "white");
    $(".modal-title3").text("Nuevo Empleado");
    $("#modalCRUD3").modal("show");
    id_user=null;
    opcion = 1; //alta
});

var fila; //capturar la fila para editar o borrar el registro

//botón EDITAR
$(document).on("click", ".btnEditar", function(){
    fila = $(this).closest("tr");
    id_user = parseInt(fila.find('td:eq(0)').text());
    nombreUser = fila.find('td:eq(1)').text();
    apellidosUser = fila.find('td:eq(1)').text();
    correoUser = fila.find('td:eq(2)').text();
    password = fila.find('td:eq(3)').text();
    telefonoUser = fila.find('td:eq(4)').text();
    tipoUser = fila.find('td:eq(5)').text();

    //alert(personal);

    $("#nombreUser").val(nombreUser);
    $("#apellidosUser").val(apellidosUser);
    $("#correoUser").val(correoUser);
    $("#password").val(password);
    $("#telefonoUser").val(telefonoUser);
    $("#tipoUser").val(tipoUser);
    opcion = 2; //editar

    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title3").text("Editar Empleado");
    $("#modalCRUD3").modal("show");

});

$("#formDescripcion3").submit(function(e){
    e.preventDefault();
    nombreUser = $.trim($("#nombreUser").val());
    apellidosUser = $.trim($("#apellidosUser").val());
    correoUser = $.trim($("#correoUser").val());
    password = $.trim($("#password").val());
    telefonoUser = $.trim($("#telefonoUser").val());
    tipoUser= $.trim($("#tipoUser").val());

    //alert("¿Estás seguro de actualizar el servicio con el identificador "+id_user+"? "+nombreUser+" "+correoUser+" "+telefonoUser+" "+tipoUser);

    $.ajax({
        url: "bd/crud3.php",
        type: "POST",
        dataType: "json",
        data: {opcion:opcion, id_user:id_user, nombreUser:nombreUser, apellidosUser:apellidosUser, correoUser:correoUser, password:password, telefonoUser:telefonoUser, tipoUser:tipoUser},
        success: function(data){
            console.log(data);
            id_user = data[0].id_user;
            nombreUser = data[0].nombreUser;
            apellidosUser  = data[0].apellidosUser;
            correoUser = data[0].correoUser;
            password = data[0].password;
            telefonoUser = data[0].telefonoUser;
            tipoUser = data[0].tipoUser;
            if(opcion == 1){
              tablaDescripcion3.row.add([id_user,nombreUser,apellidosUser,correoUser,password,telefonoUser,tipoUser]).draw();
            }
            else{
              tablaDescripcion3.row(fila).data([id_user,nombreUser,apellidosUser,correoUser,password,telefonoUser,tipoUser]).draw();
            }
        }
    });
    $("#modalCRUD3").modal("hide");

});

//botón BORRAR
$(document).on("click", ".btnBorrar3", function(){
    fila = $(this);
    id_user = parseInt($(this).closest("tr").find('td:eq(0)').text());
    opcion = 3 //borrar

    var respuesta = confirm("¿Está seguro de eliminar al usuario con el identificador "+id_user+"?");

    if(respuesta){
        $.ajax({
            url: "bd/crud3.php",
            type: "POST",
            data: {opcion:opcion, id_user:id_user},
            success: function(){
                tablaDescripcion3.row(fila.parents('tr')).remove().draw();
            }
        });
    }
});
