<?php
require('fpdf.php');

function generatePDF($customer_id, $name, $email, $phone, $dob) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    $pdf->Cell(40, 10, "Customer Details");
    $pdf->Ln();
    $pdf->Cell(40, 10, "Name: " . $name);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Email: " . $email);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Phone: " . $phone);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Date of Birth: " . $dob);
    $pdf->Ln();

    // Save the PDF to a file
    $pdf->Output('F', '../pdfs/customer_' . $customer_id . '.pdf');
}
?>
