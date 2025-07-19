<?php
              include('header.php');
              $base=new PDO('mysql:host=localhost; dbname=reservas_restaurante','root','');
              $base->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
              $base->exec("SET CHARACTER SET UTF8");
              echo "<div class='container-flex fondo1'>";

                            
              echo "<div class='container p-5 mt-1'>";
              echo "<div class='row'>";
              echo "<div class='col-12 contenedor-menu p-5  pt-3  mt-1 mb-3'>";
              $c_platos="SELECT `menu`.`id_plato`, `menu`.`nombre`, `menu`.`descripcion`, menu.precio
              FROM `menu`
              WHERE menu.categoria='plato'
              AND estado='Disponible';";

              $rusultado_platos=$base->prepare($c_platos);
              $rusultado_platos->execute();
              $platos = $rusultado_platos->fetchAll(PDO::FETCH_ASSOC);
            
              if($platos){
                  echo "<div class='centrados letraNaranja'>";
                  echo "<h2>Platos</h2>";
                  echo "</div><hr>";
                  foreach ($platos as $fila) {
                        echo "<div class='container'>";
                        echo "<div class='row'>";
                        echo "<div class='col-11 p-2'>";
                        echo "<h4>".$fila['nombre']."</h4>";
                        echo "<p>".$fila['descripcion']."</h4></p>";
                        echo "</div>";
                        echo "<div class='col-1 p-2'>";
                        echo "<h4 style='font-size: 28px;'>".$fila['precio']."$</h4>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                  }

              }

              echo "</div>";

              echo "<div class='col-12 contenedor-menu p-5 pt-3 mt-1 mb-3'>";

              $c_postres="SELECT `menu`.`id_plato`, `menu`.`nombre`, `menu`.`Descripcion`, menu.precio
              FROM `menu`
              WHERE menu.categoria='postre'
              AND estado='Disponible';";

              $rusultado_postres=$base->prepare($c_postres);
              $rusultado_postres->execute();
              $postres = $rusultado_postres->fetchAll(PDO::FETCH_ASSOC);
            
              if($postres){
                  echo "<div class='centrados letraNaranja'>";
                  echo "<h2>Postres</h2>";
                  echo "</div><hr>";
                  foreach ($postres as $fila) {
                        echo "<div class='container'>";
                        echo "<div class='row'>";
                        echo "<div class='col-11 p-2'>";
                        echo "<h4>".$fila['nombre']."</h4>";
                        echo "<p>".$fila['Descripcion']."</h4></p>";
                        echo "</div>";
                        echo "<div class='col-1 p-2'>";
                        echo "<h4 style='font-size: 28px;'>".$fila['precio']."$</h4>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        
                  }

              }
              echo "</div>";

              echo "<div class='col-12 contenedor-menu p-5 pt-3 mt-1 mb-3'>";
              $c_bebidas="SELECT `menu`.`id_plato`, `menu`.`nombre`, `menu`.`Descripcion`, menu.precio
              FROM `menu`
              WHERE menu.categoria='bebida'
              AND estado='Disponible';";

              $rusultado_bebidas=$base->prepare($c_bebidas);
              $rusultado_bebidas->execute();
              $bebidas = $rusultado_bebidas->fetchAll(PDO::FETCH_ASSOC);
            
              if($bebidas){
                  echo "<div class='centrados letraNaranja'>";
                  echo "<h2>Bebidas</h2>";
                  echo "</div><hr>";
                  foreach ($bebidas as $fila) {
                        echo "<div class='container'>";
                        echo "<div class='row'>";
                        echo "<div class='col-11 p-2'>";
                        echo "<h4>".$fila['nombre']."</h4>";
                        echo "<p>".$fila['Descripcion']."</h4></p>";
                        echo "</div>";
                        echo "<div class='col-1 p-2'>";
                        echo "<h4 style='font-size: 28px;'>".$fila['precio']."$</h4>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                  }

              }


              echo "</div>";
              echo "</div>";
              echo "</div>";
              echo "</div>";
             


              include ('footer.php');

        ?>
</body>