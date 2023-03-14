<?php
session_start();
require '../../Conexion.php';
?>

<!-- Tabla Recibos -->
<?php if ($_POST['datos'] == 'dibujarTabla' | $operacion == 'dibujarTabla') : ?>

    <style>
        table.dataTable.fixedHeader-floating,
        table.dataTable.fixedHeader-locked {
            margin-left: 0% !important;
        }

        .button-agregar-lot {
            background-color: #18252d;
        }

        .button-agregar-lot:hover {
            margin: 0 0 0 1rem !important;
            background-color: white;
            border: 1px solid #18252d !important;
            color: #18252d;
            font-size: 14px;
            border-radius: 5px !important;
            height: 35px !important;
        }

        div.dataTables_wrapper {
            margin-top: 4%;
        }
    </style>
    <table id="tabla" class="table-striped table-hover table dt-responsive" width="100%">
        <thead style="background-color: #082954; color: white;">
            <th style="text-align:center;;">ID</th>
            <th style="text-align:center;">Numero de Parte</th>
            <th style="text-align:center;">Descripcion Insumo</th>
            <th style="text-align:center;">Descripcion Unidad Insumo</th>
            <th style="text-align:center;">Cliente</th>
            <th style="text-align:center;">Cantidad</th>
            <th style="text-align:center;">Fecha</th>
            <th style="text-align:center;">Localizacion</th>
            <th style="text-align:center; width:auto;">Comentarios</th>
            <th style="text-align:center;">Archivo</th>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM empaques";
            $stmt = sqlsrv_query($conn, $sql);

            while ($row = sqlsrv_fetch_array($stmt)) {
                $id = $row['id'];

            ?>
                <tr>
                    <td class="text-center"><?php echo $row['id']; ?></td>
                    <td class="text-center"><?php echo $row['numero_parte']; ?></td>
                    <td class="text-center"><?php echo $row['descripcion_insumo']; ?></td>
                    <td class="text-center"><?php echo $row['descripcion_unidad']; ?></td>
                    <td class="text-center"><?php echo $row['cliente']; ?></td>
                    <td class="text-center"><?php echo $row['cantidad']; ?></td>
                    <?php if (date_format($row['fecha'], "Y-m-d") == '1900-01-01') { ?>
                        <td class="text-center">N/A</td>
                    <?php } else { ?>
                        <td class="text-center"><?php echo date_format($row['fecha'], "Y-m-d"); ?></td>
                    <?php } ?>
                    <td class="text-center"><?php echo $row['localizacion']; ?></td>
                    <td class="text-center"><?php echo $row['comentarios']; ?></td>
                    <td class="text-center"><a href="http://192.168.1.253:8090/Materiales/Empaque/<?php echo $row['archivo'] ?>"> <?php echo $row['archivo'] ?> </a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>


    <script>
        $('#tabla').DataTable({
            pageLength: 20,
            order: [
                [0, "desc"]
            ],
            lengthMenu: [
                [20, 40, 60, -1],
                [20, 40, 60, "Todo"]
            ],
            searching: true,
            // dom:'<"top"Blf>rt<"button"ip><"clear">',
            dom: "B<'row'<'col-sm-6 ' l><'col-sm-6 'f>><tr><'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{
                extend: 'excel',
                text: 'Excel <i class="fas fa-file-excel" style="color:green;"></i>'
            }, {
                extend: 'copy',
                text: 'Copiar <i class="fas fa-copy"></i>',
            }, {
                extend: 'pdf',
                text: 'PDF <i class="fas fa-file-pdf" style="color:red;"></i>',

            }, {
                text: 'Recibir   <i class="fas fa-plus"></i>',
                className: 'button-agregar-lot mybtn class-disabled',
                action: function() {
                    recibir();
                }
            }],
            language: {
                info: "Mostrando _START_ a _END_ de _TOTAL_ resultados",
                infoEmpty: "Mostrando 0 a 0 de 0 resultados",
                infoFiltered: "(filtrado de _MAX_ resultados)",
                infoPostFix: "",
                thousands: ",",
                lengthMenu: "Mostrar _MENU_",
                search: "Buscar:",
                zeroRecords: "Sin resultados",
                paginate: {
                    first: "Primera",
                    last: "Ultima",
                    next: "Siguiente",
                    previous: "Anterior"
                },
                buttons: {
                    copyTitle: 'Copiado en el Portapapeles',
                    copySuccess: {
                        _: '%d lineas copiadas',
                        1: '1 linea copiada'
                    }
                }
            },
            fixedHeader: {
                header: true,
                headerOffset: 0,
            },
            className: 'font-label',

        });
    </script>
