<?php
include('headerAdmin.php');
include ('procesos/conexion.php');


    include('procesos/obtener_todas_mesas.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn_eliminar_mesa"])) {
        include('procesos/eliminar_mesa.php');
        include('procesos/obtener_todas_mesas.php');
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['capacidad']) && isset($_POST['numero_mesa']) && isset($_POST["btn_cambiar_mesa"])) {
        include('procesos/cambiar_mesa.php');
        include('procesos/obtener_todas_mesas.php');
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['capacidad']) && isset($_POST['numero_mesa']) && isset($_POST["btn_agregar_mesa"])) {
        include('procesos/agregar_mesa.php');
        include('procesos/obtener_todas_mesas.php');
    }

    echo  "
    <div class='container-sm contenedor-reserva  p-5 '>
    <div class='agregar ms-auto derecha'>
    
        <button type='button' class='btn btn-primary btn-personalizado me-2' data-bs-toggle='modal' data-bs-target='#AgregarMesa'>
            Agregar Mesa
        </button>
    </div>"; ?>

            <div class='modal fade' id='AgregarMesa' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h1 class='modal-title fs-5' id='exampleModalLabel'>Agregar Mesa</h1>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>

                            <div class='modal-body' style='text-align: left;'>
                                <form action='<?php htmlspecialchars($_SERVER["PHP_SELF"])?>' method="POST" class="needs-validation" novalidate>

                                    <div class="mb-2">
                                        <label for="numero_mesa" class="form-label">Número de mesa</label><br>
                                                    <input type="text" name="numero_mesa" class="form-control" minlength="1" maxlength="3" pattern="\d{1,3}" placeholder="Número de Mesa" required>
                                                    <div class="invalid-feedback">
                                                        Digite el número de mesa.
                                                    </div>  
                                    </div>

                                    <div class="mb-2">
                                        <label for="capacidad" class="form-label">Capacidad</label><br>
                                        <input type="text" name="capacidad" class="form-control" minlength="1" maxlength="2" pattern="\d{1,2}" placeholder="Capacidad" required>
                                                <div class="invalid-feedback">
                                                        Ingrese la capacidad.
                                                </div>         
                                    </div>
                                            

                                    <div class="mb-2">
                                        <label for="estado">Estado</label><br>
                                                <select name='estado'  class="form-control" required>
                                                    <option value='Disponible'>Disponible</option>
                                                    <option value='No Disponible'>No disponible</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                        Seleccione el estado de la mesa.
                                                </div>       
                                    </div>

                                    <div class='modal-footer'>
                                        <input type="submit" value="Agregar" name='btn_agregar_mesa' class="btn btn-primary btn-personalizado">
                                        <button type='button' class='btn btn-secondary btn-personalizado' data-bs-dismiss='modal'>Cancelar</button>
                                    </div> 
                                </form>
                            </div>
                        </div>
                    </div>
                </div> 

