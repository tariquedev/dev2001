@extends('backend.master')
@section('breadcrumb')
    Sub Category Add
@endsection
@section('content')
     <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Add Form Layout</h5>
        </div><!-- sl-page-title -->
        <div class="row row-sm mg-t-20">
          <div class="col-xl-10 m-auto">
            <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
            <form action="{{ url('subcategory-post') }}" method="post">
                @csrf
              <h6 class="card-body-title">Fillup Form</h6>
              <div class="row">
                <label class="col-sm-4 form-control-label">Sub Category Name: <span class="tx-danger">*</span></label>
                <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                  <input type="text" name="subcategory_name" class="form-control" placeholder="Enter firstname">
                </div>
              </div><!-- row -->
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

              <div class="form-layout-footer mg-t-30 text-center">
                <button class="btn btn-info mg-r-5">Save</button>

              </div><!-- form-layout-footer -->
              </form>
            </div><!-- card -->
          </div><!-- col-6 -->

        </div><!-- row -->

      </div><!-- sl-pagebody -->
@endsection
