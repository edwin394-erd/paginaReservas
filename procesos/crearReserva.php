<?php
     setlocale(LC_TIME, 'es_ES.UTF-8');
     date_default_timezone_set('America/Caracas');
     $fecha_actual = date("Y-m-d");
     $horaActual = date('H:i');


     try {
        include ('procesos/conexion.php');

        $numero_personas = htmlentities(addslashes($_POST['numero_personas']));
        $fecha = htmlentities(addslashes($_POST['fecha']));
        $hora_inicio = htmlentities(addslashes($_POST['hora_inicio']));
        $hora_fin = htmlentities(addslashes($_POST['hora_fin']));

        function convertirHorasAMinutos($hora) {
            $partes = explode(':', $hora);
            return $partes[0] * 60 + $partes[1];
        }

        if($fecha_actual == $fecha && $horaActual >= $hora_inicio){
                echo "<div class='error p-3'>La hora de inicio debe ser mayor a la hora actual.</div><br>";
        }else if($hora_inicio >= $hora_fin){
            echo "<div class='error p-3'>La hora de inicio debe ser antes de la hora de fin.</div><br>";
        } else {
            $sql_fechas_bloq = "SELECT fecha_bloq FROM fechas_bloq WHERE fecha_bloq = :fecha;";
            $fechas_bloq= $base->prepare($sql_fechas_bloq);
            $fechas_bloq->bindValue(":fecha", $fecha);
            $fechas_bloq->execute();
            $fechas_bloquedas = $fechas_bloq->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($fechas_bloquedas)) {
                echo "<div class='error p-3'>Lo sentimos, esa fecha no esta disponible</div><br>";
            } else {
                $hora_inicio_minutos = convertirHorasAMinutos($hora_inicio);
                $hora_fin_minutos = convertirHorasAMinutos($hora_fin);
                $duracion = $hora_fin_minutos - $hora_inicio_minutos;

                if ($duracion > 240 || $duracion < 30) {
                    echo "<div class='error p-3'>La reserva no puede durar más de 4 horas ni menos de 30 minutos.</div><br>";
                } else {
                    $sql_mesas = "SELECT id_mesa FROM mesas 
                    WHERE capacidad >= :numero_personas 
                    AND id_mesa NOT IN (SELECT DISTINCT id_mesa FROM reservas WHERE fecha = :fecha AND NOT (hora_fin <= :hora_inicio OR hora_inicio >= :hora_fin))
                    AND estado = 'Disponible' 
                    ORDER BY capacidad ASC
                    LIMIT 1";
                    $mesas= $base->prepare($sql_mesas);
                    $mesas->bindValue(":numero_personas", $numero_personas);
                    $mesas->bindValue(":fecha", $fecha);
                    $mesas->bindValue(":hora_inicio", $hora_inicio);
                    $mesas->bindValue(":hora_fin", $hora_fin);
                    $mesas->execute();
                    $mesas_disponibles = $mesas->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($mesas_disponibles)) {
                        $id_mesa = $mesas_disponibles[0]['id_mesa'];
                        $sentenciaSQL = "INSERT INTO RESERVAS (id_usuario, id_mesa, numero_personas, hora_inicio, hora_fin, fecha) VALUES (:id_usuario, :id_mesa, :numero_personas, :hora_inicio, :hora_fin, :fecha)";
                        $resultado = $base->prepare($sentenciaSQL);
                        $resultado->bindValue(":id_usuario", $id);
                        $resultado->bindValue(":id_mesa", $id_mesa);
                        $resultado->bindValue(":numero_personas", $numero_personas);
                        $resultado->bindValue(":hora_inicio", $hora_inicio);
                        $resultado->bindValue(":hora_fin", $hora_fin);
                        $resultado->bindValue(":fecha", $fecha);
                        $resultado->execute();
                        echo "<div class='correcto p-3'>Reserva Completada.</div><br>";
                    } else {
                        echo "<div class='error p-3'>Lo sentimos, no hay mesas disponibles para esa cantidad de personas en ese horario.</div><br>";
                    }
                }
            }
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
?>