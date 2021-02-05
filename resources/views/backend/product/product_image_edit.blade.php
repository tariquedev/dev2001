@extends('backend.master')
@section('content')
     <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Edit Product</h5>
        </div><!-- sl-page-title -->
        <div class="row row-sm mg-t-20">
          <div class="col-xl-12 m-auto">
            <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
            <form action="{{ route('MultiImgUpdate') }}" method="post" enctype="multipart/form-data">
                @csrf
              
               <input type="hidden" name="product_id" value="{{ $product_id }}" class="form-control" placeholder="Ex: 500">
                @foreach ( $gallery as $img)
                    {{-- <input type="text" value="{{ $img->id }}" name="id"> --}}
                    <div class="row mg-t-20">
                        <label class="col-sm-4 form-control-label">Product Thumbnail ({{ $img->product_id }}): <span class="tx-danger">*</span></label>
                        <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                        <input type="file" name="images[]" class="form-control" placeholder="Enter firstname">
                        </div>
                        <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                            <img width="100" src="{{ asset('gallery/'.$img->created_at->format('Y/m/').$img->product_id.'/'.$img->images) }}" alt="">
                        </div>
                        <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                            <a href="{{ route('GalleryImageDelete', $img->id) }}" class="btn btn-outline-danger">Delete</a>
                        </div>
                    </div><!-- row -->
                @endforeach
                <div class="row mg-t-20">
                    <label class="col-sm-4 form-control-label">Product Thumbnail: <span class="tx-danger">*</span></label>
                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                    <input type="file" name="images[]" class="form-control" placeholder="Enter firstname">
                    </div>
                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                        <img width="100" src="#" alt="">
                    </div>
                        
                </div><!-- row -->
                <div class="row mg-t-20">
                    <label class="col-sm-4 form-control-label">Product Thumbnail: <span class="tx-danger">*</span></label>
                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                    <input type="file" name="images[]" class="form-control" placeholder="Enter firstname">
                    </div>
                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                        <img width="100" src="#" alt="">
                    </div>
                        
                </div><!-- row -->
              <div class="form-layout-footer mg-t-30 text-center">
                <button class="btn btn-info mg-r-5">Save</button>

              </div><!-- form-layout-footer -->
              </form>
            </div><!-- card -->
          </div><!-- col-6 -->

        </div><!-- row -->

      </div><!-- sl-pagebody -->
@endsection
