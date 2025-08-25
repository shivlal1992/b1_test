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
            <!-- <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Add Role</h5>
                    <form method="POST" action="{{ route('roles.store') }}">
                        @csrf
                        <input type="text" name="name" class="form-control" placeholder="Role Name" required>
                        <button type="submit" class="btn btn-primary mt-2">Add Role</button>
                    </form>
                </div>
            </div> -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Roles</h5>
               <div class="table-responsive">
                <table class="table ">
                  <thead>
                    <tr>
                      <th>Sr. No.</th>
                      <th>Role</th>
                        <!-- <th>Permissions</th> -->
                        <!-- <th>Actions</th> -->
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($roles as $key=> $role)
                    <tr>
                    <td>{{ $key+1 }}</td>
                        <td>{{ $role->name }}</td>
                        <!-- <td>{{ implode(', ', $role->permissions->pluck('name')->toArray()) }}</td> -->
                        <!-- <td>
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td> -->
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
@section('script')
@endsection
