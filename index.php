<?php

$db_dsn = 'mysql:host=189.254.212.156;dbname=BDashboard';
$db_username = 'uservmx';
$db_password = '';

try {
    // Establecer la conexión a la base de datos
    $connection = new PDO($db_dsn, $db_username, $db_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Habilitar el modo de errores de excepción

    $query = "SELECT ip_unidad, nombre_unidad, estado.id_estado AS id_estado, estado.nombre_estado, ciudad_unidad, autorizado_unidad, tipounidad.id_tipounidad AS id_tipounidad, status_unidad, id_zona, numero_unidad, activa_unidad, actualizacion_ip_unidad, telefono_unidad, direccion_unidad, descripcion_tipounidad, descripcion_status_unidad, usuario.id_user AS id_user, name_user, email_user, phone_user, usuario.id_estado, tipo_usuario.id_tipo_usuario AS id_tipo_usuario, password_user, active_user, idAutoridad, nombre_estado, tipo_usuario.nombre_tipo_usuario
                FROM unidad
                JOIN estado ON estado.id_estado = unidad.id_estado
                JOIN tipounidad ON tipounidad.id_tipounidad = unidad.id_tipounidad
                JOIN status_unidad ON status_unidad.id_status_unidad = unidad.status_unidad
                JOIN usuario
                JOIN tipo_usuario ON tipo_usuario.id_tipo_usuario = usuario.id_tipo_usuario";

    $statement = $connection->prepare($query);
    $statement->execute();

    // Verificar si hay resultados
    if ($statement->rowCount() > 0) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $data = array();
        foreach ($result as $row) {
            $data[$row["id_user"]] = $row;
        }

        $json = json_encode($data);

        // Devolver el JSON con los resultados
        print_r($json);
    } else {
        echo "No se encontraron resultados.";
    }
} catch (PDOException $e) {
    die('Error connecting to database: ' . $e->getMessage());
}
