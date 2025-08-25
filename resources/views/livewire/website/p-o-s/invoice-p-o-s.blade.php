<div>
    <style>
        body {
            background-color: #eee;
        }

        #invoice-POS {
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
            padding: 10px;
            margin: 20px auto;
            background: #FFF;
            width: 300px;
            font-family: 'Arial', sans-serif;
            font-size: 12px;
        }

        .logo {
            height: 60px;
            width: 60px;
            background: url(http://michaeltruong.ca/images/logo1.png) no-repeat center;
            background-size: cover;
            margin: 0 auto 10px;
        }

        .info h2 {
            font-size: 16px;
            text-align: center;
        }

        .info p {
            font-size: 10px;
            margin: 0;
        }

        .table th,
        .table td {
            font-size: 10px;
            padding: 4px 6px;
        }

        .table thead th {
            background-color: #eee;
        }

        .legalcopy {
            font-size: 11px;
            margin-top: 15px;
            text-align: center;
            color: #666;
        }

        @media print {
            #invoice-POS {
                box-shadow: none;
                width: auto;
                margin: 0;
            }
        }
    </style>
    <div id="invoice-POS" class="bg-white">
        <div class="text-center mb-2">
            <div class="logo mx-auto"></div>
            <div class="info">
                <h2>SBISTechs Inc</h2>
                <small>{{ $time }}</small>
            </div>
        </div>

        <div class="border-top border-bottom py-2">
            <div class="info">
                <h6>Contact Info</h6>
                <p>
                    Address: street city, state 0000<br>
                    Email: JohnDoe@gmail.com<br>
                    Phone: 555-555-5555
                </p>
            </div>
        </div>

        <div class="py-2 border-bottom">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>Rs {{ number_format($item['quantity'] * $item['price']) }}</td>
                        </tr>
                    @endforeach

                    <tr class="table-light">
                        <td></td>
                        <td><strong>Total</strong></td>
                        <td><strong>Rs {{ number_format($total) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="legalcopy">
            <p><strong>Thank you for your business!</strong></p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>


</div>
