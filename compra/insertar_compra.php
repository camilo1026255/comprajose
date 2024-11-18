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

// Insertar compra
if (isset($_POST['insertar_compra'])) {
    $id = $_POST['cmp_id'];
    $nombre = $_POST['cmp_nombre'];
    $fecha = $_POST['cmp_fecha'];
    $valor = $_POST['cmp_valor'];
    $descuento = $_POST['cmp_descuento'];
    $empl_id = $_POST['empl_id'];
    $prov_id = $_POST['prov_id'];

    // Consulta SQL para insertar en COMPRA
    $stmt = $conn->prepare("INSERT INTO COMPRA (Cmp_ID, Cmp_Nombre, Cmp_Fecha, Cmp_Valor, Cmp_Descuento, Empl_ID, Prov_ID) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issdiii", $id, $nombre, $fecha, $valor, $descuento, $empl_id, $prov_id);

    if ($stmt->execute()) {
        echo "Compra insertada con éxito.<br>";
    } else {
        echo "Error al insertar compra: " . $stmt->error . "<br>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Compra</title>
    <style>
        /* Estilos generales para el body y el fondo */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Estilo de los encabezados */
        h2 {
            color: #4e73df;
            font-size: 36px;
            text-align: right;
            margin-top: 40px;
        }

        /* Estilo de los enlaces */
        a {
            text-decoration: none;
            color: #4e73df;
            font-size: 18px;
            margin: 20px;
            display: block;
            text-align: center;
            padding: 8px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #e2e8f0;
        }

        /* Estilo del formulario */
        form {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 700px;
            margin: 20px auto;
            width: 100%;
            transition: transform 0.3s ease;
        }

        /* Estilo de las etiquetas del formulario */
        label {
            font-size: 16px;
            color: #555;
            margin-bottom: 10px;
            display: block;
        }

        /* Estilo de los campos de entrada */
        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 14px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        /* Efecto en el foco de los campos de entrada */
        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus {
            border-color: #4e73df;
            outline: none;
        }

        /* Estilo del botón de enviar */
        button[type="submit"] {
            width: 100%;
            padding: 14px;
            background-color: #28a745;
            font-size: 16px;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Efecto hover en el botón de enviar */
        button[type="submit"]:hover {
            background-color: #218838;
        }

        /* Estilo para los campos deshabilitados */
        input[disabled] {
            background-color: #f2f2f2;
        }

        /* Espaciado entre formularios */
        form + form {
            margin-top: 40px;
        }

        /* Estilo del contenedor de formulario */
        .container-form {
            max-width: 800px;
            margin: 30px auto;
            text-align: center;
        }

        /* Estilos para la caja de alerta o mensajes de éxito/error */
        .alert {
            font-size: 16px;
            color: #d9534f;
            text-align: center;
            margin-top: 20px;
        }

        /* Efecto de transición en el formulario */
        form:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <a href="index.php">Regresar</a>

    <h2>Insertar Compra</h2>
    <form action="insertar_compra.php" method="post">
        <label>ID:</label>
        <input type="number" name="cmp_id" required><br>
        
        <label>Nombre:</label>
        <input type="text" name="cmp_nombre" required><br>
        
        <label>Fecha:</label>
        <input type="date" name="cmp_fecha" required><br>
        
        <label>Valor:</label>
        <input type="number" name="cmp_valor" required><br>
        
        <label>Descuento:</label>
        <input type="number" name="cmp_descuento"><br>
        
        <label>Empleado ID:</label>
        <input type="number" name="empl_id"><br>
        
        <label>Proveedor ID:</label>
        <input type="number" name="prov_id" required><br>
        
        <button type="submit" name="insertar_compra">Insertar Compra</button>
    </form>
</body>
</html>
