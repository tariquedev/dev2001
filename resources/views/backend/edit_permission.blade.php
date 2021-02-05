@extends('backend.master')
@section('content')
    <div class="sl-pagebody">
      <div class="row row-sm mg-t-20">
        <div class="col-xl-6">
            <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
                <form action="{{ route('PermissionChangeToUser') }}" method="POST">
                    @csrf
                <h3 class="text-center">Permission Change to {{ $user->name }}</h3>
                <div class="row mg-t-20">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                  <label class="col-sm-4 form-control-label">Permission to User: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                        
                        @foreach ($permissions as $permission)
                        <li style="list-style: none">
                        <input name="permission[]" value="{{ $permission->name }}" type="checkbox" {{ $user->hasPermissionTo($permission->name) ? "checked" : '' }}><span>{{ $permission->name }}</span>
                        </li>
                        @endforeach
                        
                   
                  </div>
                </div>
                
                <div class="form-layout-footer mg-t-30 text-center">
                  <button type="submit" class="btn btn-info mg-r-5">Change Permission</button>
                
                </div><!-- form-layout-footer -->
                </form>
              </div><!-- card -->
        </div><!-- col-6 -->
      </div>

      {{-- <div class="row row-sm mg-t-20">
        
        <div class="col-xl-6">
            <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
                <form action="{{ route('RoleAddToUser') }}" method="POST">
                    @csrf
                
                <div class="row mg-t-20">
                  <label class="col-sm-4 form-control-label">User: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                    <select name="user_id" id="user_id" class="form-control">
                        @foreach ($users as $user)
                          <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                        
                    </select>
                  </div>
                </div>

                <div class="row">
                  <label class="col-sm-4 form-control-label">Permission: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
            
                    
                        @foreach ($permissions as $permission)
                        <li style="list-style: none">
                          <input type="checkbox" name="permission_name[]" value="{{ $permission->name }}"> {{ $permission->name }}
                        </li>
                        @endforeach
                        
                  </div>
                </div><!-- row -->
                
                <div class="form-layout-footer mg-t-30 text-center">
                  <button type="submit" class="btn btn-info mg-r-5">Assign</button>
                
                </div><!-- form-layout-footer -->
                </form>
              </div><!-- card -->
        </div><!-- col-6 -->
      </div> --}}

  </div><!-- sl-pagebody -->
@endsection
