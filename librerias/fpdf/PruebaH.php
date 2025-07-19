<?php
require('./fpdf.php');
class PDF extends FPDF
{
   // Cabecera de página
   function Header()
   {  
      $this->AddPage();
      $conexion = mysqli_connect('localhost', 'root', '', 'reservas_restaurante');
      $consulta_info = $conexion->query("SELECT usuarios.nombre, usuarios.apellido, usuarios.cedula, mesas.numero_mesa, reservas.id_reserva, reservas.numero_personas, reservas.hora_inicio, reservas.hora_fin, reservas.fecha, reservas.estado, mesas.id_mesa
      FROM reservas 
      left JOIN mesas ON reservas.id_mesa= mesas.id_mesa 
      left JOIN usuarios on reservas.id_usuario=usuarios.id_usuario 
      ORDER BY reservas.id_reserva DESC");

      $this->Image('logo.jpg', 185, 5, 20);
      $this->SetFont('Arial','B',12);
      $this->Cell(0,10,'Reservas de Restaurante',0,1,'C');
      
      return $consulta_info;
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15);
      $this->SetFont('Arial','I',8);
      $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
   }

   // Cuerpo de página
   function Body($consulta_info)
   {
      $this->SetFont('Arial','',12);
      while($dato_info = $consulta_info->fetch_object())
      {
         $this->Cell(0,10,'Nombre: '.$dato_info->nombre.' '.$dato_info->apellido,0,1);
         $this->Cell(0,10,'Cedula: '.$dato_info->cedula,0,1);
         $this->Cell(0,10,'Numero de Mesa: '.$dato_info->numero_mesa,0,1);
         $this->Cell(0,10,'ID de Reserva: '.$dato_info->id_reserva,0,1);
         $this->Cell(0,10,'Numero de Personas: '.$dato_info->numero_personas,0,1);
         $this->Cell(0,10,'Hora de Inicio: '.$dato_info->hora_inicio,0,1);
         $this->Cell(0,10,'Hora de Fin: '.$dato_info->hora_fin,0,1);
         $this->Cell(0,10,'Fecha: '.$dato_info->fecha,0,1);
         $this->Cell(0,10,'Estado: '.$dato_info->estado,0,1);
         $this->Ln(10);
      }
   }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$consulta_info = $pdf->Header();
$pdf->Body($consulta_info);
$pdf->Output();

?>