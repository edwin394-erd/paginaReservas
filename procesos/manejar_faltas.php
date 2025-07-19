<?php
    include('conexion.php');
    

    include('obtener_todos_usuarios.php');
 
    if($resultado){
        
        foreach ($resultado as $fila) {
            $id_usuario = $fila['id_usuario'];
            $sql_faltas = "SELECT COUNT(*) FROM usuarios u
            INNER JOIN reservas r ON u.id_usuario = r.id_usuario
            WHERE r.asistencia = 'FALTÓ' AND u.id_usuario = :id_usuario;";
            $faltas = $base->prepare($sql_faltas);
            $faltas->bindValue(":id_usuario", $id_usuario);
            $faltas->execute();
            $numero_faltas = $faltas->fetchAll(PDO::FETCH_ASSOC);
            $numero_faltas = $numero_faltas[0]['COUNT(*)'];
            


            $sentenciaSQL = "UPDATE usuarios SET faltas = :numero_faltas WHERE id_usuario = :id_usuario;";
            $sentencia = $base->prepare($sentenciaSQL);
            $sentencia->bindValue(":numero_faltas", $numero_faltas);
            $sentencia->bindValue(":id_usuario", $id_usuario);
            $sentencia->execute();
            
     
            
     
    }
}
?>