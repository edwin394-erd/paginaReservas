<?php
    include('header.php');
?>

<div class='container-flex fondo2' style='min-height: 800px'>
    <div class='container p-5 mt-1'>
        <div class="container contenedor-menu p-5 " style='min-height: 400px'>
            <div class="row">
                <div class="col-12 col-md-6 " style="text-align: center;">
                    <h2 class=" letraNaranja pt-3">¿Dónde estamos?</h2><hr>
                    <p>Calle 169 (Maracaibo)</p>
                    <img src="imgs/ubi.jpg" alt="" style="width: 100%;" ><br>
                </div>
                <div class="col-12 col-md-6" style="text-align: center;">
                    <?php
                        include('procesos/conexion.php');
                        include('procesos/obtener_horarios_habilitados.php');
                        if($resultado){
                            echo "<h2 class=' letraNaranja pt-3'>Nuestros Horarios</h2><hr>";       
                            echo "<div class='row'>";  
                            foreach ($resultado as $fila) {
                                $dia= $fila['dia'];
                                $hora_apertura = date('g:i A', strtotime($fila['hora_apertura']));
                                $hora_cierre = date('g:i A', strtotime($fila['hora_cierre']));
                                echo "<div class='col-12 col-md-6'>";  
                                echo $dia . ": <br>De ". $hora_apertura . " a ". $hora_cierre. "<br><br>";
                                echo "</div>";  
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php     
    include ('footer.php');
?>