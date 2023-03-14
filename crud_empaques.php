<?php

/* use PhpOffice\PhpSpreadsheet\Worksheet\Row; */

require '../../Conexion.php';

if ($_POST['cliente'] == ', KEYTRONIC' | $_POST['cliente'] == 'KEYTRONIC') {
    $cliente = 'KEYTRONIC';
} else if ($_POST['cliente'] == ', QUANTUM' | $_POST['cliente'] == 'QUANTUM') {
    $cliente = 'QUANTUM';
}

$image_name = '';
if (!empty($_FILES['archivo_desv'])) {
    // File upload configuration
    $archivo_desv = "";
    $targetDir = "G:/Materiales/Empaque/";
    $allowTypes = array(
        'jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'xls', 'xlsx'
    );

    $images_arr = array();
    foreach ($_FILES['archivo_desv']['name'] as $key => $val) {
        $image_name = $_FILES['archivo_desv']['name'][$key];
        $tmp_name   = $_FILES['archivo_desv']['tmp_name'][$key];
        $size       = $_FILES['archivo_desv']['size'][$key];
        $type       = $_FILES['archivo_desv']['type'][$key];
        $error      = $_FILES['archivo_desv']['error'][$key];

        $fileName = basename($_FILES['archivo_desv']['name'][$key]);

        $rawBaseName = pathinfo($fileName, PATHINFO_FILENAME);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $counter = 0;
        while (file_exists("G:/Materiales/Empaque/" . $fileName)) {
            $fileName = $rawBaseName . "-" . $counter . '.' . $extension;
            $counter++;
        };

        $archivo_desv = $fileName;

        $cadenanombre = $cadenanombre . $fileName . ",";

        if ($size > 5000000) {
            echo '<div class="alert alert-danger">Alguno de los archivos adjuntos excede el tamaño permitido (5MB).</div>';
            die("");
        }


        $targetFilePath = $targetDir . $fileName;


        // Check whether file type is valid
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        if (in_array($fileType, $allowTypes)) {
            // Store images on the server
            if (move_uploaded_file($_FILES['archivo_desv']['t
            
            <div class=""></div>_name'][$key], $targetFilePath)) {
                $images_arr[] = $targetFilePath;
            }
        }
    }
}

if ($_POST['datos'] == 'insert') {

    $query = "INSERT INTO [dbo].[empaques]
([numero_parte], [descripcion_insumo], [descripcion_unidad], [cliente], [cantidad], [fecha], [comentarios], [localizacion], [archivo])
VALUES
('{$_POST['no_parte']}'
,'{$_POST['descripcion']}'
,'{$_POST['descripcion_unidad']}'
,'{$cliente}'
,'{$_POST['cantidad']}'
,getDate()
,'{$_POST['comentarios']}'
,'{$_POST['localizacion']}'
,'$image_name')";

    $consulta = sqlsrv_query($conn, $query);

    if ($consulta === false)
        echo 'ERROR AL GUARDAR REGISTRO ' . $query;
    else
        echo 'REGISTRO GUARDADO CORRECTAMENTE';
    echo $query;


    $query2 = "INSERT INTO [dbo].[empaques_inventario]
    ([numero_parte], [descripcion_insumo], [procedencia], [cliente], [cantidad], [fecha], [comentarios], [valor_inicial], [localizacion], [archivo])
    VALUES
    ('{$_POST['no_parte']}'
    ,'{$_POST['descripcion']}'
    ,'RECIBOS'
    ,'{$cliente}'
    ,'{$_POST['cantidad']}'
    ,getDate()
    ,'{$_POST['comentarios']}'
    ,'{$_POST['cantidad']}'
    ,'{$_POST['localizacion']}'
    ,'$image_name')";

    $consulta2 = sqlsrv_query($conn, $query2);

    if ($consulta2 === false)
        echo 'ERROR AL GUARDAR REGISTRO ' . $query2;
    else
        echo 'REGISTRO GUARDADO CORRECTAMENTE';
    echo $query2;
}

if ($_POST['datos'] == 'salida') {

    $id = $_POST['id'];
    $cant = $_POST['cantidad2'];

    $query = "SELECT * FROM empaques_inventario WHERE id='$id'";
    $consulta = sqlsrv_query($conn, $query);
    while ($row = sqlsrv_fetch_array($consulta)) {
        $numero_parte = $row['numero_parte'];
        $descripcion = $row['descripcion_insumo'];
        $procedencia = $row['procedencia'];
        $cliente = $row['cliente'];
        $cantidad = $row['cantidad'];
    }

    $query2 = "INSERT INTO [dbo].[empaques_salidas] ([numero_parte], [descripcion_insumo], [procedencia], [cliente], [cantidad], [fecha_salida])
    VALUES
    ('{$numero_parte}'
    ,'{$descripcion}'
    ,'{$procedencia}'
    ,'{$cliente}'
    ,'{$_POST['cantidad2']}'
    ,getDate())";

    $consulta2 = sqlsrv_query($conn, $query2);

    if ($consulta2 === false)
        echo 'ERROR AL GUARDAR REGISTRO ' . $query2;
    else
        echo 'REGISTRO GUARDADO CORRECTAMENTE';


    $c = $cantidad - $cant;
    $query3 = "UPDATE empaques_inventario SET cantidad = '$c' WHERE id = '$id'";
    $consulta3 = sqlsrv_query($conn, $query3);

    if ($consulta3 === false)
        echo 'ERROR AL GUARDAR REGISTRO ' . $query3;
    else
        echo 'REGISTRO GUARDADO CORRECTAMENTE' . $query3;
}

if ($_POST['datos'] == 'cambiarLoc') {

    $loc = $_POST['camlocalizacion'];
    $id = $_POST['id'];

    $query = "UPDATE empaques_inventario SET localizacion = '$loc' WHERE id = $id";
    $consulta = sqlsrv_query($conn, $query);

    if ($consulta === false)
        echo 'ERROR AL GUARDAR REGISTRO ' . $query;
    else
        echo 'REGISTRO GUARDADO CORRECTAMENTE' . $query;
}



/* $no_parte = $_POST['no_parte_sal'];
    $cantidad = $_POST['cantidad_sal'];
    $_POST['descripcion_sal'];
    $_POST['procedencia'];
    $_POST['cliente_sal'];
    $_POST['fecha_empaque_sal'];

    $output = array();

    $query = "SELECT numero_parte,descripcion_insumo, procedencia, cliente, sum(cantidad) AS total FROM empaques_inventario WHERE numero_parte = '$no_parte' GROUP BY numero_parte, descripcion_insumo, procedencia, cliente";
    $consulta = sqlsrv_query($conn, $query);
    while ($resultado = sqlsrv_fetch_array($consulta)) {
        $output['total'] = $resultado['total'];
    }

    /* echo json_encode($output); 

    if ($cantidad <= $output['total']) {
        $query2 = "INSERT INTO [dbo].[empaques_salidas] ([numero_parte], [descripcion_insumo], [procedencia], [cliente], [cantidad], [fecha_salida])
    VALUES
    ('{$_POST['no_parte_sal']}'
    ,'{$_POST['descripcion_sal']}'
    ,'{$_POST['procedencia']}'
    ,'{$_POST['cliente_sal']}'
    ,'{$_POST['cantidad_sal']}'
    ,'{$_POST['fecha_empaque_sal']}')";

        $consulta2 = sqlsrv_query($conn, $query2);

        if ($consulta2 === false)
            $output['mensaje'] = "<h3 class='text-danger'>ERROR AL GUARDAR REGISTRO. </h3>" . $query2;
        else {

            $output['mensaje'] = "<h3 class='text-success'>REGISTRO GUARDADO CORRECTAMENTE. </h3><br>";

            $query3 = "SELECT TOP 1 * FROM empaques_inventario WHERE numero_parte = '$no_parte' AND cantidad != '0' ORDER BY fecha ";
            $consulta3 = sqlsrv_query($conn, $query3);
            while ($row = sqlsrv_fetch_array($consulta3)) {
                $id = $row['id'];
                $cant = $row['cantidad'];
            }

            if ($cantidad <= $cant) {
                $r = $cant - $cantidad;
                $query4 = "UPDATE empaques_inventario SET cantidad = '$r' WHERE id = '$id'";
                $consulta4 = sqlsrv_query($conn, $query4);
            } else {
                $queda = $cantidad;
                do {
                    $query5 = "SELECT TOP 1 * FROM empaques_inventario WHERE numero_parte = '$no_parte' AND cantidad != '0' ORDER BY fecha ";
                    $consulta5 = sqlsrv_query($conn, $query5);
                    while ($row = sqlsrv_fetch_array($consulta5)) {
                        $id = $row['id'];
                        $cant = $row['cantidad'];
                    }

                    if ($cant - $queda < 0) {
                        $c = 0;
                        $op = 1;
                    } else if ($cant - $queda >= 0) {
                        $c = $cant - $queda;
                        $op = 0;
                    }

                    $query6 = "UPDATE empaques_inventario SET cantidad = '$c' WHERE id = '$id'";
                    $consulta6 = sqlsrv_query($conn, $query6);

                    $queda -= $cant;
                } while ($op != 0);
            }
        }
    }
    echo json_encode($output); */
/* if ($consulta === false)
        echo 'ERROR AL GUARDAR REGISTRO ' . $query;
    else
        echo 'REGISTRO GUARDADO CORRECTAMENTE';
    echo $query; */
