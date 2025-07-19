<?php
    try {
        $id_reserva = $_POST['id_reserva'];

        
        //cambiar estatus a cancelada
        $sql_cancelar = "UPDATE `reservas` SET `estado` = 'CANCELADA' WHERE `reservas`.`id_reserva` = :id_reserva; "; 
        $resultado= $base->prepare($sql_cancelar);
        $resultado->bindValue(":id_reserva", $id_reserva);
        $resultado->execute();

        echo "<div class='notification' id='myNotification'>
                  La reserva se ha cancelado exitosamente
              </div>";
              
        
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
?>

