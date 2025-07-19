<?php
    try {
        $base = new PDO('mysql:host=localhost;dbname=reservas_restaurante', 'root', '');
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $base->exec("SET CHARACTER SET UTF8");

        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $usuario = $_POST['usuario'];
        $rol = "Usuario";
        $contrasena = $_POST['contrasena'];
        $cedula = htmlentities(addslashes($_POST['cedula']));
        $telefono = htmlentities(addslashes($_POST['telefono']));

        // Consulta para verificar si el nombre de usuario ya existe
        $validarUsuarioSQL = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $resultadoValidacionUsuario = $base->prepare($validarUsuarioSQL);
        $resultadoValidacionUsuario->bindValue(":usuario", $usuario);
        $resultadoValidacionUsuario->execute();

        // Consulta para verificar si la cedula ya existe
        $validarCedulaSQL = "SELECT * FROM usuarios WHERE cedula = :cedula";
        $resultadoValidacionCedula = $base->prepare($validarCedulaSQL);
        $resultadoValidacionCedula->bindValue(":cedula", $cedula);
        $resultadoValidacionCedula->execute();

    if ($resultadoValidacionUsuario->rowCount() > 0) {
            echo "<div class='error p-3'>El nombre de usuario ya está en uso. Por favor, elige otro.</div><br>";

    } else if($resultadoValidacionCedula->rowCount() > 0){
            echo "<div class='error p-3'>Esta cédula ya fue registrada.</div><br>";
    }else {
            // Insertar los datos en la tabla 'usuarios'
            $sentenciaSQL = "INSERT INTO usuarios (nombre, apellido, usuario, rol, contrasena, cedula, telefono) VALUES (:nombre, :apellido, :usuario, :rol, :contrasena, :cedula, :telefono)";
            $resultado = $base->prepare($sentenciaSQL);
            $resultado->bindValue(":nombre", $nombre);
            $resultado->bindValue(":apellido", $apellido);
            $resultado->bindValue(":usuario", $usuario);
            $resultado->bindValue(":rol", $rol);
            $resultado->bindValue(":contrasena", $contrasena);
            $resultado->bindValue(":cedula", $cedula);
            $resultado->bindValue(":telefono", $telefono);
            $resultado->execute();
            echo "<div class='correcto p-3'>Registro Exitoso.</div><br>";
    }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
?>