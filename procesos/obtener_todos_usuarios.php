<?php
     $c_usuarios="SELECT * FROM usuarios WHERE rol= 'usuario' ";
     $usuarios=$base->prepare($c_usuarios);
     $usuarios->execute();
     $resultado = $usuarios->fetchAll(PDO::FETCH_ASSOC);
?>