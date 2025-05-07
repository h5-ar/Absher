<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>name</th>
                <th>Quantity</th>
                <th>Color</th>
                <th>Size</th>
                <th>Price</th>
                <th>description</th>
                <th colspan="2" style="text-align: center">Image</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stocks as $stock)
                <tr>
                    <td>{{ $stock->name }}</td>
                    <td>{{ $stock->quantity }}</td>
                    <td>{{ $stock->color }}</td>
                    <td>{{ $stock->size }}</td>
                    <td>{{ $stock->purchase_price }}</td>
                    <td>{{ $stock->description }}</td>
                    <td style="text-align: center"><a
                            href="{{ env('SELLER_DASHBOARD_URL') . '/storage/' . $stock->image }}"
                            target="_blank">Show</a>
                    </td>
                    <td style="text-align: center"><a
                            href="{{ env('SELLER_DASHBOARD_URL') . '/download/image/' . $stock->image }}">Download</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
