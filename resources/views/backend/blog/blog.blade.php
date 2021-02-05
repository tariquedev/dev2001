@extends('backend.master')
@section('breadcrumb')
    Category
@endsection
@section('category', 'active show-sub')

@section('content')
<div class="sl-pagebody">
    <div class="sl-page-title">
      <h5>Blog View</h5>
    </div><!-- sl-page-title -->

    <div class="card pd-20 pd-sm-40 mg-t-50">

      <div class="table-responsive">
        <table class="table table-hover mg-b-0">
          <thead>
            <tr>
              <th>SL#</th>
              
              <th>Title</th>
              <th>Slug</th>
              <th>Thumbnail</th>
              <th>Created</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ( $blog  as $key => $item)
            <tr>
              <td>{{ $blog->firstItem() + $key}}</td>
              <td>{{ $item->title  ?? 'N/A'}}</td>
              <td>{{ $item->slug ?? 'N/A'}}</td>
              <td>{{ $item->thumbnail ?? 'N/A'}}</td>
              <td>{{ $item->created_at->format('d-M-Y l')}}</td>
              <td>
                  <a href="#" class="btn btn-purple">Edit</a>
                  <a href="#" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            @endforeach

            <tr class="text-center">
              <td colspan="10">
                <button style="cursor: pointer" class="btn btn-outline-danger" type="submit">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
        {{ $blog->links() }}
      </div><!-- table-responsive -->
    </div><!-- card -->

  </div><!-- sl-pagebody -->
@endsection

