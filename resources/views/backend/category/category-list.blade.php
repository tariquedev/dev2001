@extends('backend.master')
@section('breadcrumb')
    Category
@endsection
@section('category', 'active show-sub')

@section('content')
<div class="sl-pagebody">
    <div class="sl-page-title">
      <h5>Category View</h5>
    </div><!-- sl-page-title -->

    <div class="card pd-20 pd-sm-40 mg-t-50">

      <div class="table-responsive">
        <table class="table table-hover mg-b-0">
          <thead>
            <tr>
              <th class="text-center"><input type="checkbox" id="checkAll"> All</th>
              <th>SL#</th>
              
              <th>Name</th>
              <th>Slug</th>
              <th>Created</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <form action="{{ route('SelectedCategoryDelete') }}" method="post">
              @csrf
              @foreach ( $categories  as $key => $item)
            <tr>
              <td class="text-center">
                <input type="checkbox" name="cat_id[]" value="{{ $item->id }}">
              </td>
              <td>{{ $categories->firstItem() + $key}}</td>
              <td>{{ $item->category_name  ?? 'N/A'}}</td>
              <td>{{ $item->slug ?? 'N/A'}}</td>
              <td>{{ $item->created_at->format('d-M-Y l')}}</td>
              <td>
                  <a href="" class="btn btn-purple">Edit</a>
                  <a href="{{ route('CategoryDelete', $item->id) }}" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            @endforeach

            <tr class="text-center">
              <td colspan="10">
                <button style="cursor: pointer" class="btn btn-outline-danger" type="submit">Delete</button>
              </td>
            </tr>
            </form>
          </tbody>
        </table>
      </div><!-- table-responsive -->
    </div><!-- card -->

  </div><!-- sl-pagebody -->
@endsection

@section('footer_js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
      const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })
        @if(session('Vatija'))
        Toast.fire({
          icon: 'error',
          title: '{{ session('Vatija') }}'
        })
        @endif
        @if(session('Vatija2'))
        Toast.fire({
          icon: 'success',
          title: '{{ session('Vatija2') }}'
        })
        @endif


         $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection