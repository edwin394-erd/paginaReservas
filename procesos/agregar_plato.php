<?php
          try {
            include ('procesos/conexion.php');
            $nombre = htmlentities(addslashes($_POST['nombre']));
            $descripcion = htmlentities(addslashes($_POST['descripcion']));
            $categoria = htmlentities(addslashes($_POST['categoria']));
            $precio = htmlentities(addslashes($_POST['precio']));
            $estado = htmlentities(addslashes($_POST['estado']));
    
         
                $sentenciaSQL = "INSERT INTO menu (nombre, descripcion, categoria, precio, estado) VALUES (:nombre, :descripcion, :categoria, :precio, :estado)";
                $resultado = $base->prepare($sentenciaSQL);
                $resultado->bindValue(":nombre", $nombre);
                $resultado->bindValue(":descripcion", $descripcion);
                $resultado->bindValue(":categoria", $categoria);
                $resultado->bindValue(":precio", $precio);
                $resultado->bindValue(":estado", $estado);
                $resultado->execute();
    
                echo "<div class='notification' id='myNotification'>
                      El plato se agrego exitosamente.
                  </div>";
    
                   
        
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    ?>