<?php endif; ?>

<!-- Tabla de Inventario -->

<?php if ($_POST['datos'] == 'dibujarTablaInv' | $operacion == 'dibujarTablaInv') : ?>

    <style>
        table.dataTable.fixedHeader-floating,
        table.dataTable.fixedHeader-locked {
            margin-left: 0% !important;
        }

        .button-agregar-lot {
            background-color: #18252d;
        }

        .button-agregar-lot:hover {
            margin: 0 0 0 1rem !important;
            background-color: white;
            border: 1px solid #18252d !important;
            color: #18252d;
            font-size: 14px;
            border-radius: 5px !important;
            height: 35px !important;
        }

        div.dataTables_wrapper {
            margin-top: 4%;
        }
    </style>
    <table id="tabla2" class="table-striped table-hover table dt-responsive" width="100%">
        <thead style="background-color: #082954; color: white;">
            <th style="text-align:center;">Numero de Parte</th>
            <th style="text-align:center;">Descripcion Insumo</th>
            <th style="text-align:center;">Procedencia</th>
            <th style="text-align:center;">Cliente</th>
            <th style="text-align:center;">Cantidad</th>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT numero_parte,descripcion_insumo, procedencia, cliente, sum(cantidad) AS total FROM empaques_inventario GROUP BY numero_parte, descripcion_insumo, procedencia, cliente";
            $stmt2 = sqlsrv_query($conn, $sql2);

            while ($row2 = sqlsrv_fetch_array($stmt2)) {
                $id = $row2['id'];

            ?>
                <tr>
                    <td class="text-center"><?php echo $row2['numero_parte']; ?></td>
                    <td class="text-center"><?php echo $row2['descripcion_insumo']; ?></td>
                    <td class="text-center"><?php echo $row2['procedencia']; ?></td>
                    <td class="text-center"><?php echo $row2['cliente']; ?></td>
                    <td class="text-center"><?php echo $row2['total']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        $('#tabla2').DataTable({
            pageLength: 20,
            order: [
                [0, "desc"]
            ],
            lengthMenu: [
                [20, 40, 60, -1],
                [20, 40, 60, "Todo"]
            ],
            searching: true,
            // dom:'<"top"Blf>rt<"button"ip><"clear">',
            dom: "B<'row'<'col-sm-6 ' l><'col-sm-6 'f>><tr><'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{
                    extend: 'excel',
                    text: 'Excel <i class="fas fa-file-excel" style="color:green;"></i>'
                }, {
                    extend: 'copy',
                    text: 'Copiar <i class="fas fa-copy"></i>',
                }, {
                    extend: 'pdf',
                    text: 'PDF <i class="fas fa-file-pdf" style="color:red;"></i>',

                }
                /* , {
                            text: 'Recibir   <i class="fas fa-plus"></i>',
                            className: 'button-agregar-lot mybtn class-disabled',
                            action: function() {
                                recibir();
                            }
                        } */
            ],
            language: {
                info: "Mostrando _START_ a _END_ de _TOTAL_ resultados",
                infoEmpty: "Mostrando 0 a 0 de 0 resultados",
                infoFiltered: "(filtrado de _MAX_ resultados)",
                infoPostFix: "",
                thousands: ",",
                lengthMenu: "Mostrar _MENU_",
                search: "Buscar:",
                zeroRecords: "Sin resultados",
                paginate: {
                    first: "Primera",
                    last: "Ultima",
                    next: "Siguiente",
                    previous: "Anterior"
                },
                buttons: {
                    copyTitle: 'Copiado en el Portapapeles',
                    copySuccess: {
                        _: '%d lineas copiadas',
                        1: '1 linea copiada'
                    }
                }
            },
            fixedHeader: {
                header: true,
                headerOffset: 0,
            },
            className: 'font-label',

        });
    </script>
<?php endif; ?>

