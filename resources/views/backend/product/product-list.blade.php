@extends('backend.master')
@section('content')
    <div class="sl-pagebody">
    <div class="sl-page-title">
      <h5>Total Products ({{ $product_count }})</h5>
    <a style="float: right" href="{{ route('ProductAdd') }}"><i class="fa fa-plus"></i> Add</a>
    </div><!-- sl-page-title -->

    <div class="card pd-20 pd-sm-40 mg-t-50">

      <div class="table-responsive">
        <table class="table table-hover mg-b-0">
          <thead>
            <tr>
              <th>SL#</th>
              <th>Title</th>
              <th>Image</th>
              <th>Price</th>
              <th>Size</th>
              <th>Image</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              @foreach ( $products  as $key => $product)
            <tr>
              <td>{{ $products->firstItem() + $key}}</td>
              <td>{{$product->title }}</td>
            <td><img style="width: 150px" src="{{ asset('images/'. $product->thumbnail ) }}" alt=""></td>
              <td>{{ $product->price ?? 'N/A'}}</td>
              <td>
                  @foreach(App\Attributes::where('product_id',$product->id )->get() as $test)
                    <span>Size: {{ $test->size->size_name }}</span>
                    <span>Color: {{ $test->color->color_name }}</span>
                    <span>Quantity: {{ $test->quantity }}</span>
                  @endforeach
              </td>
              <td>
                @foreach ($product->gallery as $img)
                    <img style="width: 50px" src="{{ asset('gallery/'.$img->created_at->format('Y/m/'). $img->product_id.'/'.$img->images) }}" alt="Thumbnail">
                @endforeach
                
              </td>
              <td>
                  <a href="{{ route('ProductEdit', $product->slug) }}" class="btn btn-purple">Edit</a>
                  <a href="{{ route('ProductImageEdit', $product->slug) }}" class="btn btn-purple">Gallery Edit</a>
                  <a href="{{ route('ProductDelete', $product->id) }}" class="btn btn-danger">Delete</a>
                </td>

            </tr>
            @endforeach
          </tbody>
        </table>
        {{-- {{  $users->links() }} --}}
      </div><!-- table-responsive -->
    </div><!-- card -->

  </div><!-- sl-pagebody -->
@endsection
