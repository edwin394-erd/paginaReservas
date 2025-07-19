<?php
    try {
        include ('procesos/conexion.php');
        $numero_mesa_viejo= $_POST['numero_mesa_viejo'];
        $numero_mesa = htmlentities(addslashes($_POST['numero_mesa']));
        $capacidad = htmlentities(addslashes($_POST['capacidad']));
        $estado = htmlentities(addslashes($_POST['estado']));
        $id_mesa = $_POST['id_mesa'];

        //validar numero de mesa
        $sql_mesas = "SELECT * FROM mesas WHERE numero_mesa=:numero_mesa
        AND numero_mesa NOT IN (SELECT numero_mesa FROM mesas WHERE numero_mesa= :numero_mesa_viejo)"; 
        $mesas= $base->prepare($sql_mesas);
        $mesas->bindValue(":numero_mesa", $numero_mesa);
        $mesas->bindValue(":numero_mesa_viejo", $numero_mesa_viejo);
        $mesas->execute();

        if ($mesas->rowCount() >= 1) {
            echo "<div class='notification-error' id='myNotification'>
                  Ese número de mesa ya esta en uso.
              </div>";

        }else{
            $sentenciaSQL = "UPDATE mesas
            SET id_mesa = :id_mesa, numero_mesa = :numero_mesa, capacidad = :capacidad, estado = :estado
            WHERE id_mesa = :id_mesa;";
            $resultado = $base->prepare($sentenciaSQL);

            $resultado->bindValue(":id_mesa", $id_mesa);
            $resultado->bindValue(":capacidad", $capacidad);
            $resultado->bindValue(":numero_mesa", $numero_mesa);
            $resultado->bindValue(":estado", $estado);
            $resultado->execute();

            echo "<div class='notification' id='myNotification'>
                  La mesa se ha editado exitosamente
              </div>";

        }        
    
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
?>