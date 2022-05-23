$(document).ready(function(){

    tablaDescripcion = $("#tablaDescripcion").DataTable({
       "columnDefs":[{
        "targets": -1,
        "data":null,
        "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btnEditar'>Editar</button><button class='btn btn-danger btnBorrar'>Borrar</button></div></div>"
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

var chart1, options;

$("#btnGeneral").click(function(){
    inicial = $.trim($("#fechaInicial").val());
    final = $.trim($("#fechaFinal").val());

    if(inicial=='' || final==''){
        alert("Fecha inicial y/o Fecha final están vacía(s).");
    }else{
        $(".modal-header").css("background-color", "#1cc88a");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Reporte General");
        $("#modal-1").modal("show");
        anual();
    }
});

function anual(){
    opcion=1;
    $.ajax({
        url:"bd/graficas.php",
        type: "POST",
        dataType:"json",
        data: {opcion:opcion, inicial:inicial, final:final},
        success:function(data){
            options.series[0].data = data;
            chart1 = new Highcharts.Chart(options);
            console.log(data);
        }
    })
    datosAnual();
}

function datosAnual(){
    var v_modal = $("#modal_2").modal({show: false}); 
    options = {
        chart:{
            renderTo: 'contenedor-modal',
            type: 'pie'
        },
        lang: {
            printChart:"Imprimir gráfica",
            downloadPNG:"Descargar Imagen en formato PNG",
            downloadJPEG:"Descargar Imagen en formato JPEG",
            downloadPDF:"Descargar en un documento PDF",
            downloadCSV:"Descarga CSV (Excel)",
            downloadXLS:"Descarga XLS (Excel)",  
            viewData:"Ver tabla de datos",  
            downloadSVG:"Descarga en formato SVG",    
            viewFullscreen:"Ver en pantalla completa",
            openCloud:""
        },
        title:{
            text: 'Reporte general de Servicios Solicitados del '+inicial+" al "+final
        },
        plotOptions:{
            pie:{
                allowPointSelect:true,
                cursor:'pointer',
                dataLabels:{
                    enabled: true,
                    format: '{point.name}: <b>{point.percentage:.2f}</b>%'
                }
            }
        },
        tooltip:{
            headerFormat:"<span style='font-size:11px'> {series.name}</span><br>",
            pointFormat: "<span style='color:{point.color}'>{point.name}</span>: <b>{point.y:.0f}</b>"
        },
        series:[{
            name: "Número de solictudes ",
            colorByPoint:true,
            data:[],
        }]
    }
    v_modal.on("shown",function(){});
    v_modal.modal("show");
}

$("#btnMensual").click(function(){
    inicial = $.trim($("#fechaInicial").val());
    final = $.trim($("#fechaFinal").val());

    if(inicial=='' || final==''){
        alert("Fecha inicial y/o Fecha final están vacía(s).");
    }else{
        $(".modal-header").css("background-color", "#1cc88a");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Reporte Mensual");
        $("#modal-1").modal("show");
        mensual();
    }
});

function mensual(){
    opcion=2;
    $.ajax({
        url:"bd/graficas.php",
        type: "POST",
        dataType:"json",
        data: {opcion:opcion, inicial:inicial, final:final},
        success:function(data){
            options.series[0].data = data;
            chart1 = new Highcharts.Chart(options);
            console.log(data);
        }
    })
    datosMensual();
}

function datosMensual(){
    options = {
        chart:{
            renderTo: 'contenedor-modal',
            type: 'column'
        },
        lang: {
            printChart:"Imprimir gráfica",
            downloadPNG:"Descargar Imagen en formato PNG",
            downloadJPEG:"Descargar Imagen en formato JPEG",
            downloadPDF:"Descargar en un documento PDF",
            downloadCSV:"Descarga CSV (Excel)",
            downloadXLS:"Descarga XLS (Excel)", 
            downloadSVG:"Descarga en formato SVG",  
            viewData:"Ver tabla de datos",     
            viewFullscreen:"Ver en pantalla completa",
            openCloud:""
        },
        title:{
            text: 'Reporte mensual de Servicios Solicitados del '+inicial+" al "+final
        },
        xAxis:{
            type: 'category'
        },
        yAxis:{
            title:{
                text: ' Cantidad'
            }
        },
        plotOptions: {
            series:{
                borderWidth:1,
                dataLabels:{
                    enabled:true,
                    format:'{point.y:.0f}'
                }
            }
        },
        tooltip:{
            headerFormat:"<span style='font-size:11px'> {series.name}</span><br>",
            pointFormat: "<span style='color:{point.color}'>{point.name}</span>: <b>{point.y:.0f}</b>"
        },
        series:[{
            name: "Total de solicitudes por mes",
            colorByPoint:true,
            data:[],
        }],    
    }
}

$("#btnNuevo").click(function(){
    $("#formDescripcion").trigger("reset");
    $(".modal-header").css("background-color", "#1cc88a");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Nuevo Servicio");
    $("#modalCRUD").modal("show");
    id_servicio=null;
    opcion = 1; //alta
});

$("#btnDiario").click(function(){

    inicial = $.trim($("#fechaInicial").val());
    final = $.trim($("#fechaFinal").val());

    if(inicial=='' || final==''){
        alert("Fecha inicial y/o Fecha final están vacía(s).");
    }else{
        $(".modal-header").css("background-color", "#1cc88a");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Reporte por fecha");
        $("#modal-2").modal("show");
    }
});

$("#btnDiarioS").click(function(){
    id_servicio = parseInt($("#id_diario").val());
    nombre = $("#id_diario option:selected").text();
    diario();
});

function diario(){
    opcion=3;
    $.ajax({
        url:"bd/graficas.php",
        type: "POST",
        dataType:"json",
        data: {opcion:opcion, inicial:inicial, final:final, id_servicio:id_servicio},
        success:function(data){
            options.series[0].data = data;
            chart1 = new Highcharts.Chart(options);
            console.log(data);
        }
    })
    datosDiario();
}

function datosDiario(){
    options = {
        chart:{
            renderTo: 'contenedor-modal2',
            type: 'column'
        },
        lang: {
            printChart:"Imprimir gráfica",
            downloadPNG:"Descargar Imagen en formato PNG",
            downloadJPEG:"Descargar Imagen en formato JPEG",
            downloadPDF:"Descargar en un documento PDF",
            downloadCSV:"Descarga CSV (Excel)",
            downloadXLS:"Descarga XLS (Excel)",
            downloadSVG:"Descarga en formato SVG",   
            viewData:"Ver tabla de datos",     
            viewFullscreen:"Ver en pantalla completa",
            openCloud:""
        },
        title:{
            text: 'Reporte diario de Servicios Solicitados del '+inicial+" al "+final
        },
        xAxis:{
            type: 'category'
        },
        yAxis:{
            title:{
                text: ' Cantidad'
            }
        },
        plotOptions: {
            series:{
                borderWidth:1,
                dataLabels:{
                    enabled:true,
                    format:'{point.y:.0f}'
                }
            }
        },
        tooltip:{
            headerFormat:"<span style='font-size:11px'> {series.name}</span><br>",
            pointFormat: "<span style='color:{point.color}'>{point.name}</span>: <b>{point.y:.0f}</b>"
        },
        series:[{
            name: nombre,
            colorByPoint:true,
            data:[],
        }]       
    }
}

var fila; //capturar la fila para editar o borrar el registro

//botón EDITAR
$(document).on("click", ".btnEditar", function(){
    fila = $(this).closest("tr");
    id_servicio = parseInt(fila.find('td:eq(0)').text());
    nombre = fila.find('td:eq(1)').text();
    descripcion = fila.find('td:eq(2)').text();
    imagen = fila.find('td:eq(3)').text();
    status = parseInt(fila.find('td:eq(4)').text());

    //alert(servicio);

    $("#nombre").val(nombre);
    $("#descripcion").val(descripcion);
    $("#imagen").val(imagen);
    $("#status").val(status);
    opcion = 2; //editar

    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Editar Servicio");
    $("#modalCRUD").modal("show");

});

$("#formDescripcion").submit(function(e){
    e.preventDefault();
    nombre = $.trim($("#nombre").val());
    descripcion = $.trim($("#descripcion").val());
    imagen = $.trim($("#imagen").val());
    status = $.trim($("#status").val());

    //alert("¿Estás seguro de actualizar el servicio con el identificador "+id_servicio+"? "+nombre+" "+descripcion+" "+imagen+" "+status);

    $.ajax({
        url: "bd/crud.php",
        type: "POST",
        dataType: "json",
        data: {opcion:opcion, id_servicio:id_servicio, nombre:nombre, descripcion:descripcion, imagen:imagen, status:status},
        success: function(data){
            //console.log(data);
            id_servicio = data[0].id_servicio;
            nombre = data[0].nombre;
            descripcion = data[0].descripcion;
            imagen = data[0].imagen;
            status = data[0].status;
            if(opcion == 1){
              tablaDescripcion.row.add([id_servicio,nombre,descripcion,imagen,status]).draw();
            }
            else{
              tablaDescripcion.row(fila).data([id_servicio,nombre,descripcion,imagen,status]).draw();
            }
        }
    });
    $("#modalCRUD").modal("hide");

});

//botón BORRAR
$(document).on("click", ".btnBorrar", function(){
    fila = $(this);
    id_servicio = parseInt($(this).closest("tr").find('td:eq(0)').text());
    opcion = 3 //borrar

    var respuesta = confirm("¿Está seguro de eliminar el servicio con el identificador "+id_servicio+"?");

    if(respuesta){
        $.ajax({
            url: "bd/crud.php",
            type: "POST",
            data: {opcion:opcion, id_servicio:id_servicio},
            success: function(){
                tablaDescripcion.row(fila.parents('tr')).remove().draw();
            }
        });
    }
});
