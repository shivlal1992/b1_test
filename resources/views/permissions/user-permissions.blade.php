@extends('admin.layouts.main')
@section('style')
@endsection
@section('content')

<div class="pagetitle">
      <!-- <h1>Plans</h1> -->
   
    </div>

  
    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
           
              <h5 class="card-title">Manage Permissions for {{ $user->name }}
                
              </h5>
              <div>
                <h4>Roles:
                @foreach($roles as $role)
                    <span class="badge bg-primary">{{ $role->name }}</span>
                @endforeach
                </h4>
            </div>

<hr>
                <form action="{{ route('user.permissions.store', $user->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <h4>Assign Permissions</h4>
                        <div>
                            <input type="checkbox" id="select-all"> <label for="select-all"><strong>Select All</strong></label>
                        </div>
                        @foreach($permissions as $permission)
                            <div class="form-check">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                    class="form-check-input permission-checkbox" id="permission_{{ $permission->id }}"
                                    {{ in_array($permission->name, $userPermissions) ? 'checked' : '' }}>
                                <label class="form-check-label" for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-success">Assign Permissions</button>
                </form>
            </div>
          </div>
        </div>
      </div>
    </section>

@endsection
@section('script')
<script>
document.getElementById('select-all').addEventListener('change', function() {
    let checkboxes = document.querySelectorAll('.permission-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
});
</script>
@endsection
