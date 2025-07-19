<?php
    $base=new PDO('mysql:host=localhost; dbname=reservas_restaurante','root','');
    $base->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $base->exec("SET CHARACTER SET UTF8");
?>