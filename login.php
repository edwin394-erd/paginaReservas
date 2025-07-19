<?php
 include('header.php');

?>
<div class="container-flex fondo2">
<div class="container d-flex justify-content-center align-items-center" style="min-height: 800px">
<div class="container-sm contenedor-login  p-5 mt-3 mb-5 ">
    <h2 class="no-deco" style="text-align: center">Incio de Sesión</h2>
    <hr>
    <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") 
                    include('procesos/comprobar_login.php')
            ?>
    <div class="row">
        <div class="col-12">
         <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="input-usuario" class="form-label" name="usuario">Usuario</label>
                <input type="text" class="form-control" id="input-usuario" name="usuario" placeholder="Escribe tu Usuario" required>
                <div class="invalid-feedback">
                        Escribe tu nombre de usuario.
                </div>  
            </div>

            <div class="mb-3">
                <label for="input_contra" class="form-label">Contraseña</label>
                <div class="input-group">
                    <input type="password" class="form-control contra" id="input_contra" name="password" placeholder="Escribe tu Contraseña" required>
                    <button type="button" class="btn btn-outline-secondary btn-ver" onclick="togglePasswordVisibility('input_contra')"><i class="fa-solid fa-eye"></i></button>
                    <div class="invalid-feedback">
                        Escribe tu contraseña.
                </div>
            </div>

    </div>
            <div class="centrados">
                <button type="submit" class="btn btn-primary btn-personalizado btn-login">Ingresar</button>

            </div>
            
            </form>
    </div>
</div>
<div class="row pt-4 centrados">
    <a href="registro.php" class="no-deco"><h6>Registrarse</h6></a>
</div>

</div>

</div>

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



</div>

</div>

    
</body>

<?php
 include('footer.php')
?>
</html>