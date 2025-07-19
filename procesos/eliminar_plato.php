<?php
    try {
        $id_plato = $_POST['id_plato'];

        
        //cambiar estatus a cancelada
        $sql_eliminar = "DELETE FROM menu WHERE id_plato = :id_plato "; 
        $resultado= $base->prepare($sql_eliminar);
        $resultado->bindValue(":id_plato", $id_plato);
        $resultado->execute();

        echo "<div class='notification' id='myNotification'>
                     El plato se elimino correctamente.
                 </div>";
              
        
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
?>

