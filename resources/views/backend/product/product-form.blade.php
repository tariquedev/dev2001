@extends('backend.master')
@section('content')
     <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Add Product</h5>
        </div><!-- sl-page-title -->
        <div class="row row-sm mg-t-20">
          <div class="col-xl-12 m-auto">
            <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
            <form action="{{ route('ProductStore') }}" method="post" enctype="multipart/form-data">
                @csrf
              <div class="row">
                <label class="col-sm-4 form-control-label">Product Title: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="text" name="title" class="form-control" placeholder="Enter firstname">
                </div>
              </div><!-- row -->
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Product Price: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="text" name="price" class="form-control" placeholder="Enter firstname">
                </div>
              </div><!-- row -->
              <div class="row mg-t-20">
                <label for="brand_id" class="col-sm-4 form-control-label">Brand: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select name="brand_id" id="brand_id" class="form-control">
                        @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                        @endforeach

                    </select>
                </div>
              </div>
              <div id="items">
               <div class="row mg-t-20">
                <label for="color_id" class="col-sm-2 form-control-label">Color: <span class="tx-danger">*</span></label>
                <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                    <select name="color_id[]" id="color_id" class="form-control">
                        @foreach ($colors as $color)
                    <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                        @endforeach

                    </select>
                </div>
                <label for="size_id" class="col-sm-1 form-control-label">Size: <span class="tx-danger">*</span></label>
                <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                    <select name="size_id[]" id="size_id" class="form-control">
                        @foreach ($sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                        @endforeach

                    </select>
                </div>
                <label for="category_id" class="col-sm-1 form-control-label">Quantity: <span class="tx-danger">*</span></label>
                <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                   <input type="text" name="quantity[]" class="form-control" placeholder="50">
                </div>

              </div>
              <span id="add" class="btn add-more button-yellow uppercase mr-2"><i class="fa fa-plus"></i>Add</span>
                <span class="delete btn button-white uppercase"><i class="fa fa-times"></i></span>
                </div>
              <div class="row mg-t-20">
                <label for="category_id" class="col-sm-4 form-control-label">Category: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select name="category_id" id="category_id" class="form-control">
                        @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach

                    </select>
                </div>
              </div>

              <div class="row mg-t-20">
                <label for="subcategory_id" class="col-sm-4 form-control-label">Sub Category: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select name="subcategory_id" id="subcategory_id" class="form-control">
                        @foreach ($scat as $sc)
                    <option value="{{ $sc->id }}">{{ $sc->subcategory_name }}</option>
                        @endforeach

                    </select>
                </div>
              </div>

              <div class="row mg-t-20">
                <label for="summary" class="col-sm-4 form-control-label">Summary: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <textarea name="summary" id="summary" class="form-control"></textarea>
                </div>
              </div>
                <div class="row mg-t-20">
                <label for="description" class="col-sm-4 form-control-label">Description: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <textarea name="description" id="description" class="form-control"></textarea>
                </div>
              </div>
              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Product Thumbnail: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="file" name="thumbnail" class="form-control" placeholder="Enter firstname">
                </div>
              </div><!-- row -->

              <div class="row mg-t-20">
                <label class="col-sm-4 form-control-label">Product Images: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="file" name="images[]" multiple class="form-control" placeholder="Enter firstname">
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

@section('footer_js')

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>
        // function test(){
        //         alert('OK')
        //     }
        $(document).ready(function() {

            $(".delete").hide();
            //when the Add Field button is clicked
            $("#add").click(function(e) {
                $(".delete").fadeIn("1500");
                //Append a new row of code to the "#items" div
                $("#items").append(
                '<div class="row mg-t-20"><label for="color_id" class="col-sm-2 form-control-label">Color: <span class="tx-danger">*</span></label><div class="col-sm-3 mg-t-10 mg-sm-t-0"><select name="color_id[]" id="color_id" class="form-control">@foreach ($colors as $color)<option value="{{ $color->id }}">{{ $color->color_name }}</option>@endforeach</select></div><label for="size_id" class="col-sm-1 form-control-label">Size: <span class="tx-danger">*</span></label><div class="col-sm-3 mg-t-10 mg-sm-t-0"><select name="size_id[]" id="size_id" class="form-control"> @foreach ($sizes as $size)<option value="{{ $size->id }}">{{ $size->size_name }}</option>@endforeach</select></div><label for="category_id" class="col-sm-1 form-control-label">Quantity: <span class="tx-danger">*</span></label><div class="col-sm-2 mg-t-10 mg-sm-t-0"><input type="text" name="quantity[]" class="form-control" placeholder="50"></div></div>'
                );
            });
            $("body").on("click", ".delete", function(e) {
                $(".next-referral").last().remove();
            });
            });

    </script>
@endsection
