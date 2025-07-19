<?php
include('headerAdmin.php');
include ('procesos/conexion.php');


    include('procesos/obtener_todos_horarios.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['hora_apertura']) && isset($_POST['hora_cierre']) && isset($_POST["btn_cambiar_horario"])) {
        include('procesos/cambiar_horario.php');
        include('procesos/obtener_todos_horarios.php');
    }

    echo  "
    <div class='container-sm contenedor-reserva  p-5 '>
    
    <h1 class='no-deco centrados'>Administrar Horario</h1><hr>";

    if($resultado){
       
            echo "<div class='table-responsive'>
                <table class='table'>
                    <thead>
                        <tr>
                            <th scope='col'>Dia</th>
                            <th scope='col'>Hora de Aperutra</th>
                            <th scope='col'>Hora de Cierre</th>
                            <th scope='col'>Estado</th>
                            <th scope='col'>Opciones</th>
                        </tr>
                    </thead>";

        foreach ($resultado as $fila) {
            // Acceder a los valores de cada reserva
            $dia= $fila['dia'];
            $hora_apertura = date('g:i A', strtotime($fila['hora_apertura']));
            $hora_cierre = date('g:i A', strtotime($fila['hora_cierre']));
            $hora_apertura_24 = date('H:i', strtotime($fila['hora_apertura']));
            $hora_cierre_24 = date('H:i', strtotime($fila['hora_cierre']));
            $estado= $fila['estado'];

            // Mostrar los datos de cada reserva

            echo  "<tbody>
                <tr  style='height: 75px;'>
                    <td style='width: 80px;'>$dia</td>
                    <td style='width: 150px;'>$hora_apertura</td>
                    <td style='width: 150px;'>$hora_cierre</td>";
                    

            if($estado=="Habilitado"){
                echo "<td style='width: 100px;'><div class='estatus disponible ms-auto me-auto p-1' >$estado</div></td>";
            }
            if($estado=="No Habilitado"){
                echo "<td style='width: 100px;'><div class='estatus nodisponible ms-auto me-auto p-1'>$estado</div></td>";
            }
            ?>

            <td style='width: 100px;'>
                <div class='centrados'>
                    <button type='button' class='btn btn-primary btn-tabla' data-bs-toggle='modal' data-bs-target='#exampleModal<?php echo $dia?>'>
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    <!-- Modal -->
                    <div class='modal fade' id='exampleModal<?php echo $dia?>' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h1 class='modal-title fs-5' id='exampleModalLabel'>Editar dia: <?php echo $dia?></h1>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>

                                <div class='modal-body' style='text-align: left;'>
                                    <form action='<?php htmlspecialchars($_SERVER["PHP_SELF"])?>' method="POST" class="needs-validation" novalidate>

                                    <div class="mb-2">
                                                <label for="hora_apertura" class="form-label">Hora de Apertura</label><br>
                                                    <input type="time" class="form-control" id="hora_apertura" min="" max=""  value="<?php echo $hora_apertura_24?>" name="hora_apertura" required>
                                                    <div class="invalid-feedback">
                                                            Digite la hora de apertura.
                                                    </div>       
                                    </div>

                                    <div class="mb-2">
                                                <label for="hora_cierre" class="form-label">Hora de Cierre</label><br>
                                                <input type="time" class="form-control" id="hora_cierre" min="" max="" value="<?php echo $hora_cierre_24?>" name="hora_cierre" required>
                                                    <div class="invalid-feedback">
                                                            Digite la hora de cierre.
                                                    </div>       
                                    </div>

                                    <div class="mb-2">
                                            <label for="estado" class="form-label">Estado</label><br>
                                                    <select name='estado'  class="form-control" required>
                                                    <?php
                                                           echo "<option value='Habilitado'" . ($estado == 'Habilitado' ? " selected" : "") . ">Habilitado</option>";
                                                           echo "<option value='No Habilitado'" . ($estado == 'No Habilitado' ? " selected" : "") . ">No Habilitado</option>";
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                            Seleccione el estado de el día.
                                                    </div>       
                                        </div>

                                        <input type='hidden' name='dia' value='<?php echo $dia ?>'>

                                        <div class='modal-footer'>
                                            <input type="submit" value="Guardar Cambios" name='btn_cambiar_horario' class="btn btn-primary btn-personalizado">
                                            <button type='button' class='btn btn-secondary btn-personalizado' data-bs-dismiss='modal'>Cancelar</button>
                                        </div> 
                                    </form>
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
        echo "<br><h2>Bienvenido, aun no haz agregado ninguna mesa</h2>";
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