<?php if ($_POST['datos'] == 'dibujarTablaSalidas' | $operacion == 'dibujarTablaSalidas') : ?>

    <style>
        table.dataTable.fixedHeader-floating,
        table.dataTable.fixedHeader-locked {
            margin-left: 0% !important;
        }

        .button-agregar-lot {
            background-color: #18252d;
        }

        .button-agregar-lot:hover {
            margin: 0 0 0 1rem !important;
            background-color: white;
            border: 1px solid #18252d !important;
            color: #18252d;
            font-size: 14px;
            border-radius: 5px !important;
            height: 35px !important;
        }

        div.dataTables_wrapper {
            margin-top: 4%;
        }

        .btn-salida {
            margin-left: 25%;
            font-size: 18px;
        }
    </style>
    <!-- <h1 style="background-color:white; color:#082954;">Salidas - Localizacion</h1> -->
    <table id="tabla3" class="table-striped table-hover table dt-responsive" width="100%">
        <thead style="background-color: #082954; color: white;">
            <th style="text-align:center;">ID</th>
            <th style="text-align:center;">Numero de Parte</th>
            <th style="text-align:center;">Descripcion Insumo</th>
            <th style="text-align:center;">Cliente</th>
            <th style="text-align:center;">Comentarios</th>
            <th style="text-align:center;">Cantidad</th>
            <th style="text-align:center;">Localizacion</th>
            <th style="text-align:center;">Salida</th>
        </thead>
        <tbody>
            <?php

            $numero_parte = $_POST['no_parte_sal'];

            $sql2 = "SELECT * FROM empaques_inventario WHERE numero_parte = '$numero_parte' AND cantidad>'0'";
            $stmt2 = sqlsrv_query($conn, $sql2);

            while ($row2 = sqlsrv_fetch_array($stmt2)) {
                $id = $row2['id'];
                $cant = $row2['cantidad'];
                $no_parte = $row2['numero_parte'];
                $loc = $row2['localizacion'];

            ?>
                <tr>
                    <td class="text-center"><?php echo $row2['id']; ?></td>
                    <td class="text-center"><?php echo $row2['numero_parte']; ?></td>
                    <td class="text-center"><?php echo $row2['descripcion_insumo']; ?></td>
                    <td class="text-center"><?php echo $row2['cliente']; ?></td>
                    <td class="text-center"><?php echo $row2['comentarios']; ?></td>
                    <td class="text-center"><?php echo $row2['cantidad']; ?></td>
                    <td class="text-center"><?php echo $row2['localizacion']; ?></td>
                    <td><button class="btn im-btn-nok btn-xs btn-salida" onclick="salida(<?php echo $id ?>, '<?php echo $no_parte ?>', '<?php echo $loc ?>', <?php echo $cant ?>)"><span class="mdi mdi-exit-to-app"></span></button></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        $('#tabla3').DataTable({
            pageLength: 20,
            order: [
                [0, "desc"]
            ],
            lengthMenu: [
                [20, 40, 60, -1],
                [20, 40, 60, "Todo"]
            ],
            searching: true,
            // dom:'<"top"Blf>rt<"button"ip><"clear">',
            dom: "B<'row'<'col-sm-6 ' l><'col-sm-6 'f>><tr><'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{
                extend: 'excel',
                text: 'Excel <i class="fas fa-file-excel" style="color:green;"></i>'
            }, {
                extend: 'copy',
                text: 'Copiar <i class="fas fa-copy"></i>',
            }, {
                extend: 'pdf',
                text: 'PDF <i class="fas fa-file-pdf" style="color:red;"></i>',

            }],
            language: {
                info: "Mostrando _START_ a _END_ de _TOTAL_ resultados",
                infoEmpty: "Mostrando 0 a 0 de 0 resultados",
                infoFiltered: "(filtrado de _MAX_ resultados)",
                infoPostFix: "",
                thousands: ",",
                lengthMenu: "Mostrar _MENU_",
                search: "Buscar:",
                zeroRecords: "Sin resultados",
                paginate: {
                    first: "Primera",
                    last: "Ultima",
                    next: "Siguiente",
                    previous: "Anterior"
                },
                buttons: {
                    copyTitle: 'Copiado en el Portapapeles',
                    copySuccess: {
                        _: '    %d lineas copiadas',
                        1: '1 linea copiada'
                    }
                }
            },
            fixedHeader: {
                header: true,
                headerOffset: 0,
            },
            className: 'font-label',

        });
    </script>
