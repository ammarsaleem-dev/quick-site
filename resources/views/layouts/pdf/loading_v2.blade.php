<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title style="text-align: center">{{ $title }}</title>
    <style>
        * {
            font-family: DejaVu Sans, sans-serif;
            direction: rtl;
            font-size: 0.95rem;
            text-align: right;
            margin: 8px;
        }

        .date {
            color: red
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

            /* Remove default page margins (browser-dependent) */
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
    {{-- <h1 style="direction: rtl">{{ $title }}</h1> --}}
    <h1 style="text-align: center;font-size: 1rem">{{ $title }}</h1>
    <table style="width: 100%">
        <tbody>
            <tr>
                <td><span>التوصيل : {{ $shipper  ?? ''}} </span></td>
                <td><span>كود الروت : {{ $route_code ?? '' }} </span></td>
            </tr>
            <tr>
                <td><span>التاريخ: {{ $today }} </span></td>
                <td> <span>اسم المجهز : {{ $user }}</span></td>
            </tr>
        </tbody>
    </table>
    {{-- <div>
        <p style="direction: ltr">Date: {{ $today }}</p>
        <p>اسم المجهز {{ $user }} :</p>
    </div> --}}
    {{-- <a href="#" onclick="window.print()">🖨️ طباعة</a> --}}
    <table id="table">
        <thead>
            <tr>
                <th>اسم المنتج</th>
                <th>الكمية مع الهدية</th>
                <th>الهدايا</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product['productName'] }}</td>
                    <td>{{ $product['quantity'] ?? ''}}</td>
                    <td>{{ $product['gift'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table id="table">
        <thead>
            <tr>
                <th>اسم المجموعة</th>
                <th>الكمية مع الهدية</th>
                <th>الهدايا</th>
                <th>الراجع</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category['categoryName'] }}</td>
                    <td>{{ $category['quantity'] ?? ''}}</td>
                    <td>{{ $category['gift'] }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="border: 1 solid rgb(0, 0, 0);">
        <p> مجموع المبيعات الكلية : {{ $totalQuantity ?? '' }}</p>
        <p> مجموع الهدايا الكلية : {{ $totalGift }}</p>
        <p></p> مبلغ الروت الكلي : {{ number_format($totalPrice ?? null, 0) }} د.ع </p>
    </div>
</body>

</html>
