<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            line-height: 1.5;
        }
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
            width: 100%;
            box-sizing: border-box;
        }
        .header {
            max-width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 100px;
            height: auto;
            max-height: 100px;
        }
        .school-info {
            font-size: 14px;
            margin-bottom: 10px;
        }
        .receipt-details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .receipt-details th, .receipt-details td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-size: 14px;
        }
        .amount {
            font-weight: bold;
            font-size: 18px;
        }
        .barcode {
            text-align: center;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 20px;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="receipt-container">
        <div class="header">
            <img src="{{ asset('storage/front/images/logo.png') }}" alt="School Logo">
            <h2>{{ $schoolinfo->school_name }}</h2>
            <div class="school-info">
                <p>{{ $schoolinfo->address }}, {{ $schoolinfo->city }}, {{ $schoolinfo->state }}, {{ $schoolinfo->country }}</p>
                <p>Phone: {{ $schoolinfo->phone }} | Email: {{ $schoolinfo->email }}</p>
                <p>Motto: {{ $schoolinfo->school_motto }}</p>
            </div>
        </div>

        <h3 style="text-align: center;">Payment Receipt</h3>
        <p style="text-align: right;">Printed on: {{ now()->format('d/m/Y H:i:s') }}</p>

        <table class="receipt-details">
            <tr>
                <th>Reference</th>
                <td>{{ $payment->reference }}</td>
            </tr>
            <tr>
                <th>Student</th>
                <td>{{ $payment->student->fullname ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Amount Paid</th>
                <td class="amount">₦{{ number_format($payment->amount_paid, 2) }}</td>
            </tr>
            <tr>
                <th>Purpose</th>
                <td>{{ $payment->purpose ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Balance</th>
                <td>₦{{ number_format($payment->balance, 2) }}</td>
            </tr>
            <tr>
                <th>Paid By</th>
                <td>{{ $payment->paid_by ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Received By</th>
                <td>{{ $payment->received_by ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Payment Date</th>
                <td>{{ $payment->payment_date }}</td>
            </tr>
            <tr>
                <th>Payment Method</th>
                <td>{{ $payment->payment_method ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($payment->status) }}</td>
            </tr>
            <tr>
                <th>Receipt Number</th>
                <td>{{ $payment->receipt_number ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Session</th>
                <td>{{ $payment->session ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Term</th>
                <td>{{ $payment->term ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Notes</th>
                <td>{{ $payment->notes ?? 'N/A' }}</td>
            </tr>
        </table>

        <div class="barcode">
            <canvas id="barcode"></canvas>
        </div>

        <div class="footer">
            <p>Thank you for your payment!</p>
            <p>{{ $schoolinfo->school_name }} © {{ now()->year }}</p>
        </div>
    </div>

    <button class="no-print" onclick="window.close()" style="display: block; margin: 20px auto; padding: 10px 20px;">Close Window</button>

     <script src="{{ asset('adminpage/assets/js/lib/JsBarcode.all.min.js') }}"></script>
    <script>
        JsBarcode("#barcode", "{{ $payment->reference }}", {
            format: "CODE128",
            width: 2,
            height: 50,
            displayValue: true
        });
    </script>

    <script>
    window.onload = function () {
        window.print();
    };

    window.onafterprint = function () {
        window.close();
    };
</script>
</body>
</html>
