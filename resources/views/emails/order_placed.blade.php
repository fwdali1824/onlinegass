<!DOCTYPE html>
<html>

<head>
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .email-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }

        h2 {
            color: #0d6efd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
            vertical-align: middle;
        }

        table th {
            background-color: #f8f9fa;
        }

        .total-row td {
            font-weight: bold;
            background-color: #f1f1f1;
        }

        .text-muted {
            color: #6c757d;
        }

        .small {
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h2>Thank you, {{ $fullName }}!</h2>
        <p>Your order with Order ID: <strong>{{ $orderID }}</strong> has been successfully placed.</p>

        <h4>Order Details:</h4>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Unit Price (PKR)</th>
                    <th>Quantity</th>
                    <th>Total (PKR)</th>
                    <th>Delivery Date</th>
                    <th>Payment Method</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grandTotal = 0;
                @endphp
                @foreach ($orderList as $order)
                    @php
                        $grandTotal += $order->total_amount;
                    @endphp
                    <tr>
                        <td>{{ $order->product->name }}</td>
                        <td>{{ number_format($order->price, 2) }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ number_format($order->total_amount, 2) }}</td>
                        <td>{{ strtoupper($order->delivery_date) }}</td>
                        <td>{{ strtoupper($order->payment_method) }}</td>
                    </tr>
                @endforeach

                <tr class="total-row">
                    <td colspan="3" style="text-align: right;">Total Amount:</td>
                    <td colspan="3">PKR {{ number_format($grandTotal, 2) }}</td>
                </tr>

            </tbody>
        </table>

        <p class="mt-4">We will notify you when your order is shipped. If you have any questions, feel free to contact
            our support team.</p>
        <p class="text-muted small">This is an automated message. Please do not reply directly to this email.</p>
    </div>
</body>

</html>
