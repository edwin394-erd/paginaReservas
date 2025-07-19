<?php
     $c_horario="SELECT * FROM horario_laboral";
     $horario=$base->prepare($c_horario);
     $horario->execute();
     $resultado = $horario->fetchAll(PDO::FETCH_ASSOC);
?>