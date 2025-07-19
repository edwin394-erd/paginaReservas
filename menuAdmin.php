<?php
include('headerAdmin.php');
include ('procesos/conexion.php');


    include('procesos/obtener_todos_platos.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn_eliminar_plato"])) {
        include('procesos/eliminar_plato.php');
        include('procesos/obtener_todos_platos.php');
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST["btn_cambiar_plato"])) {
        include('procesos/cambiar_plato.php');
        include('procesos/obtener_todos_platos.php');
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST["btn_agregar_plato"])) {
        include('procesos/agregar_plato.php');
        include('procesos/obtener_todos_platos.php');
    }

    echo  "
        <div class='container-sm contenedor-reserva  p-5 '>
        <div class='agregar ms-auto derecha'>
        
            <button type='button' class='btn btn-primary btn-personalizado me-2' data-bs-toggle='modal' data-bs-target='#AgregarPlato'>
                Agregar Plato
            </button>
        </div>"; ?>

                <div class='modal fade' id='AgregarPlato' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h1 class='modal-title fs-5' id='exampleModalLabel'>Agregar Plato</h1>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>

                                <div class='modal-body' style='text-align: left;'>
                                    <form action='<?php htmlspecialchars($_SERVER["PHP_SELF"])?>' method="POST" class="needs-validation" novalidate>

                                        <div class="mb-2">
                                            <label for="nombre" class="form-label">Nombre</label><br>
                                                        <input type="text" name="nombre" class="form-control" minlength="2" maxlength="50"  placeholder="Nombre del Plato" required>
                                                        <div class="invalid-feedback">
                                                            Escribe el nombre del plato.
                                                        </div>  
                                        </div>

                                        <div class="mb-2">
                                            <label for="descripcion" class="form-label">Descripción</label><br>
                                            <textarea name="descripcion" class="form-control" minlength="1" maxlength="100" placeholder="Descripción" required></textarea>
                                            <div class="invalid-feedback">
                                                Escribe una descripción para el plato.
                                            </div>         
                                        </div>
                                                
                                        <div class="mb-2">
                                            <label for="categoria">Categoria</label><br>
                                                    <select name='categoria'  class="form-control" required>
                                                        <option value=''>Selecciona la Categoria</option>
                                                        <option value='Plato'>Plato</option>
                                                        <option value='Postre'>Postre</option>
                                                        <option value='Postre'>Bebida</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                            Seleccione el estado del plato.
                                                    </div>       
                                        </div>

                                        <div class="mb-2">
                                            <label for="estado">Estado</label><br>
                                                    <select name='estado'  class="form-control" required>
                                                        <option value='Disponible'>Disponible</option>
                                                        <option value='No Disponible'>No disponible</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                            Seleccione el estado del plato.
                                                    </div>       
                                        </div>

                                        <div class="mb-2">
                                            <label for="precio" class="form-label">Precio ($)</label><br>
                                            <input type="text" name="precio" class="form-control" minlength="1" maxlength="5" pattern="\d{1,5}" placeholder="Precio" required>
                                                    <div class="invalid-feedback">
                                                            Ingrese el precio.
                                                    </div>         
                                        </div>

                                        <div class='modal-footer'>
                                            <input type="submit" value="Agregar" name='btn_agregar_plato' class="btn btn-primary btn-personalizado">
                                            <button type='button' class='btn btn-secondary btn-personalizado' data-bs-dismiss='modal'>Cancelar</button>
                                        </div> 
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> 

