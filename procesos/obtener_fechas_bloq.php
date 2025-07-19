<?php
     $c_fechas="SELECT * FROM fechas_bloq";
     $fechas=$base->prepare($c_fechas);
     $fechas->execute();
     $resultado = $fechas->fetchAll(PDO::FETCH_ASSOC);
?>