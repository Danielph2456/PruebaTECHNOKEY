$(document).ready(function () {
    let orden = document.getElementById('ordenFiltrar').value
    cargarDatos(1, 10, '', '', orden);
});

const btnModalCrear = document.getElementById('btnNewVuelo');

btnModalCrear.addEventListener('click', abrirModalNuevo)

function eliminar(id) {
    let data = new FormData();
    data.append('indicador', 'eliminar');
    data.append('id', id);
    fetch('../Consultas/vuelos.php', {
        method: 'POST',
        body: data
    }).then(function (response) {
        return response.json();
    }).then(function (respuesta) {
        console.log(respuesta);
        if (respuesta) {
            Swal.fire({
                icon: 'success',
                title: 'registro eliminado',
                showConfirmButton: false,
                timer: 1500
            });
            let orden = document.getElementById('ordenFiltrar').value
            cargarDatos(1, 10, '', '', orden);
        }
    });
}

function editar(id) {
    let data = new FormData();
    data.append('indicador', 'editar');
    data.append('id', id);
    fetch('../Consultas/vuelos.php', {
        method: 'POST',
        body: data
    }).then(function (response) {
        return response.json();
    }).then(function (respuesta) {
        document.getElementById('fechaVueloEditar').value = respuesta[0].fecha_del_vuelo
        document.getElementById('horaSalidaEditar').value = respuesta[0].hora_de_salida
        document.getElementById('horaLlegadaEditar').value = respuesta[0].hora_de_llegada
        document.getElementById('tipoTrayectoEditar').value = respuesta[0].tipo_de_trayecto;
        document.getElementById('costoVueloEditar').value = respuesta[0].costo_del_vuelo;
        document.getElementById('idEditar').value = respuesta[0].id;
    });
    $('#modalEditarVuelo').modal('show')
}

