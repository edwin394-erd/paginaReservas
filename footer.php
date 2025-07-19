<footer>
    
    <div class="container p-5">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4 centrados">
              <h2>Restaurante</h2>
              <h4>Siguenos</h4>
              <div class="social">
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
            </div>

            </div>

            <div class="col-4 d-none d-lg-block centrados">
                <ul class="footer-nav">
                    <li>
                        <a class="nav-link footer-link" aria-current="page" href="index.php">Inicio</a><br>
                    </li>
                    <li>
                        <a class="nav-link footer-link" href="views/menu.php">Menu</a><br>
                    </li>
                    <li>
                        <a class="nav-link footer-link" href="views/sobreNosotros.php">Sobre Nosotros</a><br>
                    </li>
                    <li>
                        <a class="nav-link footer-link" href="views/ubicacion.php">Ubicación</a><br>
                    </li>
                    <li>
                      <a class="nav-link footer-link" href="views/login.php">Reserva</a><br>
                  </li>
                    
                </ul>
            </div>

            <div class="col-12 col-md-6 col-lg-4  centrados">
                  
              <h2>¿Dónde estamos?</h2>
            <p>Calle 169 (Maracaibo)</p>
            <?php
             include('procesos/conexion.php');
            include('procesos/obtener_horarios_habilitados.php');

            if($resultado){
            echo "<h4>Nuestros Horarios</h4>";         
    
            foreach ($resultado as $fila) {
                $dia= $fila['dia'];
                $hora_apertura = date('g:i A', strtotime($fila['hora_apertura']));
                $hora_cierre = date('g:i A', strtotime($fila['hora_cierre']));
                echo $dia . ": De ". $hora_apertura . " a ". $hora_cierre. "<br>";
            }
            }
            ?>

            </div>
        </div>
    </div>
    
    <script src="librerias/sweetalert.min.js"></script>
    <script src="librerias/bootstrap.bundle.min.js"></script>
    

</footer>