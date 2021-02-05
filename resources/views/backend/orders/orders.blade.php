@extends('backend.master')
@section('content')
    <div class="sl-pagebody">
    <div class="sl-page-title">
      <h5>All Orders</h5>
    
    </div><!-- sl-page-title -->
    <div class="row">
      <div class="col-lg-2">
        <a href="{{ route('ExcelDownload') }}" class="btn btn-success mb-2">Download Excel</a>
        <a href="{{ route('PDFDownload') }}" class="btn btn-dark">Download PDF</a>
      </div>
      <div class="col-lg-5">
      <form action="{{ route('ExcelImport') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="excel">
        <input type="submit" class="btn btn-success" value="Upload Excel">
      </form>
    </div>
    <div class="col-lg-5">
      <form action="{{ route('SelectedDateExcelDownload') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="date" class="form-control" name="start">
        <input type="date" class="form-control" name="end">
        <input type="submit" class="btn btn-success" value="Selected Date">
      </form>
      </div>
    </div>

    <div class="card pd-20 pd-sm-40 mg-t-50">
      <div class="table-responsive">
        <table class="table table-hover mg-b-0">
          <thead>
            <tr>
              <th>SL#</th>
              <th>Product Name</th>
              <th>Quantity</th>
              <th>Unit Price</th>
              <th>Total Unit</th>
              <th>Purchese</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              @foreach ( $orders  as $key => $order)
            <tr>
              <td>{{ $orders->firstItem() + $key}}</td>
              <td>{{ $order->product->title  ?? 'N/A'}}</td>
              <td>{{ $order->quantity ?? 'N/A'}}</td>
              <td>{{ $order->product_unit_price ?? 'N/A'}}</td>
              <td>{{ $order->quantity * $order->product_unit_price ?? 'N/A'}}</td>
              <td>{{ $order->created_at}}</td>
              <td>
                  <a href="" class="btn btn-purple">View</a>
                 
                </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{  $orders->links() }}
      </div><!-- table-responsive -->
    </div><!-- card -->

  </div><!-- sl-pagebody -->
@endsection
