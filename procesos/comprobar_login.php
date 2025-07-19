<?php
try {
    include('procesos/conexion.php');

    $login = $_POST['usuario'];
    $password = htmlentities(addslashes($_POST['password']));

    // Validar si el usuario existe
    $existeUsuario = "SELECT * FROM USUARIOS WHERE USUARIO = :usuario";
    $resultado = $base->prepare($existeUsuario);
    $resultado->bindValue(":usuario", $login);
    $resultado->execute();
    $usuarioExiste = $resultado->rowCount();

    if ($usuarioExiste != 0) {
        // Confirmar la contraseña
        $sentenciaSQL = "SELECT * FROM USUARIOS WHERE USUARIO = :usuario AND contrasena = :password";
        $resultado = $base->prepare($sentenciaSQL);
        $resultado->bindValue(":usuario", $login);
        $resultado->bindValue(":password", $password);
        $resultado->execute();
        $contrasenaCorrecta = $resultado->rowCount();

        if ($contrasenaCorrecta != 0) {
            session_start();
            $_SESSION['usuario'] = $_POST['usuario'];
            $sentenciaSQL = "SELECT * FROM USUARIOS WHERE USUARIO = :usuario";
            $resultado = $base->prepare($sentenciaSQL);
            $resultado->bindValue(":usuario", $login);
            $resultado->execute();
            $usuario = $resultado->fetch(PDO::FETCH_ASSOC); 

            if($usuario['estado']=='Bloqueado'){
                echo "<div class='error p-3'>Su cuenta ha sido suspendida.</div><br>";
            }else{
                if ($usuario['rol'] == 'usuario') {
                    header("location: mostrarReservas.php");
                    exit; 
                }
    
                if ($usuario['rol'] == 'admin') {
                    header("location: reservasAdmin.php");
                    exit; 
                }
            }

            
        } else {
            echo "<div class='error p-3'>Contraseña incorrecta.</div><br>";
        }
    } else {
        echo "<div class='error p-3'>El usuario no existe.</div><br>";

    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>