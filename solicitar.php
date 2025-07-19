<?php
    setlocale(LC_TIME, 'es_ES.UTF-8');
    date_default_timezone_set('America/Caracas');
    include('headerUsuario.php');
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
?>

<!-- Pasar los horarios al lado del cliente -->
<script>
var horarios = <?php echo json_encode($horarios); ?>;
</script>

<div class="container p-5">
    <div class="container-sm contenedor-solicitar  p-5 ">
    <h2 class="no-deco" style="text-align: center">Haz tu Reserva</h2>
    <hr>

      
      
          <form id="reservaForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="needs-validation" novalidate>

          <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                include('procesos/crearReserva.php');
            }
      ?>

          <div class="mb-2">
              <label for="numero_personas" class="form-label">Ingrese el número de personas</label><br>
                        <input type="text" name="numero_personas" class="form-control" minlength="1" maxlength="2" pattern="\d{1,2}" placeholder="Número de personas" required>
                          <div class="invalid-feedback">
                              Digite el número de personas.
                          </div>  
          </div>

          <div class="mb-2">
             <!--Label fecha -->
             <label for="fecha" class="form-label">Fecha</label><br>
                    <input type="date" class="form-control" name="fecha" id="fecha" min="<?php echo $fecha_actual; ?>" max="<?php echo $mas_un_mes; ?>" required> 
                    <div class="invalid-feedback">
                            Seleccione la Fecha.
                    </div>         
          </div>
                  

          <div class="mb-2">
                    <label for="hora_inicio" class="form-label">Hora de inicio</label><br>
                        <input type="time" class="form-control" id="hora_inicio" min="" max=""  name="hora_inicio" required>
                          <div class="invalid-feedback">
                                Seleccione una hora de inicio que este dentro del horario laboral y mayor a la hora actual.
                        </div>       
          </div>

          <div class="mb-2">
                    <label for="hora_fin" class="form-label">Hora de fin</label><br>
                    <input type="time" class="form-control" id="hora_fin" min="" max="" name="hora_fin" required>
                          <div class="invalid-feedback">
                                Seleccione una hora de fin que este dentro del horario laboral.<br>
                        </div>       
          </div>

                  
                  <div class="centrados">
                          <br><input type="submit" value="Crear Reserva" class="btn btn-primary btn-personalizado" id="btn_crear_reserva">
                  </div>
                  <div class="row pt-4 centrados">
                 <a href="mostrarReservas.php" class="no-deco"><h6>Ver Reservas</h6></a>
          </div>
          </form>
  </div>

    </div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    $('#fecha').change(function() {
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
            $("#hora_inicio").attr("disabled", false);
            $("#hora_fin").attr("disabled", false);
            $("#btn_crear_reserva").attr("disabled", false);

            // Si la fecha seleccionada es hoy
           
            if (fechaSeleccionada.setHours(0,0,0,0) == fechaActual.setHours(0,0,0,0)) {
            var fechaActual = new Date(new Date().toLocaleString("en-US", {timeZone: "America/Caracas"})); // Obtener la fecha y hora actual en la zona horaria de Venezuela
            const horaActual = `${fechaActual.getHours()}:${("0" + fechaActual.getMinutes()).slice(-2)}`;


                // Si la hora actual es mayor a la hora de apertura
                if (horaActual > horario.hora_apertura) {
                    $("#hora_inicio").attr("min", horaActual);
                }else{
                    $("#hora_inicio").attr("min",  horario.hora_apertura);
                }
                console.log(`Actual: ${horaActual}`);
                console.log(`Cierre: ${horario.hora_cierre}`);
                // Si la hora actual es mayor a la hora de cierre
                if (horaActual > horario.hora_cierre) {
                    console.log(`Ya paso`);
                    $("#hora_inicio").attr("disabled", true);
                    $("#hora_fin").attr("disabled", true);
                    $("#btn_crear_reserva").attr("disabled", true);
                }
            }else{
                $("#hora_inicio").attr("min", horario.hora_apertura);
            }

            console.log(`Actual: ${horaActual}`);
            console.log(`Cierre: ${horario.hora_cierre}`);

            // Actualizar los inputs de tiempo con los horarios
            $("#hora_inicio").attr("max", horario.hora_cierre);
            $("#hora_fin").attr("min", horario.hora_apertura);
            $("#hora_fin").attr("max", horario.hora_cierre);
        } else {
            // Si el día no está habilitado, limpiar y deshabilitar los inputs de tiempo
            $("#hora_inicio").val('');
            $("#hora_inicio").attr("disabled", true);
            $("#hora_inicio").attr("placeholder", "Ese dia esta fuera del horario");
            $("#hora_fin").val('');
            $("#hora_fin").attr("disabled", true);
            $("#hora_fin").attr("placeholder", "Ese dia esta fuera del horario");
            $("#btn_crear_reserva").attr("disabled", true);
        }
    });
});
</script>

<script>
  $(document).ready(function() {
    $('#hora_inicio, #hora_fin').change(function() {
        var fechaSeleccionada = new Date($('#fecha').val() + "T00:00:00-04:00"); // Añadir la zona horaria de Venezuela

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
                    $("#hora_inicio").attr("min", horaActual);
                }else{
                    $("#hora_inicio").attr("min",  horario.hora_apertura);
                }

                // Si la hora actual es mayor a la hora de cierre
                if (horaActual > horario.hora_cierre) {
                    $("#hora_inicio").attr("disabled", true);
                    $("#hora_fin").attr("disabled", true);
                }
            }else{
                $("#hora_inicio").attr("min", horario.hora_apertura);
            }

            // Actualizar los inputs de tiempo con los horarios
            $("#hora_inicio").attr("max", horario.hora_cierre);
            $("#hora_fin").attr("min", horario.hora_apertura);
            $("#hora_fin").attr("max", horario.hora_cierre);
        
    });
});
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

