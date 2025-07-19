<?php
include('header.php');

?>

<div class="container-flex fondo1">
<div class="container d-flex justify-content-center align-items-center" style="height: 100%">
<div class="container-sm contenedor-login  p-5 mt-5 mb-5 ">
    <h2 class="no-deco" style="text-align: center">Registro</h2>
    <hr>
    <div class="row">
         <form id="FormRegistro" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  method="POST" class="needs-validation" novalidate>
         <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") 
                    include('procesos/registrarUsuario.php')
            ?>
            <div class="mb-3">
                <label for="input_nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="input_nombre" name="nombre" placeholder="Escribe tu Nombre" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ]+" minlength="2" maxlength="50" required>
                <div class="invalid-feedback">
                        Escribe tu nombre.
                </div>  
             
            </div>
            <div class="mb-3">
                <label for="input_apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="input_apellido" name="apellido" placeholder="Escribe tu Apellido" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ]+" minlength="2" maxlength="50" required>
                <div class="invalid-feedback">
                        Escribe tu apellido.
                </div>  
            </div>
           
            <div class="mb-3">
                <label for="input_usuario" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="input_usuario" name="usuario" placeholder="Escribe un Nombre de Usuario" minlength="3" maxlength="20" required> 
                <div class="invalid-feedback">
                        Escribe un nombre de usuario.
                </div>            
            </div>

            <div class="mb-3">
                <label for="input_contra">Contraseña</label>
                <div class="input-group">
                    <input type="password" class="form-control contra" id="input_contra" name="contrasena" placeholder="Escribe tu Contraseña" minlength="4" maxlength="8" required>
                    <button type="button" class="btn btn-outline-secondary btn-ver" onclick="togglePasswordVisibility('input_contra')"><i class="fa-solid fa-eye"></i></button>
                    <div class="invalid-feedback">
                        Escribe una contraseña (entre 4 y 8 caracteres).
                </div>
                </div>
                
            </div>

            <div class="mb-3">                
                <label for="input_contra_confirm">Repetir Contraseña</label>
                <div class="input-group">
                    <input type="password" class="form-control contra" id="input_contra_confirm" name="contrasena_confirm" placeholder="Repite la contraseña" minlength="4" maxlength="8" required>
                    <button type="button" class="btn btn-outline-secondary btn-ver" id="btn-ver" onclick="togglePasswordVisibility('input_contra_confirm')"><i class="fa-solid fa-eye"></i></button>
                    <div class="invalid-feedback">
                            Las contraseñas no coinciden.
                    </div>
                </div>
                    
            </div>

            <div class="mb-3">
                <label for="input_cedula" class="form-label">Cédula</label>
                <input type="text" class="form-control" id="input_cedula" name="cedula" placeholder="Escribe tu Cédula" minlength="7" maxlength="8" pattern="\d{7,8}" required>
                <div class="invalid-feedback">
                        Cédula invalida.
                </div>
             
            </div>
            <div class="mb-3">
                <label for="input-tel" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="input_tel" name="telefono" placeholder="Escribe tu Número deTeléfono" minlength="11" maxlength="11" pattern="\d{11,11}" required>
                <div class="invalid-feedback">
                        Télefono invalido.
                </div>
            </div>
            
            <br>
            <div class="centrados">
                <button type="submit" class="btn btn-primary btn-personalizado btn-login">Registrar</button>
            </div>
            </form>

    </div>
</div>
</div>


<script>
    //boton ver
    function togglePasswordVisibility(inputId) {
        const inputElement = document.getElementById(inputId);
        const iconoVerElement = inputElement.nextElementSibling.querySelector('.fa-solid');

        if (inputElement.type === 'password') {
            // Mostrar la contraseña
            inputElement.type = 'text';
            iconoVerElement.classList.remove('fa-eye');
            iconoVerElement.classList.add('fa-eye-slash');
        } else {
            // Ocultar la contraseña
            inputElement.type = 'password';
            iconoVerElement.classList.remove('fa-eye-slash');
            iconoVerElement.classList.add('fa-eye');
        }
    }
</script>

<script>
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Obtener Campos Contraseña
        const password = document.getElementById('input_contra');
        const confirmPassword = document.getElementById('input_contra_confirm');

        // Evento cuando se llena el campor tepetir contraseña
        confirmPassword.addEventListener('input', () => {
            // Check if passwords match
            if (password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Las contraseñas no coinciden.');
                confirmPassword.classList.remove('is-valid');
                confirmPassword.classList.add('is-invalid');
            } else {
                confirmPassword.setCustomValidity('');
                confirmPassword.classList.remove('is-invalid');
                confirmPassword.classList.add('is-valid');
            }
        });

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

    </div>


</div>


</body>

<?php
 include('footer.php')
?>