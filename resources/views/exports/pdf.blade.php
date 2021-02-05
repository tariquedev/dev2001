<table>
    <thead>
        <style>
            th, td{
                text-align: center
            }
            th{
                text-decoration: underline
            }
        </style>
    <tr>
        <th>#SL</th>
        <th>Product Name</th>
        <th>Product Price</th>
        <th>quantity</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ $order->product->title }}</td>
            <td>{{ $order->product_unit_price }}</td>
            <td>{{ $order->quantity }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
