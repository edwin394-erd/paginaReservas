<?php
     $c_mesas="SELECT * FROM mesas ORDER BY numero_mesa";
     $mesas=$base->prepare($c_mesas);
     $mesas->execute();
     $resultado = $mesas->fetchAll(PDO::FETCH_ASSOC);
?>