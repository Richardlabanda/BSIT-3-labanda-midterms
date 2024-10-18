<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;

class StoreReciept extends Controller
{
    public static function print(Request $request){
        $fpdf = new Fpdf('p','mm','A4');
        $fpdf->AddPage();

       
        

        $fpdf->SetFont('Arial', 'B', 16);
        $fpdf->Cell(0, 10, 'Fresh Mart', 0, 1, 'C');
        $fpdf->SetFont('Arial', '', 12);
        $fpdf->Cell(0, 10, 'Inayagan City of Naga Cebu', 0, 1, 'C');
        $fpdf->Cell(0, 10, '#09434553453', 0, 1, 'C');
        $fpdf->Cell(0, 10, '', 0, 1);  

      
        $fpdf->SetFont('Arial', 'B', 12);
        $fpdf->Cell(0, 10, 'Date: ', 0, 1);
        $fpdf->Cell(0, 10, 'Time: ', 0, 1);
        $fpdf->Cell(0, 10, '', 0, 1);  

      
        $fpdf->SetFont('Arial', 'B', 12);
        $fpdf->Cell(100, 10, 'Item Description', 1);
        $fpdf->Cell(30, 10, 'Qty', 1);
        $fpdf->Cell(30, 10, 'Price', 1, 1);

       
        $items = [
            ['description' => 'Apples (per lb)', 'qty' => 2, 'price' => 3.00],
            ['description' => 'Bread', 'qty' => 1, 'price' => 2.50],
            ['description' => 'Milk (1 gallon)', 'qty' => 1, 'price' => 3.50],
            ['description' => 'Eggs (dozen)', 'qty' => 1, 'price' => 2.00],
        ];

        foreach ($items as $item) {
            $fpdf->SetFont('Arial', '', 12);
            $fpdf->Cell(100, 10, $item['description'], 1);
            $fpdf->Cell(30, 10, $item['qty'], 1);
            $fpdf->Cell(30, 10, '$' . number_format($item['price'], 2), 1, 1);
        }

  
        $subtotal = array_sum(array_map(function ($item) {
            return $item['qty'] * $item['price'];
        }, $items));

        $tax = $subtotal * 0.05;
        $total = $subtotal + $tax;

 
        $fpdf->Cell(130, 10, 'Subtotal', 1);
        $fpdf->Cell(30, 10, '$' . number_format($subtotal, 2), 1, 1);
        $fpdf->Cell(130, 10, 'Tax (5%)', 1);
        $fpdf->Cell(30, 10, '$' . number_format($tax, 2), 1, 1);
        $fpdf->Cell(130, 10, 'Total', 1);
        $fpdf->Cell(30, 10, '$' . number_format($total, 2), 1, 1);

   
        $fpdf->Cell(0, 10, 'Payment Method: ', 0, 1);
        $fpdf->Cell(0, 10, 'Transaction ID: ', 0, 1);
        $fpdf->Cell(0, 10, 'Thank you for shopping with us!', 0, 1, 'C');

        $fpdf->Output();
        exit;
    }
}
