@extends('backend.master')
@section('breadcrumb')
    Sub Category
@endsection
@section('category', 'active show-sub')
@section('content')
<div class="sl-pagebody">
    <div class="sl-page-title">
      <h5>Sub Category View</h5>
    <a style="float: right" href="{{ url('subcategory-form') }}"><i class="fa fa-plus"></i> Add</a>
    </div><!-- sl-page-title -->

    <div class="card pd-20 pd-sm-40 mg-t-50">

      <div class="table-responsive">
        <table class="table table-hover mg-b-0">
          <thead>
            <tr>
              <th>SL#</th>
              <th>Name</th>
              <th>Slug</th>
              <th>Category Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              @foreach ( $scategories  as $key => $item)
            <tr>
              <td>{{ $scategories->firstItem() + $key}}</td>
              <td>{{ $item->subcategory_name  ?? 'N/A'}}</td>
              <td>{{ $item->slug ?? 'N/A'}}</td>
              <td>{{ $item->category->category_name}}</td>

              <td>
              <a href="{{ route('SubCategoryEdit', $item->slug) }}" class="btn btn-purple">Edit</a>
                  <a href="" class="btn btn-danger">Delete</a>
                </td>

            </tr>
            @endforeach
          </tbody>
        </table>
      </div><!-- table-responsive -->
    </div><!-- card -->

  </div><!-- sl-pagebody -->
@endsection
