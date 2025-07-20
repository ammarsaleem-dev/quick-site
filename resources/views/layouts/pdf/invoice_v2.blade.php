<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        * {
            font-family: DejaVu Sans, sans-serif;
            direction: rtl;
            font-size: 0.91rem;
            text-align: right;
            margin: 8px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td,
        #table th {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: right;
        }

        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table tr {
            text-align: left;
        }

        #table th {
            background-color: #04aa6d;
            color: white;
        }

        .page-break {
            page-break-before: always;
        }

        /* Print-specific styles */
        @media print {
            body {
                font-family: 'Cairo', 'Amiri', sans-serif;
                direction: rtl;
                background: white !important;
                color: black !important;
                margin: 0;
                padding: 0;
            }

            a,
            button {
                display: none !important;
            }

            @page {
                size: A4 portrait;
                margin: 10mm 5mm 10mm 5mm;
            }

            /* h1,
            table,
            div,
            p {
                page-break-inside: avoid;
            } */
        }
    </style>
</head>

<body onload="print()">
    @foreach ($orders as $order)
    <h1 style="text-align: center">مركز تسويق لذيذة</h1>
        <table style="width: 100%">
            <tbody>
                <thead>
                    <td > <span>فاتورة مبيعات: #{{ $order['id'] }}</span></td>
                    <td></td>
                </thead>
                <tr>
                    <td><span>كود الروت : {{ $order['route_code'] }} </span></td>
                    <td><span>التوصيل: {{ $order['shipper'] }} </span></td>
                </tr>
                <tr>
                    <td><span>السيد : {{ $order['customer_name'] }}</span></td>
                    <td> <span>تاريخ الفاتورة: {{ $order['created_at'] }}</span></td>
                </tr>
                <tr>
                    <td> <span>العنوان : {{ $order['customer_address'] }}</span></td>
                    <td><span>تاريخ الطباعة: {{ $order['today'] }} </span></td>
                </tr>
                <tr>

                    <td><span>رقم الهاتف: {{ $order['customer_phone'] }} </span></td>
                    <td> <span>المندوب: {{ $order['user2'] }}</span></td>
                </tr>
            </tbody>
        </table>
        <table id="table">
            <thead>
                <tr>
                    <th>اسم المادة</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                    <th>المبلغ الكلي</th>
                </tr>
            </thead>
            <tbody>
                @php($total = 0)
                @php($totalPrice = 0)
                @foreach ($order['order_products'] as $product)
                    <tr>
                        <td>{{ $product['product_name'] }}</td>
                        <td>{{ $product['quantity'] }}</td>
                        <td>{{ $product['price'] }}</td>
                        <td>{{ $product['price'] * $product['quantity'] }}</td>
                    </tr>
                    @php($total += $product['quantity'])
                    @php($totalPrice += $product['price'] * $product['quantity'])
                @endforeach
                <tr>
                    <td><b>المجموع</b></td>
                    <td><b>{{ $total }}</b></td>
                    <td></td>
                    <td><b>{{ number_format($totalPrice, 0) }}</b></td>
                </tr>
            </tbody>
        </table>
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>
