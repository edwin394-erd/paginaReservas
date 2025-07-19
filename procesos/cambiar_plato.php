<?php
          try {
            include ('procesos/conexion.php');
            $id_plato=$_POST['id_plato'];
            $nombre = htmlentities(addslashes($_POST['nombre']));
            $descripcion = htmlentities(addslashes($_POST['descripcion']));
            $categoria = htmlentities(addslashes($_POST['categoria']));
            $precio = htmlentities(addslashes($_POST['precio']));
            $estado = htmlentities(addslashes($_POST['estado']));
    
         
                $sentenciaSQL = "UPDATE menu
                SET id_plato = :id_plato, nombre = :nombre, descripcion = :descripcion, categoria= :categoria, precio = :precio ,estado = :estado
                WHERE id_plato = :id_plato;";
                $resultado = $base->prepare($sentenciaSQL);
                $resultado->bindValue(":id_plato", $id_plato);
                $resultado->bindValue(":nombre", $nombre);
                $resultado->bindValue(":descripcion", $descripcion);
                $resultado->bindValue(":categoria", $categoria);
                $resultado->bindValue(":precio", $precio);
                $resultado->bindValue(":estado", $estado);
                $resultado->execute();
    
                echo "<div class='notification' id='myNotification'>
                      El plato se edito exitosamente.
                  </div>";
    
                   
        
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    ?>
