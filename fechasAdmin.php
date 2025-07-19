<?php
include('headerAdmin.php');
include ('procesos/conexion.php');
setlocale(LC_TIME, 'es_ES.UTF-8');
date_default_timezone_set('America/Caracas');
$fecha_actual = date("Y-m-d");


    include('procesos/obtener_fechas_bloq.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn_eliminar_fecha_bloq"])) {
        include('procesos/eliminar_fecha_bloq.php');
        include('procesos/obtener_fechas_bloq.php');
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fecha_bloq']) && isset($_POST["btn_agregar_fecha_bloq"])) {
        include('procesos/agregar_fecha_bloq.php');
        include('procesos/obtener_fechas_bloq.php');
    }

    echo  "
    <div class='container-sm contenedor-reserva  p-5 '>
    <div class='agregar ms-auto derecha'>
    
        <button type='button' class='btn btn-primary btn-personalizado me-2' data-bs-toggle='modal' data-bs-target='#agregarFecha'>
            Bloquear Fecha
        </button>
    </div>"; ?>

            <div class='modal fade' id='agregarFecha' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h1 class='modal-title fs-5' id='exampleModalLabel'>Bloquear Fecha</h1>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>

                            <div class='modal-body' style='text-align: left;'>
                                <form action='<?php htmlspecialchars($_SERVER["PHP_SELF"])?>' method="POST" class="needs-validation" novalidate>

                                <div class="mb-2">
                                    <!--Label fecha -->
                                    <label for="fecha_bloq" class="form-label">Fecha</label><br>
                                            <input type="date" class="form-control" name="fecha_bloq" min="<?php echo $fecha_actual; ?>" required> 
                                            <div class="invalid-feedback">
                                                    Seleccione la Fecha.
                                            </div>         
                                </div>

                                    <div class='modal-footer'>
                                        <input type="submit" value="Agregar" name='btn_agregar_fecha_bloq' class="btn btn-primary btn-personalizado">
                                        <button type='button' class='btn btn-secondary btn-personalizado' data-bs-dismiss='modal'>Cancelar</button>
                                    </div> 
                                </form>
                            </div>
                        </div>
                    </div>
                </div> 

<?php
    echo  "<h1 class='no-deco' style='text-align: center'>Fechas Bloqueadas</h1>
        <hr>";

    if($resultado){

        echo "<div class='table-responsive'>
                <table class='table'>
                    <thead>
                        <tr>
                            <th scope='col'>Fecha</th>
                            <th scope='col'>Opciones</th>
                        </tr>
                    </thead>";
        

        foreach ($resultado as $fila) {
            // Acceder a los valores de cada reserva
            $id_fecha_bloq= $fila['id_fecha_bloq'];
            $fecha_bloq= $fila['fecha_bloq'];

            // Mostrar los datos de cada reserva

            echo  "<tbody>
                <tr  style='height: 75px;'>
                    <th scope='row' style='width: 80px;'>$fecha_bloq</th>";
            ?>

            <td style='width: 100px;'>
                <div class='centrados'>

                    <button type='button' class='btn btn-primary btn-tabla' data-bs-toggle='modal' data-bs-target='#cancelModal<?php echo $fecha_bloq?>'>
                        <i class="fa-solid fa-trash"></i>
                    </button>

                    <!-- Modal -->
                    <div class='modal fade' id='cancelModal<?php echo $fecha_bloq?>' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h1 class='modal-title fs-5' id='exampleModalLabel'>Eliminar Bloqueo de Fecha <?php echo $fecha_bloq?></h1>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>

                                <div class='modal-body' style='text-align: left;'>
                                    <?php ?>
                                    <form action='<?php htmlspecialchars($_SERVER["PHP_SELF"])?>' method='POST'>
                                        <div class="centrados">
                                                <p>¿Estas seguro que quieres eliminar este bloqueo?
                                        </div>
                                        <input type='hidden' name='id_fecha_bloq' value='<?php echo $id_fecha_bloq ?>'>
                                        
        
                                        <div class='modal-footer'>
                                            <input type='submit' value='Estoy Seguro' name='btn_eliminar_fecha_bloq' class='btn btn-primary btn-personalizado' style='width: 120px;'>
                                            <button type='button' class='btn btn-secondary btn-personalizado' data-bs-dismiss='modal'>Volver</button>
                                        </div> 
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> 

                    
                </div>
            </td>
        </tr>

            <?php
        }
        echo "</tbody>
            </table>
        </div>
    </div>";
    } else {
        echo "<div class='ms-2 centrados'>";
        echo "<br><h2>Aun no haz bloqueado ninguna fecha</h2>";
        echo "</div>";
    }



    include ('footer2.php');
?>


<script>
    // Mostrar la notificación al cargar la página
    const notification = document.getElementById('myNotification');
    notification.style.display = 'block';

    // Ocultar la notificación después de 3 segundos
    setTimeout(() => {
        notification.style.display = 'none';
    }, 3000);
</script>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
            }, false)
        })
        })()
</script>