<?php endif; ?>

<!-- Tabla de Salidas -->

<?php if ($_POST['datos'] == 'dibujarTablaSal' | $operacion == 'dibujarTablaSal') : ?>

    <style>
        table.dataTable.fixedHeader-floating,
        table.dataTable.fixedHeader-locked {
            margin-left: 0% !important;
        }

        .button-agregar-lot {
            background-color: #18252d;
        }

        .button-agregar-lot:hover {
            margin: 0 0 0 1rem !important;
            background-color: white;
            border: 1px solid #18252d !important;
            color: #18252d;
            font-size: 14px;
            border-radius: 5px !important;
            height: 35px !important;
        }

        div.dataTables_wrapper {
            margin-top: 4%;
        }
    </style>
    <table id="tabla4" class="table-striped table-hover table dt-responsive" width="100%">
        <thead style="background-color: #082954; color: white;">
            <th style="text-align:center;">ID</th>
            <th style="text-align:center;">Numero de Parte</th>
            <th style="text-align:center;">Descripcion Insumo</th>
            <th style="text-align:center;">Procedencia</th>
            <th style="text-align:center;">Cliente</th>
            <th style="text-align:center;">Cantidad</th>
            <th style="text-align:center;">Fecha Salida</th>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM empaques_salidas";
            $stmt2 = sqlsrv_query($conn, $sql2);

            while ($row2 = sqlsrv_fetch_array($stmt2)) {
                $id = $row2['id'];

            ?>
                <tr>
                    <td class="text-center"><?php echo $row2['id']; ?></td>
                    <td class="text-center"><?php echo $row2['numero_parte']; ?></td>
                    <td class="text-center"><?php echo $row2['descripcion_insumo']; ?></td>
                    <td class="text-center"><?php echo $row2['procedencia']; ?></td>
                    <td class="text-center"><?php echo $row2['cliente']; ?></td>
                    <td class="text-center"><?php echo $row2['cantidad']; ?></td>
                    <?php if (date_format($row2['fecha_salida'], "Y-m-d") == '1900-01-01') { ?>
                        <td class="text-center">N/A</td>
                    <?php } else { ?>
                        <td class="text-center"><?php echo date_format($row2['fecha_salida'], "Y-m-d"); ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        $('#tabla4').DataTable({
            pageLength: 20,
            order: [
                [0, "desc"]
            ],
            lengthMenu: [
                [20, 40, 60, -1],
                [20, 40, 60, "Todo"]
            ],
            searching: true,
            // dom:'<"top"Blf>rt<"button"ip><"clear">',
            dom: "B<'row'<'col-sm-6 ' l><'col-sm-6 'f>><tr><'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{
                extend: 'excel',
                text: 'Excel <i class="fas fa-file-excel" style="color:green;"></i>'
            }, {
                extend: 'copy',
                text: 'Copiar <i class="fas fa-copy"></i>',
            }, {
                extend: 'pdf',
                text: 'PDF <i class="fas fa-file-pdf" style="color:red;"></i>',

            }, {
                text: 'Crear Salida   <i class="fas fa-plus"></i>',
                className: 'button-agregar-lot mybtn class-disabled',
                action: function() {
                    salida();
                }
            }],
            language: {
                info: "Mostrando _START_ a _END_ de _TOTAL_ resultados",
                infoEmpty: "Mostrando 0 a 0 de 0 resultados",
                infoFiltered: "(filtrado de _MAX_ resultados)",
                infoPostFix: "",
                thousands: ",",
                lengthMenu: "Mostrar _MENU_",
                search: "Buscar:",
                zeroRecords: "Sin resultados",
                paginate: {
                    first: "Primera",
                    last: "Ultima",
                    next: "Siguiente",
                    previous: "Anterior"
                },
                buttons: {
                    copyTitle: 'Copiado en el Portapapeles',
                    copySuccess: {
                        _: '    %d lineas copiadas',
                        1: '1 linea copiada'
                    }
                }
            },
            fixedHeader: {
                header: true,
                headerOffset: 0,
            },
            className: 'font-label',

        });
    </script>
