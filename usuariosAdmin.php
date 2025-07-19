<?php
include('headerAdmin.php');
include ('procesos/conexion.php');

$consulta = "SELECT * FROM usuarios WHERE rol= 'usuario' ";
$stmt = $base->prepare($consulta);
$stmt->execute();

// Guardar los resultados en un array asociativo
$reporte = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
     $reporte[] = $row;
}

    include('procesos/obtener_todos_usuarios.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn_bloquear_usuario"])) {
        include('procesos/bloquear_usuario.php');
        include('procesos/obtener_todos_usuarios.php');

        $consulta = "SELECT * FROM usuarios WHERE rol= 'usuario' ";
        $stmt = $base->prepare($consulta);
        $stmt->execute();

        // Guardar los resultados en un array asociativo
        $reporte = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reporte[] = $row;
        }
    }

    
    echo  "<div class='container-sm contenedor-reserva  p-5 '>
    <div style='text-align: right;'>
    <a href='javascript:genPDF()' class='btn btn-primary btn-personalizado me-2'><i class='fa-regular fa-file-pdf' style='font-size: 22px;'></i>  Generar Reporte </a>
    </div>
    <h1 class='no-deco' style='text-align: center'>Usuarios</h1>
    
    <hr>
        <div class='row'>
        <div class='col-12 col-md-9'>
        </div>

        <div class='col-12 col-md-3'>
                <div class='input-group mb-3'>
                <input type='text' class='form-control' placeholder='Buscar...' aria-label='Buscar'>
                <button class='btn btn-outline-secondary btn-ver' type='button' id='button-addon2'>
                <i class='fa-solid fa-magnifying-glass'></i>
                </button>
                </div>
        </div>

    </div>";

    

    if($resultado){
        echo "<div class='table-responsive'>
                <table class='table'>
                    <thead>
                        <tr>
                            <th scope='col'># Referencia</th>
                            <th scope='col'>Nombre</th>
                            <th scope='col'>Cédula</th>
                            <th scope='col'>Telefono</th>
                            <th scope='col'>Faltas</th>
                            <th scope='col'>Estado</th>
                            <th scope='col'>Opciones</th>
                        </tr>
                    </thead>";

        foreach ($resultado as $fila) {
            // Acceder a los valores de cada usuario
            $id_usuario= $fila['id_usuario'];
            $nombre= $fila['nombre'];
            $apellido = $fila['apellido'];
            $cedula = $fila['cedula'];
            $telefono = $fila['telefono'];

            
            $faltas = $fila['faltas'];

            $estado = $fila['estado'];

            // Mostrar los datos de cada usuario

            echo  "<tbody>
                <tr  style='height: 75px;'>
                    <td scope='row' style='width: 70px;'>$id_usuario</td>
                    <td style='width: 150px;'>$nombre $apellido</td>
                    <td style='width: 100px;'>$cedula</td>
                    <td style='width: 80px;'>$telefono</td>
                    <td style='width: 80px;'>$faltas</td>";

        
            if($estado=="Bloqueado"){
                echo "<td style='width: 100px;'><div class='estatus cancelada ms-auto me-auto p-1'>$estado</div></td>";
            }
            if($estado=="Permitido"){
                echo "<td style='width: 100px;'><div class='estatus terminada ms-auto me-auto p-1''>$estado</div></td>";
            }
            ?>

            <td style='width: 100px;'>
                <div class='centrados'>
                <?php
                        if($estado=="Permitido"){
                            echo " <button type='button' class='btn btn-primary btn-tabla' data-bs-toggle='modal' data-bs-target='#cancelModal$id_usuario'>
                                            <i class='fa-solid fa-ban'></i>
                                        </button>";
                        }

                        if($estado=="Bloqueado"){
                            echo " <button type='button' class='btn btn-primary btn-tabla' data-bs-toggle='modal' data-bs-target='#cancelModal$id_usuario'>
                                                <i class='fa-solid fa-check'></i>
                                        </button>";
                        }
                ?>
                    <script>
                            var reporte = <?php echo json_encode($reporte); ?>;
                            //cargar logo
                                var logo = new Image();
                                logo.src = 'imgs/logo.png';  // Reemplaza 'ruta_del_logo.jpg' con la ruta de tu logo
                            </script>


                    <!-- Modal -->
                    <div class='modal fade' id='cancelModal<?php echo $id_usuario?>' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <?php
                                        if($estado=="Permitido"){
                                            echo " <h1 class='modal-title fs-5' id='exampleModalLabel'>Bloquear usuario #$id_usuario</h1>";
                                        }

                                        if($estado=="Bloqueado"){
                                            echo " <h1 class='modal-title fs-5' id='exampleModalLabel'>Desbloquear #<?php echo $id_usuario?></h1>";
                                        }
                                    ?>
                                   
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>

                                <div class='modal-body' style='text-align: left;'>

                                    <form action='<?php htmlspecialchars($_SERVER["PHP_SELF"])?>' method='POST'>
                                        <div class="centrados">
                                            <?php
                                                      if($estado=="Permitido"){
                                                        echo " <p>¿Estas seguro que quieres bloquear a este usuario?</p>";
                                                    }
            
                                                    if($estado=="Bloqueado"){
                                                        echo " <p>¿Estas seguro que quieres desbloquear a este usuario?</p>";
                                                    }
                                            ?>
                                            
                                        </div>
                                        
                                        <input type='hidden' name='id_usuario' value='<?php echo $id_usuario ?>'>
                                        <input type='hidden' name='estado' value='<?php echo $estado ?>'>
                                        
        
                                        <div class='modal-footer'>
                                            <input type='submit' value='Estoy Seguro' name='btn_bloquear_usuario' class='btn btn-primary btn-personalizado' style='width: 120px;'>
                                            <button type='button' class='btn btn-secondary btn-personalizado' data-bs-dismiss='modal'>Volver</button>
                                        </div> 
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> 

                    
                </div>
            </td>
        </tr>

            <?php
        }
        echo "</tbody>
            </table>
        </div>
    </div>";
    } else {
        echo "<div class='ms-2 centrados'>";
        echo "<br><h2>Actualmente no se han realizado reservas</h2>";
        echo "</div>";
    }




