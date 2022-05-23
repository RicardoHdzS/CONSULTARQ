$(document).ready(function(){

    tablaDescripcion2 = $("#tablaDescripcion2").DataTable({
       "columnDefs":[{
        "targets": -1,
        "data":null,
        "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btnEditar'>Editar</button><button class='btn btn-danger btnBorrar2'>Borrar</button></div></div>"
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



$("#btnNuevo2").click(function(){
    $("#formDescripcion2").trigger("reset");
    $(".modal-header").css("background-color", "#1cc88a");
    $(".modal-header").css("color", "white");
    $(".modal-title2").text("Nueva Pregunta");
    $("#modalCRUD2").modal("show");
    id_faq=null;
    opcion = 1; //alta
});

var fila; //capturar la fila para editar o borrar el registro

//botón EDITAR
$(document).on("click", ".btnEditar", function(){
    fila = $(this).closest("tr");
    id_faq = parseInt(fila.find('td:eq(0)').text());
    question = fila.find('td:eq(1)').text();
    answer = fila.find('td:eq(2)').text();
    status2 = parseInt(fila.find('td:eq(3)').text());


    //alert(pregunta);

    $("#question").val(question);
    $("#answer").val(answer);
    $("#status2").val(status2);
    opcion = 2; //editar

    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title2").text("Editar Pregunta");
    $("#modalCRUD2").modal("show");

});

$("#formDescripcion2").submit(function(e){
    e.preventDefault();
    question = $.trim($("#question").val());
    answer = $.trim($("#answer").val());
    status2 = $.trim($("#status2").val());

    //alert("¿Estás seguro de actualizar la pregunta con el identificador "+id_faq+"? "+question+" "+answer+" "+status);

    $.ajax({
        url: "bd/crud2.php",
        type: "POST",
        dataType: "json",
        data: {opcion:opcion, id_faq:id_faq, question:question, answer:answer,  status2:status2},
        success: function(data){
            console.log(data);
            id_faq = data[0].id_faq;
            question = data[0].question;
            answer = data[0].answer;
            status2 = data[0].status2;
            if(opcion == 1){
              tablaDescripcion2.row.add([id_faq,question,answer,status2]).draw();
            }
            else{
              tablaDescripcion2.row(fila).data([id_faq,question,answer,status2]).draw();
            }
        }
    });
    $("#modalCRUD2").modal("hide");

});

//botón BORRAR
$(document).on("click", ".btnBorrar2", function(){
    fila = $(this);
    id_faq = parseInt($(this).closest("tr").find('td:eq(0)').text());
    opcion = 3 //borrar

    var respuesta = confirm("¿Está seguro de eliminar la pregunta con el identificador "+id_faq+"?");

    if(respuesta){
        $.ajax({
            url: "bd/crud2.php",
            type: "POST",
            data: {opcion:opcion, id_faq:id_faq},
            success: function(){
                tablaDescripcion2.row(fila.parents('tr')).remove().draw();
            }
        });
    }
});
