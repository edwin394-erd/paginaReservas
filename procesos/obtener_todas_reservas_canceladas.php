<?php
     $c_reservas="SELECT usuarios.nombre, usuarios.apellido, usuarios.cedula, mesas.numero_mesa, reservas.id_reserva, reservas.numero_personas, reservas.hora_inicio, reservas.hora_fin, reservas.fecha, reservas.estado, mesas.id_mesa, reservas.asistencia
     FROM reservas 
     left JOIN mesas ON reservas.id_mesa= mesas.id_mesa 
     left JOIN usuarios on reservas.id_usuario=usuarios.id_usuario
     WHERE reservas.estado='CANCELADA' 
     ORDER BY reservas.fecha ASC";
     $reservas=$base->prepare($c_reservas);
     $reservas->execute();
     $resultado = $reservas->fetchAll(PDO::FETCH_ASSOC);
?>