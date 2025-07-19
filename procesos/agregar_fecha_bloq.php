<?php
          try {
            include ('procesos/conexion.php');
            $fecha_bloq = htmlentities(addslashes($_POST['fecha_bloq']));
            
             //validar si la fecha ya ha sido bloqueada
             $sql_fechas= "SELECT * FROM fechas_bloq WHERE fecha_bloq=:fecha_bloq"; 
             $fechas= $base->prepare($sql_fechas);
             $fechas->bindValue(":fecha_bloq", $fecha_bloq);
             $fechas->execute();
     
             if ($fechas->rowCount() >= 1) {
                 echo "<div class='notification-error' id='myNotification'>
                       Esa fecha ya se encuentra bloqueada.
                   </div>";
             }else{
                $sentenciaSQL = "INSERT INTO fechas_bloq (fecha_bloq) VALUES (:fecha_bloq)";
                $resultado = $base->prepare($sentenciaSQL);
                $resultado->bindValue(":fecha_bloq", $fecha_bloq);
                $resultado->execute();
    
                echo "<div class='notification' id='myNotification'>
                      La fecha se bloqueo exitosamente.
                  </div>";


             }
         
                
    
                   
        
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    ?>
