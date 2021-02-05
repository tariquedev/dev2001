<style>
  td.brdr{
    border: 1px solid green;
  }
</style>
<table class="table table-bordered">
    <thead>
      <tr>
        <th style="border: 1px solid black; width: 10%" scope="col">SL#</th>
        <th style="border: 1px solid black; width: 50%" scope="col">Product Name</th>
        <th style="border: 1px solid black; width: 10%" scope="col">Image</th>
        <th style="border: 1px solid black; width: 10%" scope="col">Quantity</th>
        <th style="border: 1px solid black; width: 10%" scope="col">Price</th>
        
      </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
        @foreach ($data as $item)
        <tr>
            <td style="border: 1px solid black; width: 10%">{{ $loop->index +1 }}</td>
            <td style="border: 1px solid black; width: 50%">{{ $item->product->title }}</td>
            <td style="border: 1px solid black; width: 10%"><img src="https://citylocalbiz.us/listing/2020/11/6766/brad-christopher-real-estate.jpg" alt=""></td>
            <td style="border: 1px solid black; width: 10%">{{ $item->quantity }}</td>
            <td style="border: 1px solid black; width: 10%">{{ $item->product_unit_price }}</td>
            @php
                $total+= $item->quantity * $item->product_unit_price;
            @endphp
        </tr>
        @endforeach
        <span style="float: right">{{ $total }}</span>
    </tbody>
  </table>