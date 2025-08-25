<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Shops;
use App\Models\StockPurchase;
use FPDF;

class PDFExportController extends Controller
{
    public function salesReport($shop = 0, $from = 0, $to = 0)
    {
        $query = Orders::with('product', 'customer', 'delivery');

        if ($shop && $shop != 0) {
            $query->where('shop', $shop);
        }

        if ($from && $from != 0) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to && $to != 0) {
            $query->whereDate('created_at', '<=', $to);
        }

        $orders = $query->get();

        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        // Logo
        $logoWidth = 30;
        $pageWidth = $pdf->GetPageWidth();
        $x = ($pageWidth - $logoWidth) / 2;

        $pdf->Image(public_path('assets/images/logo.png'), $x, 6, $logoWidth);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Ln(25);
        $pdf->Cell(0, 10, 'Sales Report', 0, 1, 'C');
        $pdf->Ln(2);

        // Headers
        $headers = [
            'OR.ID',
            'CS.Name',
            'CS.Phone',
            'CS.Email',
            'Product',
            'Qty',
            'P.Price',
            'S.Price',
            'Profit',
            'Address',
            'OR-Status',
            'PY-Status',
            'PY-Type'
        ];

        $widths = [20, 25, 25, 25, 30, 10, 15, 15, 15, 50, 15, 15, 15];
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(230, 230, 230);

