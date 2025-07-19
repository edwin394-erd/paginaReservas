<?php
          try {
            include ('procesos/conexion.php');
            $numero_mesa = htmlentities(addslashes($_POST['numero_mesa']));
            $capacidad = htmlentities(addslashes($_POST['capacidad']));
            $estado = htmlentities(addslashes($_POST['estado']));
    
            //validar numero de mesa
            $sql_mesas = "SELECT * FROM mesas WHERE numero_mesa=:numero_mesa"; 
            $mesas= $base->prepare($sql_mesas);
            $mesas->bindValue(":numero_mesa", $numero_mesa);
            $mesas->execute();
    
            if ($mesas->rowCount() >= 1) {
                echo "<div class='notification-error' id='myNotification'>
                      Ese número de mesa ya esta en uso.
                  </div>";
    
            }else{
                $sentenciaSQL = "INSERT INTO mesas (numero_mesa, capacidad, estado) VALUES (:numero_mesa, :capacidad, :estado)";
                $resultado = $base->prepare($sentenciaSQL);
                $resultado->bindValue(":capacidad", $capacidad);
                $resultado->bindValue(":numero_mesa", $numero_mesa);
                $resultado->bindValue(":estado", $estado);
                $resultado->execute();
    
                echo "<div class='notification' id='myNotification'>
                      La mesa se agrego exitosamente.
                  </div>";
    
            }        
        
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    ?>
