<?php
include('headerAdmin.php');
include ('procesos/conexion.php');

    setlocale(LC_TIME, 'es_ES');
    $fecha_actual = date("Y-m-d");
    $mes= date("m")+1;
    $mes= "0".$mes;
    $mas_un_mes=date("Y-".$mes."-d");
    $hoy= date('d');

    include('procesos/obtener_todas_reservas_encurso.php');

    $consulta = "SELECT usuarios.nombre, usuarios.apellido, usuarios.cedula, mesas.numero_mesa, reservas.id_reserva, reservas.numero_personas, reservas.hora_inicio, reservas.hora_fin, reservas.fecha, reservas.estado, mesas.id_mesa, reservas.asistencia
    FROM reservas 
    LEFT JOIN mesas ON reservas.id_mesa = mesas.id_mesa 
    LEFT JOIN usuarios ON reservas.id_usuario = usuarios.id_usuario 
    WHERE reservas.estado='EN CURSO' 
    ORDER BY reservas.id_reserva DESC";

$stmt = $base->prepare($consulta);
$stmt->execute();

// Guardar los resultados en un array asociativo
$reporte = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
     $reporte[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn_asistencia"])) {
    include('procesos/confirmar_asistencia.php');
    include('procesos/obtener_todas_reservas.php');
    $consulta = "SELECT usuarios.nombre, usuarios.apellido, usuarios.cedula, mesas.numero_mesa, reservas.id_reserva, reservas.numero_personas, reservas.hora_inicio, reservas.hora_fin, reservas.fecha, reservas.estado, mesas.id_mesa, reservas.asistencia
    FROM reservas 
    LEFT JOIN mesas ON reservas.id_mesa = mesas.id_mesa 
    LEFT JOIN usuarios ON reservas.id_usuario = usuarios.id_usuario 
    ORDER BY reservas.id_reserva DESC";

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


    <h1 class='no-deco' style='text-align: center'>Reservaciones</h1>
    <br>
    <div class='row'>
            <div class='col-12 col-md-9'>
                <ul class='nav nav-tabs'>
                <li class='nav-item navNaranja'>
                    <a class='nav-link ' href='reservasAdmin.php' style='color: #ce7e25;'>Todas</a>
                </li>
                <li class='nav-item navNaranja'>
                    <a class='nav-link' href='reservasAdmin_pendientes.php' style='color: #ce7e25;'>Pendientes</a>
                </li>
                <li class='nav-item navNaranja'>
                    <a class='nav-link' href='reservasAdmin_canceladas.php' style='color: #ce7e25;'>Canceladas</a>
                </li>
                <li class='nav-item navNaranja'>
                    <a class='nav-link' href='reservasAdmin_terminadas.php' style='color: #ce7e25;'>Terminadas</a>
                </li>
                <li class='nav-item navNaranja'>
                    <a class='nav-link active' href='reservasAdmin_encurso.php'>En Curso</a>
                </li>
                </ul>
            </div>
            <div class='col-12 col-md-3'>
                <div class='input-group mb-3'>
                <input type='text' class='form-control' placeholder='Buscar...' aria-label='Buscar'>
                <button class='btn btn-outline-secondary btn-ver' type='button' id='button-addon2'>
                <i class='fa-solid fa-magnifying-glass'></i>
                </button>
                </div>
            </div>
    </div>
    ";
    

    if($resultado){
        echo "<div class='table-responsive'>
                <table class='table'>
                    <thead>
                        <tr>
                            <th scope='col'># Referencia</th>
                            <th scope='col'>Nombre del Cliente</th>
                            <th scope='col'>Cédula</th>
                            <th scope='col'>Mesa Asignada</th>
                            <th scope='col'>Número de Personas</th>
                            <th scope='col'>Fecha</th>
                            <th scope='col'>Hora de Inicio</th>
                            <th scope='col'>Hora de Fin</th>
                            <th scope='col'>Asistencia</th>
                            <th scope='col'>Estado</th>
                            <th scope='col'>Confirmar Asistencia</th>
                        </tr>
                    </thead><tbody>";

        foreach ($resultado as $fila) {
            // Acceder a los valores de cada reserva
            $nombre= $fila['nombre'];
            $apellido = $fila['apellido'];
            $cedula = $fila['cedula'];
            $numero_mesa = $fila['numero_mesa'];
            $id_reserva = $fila['id_reserva'];
            $numero_personas = $fila['numero_personas'];
            $fecha = $fila['fecha'];
            $hora_inicio = date('g:i A', strtotime($fila['hora_inicio']));
            $hora_fin = date('g:i A', strtotime($fila['hora_fin']));
            $estado = $fila['estado'];
            $id_mesa=$fila['id_mesa'];
            $asistencia=$fila['asistencia'];
            // Mostrar los datos de cada reserva

            echo  "<tr  style='height: 75px;'>
            <td scope='row' style='width: 70px;'>$id_reserva</td>
            <td style='width: 150px;'>$nombre $apellido</td>
            <td style='width: 100px;'>$cedula</td>
            <td style='width: 50px;'>$numero_mesa</td>
            <td style='width: 50px;'>$numero_personas</td>
            <td style='width: 120px;'>$fecha</td>
            <td style='width: 100px;'>$hora_inicio</td>
            <td style='width: 100px;'>$hora_fin</td>
            <td style='width: 120px;'>$asistencia</td>";

            if($estado=="PENDIENTE"){
                echo "<td style='width: 120px;'><div class='estatus pendiente ms-auto me-auto p-1' >$estado</div></td>";
            }
            if($estado=="CANCELADA"){
                echo "<td style='width: 120px;'><div class='estatus cancelada ms-auto me-auto p-1'>$estado</div></td>";
            }
            if($estado=="EN CURSO"){
                echo "<td style='width: 120px;'><div class='estatus encurso ms-auto me-auto p-1'>$estado</div></td>";
            }
            if($estado=="TERMINADA"){
                echo "<td style='width: 120px;'><div class='estatus terminada ms-auto me-auto p-1''>$estado</div></td>";
            }
            ?>

            <td style='width: 150px;'>

                    <?php
                        if($estado=="EN CURSO"){
                            echo "<button type='button' class='btn btn-primary btn-tabla-asistencia' data-bs-toggle='modal' data-bs-target='#cancelModal$id_reserva'>
                            <i class='fa-solid fa-check'></i>
                        </button>";
                        }else{
                            echo "<button type='button' class='btn btn-primary btn-tabla-asistencia' data-bs-toggle='modal' data-bs-target='#cancelModal$id_reserva' disabled>
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
                    <div class='modal fade' id='cancelModal<?php echo $id_reserva?>' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h1 class='modal-title fs-5' id='exampleModalLabel'>Confirmar Asistencia #<?php echo $id_reserva?></h1>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>

                                <div class='modal-body' style='text-align: left;'>
                                    <?php ?>
                                    <form action='<?php htmlspecialchars($_SERVER["PHP_SELF"])?>' method='POST'>
                                        <div class="centrados">
                                                <p>¿Estas seguro que quieres confirmar la asistencia?
                                        </div>
                                        <input type='hidden' name='id_reserva' value='<?php echo $id_reserva ?>'>
                                        
        
                                        <div class='modal-footer'>
                                            <input type='submit' value='Estoy Seguro' name='btn_asistencia' class='btn btn-primary btn-personalizado' style='width: 120px;'>
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
        </div>";   


    } else {
        echo "<div class='ms-2 centrados'>";
        echo "<br><br><br><h2>Actualmente no hay reservas en curso</h2><br><br>";        
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
   var columns = ["ID de Reserva", "Nombre", "Apellido", "Cédula", "Número de Mesa", "Número de Personas", "Hora de Inicio", "Hora de Fin", "Fecha", "Asistencia", "Estado"];
    var data = reporte.map(item => [item.id_reserva, item.nombre, item.apellido, item.cedula, item.numero_mesa, item.numero_personas, item.hora_inicio, item.hora_fin, item.fecha, item.asistencia, item.estado]);

    // Agregar tabla con estilos personalizados
    doc.setFontSize(22);
    doc.text("Reservas en Curso", 108, 45);
    doc.autoTable({
        columns: columns,
        body: data,
        styles: { fillColor: [255, 255, 255], textColor: [0, 0, 0], fontSize: 12 },  // Ajusta los estilos según sea necesario
        margin: { top: 55 }  // Ajusta el margen superior para evitar superposición con el logo y la hora del reporte
    });

    doc.save('Reservas.pdf');
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
        $("input[name='fecha']").change(function(){
            var fecha = $(this).val();
            var dia = new Date(fecha).getDay();
            $.ajax({
                url: 'procesos/obtenerHorarios.php',
                type: 'post',
                data: {dia: dia, fecha: fecha},
                success: function(response){
                    $("select[name='hora_select']").html(response);
                }
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
$(document).ready(function(){
  $("#button-addon2").click(function(){
    var texto = $("input[aria-label='Buscar']").val().toLowerCase();
    $("table tbody tr").filter(function() {
        $(this).toggle($(this).find("td:eq(0), td:eq(1), td:eq(2), td:eq(3), td:eq(5), td:eq(6), td:eq(7)").text().toLowerCase().indexOf(texto) > -1)
    });
  });
});
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