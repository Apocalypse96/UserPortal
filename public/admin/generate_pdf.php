<?php
require_once '../../vendor/autoload.php'; // Ensure this is the correct path
require_once '../../config/database.php'; // Include the correct DB config file

// No need for "use FPDF\FPDF;" since FPDF doesn't use namespaces

// Get the customer ID from the URL
$customer_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$customer_id) {
    echo "Invalid customer ID.";
    exit;
}

// Fetch customer details from the database
$stmt = $conn->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$customer = $stmt->get_result()->fetch_assoc();

if (!$customer) {
    echo "Customer not found.";
    exit;
}

// Create the PDF
$pdf = new \FPDF(); // No need for namespace
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Add customer data to the PDF
$pdf->Cell(40, 10, 'Customer Details');
$pdf->Ln();
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, 'Name: ' . $customer['name']);
$pdf->Ln();
$pdf->Cell(40, 10, 'Email: ' . $customer['email']);
$pdf->Ln();
$pdf->Cell(40, 10, 'Phone: ' . $customer['phone']);
$pdf->Ln();
$pdf->Cell(40, 10, 'Date of Birth: ' . $customer['dob']);
$pdf->Ln();

// Output the PDF
$pdf->Output('D', 'Customer_' . $customer_id . '.pdf'); // 'D' forces download

?>
