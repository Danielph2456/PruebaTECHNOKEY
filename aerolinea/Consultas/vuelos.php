<?php
session_start();
include '../config/config.php';

$indicativo = $_POST['indicador'];
if ($indicativo == 'loadVuelos') {
    $respuesta = loadVuelos();
}
if ($indicativo == 'eliminar') {
    $respuesta = eliminar();
}
if ($indicativo == 'insertar') {
    $respuesta = insertar();
}
if ($indicativo == 'editar') {
    $respuesta = editar();
}
if ($indicativo == 'actualizar') {
    $respuesta = actualizar();
}

echo json_encode($respuesta);

function loadVuelos()
{
    global $pdo;

    $inicio = $_POST['inicio'];
    $noreg = $_POST['noreg'];
    $filtro = $_POST['filtro'];
    $valor = $_POST['valor'];
    $orden = $_POST['orden'];

    $resultado = null;
    $resulPaginador = null;

    if ($filtro != '') {
        $sqlLoadVuelos = "SELECT * FROM vuelos v WHERE v.$filtro = :valor ORDER BY v.Id $orden LIMIT :noreg OFFSET :inicio";
        $sqlLoadVuelosPaginador = "SELECT COUNT(*) FROM vuelos v WHERE v.$filtro = :valor";
    } else {
        $sqlLoadVuelos = "SELECT * FROM vuelos v ORDER BY v.Id $orden LIMIT :noreg OFFSET :inicio";
        $sqlLoadVuelosPaginador = "SELECT COUNT(*) FROM vuelos v";
    }

    try {
        $Vuelos = $pdo->prepare($sqlLoadVuelos);
        $paginador = $pdo->prepare($sqlLoadVuelosPaginador);

        if ($filtro != '') {
            $Vuelos->bindParam(':valor', $valor);
            $paginador->bindParam(':valor', $valor);
        }

        $Vuelos->bindParam(':inicio', $inicio, PDO::PARAM_INT);
        $Vuelos->bindParam(':noreg', $noreg, PDO::PARAM_INT);

        if (!$Vuelos->execute()) {
            return 'error en la consulta de las Vuelos parametros: ' . $filtro . ' ' . $valor;
        } else {
            if ($Vuelos->rowCount() > 0) {
                $resultado = $Vuelos->fetchAll(PDO::FETCH_OBJ);
            } else {
                $resultado = 'no existen campañas';
            }
        }

        if (!$paginador->execute()) {
            return 'error en el paginador';
        } else {
            $resulPaginador = $paginador->fetchColumn();
        }
    } catch (PDOException $error) {
        return "error en la consulta pdo en la tabla: " . $error->getMessage();
    }
    return [$resultado, $resulPaginador];
}

function eliminar()
{
    global $pdo;
    $idVuelo = $_POST['id'];

    $sqlEliminarVuelo = "DELETE FROM vuelos WHERE Id = :idVuelo";

    try {
        $eliminarVuelo = $pdo->prepare($sqlEliminarVuelo);
        $eliminarVuelo->bindParam(':idVuelo', $idVuelo, PDO::PARAM_INT);

        if ($eliminarVuelo->execute()) {
            return true;
        } else {
            return 'Error al eliminar el registro';
        }
    } catch (PDOException $error) {
        return "Error en la consulta PDO al eliminar el registro: " . $error->getMessage();
    }
}

function insertar()
{
    $fechaVuelo = $_POST['fechaVuelo'];
    $horaSalida = $_POST['horaSalida'];
    $horaLlegada = $_POST['horaLlegada'];
    $duracionTrayecto = $_POST['duracionTrayecto'];
    $tipoTrayecto = $_POST['tipoTrayecto'];
    $costoVuelo = $_POST['costoVuelo'];


    // Validar los datos (puedes agregar más validaciones según tus requisitos)

    // Insertar el nuevo vuelo en la base de datos
    require "../config/config.php";
    $sqlInsertarVuelo = "INSERT INTO vuelos (fecha_del_vuelo, hora_de_salida, hora_de_llegada, duracion_del_trayecto, tipo_de_trayecto, costo_del_vuelo) VALUES (:fecha, :horaSalida, :horaLlegada, :duracionTrayecto, :tipoTrayecto, :costo)";

    try {
        $stmt = $pdo->prepare($sqlInsertarVuelo);
        $stmt->bindParam(':fecha', $fechaVuelo);
        $stmt->bindParam(':horaSalida', $horaSalida);
        $stmt->bindParam(':horaLlegada', $horaLlegada);
        $stmt->bindParam(':duracionTrayecto', $duracionTrayecto);
        $stmt->bindParam(':tipoTrayecto', $tipoTrayecto);
        $stmt->bindParam(':costo', $costoVuelo);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $error) {
        return ['success' => false, 'message' => 'Error en la consulta PDO: ' . $error->getMessage()];
    }
}

function editar()
{
    global $pdo;

    $id = $_POST['id'];
    $resultado = null;

    $sqlLoadVuelos = "SELECT * FROM vuelos v WHERE v.id = :valor ORDER BY v.id ";

    try {
        $Vuelos = $pdo->prepare($sqlLoadVuelos);
        $Vuelos->bindParam(':valor', $id);


        if (!$Vuelos->execute()) {
            return 'error en la consulta de las Vuelos parametros: ' . $id;
        } else {
            if ($Vuelos->rowCount() > 0) {
                $resultado = $Vuelos->fetchAll(PDO::FETCH_OBJ);
            } else {
                $resultado = 'no existen campañas';
            }
        }
    } catch (PDOException $error) {
        return "error en la consulta pdo en la tabla: " . $error->getMessage();
    }
    return $resultado;
}


function actualizar()
{
    $fechaVuelo = $_POST['fechaVuelo'];
    $horaSalida = $_POST['horaSalida'];
    $horaLlegada = $_POST['horaLlegada'];
    $duracionTrayecto = $_POST['duracionTrayecto'];
    $tipoTrayecto = $_POST['tipoTrayecto'];
    $costoVuelo = $_POST['costoVuelo'];
    $id = $_POST['id'];

    require "../config/config.php";
    $sqlActualizarVuelo = "UPDATE vuelos SET fecha_del_vuelo = :fecha, hora_de_salida = :horaSalida, hora_de_llegada = :horaLlegada, duracion_del_trayecto = :duracionTrayecto, tipo_de_trayecto = :tipoTrayecto, costo_del_vuelo = :costo WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sqlActualizarVuelo);
        $stmt->bindParam(':fecha', $fechaVuelo);
        $stmt->bindParam(':horaSalida', $horaSalida);
        $stmt->bindParam(':horaLlegada', $horaLlegada);
        $stmt->bindParam(':duracionTrayecto', $duracionTrayecto);
        $stmt->bindParam(':tipoTrayecto', $tipoTrayecto);
        $stmt->bindParam(':costo', $costoVuelo);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $error) {
        return ['success' => false, 'message' => 'Error en la consulta PDO: ' . $error->getMessage()];
    }
}
