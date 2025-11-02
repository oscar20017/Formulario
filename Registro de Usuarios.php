<?php 
// Datos de conexión
$servername = "localhost";
$username = "root";
$password = "";  // Pon tu contraseña si tienes una
$dbname = "biblioteca_la_roca";
// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario'] ?? '');
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $edad = intval($_POST['edad'] ?? 0);
    // aceptar ambas variantes de nombre de campo: 'numero_de_cedula' o 'Numero de Cedula'
    $numero_cedula = trim($_POST['numero_de_cedula'] ?? $_POST['Numero de Cedula'] ?? '');
    // usa numero_de_cedula como contraseña inicial (hasheada)
    $contrasena = password_hash($numero_cedula, PASSWORD_DEFAULT);

    // Validar campos vacíos
    if (empty($usuario) || empty($nombre) || empty($apellido) || empty($numero_cedula)) {
        echo "<script>alert('Por favor, complete todos los campos.'); window.history.back();</script>";
        exit();
    }

    // Verificar si ya está registrado por número de cédula
    $check = $conn->prepare("SELECT id FROM afiliados WHERE numero_cedula = ?");
    if (!$check) {
        echo "<script>alert('Error en la consulta de verificación.'); window.history.back();</script>";
        exit();
    }
    $check->bind_param("s", $numero_cedula);
    $check->execute();
    $result = $check->get_result();
    if ($result && $result->num_rows > 0) {
        echo "<script>alert('Ya existe un afiliado con este documento.'); window.history.back();</script>";
        $check->close();
        exit();
    }
    $check->close();

    // Insertar registro (asegúrate de que los nombres de columna coincidan con tu base de datos)
    $stmt = $conn->prepare("INSERT INTO afiliados (usuario, nombre, apellido, edad, numero_cedula, contrasena) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo "<script>alert('Error al preparar la inserción.'); window.history.back();</script>";
        exit();
    }
    $stmt->bind_param("sssiss", $usuario, $nombre, $apellido, $edad, $numero_cedula, $contrasena);
    if ($stmt->execute()) {
        echo "<script>alert('Registro exitoso. Bienvenido a la Biblioteca.'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Error al registrar. Intenta nuevamente'); window.history.back();</script>";
    }
    $stmt->close();
    $conn->close();
}
?>