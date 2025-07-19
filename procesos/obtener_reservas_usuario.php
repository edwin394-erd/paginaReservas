<?php
     $c_reservasUsuario="SELECT  usuarios.nombre, usuarios.apellido, usuarios.cedula, mesas.numero_mesa, reservas.id_reserva, reservas.numero_personas, reservas.hora_inicio, reservas.hora_fin, reservas.fecha, reservas.estado, mesas.id_mesa
     FROM reservas 
     left JOIN mesas ON reservas.id_mesa= mesas.id_mesa 
     left JOIN usuarios on reservas.id_usuario=usuarios.id_usuario 
     WHERE usuarios.id_usuario=:id
     ORDER BY reservas.id_reserva DESC";
     $reservas=$base->prepare($c_reservasUsuario);
     $reservas->bindParam(':id', $id);
     $reservas->execute();
     $resultado = $reservas->fetchAll(PDO::FETCH_ASSOC);
?>