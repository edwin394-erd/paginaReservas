<?php
    include('conexion.php');
    
    setlocale(LC_TIME, 'es_ES.UTF-8');
    date_default_timezone_set('America/Caracas');
    $fecha_actual = date("Y-m-d");    
    $horaActual = date('H:i:s'); // Usar formato de 24 horas

    include('obtener_todas_reservas.php');

    if($resultado){
        
        foreach ($resultado as $fila) {
            $id_reserva = $fila['id_reserva'];
            $fecha = $fila['fecha'];
            $hora_inicio = date('H:i:s', strtotime($fila['hora_inicio'])); // Formato de 24 horas
            $hora_fin = date('H:i:s', strtotime($fila['hora_fin'])); // Formato de 24 horas
            $estado = $fila['estado'];

            
            if($estado=="PENDIENTE" && $fecha==$fecha_actual && $horaActual>=$hora_inicio && $horaActual<=$hora_fin){
                $sentenciaSQL = "UPDATE reservas SET estado = 'EN CURSO' WHERE id_reserva = :id_reserva;";
                $sentencia = $base->prepare($sentenciaSQL);
                $sentencia->bindValue(":id_reserva", $id_reserva);
                $sentencia->execute();
                
            }
            elseif(($estado=="EN CURSO" && $fecha<$fecha_actual) || ($estado=="EN CURSO" && $fecha==$fecha_actual && $hora_fin<=$horaActual)){
                $sentenciaSQL = "UPDATE reservas SET estado = 'TERMINADA' WHERE id_reserva = :id_reserva;";
                $sentencia = $base->prepare($sentenciaSQL);
                $sentencia->bindValue(":id_reserva", $id_reserva);
                $sentencia->execute();

            }elseif(($estado=="PENDIENTE" && $fecha<$fecha_actual) || ($estado=="PENDIENTE" && $fecha==$fecha_actual && $hora_fin<=$horaActual)){
                $sentenciaSQL = "UPDATE reservas SET estado = 'TERMINADA' WHERE id_reserva = :id_reserva;";
                $sentencia = $base->prepare($sentenciaSQL);
                $sentencia->bindValue(":id_reserva", $id_reserva);
                $sentencia->execute();

            }
        }

     
            
     
    }
?>