<?php endif; ?>


<!-- Tabla Localizacion -->

<?php if ($_POST['datos'] == 'dibujarTablaLoc' | $operacion == 'dibujarTablaLoc') : ?>

    <style>
        table.dataTable.fixedHeader-floating,
        table.dataTable.fixedHeader-locked {
            margin-left: 0% !important;
        }

        .button-agregar-lot {
            background-color: #18252d;
        }

        .button-agregar-lot:hover {
            margin: 0 0 0 1rem !important;
            background-color: white;
            border: 1px solid #18252d !important;
            color: #18252d;
            font-size: 14px;
            border-radius: 5px !important;
            height: 35px !important;
        }

        div.dataTables_wrapper {
            margin-top: 4%;
        }
    </style>
    <table id="tabla5" class="table-striped table-hover table dt-responsive" width="100%">
        <thead style="background-color: #082954; color: white;">
            <th style="text-align:center;">Numero de Parte</th>
            <th style="text-align:center;">Descripcion Insumo</th>
            <th style="text-align:center;">Procedencia</th>
            <th style="text-align:center;">Cliente</th>
            <th style="text-align:center;">Cantidad</th>
            <th style="text-align:center;">Localizacion</th>
            <th style="text-align:center;">Archivo</th>
        </thead>
        <tbody>
            <?php
            $sql2 = "SELECT * FROM empaques_inventario WHERE cantidad>'0' ORDER BY numero_parte";
            $stmt2 = sqlsrv_query($conn, $sql2);

            while ($row2 = sqlsrv_fetch_array($stmt2)) {
                $id = $row2['id'];
                $loc = $row2['localizacion'];

            ?>
                <tr>
                    <td class="text-center"><?php echo $row2['numero_parte']; ?></td>
                    <td class="text-center"><?php echo $row2['descripcion_insumo']; ?></td>
                    <td class="text-center"><?php echo $row2['procedencia']; ?></td>
                    <td class="text-center"><?php echo $row2['cliente']; ?></td>
                    <td class="text-center"><?php echo $row2['cantidad']; ?></td>
                    <td class="text-center" ondblclick="cambiarLoc(<?php echo $id ?>, '<?php echo $loc ?>');"><?php echo $row2['localizacion']; ?></td>
                    <td class="text-center"><a href="http://192.168.1.253:8090/Materiales/Empaque/<?php echo $row2['archivo'] ?>"> <?php echo $row2['archivo'] ?> </a></td>

                </tr>
            <?php } ?>
        </tbody>
    </table>


    <script>
        $('#tabla5').DataTable({
            pageLength: 20,
            order: [
                [0, "desc"]
            ],
            lengthMenu: [
                [20, 40, 60, -1],
                [20, 40, 60, "Todo"]
            ],
            searching: true,
            // dom:'<"top"Blf>rt<"button"ip><"clear">',
            dom: "B<'row'<'col-sm-6 ' l><'col-sm-6 'f>><tr><'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{
                extend: 'excel',
                text: 'Excel <i class="fas fa-file-excel" style="color:green;"></i>'
            }, {
                extend: 'copy',
                text: 'Copiar <i class="fas fa-copy"></i>',
            }, {
                extend: 'pdf',
                text: 'PDF <i class="fas fa-file-pdf" style="color:red;"></i>',

            }],
            language: {
                info: "Mostrando _START_ a _END_ de _TOTAL_ resultados",
                infoEmpty: "Mostrando 0 a 0 de 0 resultados",
                infoFiltered: "(filtrado de _MAX_ resultados)",
                infoPostFix: "",
                thousands: ",",
                lengthMenu: "Mostrar _MENU_",
                search: "Buscar:",
                zeroRecords: "Sin resultados",
                paginate: {
                    first: "Primera",
                    last: "Ultima",
                    next: "Siguiente",
                    previous: "Anterior"
                },
                buttons: {
                    copyTitle: 'Copiado en el Portapapeles',
                    copySuccess: {
                        _: '    %d lineas copiadas',
                        1: '1 linea copiada'
                    }
                }
            },
            fixedHeader: {
                header: true,
                headerOffset: 0,
            },
            className: 'font-label',

        });
    </script>
<?php endif; ?>