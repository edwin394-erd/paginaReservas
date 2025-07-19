<?php
    include('headerUsuario.php');
    include ('procesos/conexion.php');
    include('procesos/manejar_estados_reservas.php');

    setlocale(LC_TIME, 'es_ES.UTF-8');
    date_default_timezone_set('America/Caracas');
    $fecha_actual = date("Y-m-d");
    $mas_un_mes = date('Y-m-d', strtotime('+1 month'));
    $hoy = date('d');

    // Obtener todos los horarios de apertura y cierre
    $consulta = "SELECT id_dia, hora_apertura, hora_cierre, estado FROM horario_laboral";
    $stmt = $base->prepare($consulta);
    $stmt->execute();

    // Guardar los resultados en un array asociativo
    $horarios = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $horarios[$row['id_dia']] = [
            'hora_apertura' => $row['hora_apertura'],
            'hora_cierre' => $row['hora_cierre'],
            'estado' => $row['estado']
        ];
    }

    

    include('procesos/obtener_reservas_usuario.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn_cancelar"])) {
        include('procesos/cancelar_reserva.php');
        include('procesos/obtener_reservas_usuario.php');
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['numero_personas']) && isset($_POST['fecha']) && isset($_POST["btn_editar"])) {
        include('procesos/cambiar_reserva.php');
        include('procesos/obtener_reservas_usuario.php');
    }

    echo  "<div class='container-sm contenedor-reserva  p-5 '>
    <h1 class='no-deco' style='text-align: center'>Tus Reservaciones</h1>
    <hr>";

    if($resultado){
            echo "<div class='table-responsive'>
                <table class='table'>
                    <thead>
                        <tr>
                            <th scope='col'># Referencia</th>
                            <th scope='col'>Número de Mesa</th>
                            <th scope='col'>Número de Personas</th>
                            <th scope='col'>Fecha</th>
                            <th scope='col'>Hora de Inicio</th>
                            <th scope='col'>Hora de Fin</th>
                            <th scope='col'>Estado</th>
                            <th scope='col'>Opciones</th>
                        </tr>
                    </thead>";

        foreach ($resultado as $fila) {
            // Acceder a los valores de cada reserva
            $nombre= $fila['nombre'];
            $apellido = $fila['apellido'];
            $numero_mesa = $fila['numero_mesa'];
            $id_reserva = $fila['id_reserva'];
            $numero_personas = $fila['numero_personas'];
            $fecha = $fila['fecha'];
            $hora_inicio = date('g:i A', strtotime($fila['hora_inicio']));
            $hora_fin = date('g:i A', strtotime($fila['hora_fin']));
            $hora_inicio_24 = date('H:i', strtotime($fila['hora_inicio']));
            $hora_fin_24 = date('H:i', strtotime($fila['hora_fin']));
            $estado = $fila['estado'];
            $id_mesa=$fila['id_mesa'];
            // Mostrar los datos de cada reserva

            echo  "<tbody>
                <tr  style='height: 75px;'>
                    <th scope='row' style='width: 80px;'>$id_reserva</th>
                    <td style='width: 120px;'>$numero_mesa</td>
                    <td style='width: 100px;'>$numero_personas</td>
                    <td style='width: 120px;'>$fecha</td>
                    <td style='width: 100px;'>$hora_inicio</td>
                    <td style='width: 100px;'>$hora_fin</td>";

            if($estado=="PENDIENTE"){
                echo "<td style='width: 100px;'><div class='estatus pendiente ms-auto me-auto p-1' >$estado</div></td>";
            }
            if($estado=="CANCELADA"){
                echo "<td style='width: 100px;'><div class='estatus cancelada ms-auto me-auto p-1'>$estado</div></td>";
            }
            if($estado=="EN CURSO"){
                echo "<td style='width: 100px;'><div class='estatus encurso ms-auto me-auto p-1'>$estado</div></td>";
            }
            if($estado=="TERMINADA"){
                echo "<td style='width: 100px;'><div class='estatus terminada ms-auto me-auto p-1''>$estado</div></td>";
            }
            ?>
            <!-- Pasar los horarios al lado del cliente -->
            <script>
            var horarios = <?php echo json_encode($horarios); ?>;
            </script>

            <td style='width: 100px;'>
                <div class='centrados'>
                <?php
                        if($estado=="PENDIENTE"){
                            echo "<button type='button' class='btn btn-primary btn-tabla' data-bs-toggle='modal' data-bs-target='#exampleModal$id_reserva'>
                            <i class='fa-solid fa-pen-to-square'></i>
                        </button>";
                        }else{
                            echo "<button type='button' class='btn btn-primary btn-tabla' data-bs-toggle='modal' data-bs-target='#exampleModal$id_reserva' disabled>
                            <i class='fa-solid fa-pen-to-square'></i>
                        </button>";
                        }

                    ?>
                    

                    <!-- Modal -->
                    <div class='modal fade' id='exampleModal<?php echo $id_reserva?>' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h1 class='modal-title fs-5' id='exampleModalLabel'>Editar reserva #<?php echo $id_reserva?></h1>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>

                                <div class='modal-body' style='text-align: left;'>
                                    <?php ?>
                                    <form action='<?php htmlspecialchars($_SERVER["PHP_SELF"])?>' method="POST" class="needs-validation" novalidate>

                                        <div class="mb-2">
                                            <label for="numero_personas" class="form-label">Ingrese el número de personas</label><br>
                                                        <input type="text" name="numero_personas" class="form-control" minlength="1" maxlength="2" pattern="\d{1,2}" value="<?php echo $numero_personas?>" placeholder="Número de personas" required>
                                                        <div class="invalid-feedback">
                                                            Digite el número de personas.
                                                        </div>  
                                        </div>

                                        <div class="mb-2">
                                            <!--Label fecha -->
                                            <label for="fecha" class="form-label">Fecha</label><br>
                                                    <input type="date" class="form-control fecha" name="fecha" value="<?php echo $fecha?>" min="<?php echo $fecha_actual; ?>" max="<?php echo $mas_un_mes; ?>" required> 
                                                    <div class="invalid-feedback">
                                                            Seleccione la Fecha.
                                                    </div>         
                                        </div>
                                                

                                        <div class="mb-2">
                                                    <label for="hora_inicio" class="form-label">Hora de inicio</label><br>
                                                        <input type="time" class="form-control hora_inicio" value="<?php echo $hora_inicio_24?>" min="" max=""  name="hora_inicio" required>
                                                        <div class="invalid-feedback">
                                                                Seleccione una hora de inicio que este dentro del horario laboral y mayor a la hora actual.
                                                        </div>       
                                        </div>

                                        <div class="mb-2">
                                                    <label for="hora_fin" class="form-label">Hora de fin</label><br>
                                                    <input type="time" class="form-control hora_fin" value="<?php echo $hora_fin_24 ?>" min="" max="" name="hora_fin" required>
                                                        <div class="invalid-feedback">
                                                                Seleccione una hora de fin que este dentro del horario laboral.<br>
                                                        </div>       
                                        </div>

                                        <input type='hidden' name='id_reserva' value='<?php echo $id_reserva ?>'>
                                        <input type='hidden' name='id_mesa' value='<?php echo $id_mesa ?>'>

                                        <div class='modal-footer'>
                                            <input type="submit" value="Guardar Cambios" name='btn_editar' class="btn btn-primary btn-personalizado btn_cambiar_reserva">
                                            <button type='button' class='btn btn-secondary btn-personalizado' data-bs-dismiss='modal'>Cancelar</button>
                                        </div> 
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <?php
                        if($estado=="PENDIENTE"){
                            echo "<button type='button' class='btn btn-primary btn-tabla' data-bs-toggle='modal' data-bs-target='#cancelModal$id_reserva'>
                            <i class='fa-solid fa-trash'></i>
                        </button>";
                        }else{
                            echo "<button type='button' class='btn btn-primary btn-tabla' data-bs-toggle='modal' data-bs-target='#cancelModal$id_reserva' disabled>
                            <i class='fa-solid fa-trash'></i>
                        </button>";
                        }

                    ?>
                    

                    <!-- Modal -->
                    <div class='modal fade' id='cancelModal<?php echo $id_reserva?>' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h1 class='modal-title fs-5' id='exampleModalLabel'>Cancelar reserva #<?php echo $id_reserva?></h1>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>

                                <div class='modal-body' style='text-align: left;'>
                                    <?php ?>
                                    <form action='<?php htmlspecialchars($_SERVER["PHP_SELF"])?>' method='POST'>
                                        <div class="centrados">
                                                <p>¿Estas seguro que quieres cancelar esta reserva?
                                        </div>
                                        <input type='hidden' name='id_reserva' value='<?php echo $id_reserva ?>'>
                                        
        
                                        <div class='modal-footer'>
                                            <input type='submit' value='Estoy Seguro' name='btn_cancelar' class='btn btn-primary btn-personalizado' style='width: 120px;'>
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
        echo "<br><h2>Bienvenido, aun no haz realizado ninguna reserva</h2>";
        echo "</div>";
    }

?>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function() {

    $('.btn-tabla').click(function() {
        // Obtén el modal que fue abierto
        var modal = $($(this).data('bs-target'));
        // Encuentra los campos de entrada dentro del modal
        var fecha = modal.find('.fecha');
        var hora_inicio = modal.find('.hora_inicio');
        var hora_fin = modal.find('.hora_fin');
        var btn_cambiar_reserva = modal.find('.btn_cambiar_reserva');

    $('.fecha').change(function() {
        var fechaSeleccionada = new Date($(this).val() + "T00:00:00-04:00"); // Añadir la zona horaria de Venezuela

        var fechaActual = new Date(new Date().toLocaleString("en-US", {timeZone: "America/Caracas"})); // Obtener la fecha y hora actual en la zona horaria de Venezuela
        const horaActual = `${fechaActual.getHours()}:${("0" + fechaActual.getMinutes()).slice(-2)}`;        
        var idDia = fechaSeleccionada.getDay(); // Convertir la fecha a un número de día de la semana
        // Obtener el horario correspondiente al día de la semana
        var horario = horarios[idDia];
        console.log(`Dia: ${idDia}`);
        // Verificar si el día está habilitado
        if (horario.estado == 'Habilitado') {
            // Si el día esta habilitado, y habilitar los inputs de tiempo
            hora_inicio.attr("disabled", false);
            hora_fin.attr("disabled", false);
            btn_cambiar_reserva.attr("disabled", false);

            // Si la fecha seleccionada es hoy
           
            if (fechaSeleccionada.setHours(0,0,0,0) == fechaActual.setHours(0,0,0,0)) {
            var fechaActual = new Date(new Date().toLocaleString("en-US", {timeZone: "America/Caracas"})); // Obtener la fecha y hora actual en la zona horaria de Venezuela
            const horaActual = `${fechaActual.getHours()}:${("0" + fechaActual.getMinutes()).slice(-2)}`;


                // Si la hora actual es mayor a la hora de apertura
                if (horaActual > horario.hora_apertura) {
                    hora_inicio.attr("min", horaActual);
                }else{
                    hora_inicio.attr("min",  horario.hora_apertura);
                }
                
                // Si la hora actual es mayor a la hora de cierre
                if (horaActual > horario.hora_cierre) {
                    hora_inicio.val('');
                    hora_inicio.attr("disabled", true);
                    hora_fin.val('');
                    hora_fin.attr("disabled", true);
                    btn_cambiar_reserva.attr("disabled", true);
                }
            }else{
                hora_inicio.attr("min", horario.hora_apertura);
            }

            // Actualizar los inputs de tiempo con los horarios
            hora_inicio.attr("max", horario.hora_cierre);
            hora_fin.attr("min", horario.hora_apertura);
            hora_fin.attr("max", horario.hora_cierre);
        } else {
            // Si el día no está habilitado, limpiar y deshabilitar los inputs de tiempo
            hora_inicio.val('');
            hora_inicio.attr("disabled", true);
            hora_fin.val('');
            hora_fin.attr("disabled", true);
            btn_cambiar_reserva.attr("disabled", true);
        }
    });


    $('.hora_inicio, .hora_fin').change(function() {
        
        var fechaSeleccionada = new Date(fecha.val() + "T00:00:00-04:00"); // Añadir la zona horaria de Venezuela

        var fechaActual = new Date(new Date().toLocaleString("en-US", {timeZone: "America/Caracas"})); // Obtener la fecha y hora actual en la zona horaria de Venezuela
        const horaActual = `${fechaActual.getHours()}:${("0" + fechaActual.getMinutes()).slice(-2)}`;        
        var idDia = fechaSeleccionada.getDay(); // Convertir la fecha a un número de día de la semana
        // Obtener el horario correspondiente al día de la semana
        var horario = horarios[idDia];
            
            if (fechaSeleccionada.setHours(0,0,0,0) == fechaActual.setHours(0,0,0,0)) {
             console.log(`Es igual`);
            var fechaActual = new Date(new Date().toLocaleString("en-US", {timeZone: "America/Caracas"})); // Obtener la fecha y hora actual en la zona horaria de Venezuela
            const horaActual = `${fechaActual.getHours()}:${("0" + fechaActual.getMinutes()).slice(-2)}`;

                // Si la hora actual es mayor a la hora de apertura
                if (horaActual > horario.hora_apertura) {
                    hora_inicio.attr("min", horaActual);
                }else{
                    hora_inicio.attr("min",  horario.hora_apertura);
                }

                // Si la hora actual es mayor a la hora de cierre
                if (horaActual > horario.hora_cierre) {
                    console.log(`XD`);
                    hora_inicio.val('');
                    hora_inicio.attr("disabled", true);
                    hora_fin.val('');
                    hora_fin.attr("disabled", true);
                    btn_cambiar_reserva.attr("disabled", true);
                }
            }else{
                hora_inicio.attr("min", horario.hora_apertura);
            }

            // Actualizar los inputs de tiempo con los horarios
            hora_inicio.attr("max", horario.hora_cierre);
            hora_fin.attr("min", horario.hora_apertura);
            hora_fin.attr("max", horario.hora_cierre);
        
    });
});
});
</script>


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


<?php
    include('footer2.php');
?>


