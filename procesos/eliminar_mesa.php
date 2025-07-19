<?php
    try {
        $id_mesa = $_POST['id_mesa'];

        
        //cambiar estatus a cancelada
        $sql_eliminar = "DELETE FROM mesas WHERE `mesas`.`id_mesa` = :id_mesa "; 
        $resultado= $base->prepare($sql_eliminar);
        $resultado->bindValue(":id_mesa", $id_mesa);
        $resultado->execute();

        echo "<div class='notification' id='myNotification'>
                     La mesa se elimino exitosamente
                 </div>";
              
        
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
?>