<?php
        echo "<h1 class='no-deco centrados'>Administrar Mesas</h1>
        <hr>";
    if($resultado){
       
            echo "<div class='table-responsive'>
                <table class='table'>
                    <thead>
                        <tr>
                            <th scope='col'>Número de mesa</th>
                            <th scope='col'>Capacidad</th>
                            <th scope='col'>Estado</th>
                            <th scope='col'>Opciones</th>
                        </tr>
                    </thead>";

        foreach ($resultado as $fila) {
            // Acceder a los valores de cada reserva
            $id_mesa= $fila['id_mesa'];
            $estado= $fila['estado'];
            $capacidad = $fila['capacidad'];
            $numero_mesa = $fila['numero_mesa'];
            // Mostrar los datos de cada reserva

            echo  "<tbody>
                <tr  style='height: 75px;'>
                    <th scope='row' style='width: 80px;'>$numero_mesa</th>
                    <td style='width: 150px;'>$capacidad</td>";

            if($estado=="Disponible"){
                echo "<td style='width: 100px;'><div class='estatus disponible ms-auto me-auto p-1' >$estado</div></td>";
            }
            if($estado=="No Disponible"){
                echo "<td style='width: 100px;'><div class='estatus nodisponible ms-auto me-auto p-1'>$estado</div></td>";
            }
            ?>

            <td style='width: 100px;'>
                <div class='centrados'>
                    <button type='button' class='btn btn-primary btn-tabla' data-bs-toggle='modal' data-bs-target='#exampleModal<?php echo $id_mesa?>'>
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    <!-- Modal -->
                    <div class='modal fade' id='exampleModal<?php echo $id_mesa?>' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h1 class='modal-title fs-5' id='exampleModalLabel'>Editar mesa <?php echo "ID: ". $id_mesa?></h1>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>

                                <div class='modal-body' style='text-align: left;'>
                                    <form action='<?php htmlspecialchars($_SERVER["PHP_SELF"])?>' method="POST" class="needs-validation" novalidate>

                                        <div class="mb-2">
                                            <label for="numero_mesa" class="form-label">Número de mesa</label><br>
                                                        <input type="text" name="numero_mesa" class="form-control" minlength="1" maxlength="3" pattern="\d{1,3}" value="<?php echo $numero_mesa ?>" placeholder="Número de Mesa" required>
                                                        <div class="invalid-feedback">
                                                            Digite el nuevo número de mesa.
                                                        </div>  
                                        </div>

                                        <div class="mb-2">
                                            <!--Label fecha -->
                                            <label for="capacidad" class="form-label">Capacidad</label><br>
                                            <input type="text" name="capacidad" class="form-control" minlength="1" maxlength="2" pattern="\d{1,2}" value="<?php echo $capacidad ?>" placeholder="Capacidad" required>
                                                    <div class="invalid-feedback">
                                                            Ingrese la nueva capacidad.
                                                    </div>         
                                        </div>
                                                

                                        <div class="mb-2">
                                            <label for="estado" class="form-label">Estado</label><br>
                                                    <select name='estado'  class="form-control" required>
                                                    <?php
                                                           echo "<option value='Disponible'" . ($estado == 'Disponible' ? " selected" : "") . ">Disponible</option>";
                                                           echo "<option value='No Disponible'" . ($estado == 'No Disponible' ? " selected" : "") . ">No Disponible</option>";
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                            Seleccione el estado de la mesa.
                                                    </div>       
                                        </div>

                                        <input type='hidden' name='id_mesa' value='<?php echo $id_mesa ?>'>
                                        <input type='hidden' name='numero_mesa_viejo' value='<?php echo $numero_mesa ?>'>

                                        <div class='modal-footer'>
                                            <input type="submit" value="Guardar Cambios" name='btn_cambiar_mesa' class="btn btn-primary btn-personalizado">
                                            <button type='button' class='btn btn-secondary btn-personalizado' data-bs-dismiss='modal'>Cancelar</button>
                                        </div> 
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <button type='button' class='btn btn-primary btn-tabla' data-bs-toggle='modal' data-bs-target='#cancelModal<?php echo $id_mesa?>'>
                        <i class="fa-solid fa-trash"></i>
                    </button>

                    <!-- Modal -->
                    <div class='modal fade' id='cancelModal<?php echo $id_mesa?>' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h1 class='modal-title fs-5' id='exampleModalLabel'>Eliminar mesa #<?php echo $numero_mesa?></h1>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>

                                <div class='modal-body' style='text-align: left;'>
                                    <?php ?>
                                    <form action='<?php htmlspecialchars($_SERVER["PHP_SELF"])?>' method='POST'>
                                        <div class="centrados">
                                                <p>¿Estas seguro que quieres eliminar esta mesa?
                                        </div>
                                        <input type='hidden' name='id_mesa' value='<?php echo $id_mesa ?>'>
                                        
        
                                        <div class='modal-footer'>
                                            <input type='submit' value='Estoy Seguro' name='btn_eliminar_mesa' class='btn btn-primary btn-personalizado' style='width: 120px;'>
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