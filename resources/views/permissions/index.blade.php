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
              <h5 class="card-title">Permissions 
                <!-- <a href="{{route('permissions.add')}}" class="btn btn-sm btn-primary " style="float:right;">Add</a> -->
              </h5>
                
                
               <div class="table-responsive">
                <table class="table ">
                  <thead>
                    <tr>
                    <th>#</th>
                    <th>Permission Name</th>
                    <!-- <th>Actions</th> -->
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($permissions as $key => $permission)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $permission->name }}</td>
                        <!-- <td>
                            <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
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