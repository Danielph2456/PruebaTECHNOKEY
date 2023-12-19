<?php
session_start();
include '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se enviaron las credenciales
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Obtiene las credenciales del formulario
        $correo = $_POST['email'];
        $password = $_POST['password'];

        // Hashea la contraseña con MD5
        $hashedPassword = md5($password);

        // Consulta la base de datos para validar las credenciales
        $query = "SELECT id, nombre FROM usuarios WHERE correo = :correo AND contrasena = :password";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':correo', $correo, PDO::PARAM_STR);
        $statement->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $statement->execute();

        // Verifica si se encontraron resultados
        if ($statement->rowCount() > 0) {
            // Las credenciales son válidas, obtén la información del usuario
            $usuario = $statement->fetch(PDO::FETCH_ASSOC);

            // Guarda la información en variables de sesión
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['sesion'] = 1; // 1 indica que el usuario está autenticado

            $sql = "UPDATE usuarios SET sesion = 1 WHERE correo = :correo";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();

            echo json_encode(true);
            exit();
        } else {
            // Las credenciales no son válidas
            echo "Credenciales inválidas";
        }
    } else {
        // No se enviaron todas las credenciales necesarias
        echo "Faltan credenciales";
    }
}
