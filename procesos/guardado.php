//obtener id reserva
            $sentenciaSQL = "SELECT id_reserva FROM reservas WHERE id_usuario=:id_usuario ORDER BY id_reserva DESC LIMIT 1;";

            $resultado = $base->prepare($sentenciaSQL);
            $resultado->bindValue(":id_usuario", $id);
            $resultado->execute();
            $ulitma_reserva= $resultado->fetchAll(PDO::FETCH_ASSOC);
            $id_reserva=$ulitma_reserva[0]['id_reserva'];

//insertar pedidos

            for($i=0; $i<$numeroPlatos; $i++){
                $plato=$i+1;
                $id_plato = htmlentities(addslashes($_POST['platos_select_'.$plato]));
                $sentenciaSQL = "INSERT INTO pedidos (id_reserva,id_plato) VALUES (:id_reserva, :id_plato)";
                $resultado = $base->prepare($sentenciaSQL);
                $resultado->bindValue(":id_reserva", $id_reserva);
                $resultado->bindValue(":id_plato", $id_plato);
                $resultado->execute();
            }

//modal pedido
<td style='width: 120px;'>
                <button type='button' class='btn btn-primary btn-personalizado' data-bs-toggle='modal' data-bs-target='#exampleModal".$id_reserva."'>
                Ver pedido
                </button>

                    <!-- Modal -->
                    <div class='modal fade' id='exampleModal".$id_reserva."' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                        <div class='modal-header'>
                                <h1 class='modal-title fs-5' id='exampleModalLabel'>Pedido reserva #".$id_reserva."</h1>
                          <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body' style='text-align: left;'>";
                        
                        $c_pedido_reserva="SELECT `pedidos`.`id_reserva`, `pedidos`.`id_pedido`, `menu`.`nombre`
                        FROM `pedidos` 
                        LEFT JOIN `menu` ON `pedidos`.`id_plato` = `menu`.`id_plato`
                        WHERE id_reserva= :id_reserva;";
                        $pedido=$base->prepare($c_pedido_reserva);
                        $pedido->bindParam(':id_reserva', $id_reserva);
                        $pedido->execute();
                        $resultado_pedidos = $pedido->fetchAll(PDO::FETCH_ASSOC);

                        if($resultado_pedidos){
                            foreach ($resultado_pedidos as $fila) {
                                $nombre= $fila['nombre'];
                                echo "• ".$nombre."<br>";
                            }
                        }

                       echo "</div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary btn-personalizado' data-bs-dismiss='modal'>Ok</button>
                        </div>
                        </div>
                    </div>
                    </div>
                </td>;

//input pedidos
<label for="numeroPlatos" class="form-label">Número de platos</label><br>
                  <input type="number" id="numeroPlatos" name="numeroPlatos" class="form-control" min="1" max="12" placeholder="Número de platos" required> <br>
                  <div id="selectsContainer"></div>
//script
<script>
$("#numeroPlatos").change(function(){
    var numeroPlatos = $(this).val();
    $.ajax({
      url: '../procesos/selectsPlatos.php',
      type: 'post',
      data: {numeroPlatos: numeroPlatos},
      success: function(response){
        $('#selectsContainer').html(response);
      }
    });
  });
</script>