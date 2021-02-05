@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center bg-primary">{{ __('View Category 5') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Name</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Created_at</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $key => $cat)
                                <tr>
                                    <th scope="row">{{ $categories->firstItem() + $key }}</th>
                                    <td>{{  $cat->category_name ?? 'N/A' }}</td>
                                    <td>{{  $cat->slug ?? 'N/A' }}</td>
                                    <td>{{  $cat->created_at != null ? $cat->created_at->diffForHumans() : "N/A"}}</td>
                                    <td>
                                        {{-- <button type="button" class="btn btn-outline-primary getid" data-toggle="modal" data-target="#exampleModal{{ $cat->id }}">
                                            edit
                                        </button> --}}
                                        <a href="{{ url('/category/edit') }}/{{ $cat->id }}" class="btn btn-outline-primary"> Edit</a>
                                        <a href="{{ url('/category/delete') }}/{{ $cat->id }}" class="btn btn-outline-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                      </table>



                      {{ $categories->links() }}

                </div>
                <div class="card-header text-center bg-danger">{{ __('Trashed Category') }}</div>
                <div class="card-body">
                    @if (session('ParmanentDelete'))
                        <div class="alert alert-danger ParmanentDelete" role="alert">
                            {{ session('ParmanentDelete') }}
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Name</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Created_at</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($trash_catgory as $t_cat)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{  $t_cat->category_name ?? 'N/A' }}</td>
                                    <td>{{  $t_cat->slug ?? 'N/A' }}</td>
                                    <td>{{  $t_cat->created_at != null ? $t_cat->created_at->diffForHumans() : "N/A"}}</td>
                                    <td>
                                        <a href="{{ url('category-restore') }}/{{ $t_cat->id }}" class="btn btn-outline-success"> Restore</a>
                                        <a href="{{ url('category-parmanent') }}/{{ $t_cat->id }}" class="btn btn-outline-danger">Permanent Delete</a>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                      </table>
                      {{ $trash_catgory->links() }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center bg-success">{{ __('Edit Category') }}</div>
                @if(session('CategoryAdd'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Good News!</strong> {{ session('CategoryAdd') }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ url('category-update') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" value="{{ $edit_category->id }}" name="id">
                          <label for="category_name">Name</label>
                          <input type="text" class="form-control" value="{{ $edit_category->category_name }}" name="category_name" id="category_name" placeholder="Ex: Fashion">

                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
