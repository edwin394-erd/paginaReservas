<?php
    try {
        $id_fecha_bloq = $_POST['id_fecha_bloq'];

        
        //cambiar estatus a cancelada
        $sql_eliminar = "DELETE FROM fechas_bloq WHERE id_fecha_bloq = :id_fecha_bloq "; 
        $resultado= $base->prepare($sql_eliminar);
        $resultado->bindValue(":id_fecha_bloq", $id_fecha_bloq);
        $resultado->execute();

        echo "<div class='notification' id='myNotification'>
                     El bloqueo se elimino correctamente.
                 </div>";
              
        
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
?>

