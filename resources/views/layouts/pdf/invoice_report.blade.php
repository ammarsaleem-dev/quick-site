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
            /* padding-top: 12px;
            padding-bottom: 12px; */

            background-color: #04aa6d;
            color: white;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    @foreach ($orders as $order)
        <h1 style="text-align: center">فاتورة مبيعات</h1>
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td>{{ $order['created_at'] }} <span>تاريخ الفاتورة:</span></td>
                    <td>{{ $order['customer_name'] }}<span>السيد :</span></td>
                </tr>
                <tr>
                    <td>{{ $order['today'] }} <span>تاريخ الطباعة:</span></td>
                    <td>{{ $order['customer_address'] }} <span>العنوان :</span></td>
                </tr>
                <tr>
                    <td>{{ $order['shipper'] }} <span>المجهز:</span></td>
                    <td>{{ $order['customer_phone'] }} <span>رقم الهاتف:</span></td>
                </tr>
            </tbody>
        </table>
        <table id="table">
            <thead>
                <tr>
                    <th>المبلغ الكلي</th>
                    <th>السعر</th>
                    <th>الكمية</th>
                    <th>اسم المادة</th>
                </tr>
            </thead>
            <tbody>
                @php($total = 0)
                @php($totalPrice = 0)
                @foreach ($order['order_products'] as $product)
                    <tr>
                        <td>{{ $product['price'] * $product['quantity'] }}</td>
                        <td>{{ $product['price'] }}</td>
                        <td>{{ $product['quantity'] }}</td>
                        <td>{{ $product['product_name'] }}</td>
                    </tr>
                    @php($total += $product['quantity'])
                    @php($totalPrice += $product['price'] * $product['quantity'])
                @endforeach
                <tr>
                    <td><b>{{ $totalPrice }}</b></td>
                    <td></td>
                    <td><b>{{ $total }}</b></td>
                    <td><b>المجموع</b></td>
                </tr>
            </tbody>
        </table>
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>