function cargarDatos(inicio, nroreg, filtro, valor, orden) {
    document.getElementById('filtroActual').value=filtro
    document.getElementById('valorFiltroActual').value=valor
    $('#tablaVuelosBody').empty();
    $("#paginacion").empty();
    let data = new FormData();
    let nuevoinicio = (inicio - 1) * nroreg;
    data.append('indicador', 'loadVuelos');
    data.append('inicio', nuevoinicio);
    data.append('noreg', nroreg);
    data.append('filtro', filtro);
    data.append('valor', valor);
    data.append('orden', orden);

    fetch('../Consultas/vuelos.php', {
        method: 'POST',
        body: data
    }).then(function (response) {
        return response.json();
    }).then(function (respuesta) {
        console.log(respuesta);
        if (respuesta[0] !="no existen campañas") {
            let htmltag = '';
    
            if (respuesta !== '') {
                for (let i = 0; i < respuesta[0].length; i++) {
                    htmltag += '<tr>';
                    htmltag += '<td style="text-align: center; color: #000">' + respuesta[0][i].fecha_del_vuelo + '</td>';
                    htmltag += '<td style="text-align: center; color: #000">' + respuesta[0][i].hora_de_salida + '</td>';
                    htmltag += '<td style="text-align: center; color: #000">' + respuesta[0][i].hora_de_llegada + '</td>';
                    htmltag += '<td style="text-align: center; color: #000">' + respuesta[0][i].duracion_del_trayecto + '</td>';
                    htmltag += '<td style="text-align: center; color: #000">' + respuesta[0][i].tipo_de_trayecto + '</td>';
                    htmltag += '<td style="text-align: center; color: #000">' + respuesta[0][i].costo_del_vuelo + '</td>';
                    htmltag += '<td style="text-align: center; color: #000"><span style="cursor: pointer" onclick="eliminar(' + respuesta[0][i].id + ')">🗑️</span><span style="cursor: pointer" onclick="editar(' + respuesta[0][i].id + ')">✍️</span></td>';
                    htmltag += '</tr>';
                }
                $('#tablaVuelosBody').append(htmltag);
            }
    
            // cargado de paginador
            let paginador = '<ul class="pagination">';
            paginador += '<li><span class="label label" style="font-size:14px; font-weight: bolder;background-color:#00757E;color:white; border:solid 1px #00757E;">' + respuesta[1] + ' Registros</span></li>';
    
            if (inicio > 1) {
                paginador += '<li><a style="font-weight:bolder; color:#00757E; background-color:#CFD3D7; border:solid 1px #00757E;" href="javascript:void(0)" onclick="cargarDatos(' + (inicio - 1) + ', ' + nroreg + ', \'' + filtro + '\', \'' + valor + '\', \'' + orden + '\' )">&lsaquo;</a></li>';
            } else {
                paginador += '<li class="disabled"><a style="font-weight:bolder; color:#00757E; background-color:#CFD3D7; border:solid 1px #00757E;" href="javascript:void(0)">&laquo;</a></li>';
                paginador += '<li class="disabled"><a style="font-weight:bolder; color:#00757E; background-color:#CFD3D7; border:solid 1px #00757E;" href="javascript:void(0)">&lsaquo;</a></li>';
            }
    
            let limit1 = inicio - 5;
            let limit2 = inicio + 5;
    
            if (inicio <= nroreg) {
                limit1 = 1;
            }
    
            if ((inicio + nroreg) >= Math.ceil(respuesta[1] / nroreg)) {
                limit2 = Math.ceil(respuesta[1] / nroreg);
            }
    
            for (let i = limit1; i <= limit2; i++) {
                if (i === inicio) {
                    paginador += '<li class="active"><a style="background-color:#00757E; border:solid 1px #00757E;" href="javascript:void(0)">' + i + '</a></li>';
                } else {
                    paginador += '<li><a style="font-weight:bolder; color:#00757E; background-color:#CFD3D7; border:solid 1px #00757E;" href="javascript:void(0)" onclick="cargarDatos(' + i + ', ' + nroreg + ', \'' + filtro + '\', \'' + valor + '\', \'' + orden + '\' )">' + i + '</a></li>';
                }
            }
    
            if (inicio < Math.ceil(respuesta[1] / nroreg)) {
                paginador += '<li><a style="font-weight:bolder; color:#00757E; background-color:#CFD3D7; border:solid 1px #00757E;" href="javascript:void(0)" onclick="cargarDatos(' + (inicio + 1) + ', ' + nroreg + ', \'' + filtro + '\', \'' + valor + '\', \'' + orden + '\' )">&rsaquo;</a></li>';
                paginador += '<li><a style="font-weight:bolder; color:#00757E; background-color:#CFD3D7; border:solid 1px #00757E;" href="javascript:void(0)" onclick="cargarDatos(' + Math.ceil(respuesta[1] / nroreg) + ', ' + nroreg + ', \'' + filtro + '\', \'' + valor + '\', \'' + orden + '\' )">&raquo;</a></li>';
            } else {
                paginador += '<li class="disabled"><a style="font-weight:bolder; color:#00757E; background-color:#CFD3D7; border:solid 1px #00757E;" href="javascript:void(0)">&rsaquo;</a></li>';
                paginador += '<li class="disabled"><a style="font-weight:bolder; color:#00757E; background-color:#CFD3D7; border:solid 1px #00757E;" href="javascript:void(0)">&raquo;</a></li>';
            }
    
            paginador += '<li><span class="label label" style="font-size:14px; font-weight: bolder; background-color:#00757E;color:white; border:solid 1px #242651;">' + Math.ceil(respuesta[1] / nroreg) + ' Páginas</span></li>';
    
            paginador += '</ul>';
            $("#paginacion").append(paginador);
            
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Error al filtrar la informacion',
                text: 'No se pudo filtrar ningún vuelo',
                showConfirmButton: true
            });
            let orden = document.getElementById('ordenFiltrar').value
            cargarDatos(1, 10, '', '', orden);
        }
    });
}

function abrirModalNuevo() {
    limpiar()
    $('#modalNuevoVuelo').modal('show')
}

