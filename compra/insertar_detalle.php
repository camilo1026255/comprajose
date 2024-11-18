<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambiar si es necesario
$password = ""; // Cambiar si es necesario
$dbname = "GestorCompras";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Insertar detalle
if (isset($_POST['insertar_detalle'])) {
    $valor = $_POST['deta_valor'];
    $cantidad = $_POST['deta_cantidad'];
    $descripcion = $_POST['deta_descripcion'];
    $prod_id = $_POST['prod_id'];
    $cmp_id = $_POST['cmp_id'];

    // Verificar si el Cmp_ID existe en la tabla COMPRA
    $checkCompra = $conn->prepare("SELECT Cmp_ID FROM COMPRA WHERE Cmp_ID = ?");
    $checkCompra->bind_param("i", $cmp_id);
    $checkCompra->execute();
    $result = $checkCompra->get_result();

    if ($result->num_rows > 0) {
        // Si el Cmp_ID existe, insertar el detalle
        $stmt = $conn->prepare("INSERT INTO DETALLE (Deta_Valor, Deta_Cantidad, Deta_Descripcion, Prod_ID, Cmp_ID) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdssi", $valor, $cantidad, $descripcion, $prod_id, $cmp_id);

        if ($stmt->execute()) {
            echo "Detalle insertado con éxito.<br>";
        } else {
            echo "Error al insertar detalle: " . $stmt->error . "<br>";
        }

        $stmt->close();
    } else {
        echo "El Cmp_ID no existe en la tabla COMPRA. Inserta una compra primero.<br>";
    }

    $checkCompra->close();
}
?>

<!-- CSS para el formulario -->
<style>
/* Estilos generales */
body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
}

h2 {
    color: #4e73df;
            font-size: 36px;
            text-align: right;
            margin-top: 40px;
}

/* Contenedor del formulario */
form {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 40px auto;
    padding: 25px;
}

/* Estilo de los labels */
label {
    font-size: 14px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
    display: block;
}

/* Estilo de los campos de entrada */
input[type="text"], input[type="number"], input[type="date"], input[type="submit"], button {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 14px;
}

/* Botón de envío */
button[type="submit"] {
    background-color: #4CAF50;
    border: none;
    color: white;
    font-size: 16px;
    padding: 12px;
    text-align: center;
    display: block;
    width: 100%;
    margin-top: 10px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #45a049;
}

/* Estilo para el enlace de regreso */
a {
    display: inline-block;
    margin: 20px auto;
    text-align: center;
    font-size: 14px;
    color: #007BFF;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 4px;
}

a:hover {
    background-color: #f0f0f0;
    text-decoration: underline;
}

/* Mensajes de error */
.error-message {
    color: red;
    text-align: center;
    font-size: 14px;
    margin-top: 20px;
}
</style>

<!-- Formulario HTML para insertar detalle -->
<a href="index.php">Regresar</a>

<h2>Insertar Detalle</h2>
<form action="insertar_detalle.php" method="post">
    <label>Valor:</label>
    <input type="text" name="deta_valor" required><br>
    <label>Cantidad:</label>
    <input type="number" name="deta_cantidad" required><br>
    <label>Descripción:</label>
    <input type="text" name="deta_descripcion" required><br>
    <label>Producto ID:</label>
    <input type="number" name="prod_id" required><br>
    <label>Compra ID:</label>
    <input type="number" name="cmp_id" required><br>
    <button type="submit" name="insertar_detalle">Insertar Detalle</button>
</form>