?>


<script type="text/javascript">
    function genPDF(){
    var doc = new jsPDF('landscape');
     // Agregar la hora del reporte
    var fecha = new Date();
    var dia = ("0" + fecha.getDate()).slice(-2);
    var mes = ("0" + (fecha.getMonth() + 1)).slice(-2);
    var año = fecha.getFullYear();
    var fechaFormateada = dia + '/' + mes + '/' + año;
    var horas = fecha.getHours();
    var minutos = fecha.getMinutes();
    var am_pm = horas >= 12 ? "PM" : "AM"; // Determina si es AM o PM

    // Convierte las horas a formato de 12 horas
    if (horas > 12) {
        horas -= 12;
    }

    var hora_formateada = horas + ":" + (minutos < 10 ? "0" : "") + minutos + " " + am_pm;

    doc.setFontSize(12);
    doc.text("Fecha: " + fechaFormateada, 245.5, 10); // Ajusta las coordenadas según sea necesario
    doc.text("Hora: " + hora_formateada, 253, 18); // Ajusta las coordenadas según sea necesario
    
    // Agregar logo
    doc.addImage(logo, 'png', 10, 5, 50, 30);  // Ajusta las coordenadas y el tamaño según sea necesario

   

    // Definir columnas y datos
    var columns = ["ID Usuario", "Nombre", "Apellido", "Cédula", "Télefono", "Faltas", "Estado"];
    var data = reporte.map(item => [item.id_usuario, item.nombre, item.apellido, item.cedula, item.telefono, item.faltas, item.estado]);

    // Agregar tabla con estilos personalizados
    doc.setFontSize(22);
    doc.text("Usuarios", 130, 45);
    doc.autoTable({
        columns: columns,
        body: data,
        styles: { fillColor: [255, 255, 255], textColor: [0, 0, 0], fontSize: 12 },  // Ajusta los estilos según sea necesario
        margin: { top: 55 }  // Ajusta el margen superior para evitar superposición con el logo y la hora del reporte
    });

    doc.save('Usuarios.pdf');
}
</script>

  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- DataTable -->
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>

<!-- Bootstrap Bundle -->
<script src="librerias/bootstrap.bundle.min.js"></script>

<!-- SweetAlert -->
<script src="librerias/sweetalert.min.js"></script>

    
<script>
$(document).ready(function(){
  $("#button-addon2").click(function(){
    var texto = $("input[aria-label='Buscar']").val().toLowerCase();
    $("table tbody tr").filter(function() {
        $(this).toggle($(this).find("td:eq(0), td:eq(1), td:eq(2), td:eq(3), td:eq(4)").text().toLowerCase().indexOf(texto) > -1)
    });
  });
});
</script>

<script>
    // Mostrar la notificación al cargar la página
    const notification = document.getElementById('myNotification');
    notification.style.display = 'block';

    // Ocultar la notificación después de 3 segundos
    setTimeout(() => {
        notification.style.display = 'none';
    }, 3000);
</script>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
            }, false)
        })
        })()
</script>