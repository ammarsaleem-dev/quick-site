<!DOCTYPE html>
<html lang="ar">

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
            /* padding-top: 12px;
            padding-bottom: 12px; */

            background-color: #04aa6d;
            color: white;
        }

    </style>
</head>

<body>
    {{-- <h1 style="direction: rtl">{{ $title }}</h1> --}}
    <h1 style="text-align: center;font-size: 1rem">{{ $title }}</h1>
    <div>
        <p style="direction: ltr">Date: {{ $today }}</p>
        <p>اسم المجهز {{ $user }} :</p>
    </div>

    <table id="table">
        <thead>
            <tr>
                <th>الهدايا</th>
                <th>الكمية مع الهدية</th>
                <th>اسم المنتج</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product['gift'] }}</td>
                    <td>{{ $product['quantity'] }}</td>
                    <td>{{ $product['productName'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table id="table">
        <thead>
            <tr>
                <th>الهدايا</th>
                <th>الكمية مع الهدية</th>
                <th>اسم المجموعة</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category['gift'] }}</td>
                    <td>{{ $category['quantity'] }}</td>
                    <td>{{ $category['categoryName'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="border: 1 solid rgb(0, 0, 0);">
        <p> مجموع المبيعات الكلية {{ $totalQuantity }} :</p>
        <p> مجموع الهدايا الكلية {{ $totalGift }} :</p>
        <p> مبلغ الروت الكلي {{ $totalPrice }} :</p>
    </div>
</body>

</html>
