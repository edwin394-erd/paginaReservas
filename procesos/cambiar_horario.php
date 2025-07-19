<?php
          try {
            include ('procesos/conexion.php');
            $dia=$_POST['dia'];
            $hora_apertura = htmlentities(addslashes($_POST['hora_apertura']));
            $hora_cierre = htmlentities(addslashes($_POST['hora_cierre']));
            $estado = htmlentities(addslashes($_POST['estado']));

            
            if($hora_apertura>=$hora_cierre){

                echo "<div class='notification-error' id='myNotification'>
                               La hora de apertura debe ser antes de la hora de cierre.
                            </div>";
           }else{
         
                $sentenciaSQL = "UPDATE horario_laboral
                SET hora_apertura = :hora_apertura, hora_cierre = :hora_cierre, estado = :estado
                WHERE dia = :dia;";
                $resultado = $base->prepare($sentenciaSQL);
                $resultado->bindValue(":hora_apertura", $hora_apertura);
                $resultado->bindValue(":hora_cierre", $hora_cierre);
                $resultado->bindValue(":estado", $estado);
                $resultado->bindValue(":dia", $dia);
                $resultado->execute();
    
                echo "<div class='notification' id='myNotification'>
                      El horario se edito exitosamente.
                  </div>";
           }
                   
        
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    ?>
