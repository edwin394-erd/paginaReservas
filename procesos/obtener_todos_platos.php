<?php
     $c_menu="SELECT * FROM menu";
     $menu=$base->prepare($c_menu);
     $menu->execute();
     $resultado = $menu->fetchAll(PDO::FETCH_ASSOC);
?>