<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1c60acea23.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="librerias/bootstrap.min.css">
    <link rel="stylesheet" href="librerias/fontawesome-free-6.5.1-web/css/all.css">
    <link rel="stylesheet" href="styles/styles.css">        
    <title>Reservas Restaurante</title>
   
</head>
<body >

<?php
    $base=new PDO('mysql:host=localhost; dbname=reservas_restaurante','root','');
    $base->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $base->exec("SET CHARACTER SET UTF8");

    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location:login.php"); 
    }
    $usuario=$_SESSION['usuario'];
    $c_nombreUsuario="SELECT * FROM USUARIOS WHERE USUARIO= :usuario";
    $nombreUsuario=$base->prepare($c_nombreUsuario);
    $nombreUsuario->bindParam(':usuario', $usuario);
    $nombreUsuario->execute();
    $resultado = $nombreUsuario->fetch(PDO::FETCH_ASSOC);

    $id = $resultado['id_usuario'];
    $nombre = $resultado['nombre'];
    $apellido = $resultado['apellido'];
    $usuario = $resultado['usuario'];
    $rol = $resultado['rol'];
    $contrasena = $resultado['Contrasena'];
    $cedula = $resultado['cedula'];
    $telefono = $resultado['telefono'];
    
    if($rol!="usuario"){
      header("location:login.php"); 
    }

    include('procesos/manejar_estados_reservas.php');
    include('procesos/manejar_asistencias.php');
    include('procesos/manejar_faltas.php');
    
?>


<nav class="navbar navbar-expand-md bg-body-header2">
    <div class="container-fluid">
      
      <a class="navbar-brand ms-2" href="" style="font-weight: bold;"><?php echo $nombre." ".$apellido?></a>
      <button class="navbar-toggler toggler2" type="button"  data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNavDropdown">

        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="mostrarReservas.php">Mis Reservas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="solicitar.php">Solicitar Reserva</a>
          </li>
        </ul>
        <a class="btn  btn-personalizado2 me-2" href="procesos/cierre.php">Cerrar Sesion</a>

      </div>
    </div>
  </nav>