<?php
        echo  "<h1 class='no-deco' style='text-align: center'>Administrar Menú</h1>
            <hr>";

    if($resultado){

        echo "<div class='table-responsive'>
                <table class='table'>
                    <thead>
                        <tr>
                            <th scope='col'>Nombre</th>
                            <th scope='col'>Descripción</th>
                            <th scope='col'>Categoria</th>
                            <th scope='col'>Precio</th>
                            <th scope='col'>Estado</th>
                            <th scope='col'>Opciones</th>
                        </tr>
                    </thead>";

        foreach ($resultado as $fila) {
            // Acceder a los valores de cada reserva
            $id_plato= $fila['id_plato'];
            $nombre= $fila['nombre'];
            $descripcion = $fila['descripcion'];
            $categoria = $fila['categoria'];
            $precio = $fila['precio'];
            $estado = $fila['estado'];
            // Mostrar los datos de cada reserva

            echo  "<tbody>
                <tr  style='height: 75px;'>
                    <th scope='row' style='width: 80px;'>$nombre</th>
                    <td style='width: 150px; ; text-align: left;'>$descripcion</td>
                    <td style='width: 80px'>$categoria</td>
                    <td style='width: 80px;'>$precio</td>";
                    

            if($estado=="Disponible"){
                echo "<td style='width: 100px;'><div class='estatus disponible ms-auto me-auto p-1' >$estado</div></td>";
            }
            if($estado=="No Disponible"){
                echo "<td style='width: 100px;'><div class='estatus nodisponible ms-auto me-auto p-1'>$estado</div></td>";
            }
            ?>

            <td style='width: 100px;'>
                <div class='centrados'>
                    <button type='button' class='btn btn-primary btn-tabla' data-bs-toggle='modal' data-bs-target='#exampleModal<?php echo $id_plato?>'>
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>

                    <!-- Modal -->
                    <div class='modal fade' id='exampleModal<?php echo $id_plato?>' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h1 class='modal-title fs-5' id='exampleModalLabel'>Editar plato ID: <?php echo $id_plato?></h1>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>

                                <div class='modal-body' style='text-align: left;'>
                                    <form action='<?php htmlspecialchars($_SERVER["PHP_SELF"])?>' method="POST" class="needs-validation" novalidate>

                                            <div class="mb-2">
                                                <label for="nombre" class="form-label">Nombre</label><br>
                                                            <input type="text" name="nombre" class="form-control" minlength="2" maxlength="50"  value="<?php echo $nombre?>"  placeholder="Nombre del Plato" required>
                                                            <div class="invalid-feedback">
                                                                Escribe el nombre del plato.
                                                            </div>  
                                            </div>

                                            <div class="mb-2">
                                            <label for="descripcion" class="form-label">Descripción</label><br>
                                            <textarea name="descripcion" class="form-control" minlength="1" maxlength="100" placeholder="Descripción" required><?php echo $descripcion?></textarea>
                                            <div class="invalid-feedback">
                                                Escribe una descripción para el plato.
                                            </div>         
                                        </div>
                                                    
                                            <div class="mb-2">
                                                <label for="categoria">Categoria</label><br>
                                                        <select name='categoria'  class="form-control" required>
                                                            <option value=''>Selecciona la Categoria</option>
                                                            <?php
                                                            echo "<option value='Plato'" . ($categoria == 'Plato' ? " selected" : "") . ">Plato</option>";
                                                            echo "<option value='Postre'" . ($categoria == 'Postre' ? " selected" : "") . ">Postre</option>";
                                                            echo "<option value='Bebida'" . ($categoria == 'Bebida' ? " selected" : "") . ">Bebida</option>";
                                                            ?>
                                                            
                                                        </select>
                                                        <div class="invalid-feedback">
                                                                Seleccione la categoria.
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
                                                                Seleccione el estado del plato.
                                                        </div>       
                                            </div>

                                            <div class="mb-2">
                                                <label for="precio" class="form-label">Precio ($)</label><br>
                                                <input type="text" name="precio" class="form-control" minlength="1" maxlength="5" pattern="\d{1,5}" placeholder="Precio" value=<?php echo $precio?> required>
                                                        <div class="invalid-feedback">
                                                                Ingrese el precio.
                                                        </div>         
                                                        <input type='hidden' name='id_plato' value='<?php echo $id_plato ?>'>
                                            </div>

                                            <div class='modal-footer'>
                                                <input type="submit" value="Guardar Cambios" name='btn_cambiar_plato' class="btn btn-primary btn-personalizado">
                                                <button type='button' class='btn btn-secondary btn-personalizado' data-bs-dismiss='modal'>Cancelar</button>
                                            </div> 
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <button type='button' class='btn btn-primary btn-tabla' data-bs-toggle='modal' data-bs-target='#cancelModal<?php echo $id_plato?>'>
                        <i class="fa-solid fa-trash"></i>
                    </button>

                    <!-- Modal -->
                    <div class='modal fade' id='cancelModal<?php echo $id_plato?>' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h1 class='modal-title fs-5' id='exampleModalLabel'>Eliminar Plato #<?php echo $id_plato?></h1>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>

                                <div class='modal-body' style='text-align: left;'>
                                    <?php ?>
                                    <form action='<?php htmlspecialchars($_SERVER["PHP_SELF"])?>' method='POST'>
                                        <div class="centrados">
                                                <p>¿Estas seguro que quieres eliminar este plato?
                                        </div>
                                        <input type='hidden' name='id_plato' value='<?php echo $id_plato ?>'>
                                        
        
                                        <div class='modal-footer'>
                                            <input type='submit' value='Estoy Seguro' name='btn_eliminar_plato' class='btn btn-primary btn-personalizado' style='width: 120px;'>
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
        echo "<br><h2>Aun no haz agregado ningun plato al menú</h2>";
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