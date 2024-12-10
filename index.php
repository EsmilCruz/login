<?php

session_start();
// Inicio de conexión
$conexion = new mysqli('localhost', 'root', '9844', 'login2');

// Verificar la conexión
if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
} else {
    echo 'Conexión exitosa<br>';
}

//---------------------------------------------------------------------------------
$nombre = $_POST['usuario'];
$pass = $_POST['password'];

//---------------------------------------------------------consulta
$sql = "SELECT * FROM user WHERE nombre = ?";
$stmt = $conexion->prepare($sql);

if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conexion->error);
}

$stmt->bind_param('s', $nombre);
$stmt->execute();
$resultado = $stmt->get_result(); 
if ($resultado->num_rows > 0) { 
    $row = $resultado->fetch_assoc();

    if ($pass === $row['password']) { 
        echo 'Login exitoso';
    } else {
        echo 'La contraseña es incorrecta: ' . $pass;
    }
} else {
    echo 'El usuario no existe';
}

$stmt->close();
$conexion->close();

?>
