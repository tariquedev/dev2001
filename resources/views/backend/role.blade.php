@extends('backend.master')
@section('content')
    <div class="sl-pagebody">

    <div class="card pd-20 pd-sm-40 mg-t-50">
      <div class="table-responsive">
        <table class="table table-hover mg-b-0">
          <thead>
            <tr>
              <th>SL#</th>
              <th>Role</th>
              <th>Permission</th>
              <th>Created Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              @foreach ( $roles  as $key => $role)
            <tr>
              <td>{{ $loop->index + 1}}</td>
              <td>{{ $role->name  ?? 'N/A'}}</td>
              <td>
                  @foreach ($role->getPermissionNames() as $per)
                      <li>{{ $per }}</li>
                  @endforeach
              </td>
              <td>{{ $role->created_at  ?? 'N/A'}}</td>
              <td>
                  <a href="" class="btn btn-purple">Edit</a>
                  <a href="" class="btn btn-danger">Delete</a>
            </td>

            </tr>
            @endforeach
          </tbody>
        </table>
        {{-- {{  $users->links() }} --}}
      </div><!-- table-responsive -->
    </div><!-- card -->
    <div class="card pd-20 pd-sm-40 mg-t-50">
        <div class="table-responsive">
          <table class="table table-hover mg-b-0">
            <thead>
              <tr>
                <th>SL#</th>
                <th>User Name</th>
                <th>User Role</th>
                <th>User Permission</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ( $users  as $key => $user)
              <tr>
                <td>{{ $loop->index + 1}}</td>
                <td>{{ $user->name  ?? 'N/A'}}</td>
                <td>
                    @foreach ($user->getRoleNames() as $ur)
                        <li>{{ $ur }}</li>
                    @endforeach
                </td>
                <td>
                    @foreach ($user->getAllPermissions() as $up)
                    <li>{{ $up->name }}</li>
                @endforeach
                </td>
                <td>
                    <a href="{{ route('PermissionChange', $user->id) }}" class="btn btn-purple">Edit Permission</a>
                    <a href="" class="btn btn-danger">Delete</a>
              </td>
  
              </tr>
              @endforeach
            </tbody>
          </table>
          {{-- {{  $users->links() }} --}}
        </div><!-- table-responsive -->
      </div><!-- card -->

    <div class="card pd-20 pd-sm-40 mg-t-50">
        <div class="table-responsive">
          <table class="table table-hover mg-b-0">
            <thead>
              <tr>
                <th>SL#</th>
                <th>Permission Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ( $permissions  as $key => $permission)
              <tr>
                <td>{{ $loop->index + 1}}</td>
                <td>{{ $permission->name  ?? 'N/A'}}</td>
                
                <td>
                    <a href="" class="btn btn-purple">Edit</a>
                    <a href="" class="btn btn-danger">Delete</a>
              </td>
  
              </tr>
              @endforeach
            </tbody>
          </table>
          {{-- {{  $users->links() }} --}}
        </div><!-- table-responsive -->
        
      </div><!-- card -->

      <div class="row row-sm mg-t-20">
        <div class="col-xl-6">
          <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
            <form action="{{ route('RoleAddToPermission') }}" method="POST">
                @csrf
            <div class="row">
              <label class="col-sm-4 form-control-label">Role: <span class="tx-danger">*</span></label>
              <div class="col-sm-8 mg-t-10 mg-sm-t-0">
        
                <select name="role_name" id="role_name" class="form-control">
                    @foreach ($roles as $role)
                      <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                    
                </select>
              </div>
            </div><!-- row -->
            <div class="row mg-t-20">
              <label class="col-sm-4 form-control-label">Permission: <span class="tx-danger">*</span></label>
              <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                <select name="permission_name" id="role_name" class="form-control">
                    @foreach ($permissions as $permission)
                      <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                    @endforeach
                    
                </select>
              </div>
            </div>
            
            <div class="form-layout-footer mg-t-30 text-center">
              <button type="submit" class="btn btn-info mg-r-5">Assign</button>
            
            </div><!-- form-layout-footer -->
            </form>
          </div><!-- card -->
        </div><!-- col-6 -->
        <div class="col-xl-6">
            <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
                <form action="{{ route('RoleAddToUser') }}" method="POST">
                    @csrf
                <div class="row">
                  <label class="col-sm-4 form-control-label">Role: <span class="tx-danger">*</span></label>
                  <div class="col-sm-8 mg-t-10 mg-sm-t-0">
            
                    <select name="role_name" id="role_name" class="form-control">
                        @foreach ($roles as $role)
                          <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                        
                    </select>
                  </div>
                </div><!-- row -->
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
                
                <div class="form-layout-footer mg-t-30 text-center">
                  <button type="submit" class="btn btn-info mg-r-5">Assign</button>
                
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
