<?php
    include ('procesos/conexion.php');
    $id_usuario=$_POST['id_usuario'];
    $estado=$_POST['estado'];

    try {
        if($estado=="Permitido"){
            $sentenciaSQL = "UPDATE usuarios
            SET estado= 'Bloqueado'
            WHERE id_usuario = :id_usuario;";
            $resultado = $base->prepare($sentenciaSQL);
            $resultado->bindValue(":id_usuario", $id_usuario);
            $resultado->execute();

            echo "<div class='notification' id='myNotification'>
                 El usuario ha sido bloqueado.
              </div>";
        }

        if($estado=="Bloqueado"){
            $sentenciaSQL = "UPDATE usuarios
            SET estado= 'Permitido'
            WHERE id_usuario = :id_usuario;";
            $resultado = $base->prepare($sentenciaSQL);
            $resultado->bindValue(":id_usuario", $id_usuario);
            $resultado->execute();

            echo "<div class='notification' id='myNotification'>
                El usuario ha sido desbloqueado.
              </div>";
        }

    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }


   
?>