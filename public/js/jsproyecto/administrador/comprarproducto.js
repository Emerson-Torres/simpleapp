
$(document).ready(function () {
    // Inicializa el DataTable cuando la página está lista por primera vez.

    

    inicializarDataTable();

    inicializarDataTable2();
    sumaCompra();



    //valido ambos imputs para obtener el precio unitario por producto
   
    $("#txtPrecioCompra, #txtCantidad").keyup(function () {
        let cantidad = parseInt($("#txtCantidad").val());
        let precioCompra = parseFloat($("#txtPrecioCompra").val());
        
        //alert(unidades);
        let existencias = cantidad * unidades;
        $("#txtExistencias").val(existencias);
        // Verifica si los valores son números válidos
        if (!isNaN(cantidad) && !isNaN(precioCompra) && existencias !== 0) {

                let precioUnitario = precioCompra / existencias;
                let precioIva=0;
                $("#txtPrecioUnitario").val(precioUnitario.toFixed(10));
                if(creditoFiscal ==="1"){
                    precioIva = precioUnitario+(precioUnitario*0.13);
                    $("#txtPrecioIva").val(precioIva.toFixed(10));
                }else{
                    $("#txtPrecioIva").val("N/A");
                }
        } else {
            $("#txtPrecioUnitario").val('');
            $("#txtPrecioIva").val('');
            $("#txtPrecioVenta").val('');

        }

        var precioUnitario = parseFloat($('#txtPrecioUnitario').val());
        var precioIva = parseFloat($('#txtPrecioIva').val());
        var porcentaje = parseFloat($('#rangeInput').val());
        if (isNaN(precioUnitario) && isNaN(precioIva)) {

        } else {

            if(creditoFiscal ==="1"){
                let precioVenta = (precioIva * (porcentaje / 100)) + precioIva;
                precioVenta = precioVenta.toFixed(2);
                $("#txtPrecioVenta").val(precioVenta);
            }else{
                let precioVenta = (precioUnitario * (porcentaje / 100)) + precioUnitario;
                precioVenta = precioVenta.toFixed(2);
                $("#txtPrecioVenta").val(precioVenta);
            }
        }
    });
    //Fin valido ambos imputs para obtener el precio unitario por producto

    


    $("#txtPrecioVenta").keyup(function () {
        let precioUnitario = $("#txtPrecioUnitario").val();
        let precioVenta = $("#txtPrecioVenta").val();
        var precioIva = parseFloat($('#txtPrecioIva').val());

        if (precioVenta > 0 && precioUnitario > 0) {
           
            if(creditoFiscal ==="1"){
                porcentaje = ((precioVenta / precioIva) - 1) * 100;
                porcentaje = porcentaje.toFixed(0);
            }else{
                porcentaje = ((precioVenta / precioUnitario) - 1) * 100;
            porcentaje = porcentaje.toFixed(0);
            }
           
            $("#rangeInput").val(porcentaje);
            $("#rangeValue").text(porcentaje + "%");
        } else {
          
        }


    });


    $("#rangeValue").text($("#rangeInput").val() + "%");
    $("#rangeInput").on('input', function () {
        var precioUnitario = parseFloat($('#txtPrecioUnitario').val());
        var precioIva = parseFloat($('#txtPrecioIva').val());
        var porcentaje = parseFloat($('#rangeInput').val());
        $("#rangeValue").text(porcentaje + "%");
        if (isNaN(precioUnitario) && isNaN(precioIva)) {

        } else {

            if(creditoFiscal ==="1"){
                let precioVenta = (precioIva * (porcentaje / 100)) + precioIva;
                precioVenta = precioVenta.toFixed(2);
                $("#txtPrecioVenta").val(precioVenta);
            }else{
                let precioVenta = (precioUnitario * (porcentaje / 100)) + precioUnitario;
                precioVenta = precioVenta.toFixed(2);
                $("#txtPrecioVenta").val(precioVenta);
            }
        }

    });
});







let unidades;


function agregarCompraUnidad(id, nombrepro, unidad) {
    $("#chkRegalia").prop("checked", false);
    $("#txtPrecioCompra").attr("disabled", false);
    $("#rangeInput").attr("disabled", false);
    $("#txtPrecioCompra").val("");
    $('#exampleModal').modal('show');
    $("#exampleModalLabel").html(nombrepro);
    $("#txtIdProducto").val(id);
    $("#txtPaquete").val(0);
    unidades = 1;
    $("#divExistencias").hide();
    $("#btnAgregarCompra").css("display","block");
    $("#rangeInput").val(20);
    $("#rangeValue").text(20 + "%");
    $("#btnModificarCompra").css("display","none");
    $("#btnEliminarCompra").css("display","none");
    $("#divCantidad").removeClass("col-md-6").addClass("col-md-12");
    $("#txtPrecioCompra, #txtCantidad, #txtPrecioVenta,#txtPrecioUnitario, #txtExistencias, #txtFechaCaducidad,#txtIdInventario, #txtPrecioIva").val("");
}
function agregarCompraPaquete(id, nombrepro, unidad) {
    $("#chkRegalia").prop("checked", false);
    $("#txtPrecioCompra").attr("disabled", false);
    $("#rangeInput").attr("disabled", false);
    $("#txtPrecioCompra").val("");
    $('#exampleModal').modal('show');
    $("#exampleModalLabel").html(nombrepro);
    $("#txtIdProducto").val(id);
    $("#divExistencias").show();
    $("#txtPaquete").val(1);
    $("#rangeInput").val(20);
    $("#rangeValue").text(20 + "%");
    $("#btnAgregarCompra").css("display","block");
    $("#btnModificarCompra").css("display","none");
    $("#btnEliminarCompra").css("display","none");
    $("#txtCantidad").val(1);
    $("#txtExistencias").val(unidad);
    $("#txtExistencias").prop("disabled", true);
    unidades = unidad;
    $("#divCantidad").removeClass("col-md-12").addClass("col-md-6");
    $("#txtPrecioCompra, #txtPrecioVenta,#txtPrecioUnitario, #txtFechaCaducidad,#txtIdInventario, #txtPrecioIva").val("");
}


function modificarCompraUnidad(id, nombrepro, unidad) {
    $('#exampleModal').modal('show');
    $("#exampleModalLabel").html(nombrepro);
    $("#txtIdProducto").val(id);
    $("#txtPaquete").val(0);
    unidades = 1;
    $("#divExistencias").hide();
    $("#btnAgregarCompra").css("display","none");
    $("#btnModificarCompra").css("display","block");
    $("#btnEliminarCompra").css("display","block");
    $("#txtExistencias").prop("disabled", true);
    $("#divCantidad").removeClass("col-md-6").addClass("col-md-12");
}
function modificarCompraPaquete(id, nombrepro, unidad) {
    $('#exampleModal').modal('show');
    $("#exampleModalLabel").html(nombrepro);
    $("#txtIdProducto").val(id);
    $("#divExistencias").show();
    $("#txtPaquete").val(1);
   
    $("#btnAgregarCompra").css("display","none");
    $("#btnModificarCompra").css("display","block");
    $("#btnEliminarCompra").css("display","block");
    unidades = unidad;
    $("#divCantidad").removeClass("col-md-12").addClass("col-md-6");
}

