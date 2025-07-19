<?php
    try {
        include ('procesos/conexion.php');
        setlocale(LC_TIME, 'es_ES.UTF-8');
        date_default_timezone_set('America/Caracas');

        $id_reserva = $_POST['id_reserva'];
        $sentenciaSQL = "UPDATE  RESERVAS SET asistencia= 'ASISTIÓ' WHERE id_reserva= :id_reserva";
        $resultado = $base->prepare($sentenciaSQL);     
        $resultado->bindValue(":id_reserva", $id_reserva);
                      
        $resultado->execute();
        echo "<div class='notification' id='myNotification'>Asistencia Confirmada.</div><br>";
            
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
?>