        foreach ($headers as $i => $header) {
            $pdf->Cell($widths[$i], 8, $header, 1, 0, 'C', true);
        }
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 7);
        $lineHeight = 4;

        $totalQty = 0;
        $totalPPrice = 0;
        $totalSPrice = 0;
        $totalProfit = 0;

        foreach ($orders as $order) {
            $profit = $order->price - $order->p_price;

            $totalQty += $order->quantity;
            $totalPPrice += $order->p_price;
            $totalSPrice += $order->price;
            $totalProfit += ($order->price - $order->p_price);

            $data = [
                $order->orderid,
                $order->customer->name ?? '',
                $order->customer->phone_number ?? '',
                $order->customer->email ?? '',
                $order->product->name ?? '',
                $order->quantity,
                number_format($order->p_price),
                number_format($order->price),
                number_format($profit),
                $order->delivery_address ?? '',
                $order->status ?? '',
                $order->payment_status ?? '',
                $order->payment_method ?? '',
            ];

            // Step 1: Calculate max number of lines
            $maxLines = 1;
            foreach ($data as $i => $text) {
                $numLines = ceil($pdf->GetStringWidth($text) / ($widths[$i] - 1));
                if ($numLines > $maxLines) {
                    $maxLines = $numLines;
                }
            }
            $rowHeight = $lineHeight * $maxLines;

            // Step 2: Draw each cell with fixed height using manual positioning
            $x = $pdf->GetX();
            $y = $pdf->GetY();

            $centerAlignedIndexes = [3, 4, 5, 6]; // 'Qty', 'P.Price', 'S.Price', 'Profit'

            foreach ($data as $i => $text) {
                $pdf->SetXY($x, $y);

                // Calculate number of lines for this cell
                $numLines = ceil($pdf->GetStringWidth($text) / ($widths[$i] - 1));
                $cellHeight = $numLines * $lineHeight;

                // Calculate Y offset to vertically center it inside rowHeight
                $yOffset = ($rowHeight - $cellHeight) / 2;
                $pdf->SetXY($x, $y + $yOffset);

                // Choose alignment
                $align = in_array($i, $centerAlignedIndexes) ? 'C' : 'L';

                // Draw text
                $pdf->MultiCell($widths[$i], $lineHeight, $text, 0, $align);

                // Draw border
                $pdf->Rect($x, $y, $widths[$i], $rowHeight);

                // Move to next column
                $x += $widths[$i];
            }


            // Step 3: Go to next row (max row height)
            $pdf->SetY($y + $rowHeight);
        }

        // After all rows, print total row
        $pdf->SetFont('Arial', 'B', 7);
        $lineHeight = 5;
        $x = $pdf->GetX();
        $y = $pdf->GetY();

        $widths = [20, 25, 25, 25, 30, 10, 15, 15, 15, 50, 15, 15, 15];
        $pdf->SetXY($x, $y);

        // Prepare total row data
        $totals = [
            '',
            '',
            '',
            '',
            'Total:',
            $totalQty,
            number_format($totalPPrice),
            number_format($totalSPrice),
            number_format($totalProfit),
            '',
            '',
            '',
            ''
        ];

        // Draw total row
        foreach ($totals as $i => $text) {
            $pdf->Cell($widths[$i], $lineHeight, $text, 1, 0, 'C', true);
        }

        // Save & return
        $filePath = storage_path('app/public/sales_report.pdf');
        $pdf->Output('F', $filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function DailyReport()
    {
        $selectedDate = $this->selectedDate ?? now()->format('Y-m-d');

        $shops = Shops::all();
        $sales = [];
        $purchases = [];

        $totalAllSales = 0;
        $totalAllPurchases = 0;
        $totalAllProfit = 0;

        foreach ($shops as $shop) {
            $shopId = $shop->id;

            $sales[$shopId] = Orders::with('product', 'productshop')
                ->where('shop', $shopId)
                ->whereDate('created_at', $selectedDate)
                ->get();

            $purchases[$shopId] = StockPurchase::with('product', 'productshop')
                ->where('shop', $shopId)
                ->whereDate('created_at', $selectedDate)
                ->get();
        }

        $pdf = new FPDF('P', 'mm', 'A4');

        $headers = ['Product', 'Shop', 'Qty', 'P.Price', 'S.Price'];


        $widths = [40, 25, 20, 25, 25];

        $summary = [];

        foreach ($shops as $shop) {
            $shopId = $shop->id;

            $pdf->AddPage(); // separate page for each shop
            // Logo
            $logoWidth = 25;
            $pageWidth = $pdf->GetPageWidth();
            $x = ($pageWidth - $logoWidth) / 2;

            $pdf->Image(public_path('assets/images/logo.png'), $x, 6, $logoWidth);
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Ln(17);
            $pdf->Ln(2);

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, 'Daily Report - ' . $selectedDate, 0, 1, 'C');
            $pdf->Ln(2);

            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(0, 10, 'Shop: ' . $shop->name, 0, 1);
            $pdf->Ln(2);

            // === Sales Report ===
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(0, 8, 'Sales Report', 0, 1);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->SetFillColor(230, 230, 230);

            foreach ($headers as $i => $header) {
                $pdf->Cell($widths[$i], 8, $header, 1, 0, 'C', true);
            }
            $pdf->Ln();

            $pdf->SetFont('Arial', '', 7);
            $totalSaleQty = $totalSalePPrice = $totalSaleSPrice = 0;

            foreach ($sales[$shopId] as $sale) {
                $qty = $sale->quantity ?? 0;
                $pPrice = $sale->p_price ?? 0;
                $sPrice = $sale->price ?? 0;

                $totalSaleQty += $qty;
                $totalSalePPrice += ($pPrice * $qty);
                $totalSaleSPrice += ($sPrice * $qty);

                $data = [
                    $sale->product->name ?? '',
                    $sale->productshop->name ?? '',
                    $qty,
                    number_format($pPrice),
                    number_format($sPrice),
                ];

                foreach ($data as $i => $text) {
                    $pdf->Cell($widths[$i], 6, $text, 1, 0, 'C');
                }
                $pdf->Ln();
            }

            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell($widths[0], 5, '', 1, 0, 'C', true);
            $pdf->Cell($widths[1], 5, 'Total:', 1, 0, 'C', true);
            $pdf->Cell($widths[2], 5, $totalSaleQty, 1, 0, 'C', true);
            $pdf->Cell($widths[3], 5, number_format($totalSalePPrice), 1, 0, 'C', true);
            $pdf->Cell($widths[4], 5, number_format($totalSaleSPrice), 1, 0, 'C', true);
            $pdf->Ln(12);

            // === Purchase Report ===
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(0, 8, 'Purchase Report', 0, 1);
            $pdf->SetFont('Arial', 'B', 7);

            foreach ($headers as $i => $header) {
                $pdf->Cell($widths[$i], 8, $header, 1, 0, 'C', true);
            }
            $pdf->Ln();

            $pdf->SetFont('Arial', '', 7);
            $totalPurchaseQty = $totalPurchasePPrice = $totalPurchaseSPrice = 0;

            foreach ($purchases[$shopId] as $purchase) {
                $qty = $purchase->qty ?? 0;
                $pPrice = $purchase->p_price ?? 0;
                $sPrice = $purchase->price ?? 0;

                $totalPurchaseQty += $qty;
                $totalPurchasePPrice += $pPrice * $qty;
                $totalPurchaseSPrice += $sPrice * $qty;

                $data = [
                    $purchase->product->name ?? '',
                    $purchase->productshop->name ?? '',
                    $qty,
                    number_format($pPrice),
                    number_format($sPrice),
                ];

                foreach ($data as $i => $text) {
                    $pdf->Cell($widths[$i], 6, $text, 1, 0, 'C');
                }
                $pdf->Ln();
            }

            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell($widths[0], 5, '', 1, 0, 'C', true);
            $pdf->Cell($widths[1], 5, 'Total:', 1, 0, 'C', true);
            $pdf->Cell($widths[2], 5, $totalPurchaseQty, 1, 0, 'C', true);
            $pdf->Cell($widths[3], 5, number_format($totalPurchasePPrice), 1, 0, 'C', true);
            $pdf->Cell($widths[4], 5, number_format($totalPurchaseSPrice), 1, 0, 'C', true);
            $pdf->Ln(12);

            // Track totals
            $shopProfit = $totalSaleSPrice - $totalSalePPrice;
            $totalAllSales += $totalSaleSPrice;
            $totalAllPurchases += $totalPurchasePPrice;
            $totalAllProfit += $shopProfit;

            $summary[] = [
                'shop' => $shop->name,
                'sales' => $totalSaleSPrice,
                'purchases' => $totalPurchasePPrice,
                'profit' => $shopProfit,
            ];
        }

        // === Summary Page ===
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Summary (All Branches)', 0, 1, 'C');
        $pdf->Ln(4);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell(60, 8, 'Shop', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Sales', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Purchases', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Profit', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 10);
        foreach ($summary as $row) {
            $pdf->Cell(60, 8, $row['shop'], 1);
            $pdf->Cell(40, 8, number_format($row['sales']), 1, 0, 'C');
            $pdf->Cell(40, 8, number_format($row['purchases']), 1, 0, 'C');
            $pdf->Cell(40, 8, number_format($row['profit']), 1, 1, 'C');
        }

        // === Grand Total ===
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(60, 8, 'Grand Total', 1, false, 'C', true);
        $pdf->Cell(40, 8, number_format($totalAllSales), 1, 0, 'C', true);
        $pdf->Cell(40, 8, number_format($totalAllPurchases), 1, 0, 'C', true);
        $pdf->Cell(40, 8, number_format($totalAllProfit), 1, 1, 'C', true);

        // === Output ===
        $filePath = storage_path('app/public/sales_report.pdf');
        $pdf->Output('F', $filePath);
        return response()->download($filePath)->deleteFileAfterSend(true);
    }




    public function PurchaseReport($shop = 0, $from = 0, $to = 0)
    {
        $query = StockPurchase::with('productshop', 'product', 'user');

        if ($shop && $shop != 0) {
            $query->where('shop', $shop);
        }

        if ($from && $from != 0) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to && $to != 0) {
            $query->whereDate('created_at', '<=', $to);
        }

        $orders = $query->get();

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();

        // Logo center
        $logoWidth = 30;
        $pageWidth = $pdf->GetPageWidth();
        $x = ($pageWidth - $logoWidth) / 2;
        $pdf->Image(public_path('assets/images/logo.png'), $x, 6, $logoWidth);

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Ln(25);
        $pdf->Cell(0, 10, 'Purchase Report', 0, 1, 'C');
        $pdf->Ln(2);

        // Headers
        $headers = ['Product', 'Shop', 'PR.Name', 'Qty', 'P.Price', 'S.Price', 'Profit'];
        $widths = [40, 25, 25, 20, 25, 25, 25];
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(230, 230, 230);

        foreach ($headers as $i => $header) {
            $pdf->Cell($widths[$i], 8, $header, 1, 0, 'C', true);
        }
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 7);
        $lineHeight = 4;

        $totalQty = 0;
        $totalPPrice = 0;
        $totalSPrice = 0;
        $totalProfit = 0;

        foreach ($orders as $order) {
            $qty = $order->qty ?? 0;
            $pPrice = $order->p_price ?? 0;
            $sPrice = $order->price ?? 0;
            $profit = $sPrice - $pPrice;

            $totalQty += $qty;
            $totalPPrice += $pPrice;
            $totalSPrice += $sPrice;
            $totalProfit += $profit;

            $data = [
                $order->product->name ?? '',
                $order->productshop->name ?? '',
                $order->user->name ?? '',
                $qty,
                number_format($pPrice),
                number_format($sPrice),
                number_format($profit),
            ];

            // Step 1: Max row height based on text wrapping
            $maxLines = 1;
            foreach ($data as $i => $text) {
                $numLines = ceil($pdf->GetStringWidth($text) / ($widths[$i] - 1));
                if ($numLines > $maxLines) {
                    $maxLines = $numLines;
                }
            }
            $rowHeight = $lineHeight * $maxLines;

            // Step 2: Render row
            $x = $pdf->GetX();
            $y = $pdf->GetY();

            $centerAligned = [3, 4, 5, 6]; // Qty, P.Price, S.Price, Profit

            foreach ($data as $i => $text) {
                $pdf->SetXY($x, $y);
                $numLines = ceil($pdf->GetStringWidth($text) / ($widths[$i] - 1));
                $cellHeight = $numLines * $lineHeight;
                $yOffset = ($rowHeight - $cellHeight) / 2;

                $pdf->SetXY($x, $y + $yOffset);
                $align = in_array($i, $centerAligned) ? 'C' : 'L';
                $pdf->MultiCell($widths[$i], $lineHeight, $text, 0, $align);
                $pdf->Rect($x, $y, $widths[$i], $rowHeight);

                $x += $widths[$i];
            }

            $pdf->SetY($y + $rowHeight);
        }

        // Total Row
        $pdf->SetFont('Arial', 'B', 7);
        $lineHeight = 5;
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->SetXY($x, $y);

        $totals = [
            '',
            '',
            'Total:',
            $totalQty,
            number_format($totalPPrice),
            number_format($totalSPrice),
            number_format($totalProfit),
        ];

        foreach ($totals as $i => $text) {
            $pdf->Cell($widths[$i], $lineHeight, $text, 1, 0, 'C', true);
        }

        $filePath = storage_path('app/public/purchase_report.pdf');
        $pdf->Output('F', $filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function OrderReport($shop = 0, $from = 0, $to = 0)
    {
        $query = Orders::with(['product', 'productshop', 'customer']);

        if ($shop && $shop != 0) {
            $query->where('shop', $shop);
        }

        if ($from && $from != 0) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to && $to != 0) {
            $query->whereDate('created_at', '<=', $to);
        }

        $orders = $query->get();

        $pdf = new FPDF('L', 'mm', 'A4'); // Landscape for more columns
        $pdf->AddPage();

        // Logo Center
        $logoWidth = 30;
        $pageWidth = $pdf->GetPageWidth();
        $x = ($pageWidth - $logoWidth) / 2;
        $pdf->Image(public_path('assets/images/logo.png'), $x, 6, $logoWidth);

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Ln(25);
        $pdf->Cell(0, 10, 'Customer Order Report', 0, 1, 'C');
        $pdf->Ln(2);

        // Headers
        $headers = ['ID', 'OrderID', 'Product', 'Qty', 'S.Price', 'P.Price', 'Profit', 'Status', 'Shop', 'Customer', 'Address'];
        $widths = [10, 35, 35, 15, 20, 20, 20, 15, 30, 30, 45];

        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetFillColor(230, 230, 230);
        foreach ($headers as $i => $header) {
            $pdf->Cell($widths[$i], 8, $header, 1, 0, 'C', true);
        }
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 7);
        $lineHeight = 4;

        $totalQty = 0;
        $totalPPrice = 0;
        $totalSPrice = 0;
        $totalProfit = 0;

        foreach ($orders as $order) {
            $qty = $order->quantity ?? 0;
            $pPrice = $order->p_price ?? 0;
            $sPrice = $order->price ?? 0;
            $profit = $sPrice - $pPrice;

            $totalQty += $qty;
            $totalPPrice += $pPrice;
            $totalSPrice += $sPrice;
            $totalProfit += $profit;

            $data = [
                $order->id,
                $order->orderid,
                $order->product->name ?? '',
                $qty,
                number_format($sPrice),
                number_format($pPrice),
                number_format($profit),
                $order->status ?? 'N/A',
                $order->productshop->name ?? '',
                $order->customer->name ?? '',
                $order->delivery_address ?? '',
            ];

            // Calculate row height
            $maxLines = 1;
            foreach ($data as $i => $text) {
                $numLines = ceil($pdf->GetStringWidth($text) / ($widths[$i] - 1));
                $maxLines = max($maxLines, $numLines);
            }
            $rowHeight = $lineHeight * $maxLines;

            // Render row
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            $centerAlign = [3, 4, 5, 6]; // Qty, S.Price, P.Price, Profit

            foreach ($data as $i => $text) {
                $pdf->SetXY($x, $y);
                $numLines = ceil($pdf->GetStringWidth($text) / ($widths[$i] - 1));
                $cellHeight = $numLines * $lineHeight;
                $yOffset = ($rowHeight - $cellHeight) / 2;

                $pdf->SetXY($x, $y + $yOffset);
                $align = in_array($i, $centerAlign) ? 'C' : 'L';
                $pdf->MultiCell($widths[$i], $lineHeight, $text, 0, $align);
                $pdf->Rect($x, $y, $widths[$i], $rowHeight);

                $x += $widths[$i];
            }

            $pdf->SetY($y + $rowHeight);
        }

        // Total Row
        $pdf->SetFont('Arial', 'B', 7);
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->SetXY($x, $y);

        $totals = [
            '',
            '',
            'Total:',
            $totalQty,
            number_format($totalSPrice),
            number_format($totalPPrice),
            number_format($totalProfit),
            '',
            '',
            '',
            '',
        ];

        foreach ($totals as $i => $text) {
            $pdf->Cell($widths[$i], 6, $text, 1, 0, 'C', true);
        }

        $filePath = storage_path('app/public/order_report.pdf');
        $pdf->Output('F', $filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