function insertarVuelo() {
    let fechaVuelo = $('#fechaVuelo').val();
    let horaSalida = $('#horaSalida').val();
    let horaLlegada = $('#horaLlegada').val();
    let duracionTrayecto = calcularDiferenciaHoras(horaSalida, horaLlegada)
    let tipoTrayecto = $('#tipoTrayecto').val();
    let costoVuelo = $('#costoVuelo').val();
    let data = new FormData();
    data.append('indicador', 'insertar')
    data.append('fechaVuelo', fechaVuelo)
    data.append('horaSalida', horaSalida)
    data.append('horaLlegada', horaLlegada)
    data.append('duracionTrayecto', duracionTrayecto)
    data.append('tipoTrayecto', tipoTrayecto)
    data.append('costoVuelo', costoVuelo)

    fetch('../Consultas/vuelos.php', {
        method: 'POST',
        body: data
    }).then(function (response) {
        return response.json();
    }).then(function (respuesta) {
        console.log(respuesta);
        if (respuesta) {
            Swal.fire({
                icon: 'success',
                title: 'vuelo registrado',
                showConfirmButton: false,
                timer: 1500
            });
            let orden = document.getElementById('ordenFiltrar').value
            cargarDatos(1, 10, '', '', orden);
            $('#modalNuevoVuelo').modal('hide')
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error al insertar el vuelo',
                text: 'No se pudo insertar el vuelo',
                showConfirmButton: true
            });
            let orden = document.getElementById('ordenFiltrar').value
            cargarDatos(1, 10, '', '', orden);
            $('#modalNuevoVuelo').modal('hide')
        }
    });

}

function limpiar() {
    document.getElementById('fechaVuelo').value = ''
    document.getElementById('horaSalida').value = ''
    document.getElementById('horaLlegada').value = ''
    document.getElementById('tipoTrayecto').value = ''
    document.getElementById('costoVuelo').value = ''
}


function calcularDiferenciaHoras(horaSalida, horaLlegada) {
    // Convertir las cadenas de tiempo en objetos de fecha
    const salida = new Date(`1970-01-01 ${horaSalida}`);
    const llegada = new Date(`1970-01-01 ${horaLlegada}`);

    // Calcular la diferencia en milisegundos
    let diferencia = llegada - salida;

    // Convertir la diferencia a horas, minutos y segundos
    const horas = Math.floor(diferencia / (1000 * 60 * 60));
    diferencia %= 1000 * 60 * 60;
    const minutos = Math.floor(diferencia / (1000 * 60));
    diferencia %= 1000 * 60;
    const segundos = Math.floor(diferencia / 1000);

    let resultado = "" + horas + ":" + minutos + ":" + segundos

    return resultado

}

function actualizarVuelo() {
    let fechaVuelo = $('#fechaVueloEditar').val();
    let horaSalida = $('#horaSalidaEditar').val();
    let horaLlegada = $('#horaLlegadaEditar').val();
    let duracionTrayecto = calcularDiferenciaHoras(horaSalida, horaLlegada)
    let tipoTrayecto = $('#tipoTrayectoEditar').val();
    let costoVuelo = $('#costoVueloEditar').val();
    let id = $('#idEditar').val();
    let data = new FormData();
    data.append('indicador', 'actualizar')
    data.append('fechaVuelo', fechaVuelo)
    data.append('horaSalida', horaSalida)
    data.append('horaLlegada', horaLlegada)
    data.append('duracionTrayecto', duracionTrayecto)
    data.append('tipoTrayecto', tipoTrayecto)
    data.append('costoVuelo', costoVuelo)
    data.append('id', id)

    fetch('../Consultas/vuelos.php', {
        method: 'POST',
        body: data
    }).then(function (response) {
        return response.json();
    }).then(function (respuesta) {
        console.log(respuesta);
        if (respuesta) {
            Swal.fire({
                icon: 'success',
                title: 'vuelo actualizado',
                showConfirmButton: false,
                timer: 1500
            });
            let orden = document.getElementById('ordenFiltrar').value
            cargarDatos(1, 10, '', '', orden);
            $('#modalNuevoVuelo').modal('hide')
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error al actualizar el vuelo',
                text: 'No se pudo actualizar el vuelo',
                showConfirmButton: true
            });
            let orden = document.getElementById('ordenFiltrar').value
            cargarDatos(1, 10, '', '', orden);
            $('#modalNuevoVueloEditar').modal('hide')
        }
    });

}

function cambioFiltro(valor, filtro) {
    if (valor !='') {
        let orden = document.getElementById('ordenFiltrar').value
        cargarDatos(1, 10, filtro, valor, orden)
    }
}

function ordenar(orden){
    let filtro = document.getElementById('filtroActual').value
    let valor = document.getElementById('valorFiltroActual').value
    cargarDatos(1, 10, filtro, valor, orden)
}