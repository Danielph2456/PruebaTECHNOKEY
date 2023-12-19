<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Vuelos</title>
    <!-- Agrega el enlace al archivo CSS de Bootstrap si lo estás utilizando -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> <!-- Agrega el enlace a tu propio archivo de estilo si es necesario -->
    <link rel="stylesheet" href="../CSS/vuelos.css">
</head>

<body>

    <div class="wrapper theme-6-active pimary-color-yellow">
        <?php include '../includes/menu.php'; ?>
        <!-- INICIA WALLPAPER -->
        <div class="page-wrapper">
            <span id="filtroActual"></span>
            <span id="valorFiltroActual"></span>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6" style="padding-top: 5px;">
                        <h3 class="panel-title" style="font-size: 30px;">
                            🛫 Vuelos
                        </h3>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="table-responsive mb-30 col-md-12">
                        <div class="panel panel-primary card-view">
                            <div class="panel-heading" style="padding:5px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span id="txt-agente" data-id="<?php echo ($_SESSION['id']) ?>" data-nom="<?php echo ($_SESSION['nombre']) ?>" class="badge badge-info" style="height:30px;font-size: 18px; color:black; margin-left:15px;margin-top:10px">
                                            <i class="fa fa-user lg 3x data-right-rep-icon txt-bold-black"></i>
                                            <?php echo ($_SESSION['nombre']) ?>👋
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <button class="btn btn-info waves-effect" id="btnNewVuelo" name="btnNewVuelo" style="background: #45813A!important; border: solid white 1px; margin-top:10px">
                                            📝 Nuevo Vuelo
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-wrapper">
                                <div class="panel-body">
                                    <div class="responsive">
                                        <div class="table-wrapper">
                                            <table class="table table-bordered table-striped mb-0">
                                                <thead class="table-dark">
                                                    <tr style="background-color:#0098A3; color:white">
                                                        <th style="font-weight:bold;color:white; text-align:center; font-size:14px">
                                                            <label for="">Fecha del Vuelo</label>
                                                            <input onchange="cambioFiltro(this.value,'fecha_del_vuelo')" type="date" id="fechaVueloFiltrar" name="fechaVueloFiltrar" class="form-control">
                                                        </th>
                                                        <th style="font-weight:bold;color:white; text-align:center; font-size:14px">
                                                            <label for="">Hora de Salida</label>
                                                            <input onchange="cambioFiltro(this.value,'hora_de_salida')" type="time" step="1" pattern="(?:[01]\d|2[0123]):(?:[012345]\d):(?:[012345]\d)" id="horaSalidaFiltrar" name="horaSalidaFiltrar" class="form-control">
                                                        </th>
                                                        <th style="font-weight:bold;color:white; text-align:center; font-size:14px">
                                                            <label for="">Hora de Llegada</label>
                                                            <input onchange="cambioFiltro(this.value,'hora_de_llegada')" type="time" step="1" pattern="(?:[01]\d|2[0123]):(?:[012345]\d):(?:[012345]\d)" id="horaLlegadaFiltrar" name="horaLlegadaFiltrar" class="form-control">
                                                        </th>
                                                        <th style="font-weight:bold;color:white; text-align:center; font-size:14px">
                                                            <label for="">Tipo de Trayecto</label>
                                                            <select onchange="cambioFiltro(this.value,'tipo_de_trayecto')" id="tipoTrayectoFiltrar" name="tipoTrayectoFiltrar" class="form-control">
                                                                <option value="">Seleccione tipo de trayecto</option>
                                                                <option value="Nacional">Nacional</option>
                                                                <option value="Internacional">Internacional</option>
                                                            </select>
                                                        </th>
                                                        <th style="font-weight:bold;color:white; text-align:center; font-size:14px">
                                                            <label for="">Costo del Vuelo</label>
                                                            <input onchange="cambioFiltro(this.value,'costo_del_vuelo')" type="number" step="0.01" id="costoVueloFiltrar" name="costoVueloFiltrar" class="form-control">
                                                        </th>
                                                        <th style="font-weight:bold;color:white; text-align:center; font-size:14px">
                                                            <label for="">Orden</label>
                                                            <select onchange="ordenar(this.value)" id="ordenFiltrar" name="ordenFiltrar" class="form-control">
                                                                <option value="DESC">Descendente</option>
                                                                <option value="ASC">Ascendente</option>
                                                            </select>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <table class="table table-bordered table-striped mb-0">
                                                <thead class="table-dark">
                                                    <tr style="background-color:#0098A3; color:white">
                                                        <th style="font-weight:bold;color:white; text-align:center; font-size:14px">Fecha del Vuelo</th>
                                                        <th style="font-weight:bold;color:white; text-align:center; font-size:14px">Hora de Salida</th>
                                                        <th style="font-weight:bold;color:white; text-align:center; font-size:14px">Hora de Llegada</th>
                                                        <th style="font-weight:bold;color:white; text-align:center; font-size:14px">Duración del Trayecto</th>
                                                        <th style="font-weight:bold;color:white; text-align:center; font-size:14px">Tipo de Trayecto</th>
                                                        <th style="font-weight:bold;color:white; text-align:center; font-size:14px">Costo del Vuelo</th>
                                                        <th style="font-weight:bold;color:white; text-align:center; font-size:14px">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tablaVuelosBody">
                                                </tbody>
                                            </table>
                                            <div id="paginacion" style="text-align: right"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Row -->
            </div>
        </div>
    </div>

    <!-- Modal para insertar nuevos vuelos -->
    <div class="modal fade" id="modalNuevoVuelo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="width: 90% !important;">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#2A3E4C; position: relative;">
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 0; right: 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                        </svg>
                    </button>
                    <h5 class="modal-title" id="exampleModalCenterTitle" style="color:white; margin-right: 2rem;"><i class="fa fa-plane"></i> Nuevo Vuelo</h5>
                </div>
                <div class="modal-body">
                    <form id="formNuevoVuelo" method="POST" onsubmit="event.preventDefault(); insertarVuelo();">
                        <div id="divResultVuelos" name="divResultVuelos">
                            <label for="fechaVuelo" class="form-label">Fecha del Vuelo:</label>
                            <input type="date" id="fechaVuelo" name="fechaVuelo" class="form-control" required>
                            <label for="horaSalida" class="form-label">Hora de Salida:</label>
                            <input type="time" step="1" pattern="(?:[01]\d|2[0123]):(?:[012345]\d):(?:[012345]\d)" id="horaSalida" name="horaSalida" class="form-control" required>
                            <label for="horaLlegada" class="form-label">Hora de Llegada:</label>
                            <input type="time" step="1" pattern="(?:[01]\d|2[0123]):(?:[012345]\d):(?:[012345]\d)" id="horaLlegada" name="horaLlegada" class="form-control" required>
                            <label for="tipoTrayecto" class="form-label">Tipo de Trayecto:</label>
                            <select id="tipoTrayecto" name="tipoTrayecto" class="form-control" required>
                                <option value="">Seleccione tipo de trayecto</option>
                                <option value="Nacional">Nacional</option>
                                <option value="Internacional">Internacional</option>
                            </select>
                            <label for="costoVuelo" class="form-label">Costo del Vuelo:</label>
                            <input type="number" step="0.01" id="costoVuelo" name="costoVuelo" class="form-control" required>
                            <button type="submit" class="btn btn-primary mt-3">Insertar Vuelo</button>
                        </div>
                    </form>
                </div>
                <p id="mensajeModalNuevoVuelo" name="mensajeModalNuevoVuelo" style="color:red"></p>
            </div>
        </div>
    </div>

    <!-- Modal para insertar nuevos vuelos -->
    <div class="modal fade" id="modalEditarVuelo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="width: 90% !important;">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#2A3E4C; position: relative;">
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 0; right: 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                        </svg>
                    </button>
                    <h5 class="modal-title" id="exampleModalCenterTitle" style="color:white; margin-right: 2rem;"><i class="fa fa-plane"></i> Editar Vuelo</h5>
                </div>
                <div class="modal-body">
                    <form id="formEditarVuelo" method="POST" onsubmit="event.preventDefault(); actualizarVuelo();">
                        <div id="divResultVuelosEditar" name="divResultVuelosEditar">
                            <label id="idEditar"></label>
                            <label for="fechaVueloEditar" class="form-label">Fecha del Vuelo:</label>
                            <input type="date" id="fechaVueloEditar" name="fechaVueloEditar" class="form-control" required>
                            <label for="horaSalidaEditar" class="form-label">Hora de Salida:</label>
                            <input type="time" step="1" pattern="(?:[01]\d|2[0123]):(?:[012345]\d):(?:[012345]\d)" id="horaSalidaEditar" name="horaSalidaEditar" class="form-control" required>
                            <label for="horaLlegadaEditar" class="form-label">Hora de Llegada:</label>
                            <input type="time" step="1" pattern="(?:[01]\d|2[0123]):(?:[012345]\d):(?:[012345]\d)" id="horaLlegadaEditar" name="horaLlegadaEditar" class="form-control" required>
                            <label for="tipoTrayectoEditar" class="form-label">Tipo de Trayecto:</label>
                            <select id="tipoTrayectoEditar" name="tipoTrayectoEditar" class="form-control" required>
                                <option value="">Seleccione tipo de trayecto</option>
                                <option value="Nacional">Nacional</option>
                                <option value="Internacional">Internacional</option>
                            </select>
                            <label for="costoVueloEditar" class="form-label">Costo del Vuelo:</label>
                            <input type="number" step="0.01" id="costoVueloEditar" name="costoVueloEditar" class="form-control" required>
                            <button type="submit" class="btn btn-primary mt-3">Actualizar Vuelo</button>
                        </div>
                    </form>
                </div>
                <p id="mensajeModalNuevoVuelo" name="mensajeModalNuevoVuelo" style="color:red"></p>
            </div>
        </div>
    </div>



    <!-- CSS de DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="../JS/vuelos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>