<?php

require('./fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {

      $this->Image('./logo2-itos.jpg', 185, 5, 25); 
      $this->SetFont('Arial', 'B', 19); 
      $this->Cell(45);
      $this->SetTextColor(0, 0, 0); 
      $this->Cell(110, 15, 'TIENDA AGROPECUARIA ITOS', 1, 1, 'C', 0); 
      $this->Ln(3); // 
      $this->SetTextColor(103); 

      /* UBICACION */
      $this->Cell(110);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(96, 10, utf8_decode("Ubicación : Sahagún - Córdoba"), 0, 0, '', 0);
      $this->Ln(5);

      /* TELEFONO */
      $this->Cell(110);
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(59, 10, utf8_decode("Teléfono : 018000"), 0, 0, '', 0);
      $this->Ln(5);

      /* CORREO */
      $this->Cell(110);
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(85, 10, utf8_decode("Correo : tiendaitos@gmail.com"), 0, 0, '', 0);
      $this->Ln(5);

      require '../conexion.php';
      if ($_GET['idFactura']) {
         $idFactura = $_GET['idFactura'] ? $_GET['idFactura'] : '';
         if (!empty($idFactura)) {
            $sql = $con->prepare("SELECT c.nombres, c.apellidos FROM clientes c INNER JOIN factura f ON c.idCliente=f.idCliente WHERE f.idFactura = ? LIMIT 1");
            $sql->execute([$idFactura]);
            $result = $sql->get_result();
            $cliente = $result->fetch_assoc();

            /* FACTURA */
            $this->Cell(110);  
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(85, 10, utf8_decode("Factura Nº : " . $idFactura), 0, 0, '', 0);
            $this->Ln(5);

            /* NOMBRES Y APELLIDOS CLIENTE */
            $this->Cell(110);  
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(85, 10, utf8_decode("Nombres : " . ucwords($cliente['nombres']) . ' ' .ucwords($cliente['apellidos'])), 0, 0, '', 0);
            $this->Ln(10);
         }
      }

      /* TITULO DE LA TABLA */
      $this->SetTextColor(52, 209, 155);
      $this->Cell(50); 
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(100, 10, "DETALLES DE LA COMPRA", 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      $this->SetFillColor(52, 209, 155); 
      $this->SetTextColor(255, 255, 255); 
      $this->SetDrawColor(163, 163, 163); 
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(30, 10, utf8_decode('#'), 1, 0, 'C', 1);
      $this->Cell(40, 10, 'Producto', 1, 0, 'C', 1);
      $this->Cell(40, 10, 'Precio', 1, 0, 'C', 1);
      $this->Cell(40, 10, 'Cantidad', 1, 0, 'C', 1);
      $this->Cell(40, 10, 'Subtotal', 1, 1, 'C', 1);

   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); 
      $this->SetFont('Arial', 'I', 8); 
      $this->Cell(0, 10, utf8_decode('Página') . $this->PageNo() . '/{nb}', 0, 0, 'C'); 

      $this->SetY(-15); 
      $this->SetFont('Arial', 'I', 8); 
      $hoy = date('d/m/Y');
      $this->Cell(355, 10, $hoy, 0, 0, 'C'); 
   }
}


require '../conexion.php';

$pdf = new PDF();
$pdf->AddPage(); 
$pdf->AliasNbPages(); 

$i = 0;
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); 

$idFactura = $_GET['idFactura'] ? $_GET['idFactura'] : '';

if (!empty($idFactura)) {
   $sqlDetalles = $con->prepare("SELECT nombre, precio, cantidad, subtotal FROM detalles_factura  WHERE idFactura = ?");
   $sqlDetalles->execute([$idFactura]);
   $result = $sqlDetalles->get_result();

   while ($compra = $result->fetch_object()) { 
      $i = $i + 1;
      /* TABLA */
      $pdf->Cell(30, 10, $i, 1, 0, 'C', 0);
      $pdf->Cell(40, 10, $compra->nombre, 1, 0, 'C', 0);
      $pdf->Cell(40, 10, $compra->precio, 1, 0, 'C', 0);
      $pdf->Cell(40, 10, $compra->cantidad, 1, 0, 'C', 0);
      $pdf->Cell(40, 10, $compra->subtotal, 1, 1, 'C', 0);
      // $pdf->Cell(70, 10, utf8_decode("info"), 1, 0, 'C', 0);
      // $pdf->Cell(25, 10, utf8_decode("total"), 1, 1, 'C', 0);    
   }

} 



$pdf->Output('Factura.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
