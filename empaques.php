<?php include "../../Header_extra_new.php";

require("../../Conexion.php");

$departamento = "";
$consulta = sqlsrv_query($conn, "SELECT* FROM usuarios WHERE usuario_usuario='" . $_SESSION["username"] . "'");
while ($resultado = sqlsrv_fetch_array($consulta)) {
    $id_usuario = $resultado['id_usuario'];
    $nombre_usuario = $resultado['nombre_usuario'];
    $departamento = $resultado['departamento_usuario'];
}

/* if (!isset($_SESSION["username"])) {
    header("Location: http://192.168.1.240:8080/security/login.php");
    exit();
} */
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../../AdministradorInsumos/NEOM/Styles/styles_requisiciones.css">
    <link rel="stylesheet" href="../../AdministradorInsumos/NEOM/Styles/imssa.css">
    <link rel="stylesheet" href="../../LAMM/css/alertify.css">
    <link rel="stylesheet" href="../../LAMM/css/bootstrap.css">
    <link rel="stylesheet" href="../../LAMM/DataTables/datatables.min.css">
    <link rel="stylesheet" href="../../LAMM/DataTables/DataTables-1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../../LAMM/DataTables/Buttons-2.2.3/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="../../LAMM/DataTables/FixedHeader-3.2.4/css/fixedHeader.bootstrap5.min.css">
    <link rel="stylesheet" href="../../LAMM/node_modules/sweetalert2/dist/sweetalert2.min.css">


    <link rel="stylesheet" href="../../LAMM/css/themes/bootstrap.min.css">
    <link rel="stylesheet" href="../../LAMM/css/fa-all.min.css">
    <link rel="stylesheet" href="../../LAMM/css/select2.min.css">
    <link rel="stylesheet" href="../../LAMM/css/style.css">

</head>

<script>
    alertify.defaults.transition = "slide";
    alertify.defaults.theme.ok = "btn btn-primary";
    alertify.defaults.theme.cancel = "btn btn-danger";
    alertify.defaults.theme.input = "form-control";
</script>


<script src="../../js/repeater.js" type="text/javascript"></script>
<script src="../../LAMM/node_modules/sweetalert2/dist/sweetalert2.js"></script>

<style>
    .imssa-contenedor {
        width: 100% !important;
        margin-top: 2% !important;
    }

    .container {
        min-width: 95% !important;
    }

    .bsuccess2 {
        width: 30% !important;
        margin: 1rem 5%;
    }

    .btn-b {
        width: 8%;
        background-color: black;
        border-color: black;
        margin: 1% 1% !important;
        height: 5%;
    }

    .btn-b:hover {
        background-color: white;
        border-color: black;
        color: #000;
    }

    .btn-s {
        width: 8%;
        background-color: #082954;
        border-color: #082954;
        margin: 1% 1% !important;
        height: 5%;
    }

    .btn-s:hover {
        background-color: white;
        border-color: #082954;
        color: #000;
    }

    #btnrecibir {
        background-color: white;
        color: #082954;
        border-color: #082954;
        border-radius: 10px;
        margin-left: 80%;
        margin-top: 2%;
        width: 20% !important;
    }

    #btnrecibir:hover {
        background-color: #128396;
        color: white;
    }

    #btninsert {
        background-color: white;
        color: #082954;
        border-color: #082954;
        border-radius: 5px;
    }

    #btninsert:hover {
        background-color: #128396;
        color: white;
    }

    /* input[type=checkbox],
    input[type=radio],
    textarea {
        display: initial !important;
    } */

    /* .ctrl {
        position: relative;
        display: block;
        width: 100%;
    } */

    .alertify .ajs-dialog {
        max-width: 100px;
    }

    .mt {
        margin-top: 2%;
    }

    .fz-15 {
        font-size: 20px;
    }

    /* .input, input, select, textarea {
        height: 35px !important;
    } */

    .ctrl-label {
        font-size: 15px;
    }

    .i-h-45 {
        height: 45px !important;
    }

    .i-h-40 {
        height: 40px;
    }

    .alertify .ajs-dialog {
        max-width: 80% !important;
    }

    .ajs-dialog {
        min-width: 0 !important;
    }

    .select2-container .select2-selection--single {
        height: 45px !important;
    }

    .m-l {
        margin-left: 2% !important;
    }

    .tc {
        text-align: center;
    }

    .alertify-notifier .ajs-message.ajs-warning {
        background: rgb(151 10 10 / 95%);
        border-color: #000;
        color: yellow;
    }

    .swal2-popup {
        width: fit-content;
        max-width: 1000px;
        min-width: 300px;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-top: 8px !important;
        font-size: 15px !important;
    }

    .in {
        width: 175px;
        height: 50px;
    }

    .in2 {
        width: 175px;
        height: 50px;
    }
