<?php
    if(isset($_POST['numeroPlatos'])) {

        function obtenerPlatos(){
            $base=new PDO('mysql:host=localhost; dbname=reservas_restaurante','root','');
            $base->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $base->exec("SET CHARACTER SET UTF8");

            $sql = "SELECT `menu`.`id_plato`, `menu`.`nombre`
            FROM `menu`; ";
            $resultado=$base->prepare($sql);
            $resultado->execute();
            return $resultado;
        }
        
        $numeroPlatos = $_POST['numeroPlatos'];
        $resultado=obtenerPlatos();

        $selects = "";
        for($i=0; $i<$numeroPlatos; $i++){
            $resultado=obtenerPlatos();
            $plato=$i+1;
            $selects .= 
            "<label for='platos_select_".$plato."'>Plato #".$plato."</label><br>
            <select name='platos_select_".$plato."'  class='form-control' required>
                    <option value=''>Selecciona el plato ".$plato."</option>";

                    while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) {
                    $selects .= "<option value='" . $row['id_plato'] . "'>" . $row['nombre'] ."</option>";   
                    }

            $selects .= "</select><br>";
    }   
    echo $selects;
    }
?>