</style>

<div class="container">
    <div class="panel-group crear">
        <div class="panel">

            <h1>Empaques</h1>
            <h2 id="titulo">Recibos</h2>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Recibos</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab1" data-bs-toggle="tab" data-bs-target="#profile-tab-pane1" type="button" role="tab" aria-controls="profile-tab-pane1" aria-selected="false">Inventario</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab2" data-bs-toggle="tab" data-bs-target="#profile-tab-pane2" type="button" role="tab" aria-controls="profile-tab-pane2" aria-selected="false">Salidas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab3" data-bs-toggle="tab" data-bs-target="#profile-tab-pane3" type="button" role="tab" aria-controls="profile-tab-pane3" aria-selected="false">Localizacion</button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent" style="margin-top: 15px;">

                <div class="tab-pane active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    <!-- <button type="submit" id="btnrecibir" name="btnrecibir" class="im-btn im-btn-ok bsuccess env" onclick="recibir()">Recibir</button> -->

                    <div id="formulario">
                        <div class="imssa-contenedor">

                            <div class="mside">
                                <span id="success_result"></span>
                                <form method="post" id="empaques_form">
                                    <!-- Encabezado -->

                                    <div class="fila">
                                        <div class="mcolumnt im-w-15 im-md-100">
                                            <div class="ctrl im-my-1rem">
                                                <select type="text" id="no_parte" name="no_parte" class="js-select2 cambiar_tipo_prove i-h-45">
                                                    <option value="" selected>Seleccionar...</option>
                                                    <?php
                                                    $sql = sqlsrv_query($conn, "SELECT * FROM catalogo_insumos_sinCostoCliente WHERE cliente_insumo LIKE '%KEYTRONIC%' OR cliente_insumo LIKE '%QUANTUM%'");
                                                    while ($row2 = sqlsrv_fetch_array($sql)) {
                                                        $no_parte = $row2{
                                                            'codigo_insumo'};
                                                        $descripcion = $row2{
                                                            'descripcion_insumo'};
                                                        $descripcionUnidad = $row2{
                                                            'desc_unidad_entrega'};
                                                        $cliente = $row2{
                                                            'cliente_insumo'};
                                                        echo "<option value='$no_parte' data-desc='$descripcion' data-desc-unidad='$descripcionUnidad' data-cliente='$cliente'>{$no_parte}</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <label class="ctrl-label">* Numero de Parte</label>
                                            </div>
                                        </div>

                                        <!-- <div class="form-group mcolumnr" style="display:none;">
                                        <input type="number" id="filas_requi" name="filas_requi" readonly>
                                    </div> -->

                                        <div class="mcolumnt im-w-10 im-md-100 m-l">
                                            <div class="ctrl im-my-1rem">
                                                <input class="i-h-45" type="number" min=0 name="cantidad" id="cantidad" value="0" />
                                                <label class="ctrl-label">* Cantidad</label>
                                            </div>
                                        </div>


                                        <div class="mcolumnt im-w-30 im-md-100 m-l">
                                            <div class="ctrl im-my-1rem">
                                                <input class="i-h-45" type="text" id="descripcion" name="descripcion" value="Descripcion Insumo..." readonly />
                                                <label class="ctrl-label">Descripcion Insumo</label>
                                            </div>
                                        </div>

                                        <div class="mcolumnt im-w-35 im-md-100 m-l">
                                            <div class="ctrl im-my-1rem">
                                                <input class="i-h-45" type="text" name="descripcion_unidad" id="descripcion_unidad" value="Descripcion Unidad Insumo..." readonly />
                                                <label class="ctrl-label">Descripcion Unidad Insumo</label>
                                            </div>
                                        </div>
                                        <br>
                                    </div>

                                    <div class="fila" style="margin-top: 2%;">

                                        <div class="mcolumnt im-w-15 im-md-100">
                                            <div class="ctrl im-my-1rem">
                                                <select type="text" id="localizacion" name="localizacion" class="js-select2 cambiar_tipo_prove i-h-45">
                                                    <option value="" selected>Seleccionar...</option>
                                                    <?php
                                                    $sql = sqlsrv_query($conn, "SELECT * FROM localizacion_virtual");
                                                    while ($row2 = sqlsrv_fetch_array($sql)) {
                                                        $localizacion = $row2{
                                                            'nombre_local'};
                                                        echo "<option value='$localizacion'>{$localizacion}</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <label class="ctrl-label">* Localizacion</label>
                                            </div>
                                        </div>

                                        <div class="mcolumnt im-w-15 im-md-100 m-l">
                                            <div class="ctrl im-my-1rem">
                                                <input class="i-h-45" type="text" name="cliente" id="cliente" value="Cliente..." readonly>
                                                <label class="ctrl-label">Cliente</label>
                                            </div>
                                        </div>

                                        <div class="mcolumnt im-w-30 im-md-100 m-l">
                                            <div class="ctrl im-my-1rem">
                                                <input class="i-h-45" type="text" id="comentarios" name="comentarios" placeholder="Comentarios...">
                                                <label class="ctrl-label">Comentarios</label>
                                            </div>
                                        </div>

                                        <div class="mcolumnt im-w-12 im-md-100 m-l">
                                            <div class="ctrl im-my-1rem">
                                                <input class="i-h-45" type="date" id="fecha_empaque" name="fecha_empaque" value="<?php echo date('Y-m-d'); ?>" readonly>
                                                <label class="ctrl-label">Fecha </label>
                                            </div>
                                        </div>

                                        <label style="height:40px; padding-top:10px;" class="mcolumnt im-btn im-btn-aux2 im-my-1rem">
                                            <input type="file" id="archivo_desv[]" style="height:40px" name="archivo_desv[]" onchange="changeText(this)" accept=".jpg,.jpeg,.png,.xls,.xlsx,.doc,.docx,.pdf" />
                                            <!-- accept="image/*,.doc,.docx,.pdf"  -->
                                            <span id="selectedFileName">Adjuntar Archivo...</span>
                                        </label>
                                        <script>
                                            function changeText(file) {
                                                if (validateFile(file) != 0) {
                                                    var name = document.getElementById("archivo_desv[]").files[0].name;
                                                    document.getElementById("selectedFileName").innerHTML = name;
                                                }
                                            }

                                            function validateFile(fileInput) {
                                                var files = fileInput.files;
                                                if (files.length === 0) {
                                                    return;
                                                }

                                                var fileName = files[0].name;
                                                if (fileName.length > 60) {
                                                    $("#fileInput").val('');
                                                    alertify.alert('El nombre del archivo es muy largo. (Max. 60 Caracteres)');
                                                    return 0;
                                                }
                                            }
                                        </script>

                                    </div>

                                    <!-- <br>

                            <br>
                            <button type="submit" id="btninsert" name="btninsert" class="im-btn im-btn-ok bsuccess env" style="margin-left:40%; width:20% !important;" value="Enviar">Enviar</button> -->

                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="tab-pane active" id="profile-tab-pane1" role="tabpanel" aria-labelledby="profile-tab" tabindex="0"> -->
                    <div id="tabla-contenedor" class="imssa-contenedor" style="margin-top: 6%;">
                        <!-- Contenedor Tabla -->
                    </div>
                    <div id="vista_form">
                        <!-- Contenedor Vista Formulario -->
                    </div>
                    <!-- </div> -->

                </div>

                <div class="tab-pane" id="profile-tab-pane1" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">

                    <div id="inventario-contenedor" class="imssa-contenedor" style="margin-top: 6%">
                        <!-- Contenedor Tabla Inventario -->
                    </div>

                </div>

                <div class="tab-pane" id="profile-tab-pane2" role="tabpane2" aria-labelledby="profile-tab" tabindex="0">

                    <div id="formulario-salidas">
                        <div class="imssa-contenedor">
                            <div class="mside">
                                <span id="success_result"></span>
                                <form method="post" id="salidas_form">
                                    <!-- Encabezado -->

                                    <div class="fila">
                                        <div class="fila">
                                            <div class="mcolumnt im-w-25 im-md-100">
                                                <div class="ctrl im-my-1rem i-h-45">
                                                    <select type="text" id="no_parte_sal" name="no_parte_sal" class="js-select2 cambiar_tipo_prove">
                                                        <option value="" selected>Seleccionar...</option>
                                                        <?php
                                                        /* SELECT numero_parte,descripcion_insumo, procedencia, cliente, sum(cantidad) AS total FROM empaques_inventario GROUP BY numero_parte, descripcion_insumo, procedencia, cliente */
                                                        $sql2 = sqlsrv_query($conn, "SELECT numero_parte, sum(cantidad) AS total FROM empaques_inventario GROUP BY numero_parte");
                                                        while ($row3 = sqlsrv_fetch_array($sql2)) {
                                                            $no_parte_s = $row3{
                                                                'numero_parte'};
                                                            echo "<option value='$no_parte_s'>{$no_parte_s}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <label class="ctrl-label">* Numero de Parte</label>
                                                </div>
                                            </div>

                                            <button type="submit" id="buscar" name="buscar" class="im-btn im-btn-ok btn-b" style="margin-left: 5%;" value="buscar">Buscar</button>

                                            <button type="submit" id="tabla-sal" name="tabla-sal" class="im-btn im-btn-ok btn-s" style="margin-right: 5%; float:right;" value="salida">Ver Salidas</button>
                                        </div>
                                    </div>

                                </form>


                            </div>
                        </div>
                    </div>

                    <div id="form-salidas">
                        <div class="imssa-contenedor">
                            <div class="mside">
                                <span id="success_result"></span>
                                <form method="post" id="salidas_form2">
                                    <!-- Encabezado -->

                                    <div class="fila" style="padding-left: 10%;">

                                        <div class="mcolumnt im-w-30 im-md-100">
                                            <div class="ctrl im-my-1rem i-h-45">
                                                <input class="i-h-45 tc" type="text" name="no_parte2" id="no_parte2" readonly>
                                                <label class="ctrl-label">* Numero de Parte</label>
                                            </div>
                                        </div>

                                        <div class="mcolumnt im-w-30 im-md-100 m-l">
                                            <div class="ctrl im-my-1rem">
                                                <input class="i-h-45 tc" type="text" name="localizacion2" id="localizacion2" readonly>
                                                <label class="ctrl-label">* Localizacion</label>
                                            </div>
                                        </div>

                                        <div class="mcolumnt im-w-20 im-md-100 m-l">
                                            <div class="ctrl im-my-1rem">
                                                <input class="i-h-45 tc" type="number" min=0 name="cantidad2" id="cantidad2" value="0" />
                                                <label class="ctrl-label">* Cantidad</label>
                                            </div>
                                        </div>

                                    </div>

                                </form>


                            </div>
                        </div>
                    </div>

                    <div style="padding: 0 1%;">
                        <div id="salidas-form-contenedor" class="imssa-contenedor" style="margin-top: 0%">
                            <!-- Contenedor Tabla Inventario -->
                        </div>

                        <div id="salidas-contenedor" class="imssa-contenedor" style="margin-top: 0%">
                            <!-- Contenedor Tabla Inventario -->
                        </div>
                    </div>

                </div>

                <div class="tab-pane" id="profile-tab-pane3" role="tabpane3" aria-labelledby="profile-tab" tabindex="0">

                    <div id="localizacion-contenedor" class="imssa-contenedor" style="margin-top: 0%">
                        <!-- Contenedor Tabla Inventario -->
                    </div>
                </div>
            </div>
        </div>

        <!-- <button type="submit" id="form" name="form" class="im-btn im-btn-ok bsuccess2 env btn1" style="margin-left: 5%; float:left;" value="Enviar">Formulario</button> 
            <button type="submit" id="btntabla" name="btntabla" class="im-btn im-btn-ok bsuccess2 env btn2" style="margin-left: 5%; float:right;" value="Enviar">Tabla</button> -->

    </div>
</div>
</div>

<script>
    $(document).ready(function() {

        $('#formulario').hide();
        $('#form-salidas').hide();
        $('#form_cambio_loc').hide();


        dibujarTabla();
        dibujarTablaInv();
        dibujarTablaSalidas();
        dibujarTablaLoc();

        alertify.genericDialog || alertify.dialog('genericDialog', function() {
            return {
                main: function(content) {
                    this.setContent(content);
                },
                setup: function() {
                    return {
                        focus: {
                            element: function() {
                                return this.elements.body.querySelector(this.get('selector'));
                            },
                            select: true
                        },
                        options: {
                            basic: true,
                            maximizable: false,
                            resizable: false,
                            padding: false
                        },
                    };
                },
                settings: {
                    selector: undefined
                }
            };
        });

        $(".js-select2").select2({
            width: '100%', // need to override the changed default
            height: '100%'
        });

    });

    $('#home-tab').click(function() {
        $('#titulo').text('Recibos');
    });

    $('#profile-tab1').click(function() {
        $('#titulo').text('Inventario');
    });

    $('#profile-tab2').click(function() {
        $('#titulo').text('Localizacion por Numero de Parte');
    });

    $('#profile-tab3').click(function() {
        $('#titulo').text('Localizacion');
    });

    $('#buscar').click(function() {
        $('#titulo').text('Localizacion por Numero de Parte');
    });

    $('#tabla-sal').click(function() {
        $('#titulo').text('Registro de Salidas');
    });

    $('#buscar').click(function(e) {
        e.preventDefault();

        $('#salidas-contenedor').hide();
        $('#salidas-form-contenedor').show();
        dibujarTablaSalidas();
    });

    $('#tabla-sal').click(function(e) {
        e.preventDefault();

        $('#salidas-form-contenedor').hide();
        $('#salidas-contenedor').show();
        dibujarTablaSal();
    });


    $('#no_parte').change(function() {

        $('#descripcion').val($(this).find(':selected').attr('data-desc'));
        $('#descripcion_unidad').val($(this).find(':selected').attr('data-desc-unidad'));
        $('#cliente').val($(this).find(':selected').attr('data-cliente'));

    });

    $('#no_parte_sal').change(function() {

        $('#descripcion_sal').val($(this).find(':selected').attr('data-desc'));
        $('#procedencia').val($(this).find(':selected').attr('data-procedencia'));
        $('#cliente_sal').val($(this).find(':selected').attr('data-cliente'));

    });


    function recibir() {

        $('#formulario').show();
        vaciarCampos();

        alertify.confirm($('#formulario')[0], function() {

            var datosFormulario = new FormData(document.getElementById("empaques_form"));
            datosFormulario.append("datos", "insert");

            if ($('#no_parte').val() == "" | $('#cantidad').val() == "0" | $('#localizacion').val() == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Llenar Todos los Campos Necesarios!',
                });
            } else {

                Swal.fire({
                    title: 'Guardar registro?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#5fd3b8',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Agregar',
                    cancelButtonText: 'Cancelar'

                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: 'crud_empaques.php',
                            type: 'POST',
                            data: datosFormulario,
                            processData: false,
                            contentType: false,
                            success: function(result) {

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Datos Insertados!',
                                });
                                dibujarTabla();
                                dibujarTablaInv();
                                dibujarTablaSalidas();
                            }
                        });
                    }
                });
            }
        }, function() {

        }).set({
            transition: 'zoom',
            width: '80%',
            heigth: '80%',
            resizable: true
        }).resizeTo('80%', 360);
    }

    function salida(id, np, loc, cant) {

        $('#form-salidas').show();

        $('#no_parte2').val(np);
        $('#localizacion2').val(loc);
        $('#cantidad2').attr('max', cant);
        $('#cantidad2').val("0");

        alertify.confirm($('#form-salidas')[0], function() {

            if ($('#cantidad2').val() == "0") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Llenar Todos los Campos Necesarios!',
                });
            } else if ($('#cantidad2').val() > cant) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cantidad No Disponible En Esta Localizacion!',
                });
            } else {

                var datosFormulario = new FormData(document.getElementById("salidas_form2"));
                datosFormulario.append("id", id);
                datosFormulario.append("cantidad", cantidad2);
                datosFormulario.append("datos", "salida");

                Swal.fire({
                    title: 'Dar Salida?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#5fd3b8',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirmar',
                    cancelButtonText: 'Cancelar'

                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: 'crud_empaques.php',
                            type: 'POST',
                            data: datosFormulario,
                            processData: false,
                            contentType: false,
                            success: function(result) {

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Salida Registrada!',
                                });
                                dibujarTablaSal();
                                dibujarTablaSalidas();
                            }
                        });
                    }
                });
            }
        }, function() {

        }).set({
            transition: 'zoom',
            width: '50%',
            heigth: '80%',
            resizable: true
        }).resizeTo('50%', 275);
    }


    function dibujarTabla() {

        var form_data = new FormData();
        form_data.append('datos', 'dibujarTabla');

        $.ajax({
            url: 'tabla_empaques.php',
            type: 'POST',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(result) {

                $('#tabla-contenedor').html(result);
            }
        });
    }

    function dibujarTablaInv() {

        var form_data = new FormData();
        form_data.append('datos', 'dibujarTablaInv');

        $.ajax({
            url: 'tabla_empaques.php',
            type: 'POST',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(result) {

                $('#inventario-contenedor').html(result);
            }
        });
    }

    function dibujarTablaSalidas() {
        var form_data = new FormData(document.getElementById("salidas_form"));
        form_data.append('datos', 'dibujarTablaSalidas');

        $.ajax({
            url: 'tabla_empaques.php',
            type: 'POST',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(result) {

                $('#salidas-form-contenedor').html(result);
            }
        });
    }

    function dibujarTablaSal() {

        var form_data = new FormData();
        form_data.append('datos', 'dibujarTablaSal');

        $.ajax({
            url: 'tabla_empaques.php',
            type: 'POST',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(result) {

                $('#salidas-contenedor').html(result);
            }
        });
    }

    function dibujarTablaLoc() {

        var form_data = new FormData();
        form_data.append('datos', 'dibujarTablaLoc');

        $.ajax({
            url: 'tabla_empaques.php',
            type: 'POST',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(result) {

                $('#localizacion-contenedor').html(result);
            }
        });
    }


    function cambiarLoc(id, loc) {

        var html = `<form method="post" id="cambio_loc_form">

<div class="fila" style="margin-left: 0%;">

    <div class="mcolumnt im-md-100">
        <div class="in ctrl im-my-1rem">
            <input class="tc" style="height: 45px;" type="text" name="locant" id="locant" value="` + loc + `" readonly>
            <label class="ctrl-label">Localizacion Actual</label>
        </div>
    </div>

    <div class="in2 mcolumnt im-md-100">
        <div class="ctrl im-my-1rem">
            <select type="text" id="camlocalizacion" name="camlocalizacion" class="js-select2 cambiar_tipo_prove i-h-45">
                <option value="" selected>Seleccionar...</option>
                <?php
                $sql = sqlsrv_query($conn, "SELECT * FROM localizacion_virtual");
                while ($row2 = sqlsrv_fetch_array($sql)) {
                    $localizacion = $row2{
                        'nombre_local'};
                    echo "<option value='$localizacion'>{$localizacion}</option>";
                }
                ?>
            </select>
            <label class="ctrl-label">Nueva Localizacion</label>
        </div>
    </div>
</div>

</form>`;

        Swal.fire({
            title: 'Cambio de Localizacion',
            html: html,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: 'Cambiar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {

                if ($('#camlocalizacion').val() == "") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Llenar Todos los Campos Necesarios!',
                    });
                } else {

                    var datosFormulario = new FormData(document.getElementById("cambio_loc_form"));
                    datosFormulario.append("id", id);
                    datosFormulario.append("datos", "cambiarLoc");

                    $.ajax({
                        url: 'crud_empaques.php',
                        type: 'POST',
                        data: datosFormulario,
                        processData: false,
                        contentType: false,
                        success: function(result) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Localizacion Modificada!',
                            });
                            dibujarTabla();
                            dibujarTablaInv();
                            dibujarTablaSalidas();
                            dibujarTablaLoc();
                        }
                    });
                }
            }
        });
    }



    function cambiarLo(id, loc) {

        $('#form_cambio_loc').show();
        $('#locant').val(loc);
        vaciarCampos();

        alertify.confirm($('#form_cambio_loc')[0], function() {

            Swal.close();
            if ($('#camlocalizacion').val() == "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Llenar Todos los Campos Necesarios!',
                });
            } else {

                Swal.fire({
                    title: 'Cambiar Localizacion?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#5fd3b8',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirmar',
                    cancelButtonText: 'Cancelar'

                }).then((result) => {
                    if (result.isConfirmed) {

                        var datosFormulario = new FormData(document.getElementById("cambio_loc_form"));
                        datosFormulario.append("id", id);
                        datosFormulario.append("datos", "cambiarLoc");

                        $.ajax({
                            url: 'crud_empaques.php',
                            type: 'POST',
                            data: datosFormulario,
                            processData: false,
                            contentType: false,
                            success: function(result) {

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Localizacion Modificada!',
                                });
                                dibujarTabla();
                                dibujarTablaInv();
                                dibujarTablaSalidas();
                                dibujarTablaLoc();
                            }
                        });
                    }
                });
            }
        }, function() {

        }).set({
            transition: 'zoom',
            width: '80%',
            heigth: '80%',
            resizable: true
        }).resizeTo('40%', 250);
    }

    function vaciarCampos() {
        $('#no_parte').val('');
        $('#no_parte').select2({
            width: '100%'
        }).val('');
        $('#descripcion').val('Descripcion Insumo...');
        $('#descripcion_unidad').val('Descripcion Unidad Insumo...');
        $('#cliente').val('Cliente...');
        $('#cantidad').val('0');
        $('#localizacion    ').val('');
        $('#localizacion    ').select2({
            width: '100%'
        }).val('');
        $('#comentarios').val('');
    }

    function vaciarC() {
        $('#no_parte_sal').val('');
        $('#no_parte_sal').select2({
            width: '100%'
        }).val('');
        $('#cantidad_sal').val('0');
        $('#descripcion_sal').val('Descripcion Insumo...');
        $('#procedencia').val('Procedencia...');
        cliente_sal
        $('#cliente_sal').val('Cliente...');
    }
</script>

<style>
    .alertify .ajs-dialog {
        max-width: 80% !important;
    }

    element.style {
        min-width: 100px !important;
    }
</style>